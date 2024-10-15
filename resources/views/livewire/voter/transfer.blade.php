<div class="position-relative">
    @include('partials/loading')
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Transfer
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Transfer
            </li>
        </ol>
    </div>
    @production
        <div class="alert alert-info" role="alert">
            <strong>Informasi!</strong>
            Transfer pemilih akan merubah nama Tim Bersinar dan basis pemilih tersebut.
        </div>

        <div class="mb-4">
            <button class="btn btn-danger" wire:click="decrement" @disabled($step == 1)>
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
            <button class="btn btn-success" wire:click="increment" @disabled($step == 1 || $step == 3)>
                Selanjutnya
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        @if ($step == 1)
            <div class="mb-4 fs-5 fw-bold">
                #1 Pilih Pemilih yang akan dimigrasikan.
            </div>
            <div class="card-2">
                <div class="mb-4">
                    <input type="search" placeholder="Cari pemilih..." class="form-control" id="search"
                        wire:model="search">
                </div>
                <div class="overflow-auto" style="max-height:450px">
                    <table class="table table-striped table-sm">
                        <tbody>
                            @forelse ($data as $voter)
                                <tr>
                                    <td class="p-4" style="width:190px">
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                NIK
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $voter->nik }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Nama
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $voter->name }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Kecamatan
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $voter->district->name }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Kelurahan/Desa
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $voter->village->name }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                TPS
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $voter->tps->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center p-4" style="width:140px">
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_voter('{{ $voter->id }}')">
                                            Pilih Pemilih
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=2 class="text-center">
                                        Tidak ada pemilih ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($step == 2)
            <div class="mb-4 fs-5 fw-bold">
                #2 Konfirmasi Data Pemilih yang akan dimigrasikan.
            </div>
            <div class="card-2">
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <th class="p-2">NIK</th>
                            <td class="p-2">{{ $selected_voter->nik }}</td>
                        </tr>
                        <tr>
                            <th class="p-2">Nama</th>
                            <td class="p-2">{{ $selected_voter->name }}</td>
                        </tr>
                        <tr>
                            <th class="p-2">Kecamatan</th>
                            <td class="p-2">{{ $selected_voter->district->name }}</td>
                        </tr>
                        <tr>
                            <th class="p-2">Kelurahan/Desa</th>
                            <td class="p-2">{{ $selected_voter->village->name }}</td>
                        </tr>
                        <tr>
                            <th class="p-2">TPS</th>
                            <td class="p-2">{{ $selected_voter->tps->name }}</td>
                        </tr>
                        <tr>
                            <th class="p-2">Nama Tim Bersinar</th>
                            <td class="p-2">{{ $selected_voter->team_by->fullname }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @elseif($step == 3)
            <div class="mb-4 fs-5 fw-bold">
                #3 Pilih Tim Bersinar baru.
            </div>
            <div class="card-2 mb-4">
                <div class="d-flex gap-1">
                    <div class="fw-bold voter-table-width">
                        Nama
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $old_team->fullname }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold voter-table-width">
                        Peran
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $old_team->role_name }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold voter-table-width">
                        Kecamatan
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $old_team?->district->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold voter-table-width">
                        Kelurahan/Desa
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $old_team?->village->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold voter-table-width">
                        TPS
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $old_team?->tps->name ?? '-' }}
                    </div>
                </div>
            </div>
            <div class="card-2">
                <div class="mb-4">
                    <input type="text" placeholder="Cari Tim Bersinar..." class="form-control" id="team_search"
                        wire:model="team_search">
                </div>
                <div class="overflow-auto" style="max-height:450px">
                    <table class="table table-striped table-sm">
                        <tbody>
                            @forelse ($data as $team)
                                <tr>
                                    <td class="p-4" style="width:190px">
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Nama
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team->fullname }}
                                                @if ($selected_team && $selected_team->id == $team->id)
                                                    (dipilih)
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Peran
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team->role_name }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Kecamatan
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team?->district->name ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Kelurahan/Desa
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team?->village->name ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                TPS
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team?->tps->name ?? '-' }}
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <div class="fw-bold voter-table-width">
                                                Jumlah Pemilih
                                            </div>
                                            <div style="flex: 1 1 0%">
                                                {{ $team?->voters_by_team_count ?? 0 }} Pemilih
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center p-4" style="width:140px">
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_team('{{ $team->id }}')">
                                            Pilih Tim Bersinar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan=2 class="text-center">
                                        Tidak ada Tim Bersinar ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($step == 4)
            <div class="mb-4 fs-5 fw-bold">
                #4 Konfirmasi migrasi.
            </div>
            <div class="card-2">
                @if ($selected_team)
                    <div class="mb-3">Data Awal</div>
                    <table class="table table-sm table-striped mb-4">
                        <tbody>
                            <tr>
                                <th class="text-center" colspan=2>
                                    Data Awal
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2">NIK</th>
                                <td class="p-2">{{ $selected_voter->nik }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Nama</th>
                                <td class="p-2">{{ $selected_voter->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Kecamatan</th>
                                <td class="p-2">{{ $selected_voter->district->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Kelurahan/Desa</th>
                                <td class="p-2">{{ $selected_voter->village->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">TPS</th>
                                <td class="p-2">{{ $selected_voter->tps->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Tim Bersinar</th>
                                <td class="p-2">{{ $selected_voter->team_by->fullname }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" colspan=2>
                                    Data Setelah Transfer
                                </th>
                            </tr>
                            <tr>
                                <th class="p-2">NIK</th>
                                <td class="p-2">{{ $selected_voter->nik }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Nama</th>
                                <td class="p-2">{{ $selected_voter->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">Kecamatan</th>
                                <td class="p-2">
                                    {{ $selected_team?->district->name ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">Kelurahan/Desa</th>
                                <td class="p-2">
                                    {{ $selected_team?->village->name ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">TPS</th>
                                <td class="p-2">{{ $selected_team?->tps->name ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">Tim Bersinar</th>
                                <td class="p-2">{{ $selected_team->fullname }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button class="btn btn-primary" wire:click="$emit('trigger_save')" wire:loading.attr="disabled">
                        Transfer Pemilih
                    </button>
                @else
                    Silahkan pilih Tim Bersinar baru terlebih dahulu pada #3.
                @endif
            </div>
        @endif
    @else
        Sedang dalam pengembangan...
    @endproduction
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            @this.on('trigger_save', () => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan melakukan migrasi terhadap pemilih ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('save')
                        Swal.fire({
                            text: 'Permintaan sedang diproses!',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            text: 'Aksi dibatalkan!',
                            icon: 'success'
                        });
                    }
                });
            });
        });
    </script>
@endpush
