<?php

namespace App\Http\Livewire\Voter\Print;

use App\Jobs\Report;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\District;
use App\Models\PrintHistory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Form extends Component
{
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $jenis_laporan;
    public $district;
    public $districts;
    public $available_reports;

    public function rules()
    {
        return
            [
                'jenis_laporan' => [
                    'required',
                    Rule::in(collect($this->available_reports)->pluck('value')->toArray())
                ],
                'district' => [
                    'required',
                    Rule::in(['semua', ...$this->districts->pluck('id')->toArray()])
                ]
            ];
    }

    public function render()
    {
        return view('livewire.voter.print.form');
    }

    public function mount()
    {
        $this->available_reports = [
            [
                'value' => 'counter',
                'title' => 'Data Perhitungan'
            ],
            [
                'value' => 'voters',
                'title' => 'Data Pemilih'
            ]
        ];
        $this->districts = District::all();
        $this->district = 'semua';
    }

    public function print()
    {
        $this->validate();

        $district = $this->district === 'semua' ? 'Semua Kecamatan' : District::findOrFail($this->district)->name;

        do {
            $unique_code = base64_encode(Carbon::now()->timestamp);
        } while (PrintHistory::where('unique_code', $unique_code)->count());

        $created_at = \Carbon\Carbon::now()->format('d M Y H:i:s');

        if (in_array($this->jenis_laporan, ['counter', 'voters'])) {
            DB::beginTransaction();
            try {
                $paper = 'A4';
                $orientation = 'portrait';

                if ($this->jenis_laporan == 'counter') {
                    $filename = 'Data Perhitungan Pemilih.pdf';

                    $view = 'printout.counter';
                    $addition = [
                        'unique_code' => $unique_code,
                        'created_at' => $created_at
                    ];
                } else if ($this->jenis_laporan == 'voters') {
                    $filename = 'Data Pemilih.pdf';

                    $view = 'printout.voters';
                    $addition = [
                        'unique_code' => $unique_code,
                        'created_at' => $created_at
                    ];

                    $orientation = 'landscape';
                }

                $payload = [
                    'district' => $district,
                ];

                if (!empty($addition))
                    $payload += $addition;

                $filename = $unique_code . '_' . Carbon::now()->timestamp . '_' . $filename;
                $path = '/' . $this->jenis_laporan . '/' . $filename;

                $translations = [
                    'counter' => 'Data Perhitungan',
                    'voters' => 'Data Pemilih',
                ];

                $paper = [
                    'paper' => $paper,
                    'orientation' => $orientation
                ];

                $history = PrintHistory::create([
                    'filename' => $filename,
                    'type' => !empty($translations[$this->jenis_laporan]) ? $translations[$this->jenis_laporan] : $this->jenis_laporan,
                    'path' => $path,
                    'unique_code' => $unique_code,
                    'district_id' => $this->district,
                    'user_id' => auth()->user()->id,
                    'status' => 'on_progress'
                ]);

                dispatch(new Report(
                    type: $this->jenis_laporan,
                    district: $this->district,
                    filename: $filename,
                    view: $view,
                    path: $path,
                    paper: $paper,
                    payload: $payload,
                    history: $history
                ));

                DB::commit();
                $this->emit('refresh_print_history');
                $this->alert('success', 'Laporan berhasil didaftarkan ke antrian, silahkan pantau status laporan pada halaman ini.');
            } catch (\Exception $e) {
                DB::rollBack();
                $this->alert('error', $e->getMessage());
                return;
            } catch (\Throwable $e) {
                DB::rollBack();
                $this->alert('error', $e->getMessage());
                return;
            }
        } else {
            $this->alert('warning', 'Jenis Laporan tidak tersedia.');
        }
    }
}
