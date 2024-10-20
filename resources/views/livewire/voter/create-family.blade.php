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
                Tambah Data Keluarga
            </li>
        </ol>
    </div>

    <div class="d-flex justify-content-center align-items-center gap-3">
        <button @disabled($step == 1) class="btn btn-danger mb-3" wire:click="reset_semua"
            wire:loading.attr="disabled">
            <i class="fas fa-arrow-left"></i>
            Kembali ke awal
        </button>
        <button @disabled($step == 3) class="btn btn-success mb-3" wire:click="next_step"
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
                2. Pilih Koordinator Keluarga
            @break

            @case(3)
                3. Isi data Pemilih
            @break
        @endswitch
    </div>

    @if ($step != 1 || $remember)
        @if ($remember && $step == 1)
            <div class="alert alert-warning">
                Anda memilih untuk menggunakan Koordinator Keluarga yang sama.<br />
                Fitur ini hanya meminta anda untuk melakukan pengecekan NIK dan DPT di wilayah yang sama dengan Pemilih
                sebelumnya tanpa perlu memilih Koordinator Keluarga kembali.
            </div>
        @endif
        <div class="mb-3 team-choise-information">
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
                        Koordinator Keluarga
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $family_coor?->fullname ?? 'Belum dipilih' }}
                    </div>
                </div>
                @if ($step == 3)
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"
                            wire:model="remember">
                        <label class="form-check-label" for="flexCheckDefault">
                            Gunakan Koordinator ini kembali
                        </label>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if ($step == 1)
        <div class="card-2 mb-3">
            <div class="mb-3 fw-bold text-center fs-5">
                Silahkan cek ketersediaan NIK terlebih dahulu.
            </div>
            <div class="input-group mx-auto has-validation" style="width:100%; max-width:480px">
                <input type="text" autocomplete="off" maxlength="16"
                    class="form-control @error('cek_nik') is-invalid @enderror" id="cek_nik"
                    wire:model.defer="cek_nik" wire:keyup.enter="check_nik">
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

        <div class="card-2 mb-3">
            <div class="text-center fs-4 fw-bold">
                {{ $dpt?->name ?? '-' }}
            </div>
            <div class="text-center fw-light">
                {{ $dpt?->district->name ?? '-' }} /
                {{ $dpt?->village->name ?? '-' }} /
                {{ $dpt?->tps->name ?? '-' }}
            </div>
        </div>

        <div class="card-2">
            <div class="mb-3">
                <input type="search" placeholder="Cari DPT..." class="form-control" wire:model="search">
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </div>
                            <select class="form-select" wire:model='dpt_district' wire:change="set_dpt_villages">
                                <option value="">--Pilih semua Kecamatan--</option>
                                @if ($dpt_districts)
                                    @foreach ($dpt_districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </div>
                            <select class="form-select" wire:model='dpt_village' wire:change="set_dpt_tpses">
                                <option value="">--Pilih semua Kelurahan/Desa--</option>
                                @if ($dpt_villages)
                                    @foreach ($dpt_villages as $village)
                                        <option value="{{ $village->id }}">{{ $village->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </div>
                            <select class="form-select" wire:model='dpt_tps'>
                                <option value="">--Pilih semua TPS--</option>
                                @if ($dpt_tpses)
                                    @foreach ($dpt_tpses as $tps)
                                        <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
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
                <input type="text" autocomplete="off" placeholder="Cari Koordinator Keluarga..."
                    class="form-control" wire:model="search">
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
                                            Jumlah Pemilih
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $item?->voters_by_family_count ?? 0 }} Pemilih
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center p-4" style="width:140px">
                                    @if ($item->id === $family_coor?->id)
                                        (dipilih)
                                    @else
                                        <button class="btn btn-primary btn-sm"
                                            wire:click="set_family_coor('{{ $item->id }}')">
                                            Pilih Koordinator Keluarga
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan=2 class="text-center">
                                    Tidak ada Koordinator Keluarga ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($step == 3)
        <div class="card-2">
            <form wire:submit.prevent="store">
                <div class="row">
                    <div class="col-md-5 col-lg-3">
                        <div class="form-group mb-3 position-relative">
                            <label for="nik" class="form-label label-important">NIK</label>
                            <input type="text" autocomplete="off" readonly maxlength="16"
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
                            <label for="nama" class="form-label label-important">Nama</label>
                            <input type="text" autocomplete="off"
                                class="form-control @error('nama') is-invalid @enderror" id="nama"
                                wire:model.defer='nama'>
                            @error('nama')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="jenis_kelamin" class="form-label label-important">Jenis Kelamin</label>
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
                            <input type="text" autocomplete="off"
                                class="form-control @error('tempat_lahir') is-invalid @enderror" autofocus
                                id="tempat_lahir" wire:model.defer="tempat_lahir">
                            @error('tempat_lahir')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        {{-- <div class="form-group mb-3 position-relative">
                            <label for="tanggal_lahir" class="form-label label-important">Tanggal Lahir</label>
                            <input type="text" autocomplete="off" placeholder="dd/mm/yyyy"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" id="date"
                                wire:model.defer="tanggal_lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group mb-3 position-relative">
                            <label for="umur" class="form-label label-important">Umur</label>
                            <input type="number" autocomplete="off"
                                class="form-control @error('umur') is-invalid @enderror" id="date"
                                wire:model="umur">
                            @error('umur')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3 position-relative">
                            <label for="no_telp" class="form-label">No. Telp.</label>
                            <input type="text" autocomplete="off"
                                class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                                wire:model.defer="no_telp">
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
                            <input type="text" autocomplete="off"
                                class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                wire:model.defer="alamat" />
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
                            <input type="text" autocomplete="off"
                                class="form-control @error('rt') is-invalid @enderror" id="rt"
                                wire:model.defer="rt">
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
                            <input type="text" autocomplete="off"
                                class="form-control @error('rw') is-invalid @enderror" id="rw"
                                wire:model.defer="rw">
                            @error('rw')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group">
                                <label for="kecamatan" class="form-label label-important">Kecamatan</label>
                                <select id="kecamatan" class="form-select @error('kecamatan') is-invalid @enderror"
                                    wire:model="kecamatan" wire:change="set_villages">
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kecamatan')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group">
                                <label for="kelurahan" class="form-label label-important">Kelurahan/Desa</label>
                                <select id="kelurahan" class="form-select @error('kelurahan') is-invalid @enderror"
                                    wire:model="kelurahan" wire:change="set_tpses">
                                    @foreach ($villages as $village)
                                        <option value="{{ $village->id }}">{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelurahan')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group">
                                <label for="tps" class="form-label label-important">TPS</label>
                                <select id="tps" class="form-select @error('tps') is-invalid @enderror"
                                    wire:model="tps">
                                    @foreach ($tpses as $tps)
                                        <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tps')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="mb-3 position-relative">
                            <div class="form-group">
                                <label for="agama" class="form-label label-important">Agama</label>
                                <select id="religion_id" class="form-select @error('agama') is-invalid @enderror"
                                    wire:model="agama">
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
                            <div class="form-group">
                                <label for="status_perkawinan" class="form-label label-important">Status
                                    Perkawinan</label>
                                <select id="marital_status_id"
                                    class="form-select @error('status_perkawinan') is-invalid @enderror"
                                    wire:model="status_perkawinan">
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
                            <div class="form-group">
                                <label for="pekerjaan" class="form-label label-important">Pekerjaan</label>
                                <select id="profession_id"
                                    class="form-select @error('pekerjaan') is-invalid @enderror"
                                    wire:model="pekerjaan">
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
                            <div class="form-group">
                                <label for="kewarganegaraan"
                                    class="form-label label-important">Kewarganegaraan</label>
                                <select id="nasionality_id"
                                    class="form-select @error('kewarganegaraan') is-invalid @enderror"
                                    wire:model="kewarganegaraan">
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
                                            <button class="btn btn-sm btn-danger mt-3" type="button"
                                                wire:click="setNull('ktp')">Hapus KTP</button>
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
                                                <button class="btn btn-sm btn-danger mt-3" type="button"
                                                    wire:click="setNull('kk')">Hapus KK</button>
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.14.0/jquery-ui.js"></script>
    <script>
        $.datepicker.setDefaults({
            closeText: "Tutup",
            prevText: "Mundur",
            nextText: "Maju",
            currentText: "Hari ini",
            monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember"
            ],
            monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                "Jul", "Agus", "Sep", "Okt", "Nop", "Des"
            ],
            dayNames: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"],
            dayNamesShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            dayNamesMin: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sb"],
            weekHeader: "Mg",
            dateFormat: "dd/mm/yy",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        });

        document.addEventListener('DOMContentLoaded', function() {
            setDateInput()
        })

        document.addEventListener('livewire:load', function() {
            function setDateInput() {
                $("input#date").datepicker({
                    onSelect: function(date) {
                        @this.tanggal_lahir = date;
                    },
                    "dateFormat": "dd/mm/yy"
                });
            }

            $(window).on('setDateInput', function(e) {
                setDateInput()
            })
        })
    </script>
@endpush

{{-- @push('scripts')
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
@endpush --}}
