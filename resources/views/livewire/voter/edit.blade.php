<div id="edit-voters">
    @include('partials/loading')

    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Edit Pemilih
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">
                    Beranda
                </a>
            </li>
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
                Edit Data
            </li>
        </ol>
    </div>

    <div class="card-2">
        @if ($errors->all())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="errors">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="update">
            <div class="row">
                <div class="col-md-5 col-lg-3">
                    <div class="form-group mb-3 position-relative">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" readonly maxlength="16"
                            class="form-control is-valid @error('nik') is-invalid @enderror" id="nik"
                            wire:model.lazy="nik">
                        @error('nik')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-7 col-lg-5">
                    <div class="form-group mb-3 position-relative">
                        <label for="nama" class="form-label label-important">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            wire:model.lazy='nama'>
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
                                    wire:model.lazy="jenis_kelamin">
                                <label class="form-check-label" for="inlineRadio1">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                    type="radio" name="inlineRadioOptions" id="inlineRadio2" value="Perempuan"
                                    wire:model.lazy="jenis_kelamin">
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
                            id="tempat_lahir" wire:model.lazy="tempat_lahir">
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
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            id="date" wire:model.lazy="tanggal_lahir">
                        @error('tanggal_lahir')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                    <div class="form-group mb-3 position-relative">
                        <label for="umur" class="form-label label-important">Umur</label>
                        <input type="number" autocomplete="off"
                            class="form-control @error('umur') is-invalid @enderror" id="date" wire:model="umur">
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
                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp"
                            wire:model.lazy="no_telp">
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
                            id="alamat" wire:model.lazy="alamat" />
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
                        <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt"
                            wire:model.lazy="rt">
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
                        <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw"
                            wire:model.lazy="rw">
                        @error('rw')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                @if ($type == 'family')
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
                @endif
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
                            <select id="profession_id" class="form-select @error('pekerjaan') is-invalid @enderror"
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
                            <label for="kewarganegaraan" class="form-label label-important">Kewarganegaraan</label>
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
                            class="form-control @error('gambar') is-invalid @enderror" wire:model.lazy="ktp">
                        @if ($preview_ktp)
                            <button class="btn btn-sm btn-danger mt-3" type="button"
                                wire:click="setNull('ktp')">Hapus KTP
                                Terbaru</button>
                        @endif
                        @error('ktp')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        @if ($preview_ktp_old)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingKtpOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseKtpOne"
                                        aria-expanded="false" aria-controls="flush-collapseKtpOne">
                                        Foto KTP Saat Ini
                                    </button>
                                </h2>
                                <div id="flush-collapseKtpOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingKtpOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="preview">
                                            <img src="{{ $preview_ktp_old }}" class="w-100" alt="preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($preview_ktp)
                            <div class="accordion-item">
                                <h2 class="accordion-header d-flex gap-3" id="flush-headingKtpTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseKtpTwo"
                                        aria-expanded="false" aria-controls="flush-collapseKtpTwo">
                                        Foto KTP Terbaru
                                    </button>
                                </h2>
                                <div id="flush-collapseKtpTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingKtpTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <div class="preview">
                                            <img src="{{ $preview_ktp }}" class="w-100" alt="preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3 position-relative">
                        <label for="kk">Foto KK (Maks: 2Mb)</label>
                        <input type="file" id="kk" accept="image/*"
                            class="form-control @error('gambar') is-invalid @enderror" wire:model.lazy="kk">
                        @if ($preview_kk)
                            <button class="btn btn-sm btn-danger mt-3" type="button"
                                wire:click="setNull('kk')">Hapus KK
                                Terbaru</button>
                        @endif
                        @error('kk')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample2">
                        @if ($preview_kk_old)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingKkOne">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseKkOne"
                                        aria-expanded="false" aria-controls="flush-collapseKkOne">
                                        Foto KK Saat Ini
                                    </button>
                                </h2>
                                <div id="flush-collapseKkOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingKkOne" data-bs-parent="#accordionFlushExample2">
                                    <div class="accordion-body">
                                        <div class="preview">
                                            <img src="{{ $preview_kk_old }}" class="w-100" alt="preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($preview_kk)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingKkTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseKkTwo"
                                        aria-expanded="false" aria-controls="flush-collapseKkTwo">
                                        Foto KK Terbaru
                                    </button>
                                </h2>
                                <div id="flush-collapseKkTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingKkTwo" data-bs-parent="#accordionFlushExample2">
                                    <div class="accordion-body">
                                        <div class="preview">
                                            <img src="{{ $preview_kk }}" class="w-100" alt="preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-warning" wire:loading.attr='disabled'>
                    <i class="fas fa-save"></i>
                    Edit Data
                </button>
            </div>
        </form>
    </div>
</div>
