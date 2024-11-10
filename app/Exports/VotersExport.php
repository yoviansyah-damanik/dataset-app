<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Voter;
use App\Helpers\GeneralHelper;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VotersExport implements FromCollection, WithColumnWidths, WithHeadings, WithStyles
{
    public function __construct(
        public $team
    ) {
        $this->team = User::findOrFail($team);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Voter::with('dpt', 'dpt.tps')->where('team_id', $this->team->id)
            ->get()
            ->map(fn($voter, $idx) => [
                '_i' => $idx + 1,
                'name' => $voter->name,
                'tps' => $voter->dpt->tps->name
            ]);
    }

    public function map($voter): array
    {
        return [
            $voter->_i,
            $voter->name,
            $voter->tps,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'CEK BERSIH DATA PEMILIH',
            ],
            [
                GeneralHelper::get_candidate_1_name() . ' & ' . GeneralHelper::get_candidate_2_name(),
            ],
            [
                'CALON ' . GeneralHelper::get_candidate_callsign() . ' & WAKIL ' . GeneralHelper::get_candidate_2_name(),
            ],
            [
                'PERIODE 2024-2029',
            ],
            [],
            [
                'Nama Tim',
                ': ' . $this->team->fullname
            ],
            [
                'Kelurahan/Desa',
                ': ' . $this->team->village->name
            ],
            [
                'Kecamatan',
                ': ' . $this->team->district->name
            ],
            [],
            [
                'No',
                'Nama Pemilih',
                'TPS',
                'TTD',
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 40,
            'C' => 12,
            'D' => 25,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => ['bold' => true],
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ]
            ],
            2    => [
                'font' => ['bold' => true],
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ]
            ],
            3    => [
                'font' => ['bold' => true],
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ]
            ],
            4    => [
                'font' => ['bold' => true],
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ]
            ],

            6    => [
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ]
            ],

            7    => [
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ]
            ],

            8   => [
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ]
            ],

            10    => [
                'font' => ['bold' => true],
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'wrapText' => true,
                ]
            ],

            'A' => [
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            'B' => [
                'alignment' =>   [
                    'wrapText' => true,
                ]
            ],

            'C' => [
                'alignment' =>   [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ]

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}
