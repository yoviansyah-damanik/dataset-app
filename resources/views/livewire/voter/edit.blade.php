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
                        <label for="nama" class="form-label">Nama</label>
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
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
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
                    <div class="form-group mb-3 position-relative">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            id="date" wire:model.lazy="tanggal_lahir">
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
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                            wire:model.lazy="alamat" />
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
                {{-- <div class="col-lg-2 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select wire:model="kecamatan" id="district_id"
                            class="form-select @error('kecamatan') is-invalid @enderror"
                            @disabled(!in_array(auth()->user()->role_name, ['Superadmin', 'Administrator']))>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('kecamatan')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <select wire:model="kelurahan" id="village_id"
                            class="form-select @error('kelurahan') is-invalid @enderror"
                            @disabled(!in_array(auth()->user()->role_name, ['Superadmin', 'Administrator', 'Koordinator Kecamatan']))>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                        @error('kelurahan')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="tps" class="form-label">TPS</label>
                        <select wire:model="tps" id="tps_id"
                            class="form-select @error('tps') is-invalid @enderror" @disabled(
                                !in_array(auth()->user()->role_name, [
                                    'Superadmin',
                                    'Administrator',
                                    'Koordinator Kecamatan',
                                    'Koordinator Kelurahan/Desa',
                                ]))>
                            @foreach ($tps_ as $tps__)
                                <option value="{{ $tps__->id }}">{{ $tps__->name }}</option>
                            @endforeach
                        </select>
                        @error('tps')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="agama" class="form-label">Agama</label>
                        <select id="religion_id" class="form-select @error('agama') is-invalid @enderror">
                            @foreach ($religions as $religion)
                                <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select id="marital_status_id"
                            class="form-select @error('status_perkawinan') is-invalid @enderror">
                            @foreach ($marital_statuses as $marital_status)
                                <option value="{{ $marital_status->id }}">{{ $marital_status->name }}</option>
                            @endforeach
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <select id="profession_id" class="form-select @error('pekerjaan') is-invalid @enderror">
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                            @endforeach
                        </select>
                        @error('pekerjaan')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group mb-3 position-relative" wire:ignore>
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <select id="nasionality_id"
                            class="form-select @error('kewarganegaraan') is-invalid @enderror">
                            @foreach ($nasionalities as $nasionality)
                                <option value="{{ $nasionality->id }}">{{ $nasionality->name }}</option>
                            @endforeach
                        </select>
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
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingKtpOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseKtpOne" aria-expanded="false"
                                    aria-controls="flush-collapseKtpOne">
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
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingKkOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseKkOne" aria-expanded="false"
                                    aria-controls="flush-collapseKkOne">
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#religion_id').val(@this.get('agama'))
            $('#marital_status_id').val(@this.get('status_perkawinan'))
            $('#profession_id').val(@this.get('pekerjaan'))
            $('#nasionality_id').val(@this.get('kewarganegaraan'))
            setAdditionalInput()
        })

        function setAdditionalInput() {
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
    </script>
@endpush
