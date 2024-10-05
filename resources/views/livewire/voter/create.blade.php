<div id="create-voters">
    @include('partials/loading')

    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Tambah Pemilih
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('voters') }}">
                    Pemilih
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Tambah Data
            </li>
        </ol>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3">
        <button @disabled($step == 1) class="btn btn-danger mb-3" wire:click="reset_semua"
            wire:loading.attr="disabled">
            <i class="fas fa-arrow-left"></i>
            Kembali ke awal
        </button>
        <button @disabled($step == 6) class="btn btn-success mb-3" wire:click="next_step"
            wire:loading.attr="disabled">
            Selanjutnya
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>

    <div class="fw-bold mb-3 text-center fs-5">
        @switch($step)
            @case(1)
                1. Cek NIK dan Pilih DPT
            @break

            @case(2)
                2. Pilih Tim Bersinar
            @break

            @case(3)
                3. Pilih Koordinator Kecamatan
            @break

            @case(4)
                4. Pilih Koordinator Kelurahan/Desa
            @break

            @case(5)
                5. Pilih Koordinator TPS
            @break

            @case(6)
                6. Isi data Pemilih
            @break
        @endswitch
    </div>

    @if ($step != 1 || $remember)
        @if ($remember && $step == 1)
            <div class="mb-3 text-center">
                Anda memilih untuk menggunakan Tim Bersinar dan Koordinator yang sama.<br />
                Fitur ini hanya meminta anda untuk melakukan pengecekan NIK dan DPT tanpa perlu memilih Tim Bersinar dan
                Koordinator kembali.
            </div>
        @endif
        <div class="mb-3 team-choise-information">
            <div class="card-2">
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:220px">
                        Nama Tim Bersinar
                    </div>
                    <div style="flex: 1 1 0%">
                        <span class="fw-bolder">{{ $team?->fullname ?? '-' }}</span>
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:220px">
                        Kecamatan
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $team?->district->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:220px">
                        Kelurahan/Desa
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $team?->village->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:220px">
                        TPS
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $team?->tps->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:220px">
                        Jumlah Pemilih
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $team?->voters_by_team->count() ?? 0 }} Pemilih
                    </div>
                </div>
                @if ($step == 6)
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                            wire:model="remember">
                        <label class="form-check-label" for="flexCheckDefault">
                            Gunakan Tim Bersinar dan Koordinator ini kembali
                        </label>
                    </div>
                @endif
            </div>
            <div class="card-2">
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width: 220px">
                        NIK
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $nik ?? 'Belum valid' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width: 220px">
                        DPT
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $dpt ? $dpt->name . ' - ' . $dpt->age . ' Tahun - ' . $dpt->genderFull . ' - ' . $dpt->tps->name . ' - ' . $dpt->village->name . ' - ' . $dpt->district->name : '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width: 220px">
                        Koordinator Kecamatan
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $district_coor?->fullname ?? 'Belum dipilih' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width: 220px">
                        Koordinator Kelurahan/Desa
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $village_coor?->fullname ?? 'Belum dipilih' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width: 220px">
                        Koordinator TPS
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $tps_coor?->fullname ?? 'Belum dipilih' }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($step == 1)
        <div class="card-2 mb-3">
            <div class="mb-3 fw-bold text-center fs-5">
                Silahkan cek ketersediaan NIK terlebih dahulu.
            </div>
            <div class="input-group mx-auto has-validation" style="width:100%; max-width:480px">
                <input type="text" maxlength="16" class="form-control @error('cek_nik') is-invalid @enderror"
                    id="cek_nik" wire:model.defer="cek_nik" wire:keyup.enter="check_nik">
                <button class="btn btn-primary" wire:click="check_nik" type="button" id="button-addon2">Cek
                    NIK</button>
                @error('cek_nik')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @if ($valid_message)
                <div @class([
                    'mt-3 text-center',
                    'text-success' => $is_nik_valid,
                    'text-danger' => !$is_nik_valid,
                ])>
                    {!! $valid_message !!}
                </div>
            @endif
        </div>

        <div class="card-2">
            <div class="mb-3">
                <input type="text" placeholder="Cari DPT..." class="form-control" wire:model="search">
            </div>
            <div class="overflow-auto" style="max-height:450px">
                <table class="table table-striped table-sm">
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-4" style="width:190px">
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Nama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Umur
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->age }} Tahun
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jenis Kelamin
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->genderFull }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Alamat
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->address }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->tps->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->village->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->district->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $dpt?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_dpt('{{ $item->id }}')">
                                            Pilih DPT
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan=2 class="text-center">
                                    Tidak ada DPT ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($step == 2)
        <div class="card-2">
            <div class="mb-3 input-group">
                <input type="text" placeholder="Cari Tim Bersinar..." class="form-control" wire:model="search">
                @if (auth()->user()->role_name == 'Superadmin')
                    <select class="form-select" wire:model="district" wire:change="reset_region('district')">
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select" wire:model="village" wire:change="reset_region('village')">
                        @foreach ($villages as $village)
                            <option value="{{ $village->id }}">{{ $village->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-select" wire:model="tps_">
                        @foreach ($tpses as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="overflow-auto" style="max-height:450px">
                <table class="table table-striped table-sm">
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-4" style="width:190px">
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Nama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->fullname }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Peran
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->role_name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->district->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->village->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->tps->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jumlah Pemilih
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->voters_by_team_count ?? 0 }} Pemilih
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $team?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_team('{{ $item->id }}')">
                                            Pilih Tim Bersinar
                                        </button>
                                    @endif
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
    @elseif($step == 3)
        <div class="card-2">
            <div class="mb-3">
                <input type="text" placeholder="Cari Koordinator Kecamatan..." class="form-control"
                    wire:model="search" />
            </div>
            <div class="overflow-auto" style="max-height:450px">
                <table class="table table-striped table-sm">
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-4" style="width:190px">
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Nama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->fullname }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Peran
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->role_name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->district->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->village->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->tps->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jumlah Pemilih
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->voters_count ?? 0 }} Pemilih
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $district_coor?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_district_coor('{{ $item->id }}')">
                                            Pilih Koordinator Kecamatan
                                        </button>
                                    @endif
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
        <div class="card-2">
            <div class="mb-3">
                <input type="text" placeholder="Cari Koordinator Kelurahan/Desa..." class="form-control"
                    wire:model="search" />
            </div>
            <div class="overflow-auto" style="max-height:450px">
                <table class="table table-striped table-sm">
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-4" style="width:190px">
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Nama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->fullname }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Peran
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->role_name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->district->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->village->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->tps->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jumlah Pemilih
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->voters_count ?? 0 }} Pemilih
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $village_coor?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_village_coor('{{ $item->id }}')">
                                            Pilih Koordinator Kelurahan/Desa
                                        </button>
                                    @endif
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
    @elseif($step == 5)
        <div class="card-2">
            <div class="mb-3">
                <input type="text" placeholder="Cari Koordinator TPS..." class="form-control"
                    wire:model="search" />
            </div>
            <div class="overflow-auto" style="max-height:450px">
                <table class="table table-striped table-sm">
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td class="p-4" style="width:190px">
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Nama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->fullname }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Peran
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item->role_name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->district->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->village->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->tps->name ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jumlah Pemilih
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->voters_count ?? 0 }} Pemilih
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $tps_coor?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_tps_coor('{{ $item->id }}')">
                                            Pilih Koordinator TPS
                                        </button>
                                    @endif
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
    @elseif($step == 6)
        <div class="card-2">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-5 col-lg-3">
                        <div class="form-group mb-3 position-relative">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" readonly maxlength="16"
                                class="form-control is-valid @error('nik') is-invalid @enderror" id="nik"
                                wire:model.defer="nik">
                            @error('nik')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @else
                                <div class="valid-tooltip">
                                    NIK dapat digunakan.
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-5">
                        <div class="form-group mb-3 position-relative">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                id="nama" wire:model.defer='nama'>
                            @error('nama')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <div id="jenis_kelamin">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio" name="inlineRadioOptions" id="inlineRadio1" value="Laki-laki"
                                        wire:model.defer="jenis_kelamin">
                                    <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Perempuan"
                                        wire:model.defer="jenis_kelamin">
                                    <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" wire:model.defer="tempat_lahir">
                            @error('tempat_lahir')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="date" wire:model.defer="tanggal_lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="no_telp" class="form-label">No. Telp.</label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                id="no_telp" wire:model.defer="no_telp">
                            @error('no_telp')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group mb-3 position-relative">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                id="alamat" wire:model.defer="alamat" />
                            @error('alamat')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group mb-3 position-relative">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" class="form-control @error('rt') is-invalid @enderror"
                                id="rt" wire:model.defer="rt">
                            @error('rt')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3">
                        <div class="form-group mb-3 position-relative">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" class="form-control @error('rw') is-invalid @enderror"
                                id="rw" wire:model.defer="rw">
                            @error('rw')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="agama" class="form-label">Agama</label>
                                <select id="religion_id" class="form-select @error('agama') is-invalid @enderror">
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('agama')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                <select id="marital_status_id"
                                    class="form-select @error('status_perkawinan') is-invalid @enderror">
                                    @foreach ($marital_statuses as $marital_status)
                                        <option value="{{ $marital_status->id }}">{{ $marital_status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('status_perkawinan')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <select id="profession_id"
                                    class="form-select @error('pekerjaan') is-invalid @enderror">
                                    @foreach ($professions as $profession)
                                        <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('pekerjaan')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                <select id="nasionality_id"
                                    class="form-select @error('kewarganegaraan') is-invalid @enderror">
                                    @foreach ($nasionalities as $nasionality)
                                        <option value="{{ $nasionality->id }}">{{ $nasionality->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kewarganegaraan')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3 position-relative">
                            <label for="ktp">Foto KTP (Maks: 2Mb)</label>
                            <input type="file" id="ktp" accept="image/*"
                                class="form-control @error('gambar') is-invalid @enderror" wire:model.defer="ktp">
                            @error('ktp')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @if ($preview_ktp)
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            Foto KTP
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="preview">
                                                <img src="{{ $preview_ktp }}" class="w-100" alt="preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3 position-relative">
                            <label for="kk">Foto KK (Maks: 2Mb)</label>
                            <input type="file" id="kk" accept="image/*"
                                class="form-control @error('gambar') is-invalid @enderror" wire:model.defer="kk">
                            @error('kk')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        @if ($preview_kk)
                            <div class="accordion accordion-flush" id="accordionFlushExample2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            Foto KK
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample2">
                                        <div class="accordion-body">
                                            <div class="preview">
                                                <img src="{{ $preview_kk }}" class="w-100" alt="preview">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary" wire:loading.attr='disabled'>
                        <i class="fas fa-plus"></i>
                        Tambah Data
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            setAdditionalInput(true)
        })

        function setAdditionalInput(isEmpty) {
            if (isEmpty) {
                $('#religion_id').val('')
                $('#marital_status_id').val('')
                $('#profession_id').val('')
                $('#nasionality_id').val('')
            }

            $('#religion_id').select2({
                placeholder: "Pilih Agama",
                theme: "bootstrap-5",
                language: "id",
            });
            $('#religion_id').on('change', function(e) {
                let religion_id = $('#religion_id').select2("val");
                $('#religion_id').removeClass('is-invalid');
                @this.set('agama', religion_id);
            });

            $('#marital_status_id').select2({
                placeholder: "Pilih Status Perkawinan",
                theme: "bootstrap-5",
                language: "id",
            });
            $('#marital_status_id').on('change', function(e) {
                let marital_status_id = $('#marital_status_id').select2("val");
                $('#marital_status_id').removeClass('is-invalid');
                @this.set('status_perkawinan', marital_status_id);
            });

            $('#profession_id').select2({
                placeholder: "Pilih Pekerjaan",
                theme: "bootstrap-5",
                language: "id",
            });
            $('#profession_id').on('change', function(e) {
                let profession_id = $('#profession_id').select2("val");
                $('#profession_id').removeClass('is-invalid');
                @this.set('pekerjaan', profession_id);
            });

            $('#nasionality_id').select2({
                placeholder: "Pilih Kewarganegaraan",
                theme: "bootstrap-5",
                language: "id",
            });
            $('#nasionality_id').on('change', function(e) {
                let nasionality_id = $('#nasionality_id').select2("val");
                $('#nasionality_id').removeClass('is-invalid');
                @this.set('kewarganegaraan', nasionality_id);
            });
        }

        $(window).on('reloadAdditionalInput', function(e) {
            setAdditionalInput(e.detail.is_empty)
        })
    </script>
@endpush
