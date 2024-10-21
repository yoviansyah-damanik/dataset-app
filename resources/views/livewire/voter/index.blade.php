<div class="position-relative">
    @include('partials/loading')
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Data Pemilih
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Pemilih
            </li>
        </ol>
    </div>
    <div class="card-2">
        @haspermission('create voter')
            <div class="position-relative pb-5">
                <a href="{{ route('voters.create') }}" class="add-data">
                    <i class="fas fa-plus"></i>
                    <div class="small mt-1">
                        Pemilih
                    </div>
                </a>
            </div>
        @endhaspermission
        <div class="d-md-flex align-items-md-start gap-4 justify-content-md-between d-block">
            <div class="row flex-fill">
                <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                    <div class="input-group">
                        <div class="input-group-text" id="per_page">
                            <i class="fas fa-pager"></i>
                        </div>
                        <select class="form-select" wire:model="per_page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-filter"></i>
                            </div>
                            <select class="form-select" wire:model='district' @disabled(!in_array(auth()->user()->role_name, ['Superadmin', 'Administrator Keluarga']))>
                                <option value="">--Tidak ada kecamatan dipilih--</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
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
                            <select class="form-select" wire:model='village' @disabled(
                                !in_array(auth()->user()->role_name, [
                                    'Superadmin',
                                    'Koordinator Kecamatan',
                                    'Administrator',
                                    'Administrator Keluarga',
                                ]))>
                                <option value="">--Tidak ada kelurahan/desa dipilih--</option>
                                @foreach ($villages as $village)
                                    <option value="{{ $village->id }}">{{ $village->name }}</option>
                                @endforeach
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
                            <select class="form-select" wire:model='tps' @disabled(
                                !in_array(auth()->user()->role_name, [
                                    'Superadmin',
                                    'Koordinator Kecamatan',
                                    'Koordinator Kelurahan/Desa',
                                    'Administrator',
                                    'Administrator Keluarga',
                                ]))>
                                <option value="">--Tidak ada TPS dipilih--</option>
                                @foreach ($tpses as $tps)
                                    <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if (!in_array(auth()->user()->role_name, ['Koordinator Keluarga', 'Administrator Keluarga']))
                    <div class="col-sm-6 col-lg-6 col-xxl-4 mb-3">
                        <div class="input-group">
                            <div class="input-group-text" id="btnGroupAddon3">
                                <i class="fas fa-sort"></i>
                            </div>
                            <select class="form-select" wire:model="type">
                                <option value="semua">--Semua Tim--</option>
                                <option value="bersinar">Tim Bersinar</option>
                                <option value="keluarga">Tim Keluarga</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row mx-0 justify-content-end" style="width: 100%; max-width: 700px">
                <div class="col-sm-12 px-0">
                    <div class="input-group">
                        <div class="input-group-text" id="btnGroupAddon2">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="search" class="form-control w-50" id="colFormLabelSm" placeholder="Cari..."
                            wire:model="search">
                        <select class="form-select" wire:model="attribute_search">
                            <option value="name">Nama</option>
                            <option value="nik">NIK</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 px-0">
                    <div class="input-group">
                        <div class="input-group-text" id="btnGroupAddon2">
                            <i class="fas fa-filter"></i>
                        </div>
                        <select class="form-select me-0 me-sm-2" wire:model="filter">
                            <option value="">--Tidak ada filter dipilih--</option>
                            <optgroup label="Jenis Kelamin">
                                <option value="gender-1">Laki-laki</option>
                                <option value="gender-2">Perempuan</option>
                            </optgroup>
                            <optgroup label="Umur">
                                <option value="age-1">17 - 25 Tahun</option>
                                <option value="age-2">25 - 35 Tahun</option>
                                <option value="age-3">35 - 45 Tahun</option>
                                <option value="age-4">45 - 55 Tahun</option>
                                <option value="age-5">> 55 Tahun</option>
                            </optgroup>
                            <optgroup label="File">
                                <option value="file-1">Ada KTP</option>
                                <option value="file-2">Ada KK</option>
                                <option value="file-3">Ada KTP + KK</option>
                                <option value="file-4">Tidak ada KTP</option>
                                <option value="file-5">Tidak ada KK</option>
                                <option value="file-6">Tidak ada KTP + KK</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 px-0">
                    <div class="input-group">
                        <div class="input-group-text" id="btnGroupAddon2">
                            <i class="fas fa-sort"></i>
                        </div>
                        <select class="form-select" wire:model="sortBy">
                            <option value="">--Tidak ada pengurutan dipilih--</option>
                            <option value="sortBy-1">Termuda</option>
                            <option value="sortBy-2">Tertua</option>
                            <option value="sortBy-3">Nama | A-Z</option>
                            <option value="sortBy-4">Nama | Z-A</option>
                            <option value="sortBy-5">Terbaru</option>
                            <option value="sortBy-6">Terlama</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        Total: {{ GeneralHelper::number_format($voters->total()) }} Pemilih
        <div class="table-responsive mt-2">
            <table class="table table-striped" wire:loading.class="opacity-50">
                <thead class="text-center">
                    <th>#</th>
                    <th style="min-width: 550px;" colspan=2>Data Pemilih</th>
                    <th style="min-width: 180px;">Basis</th>
                    <th style="min-width: 80px;">
                        KTP
                    </th>
                    <th style="min-width: 80px;">
                        KK
                    </th>
                    <th style="min-width: 180px;">Aksi</th>
                </thead>
                <tbody>
                    @forelse ($voters as $voter)
                        <tr>
                            <td class="text-center">
                                {{ ($voters->currentPage() - 1) * $voters->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="mb-4">
                                    <div class="fw-bold text-nowrap">
                                        {{ $voter->name }}
                                    </div>
                                    <div class="fw-light text-nowrap">
                                        NIK. {{ $voter->nik }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Tempat Lahir
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->place_of_birth ?: '-' }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Umur
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->age }} Tahun
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Jenis Kelamin
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->gender }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        No. Telp.
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->phone_number ?: '-' }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Alamat
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->address ?: '-' }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Agama
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->religion->name }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Status Perkawinan
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->marital_status->name }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Pekerjaan
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->profession->name }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Kewarganegaraan
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->nasionality->name }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($voter->family_coor_id)
                                    <div class="badge bg-success">
                                        Tim Keluarga
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Koordinator Keluarga
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            @if (in_array(auth()->user()->role_name, ['Superadmin']))
                                                <a
                                                    href="{{ route('users', ['s' => $voter->family_coor->fullname]) }}">
                                                    {{ $voter->family_coor->fullname }}
                                                </a>
                                            @else
                                                {{ $voter->family_coor->fullname }}
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="badge bg-danger">
                                        Tim Bersinar
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Koordinator
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            @if (in_array(auth()->user()->role_name, ['Superadmin']))
                                                <a href="{{ route('users', ['s' => $voter->team_by->fullname]) }}">
                                                    {{ $voter->team_by->fullname }}
                                                </a>
                                            @else
                                                {{ $voter->team_by->fullname }}
                                            @endif
                                        </div>
                                    </div>
                                @endif
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
                                <div class="d-flex gap-1">
                                    <div class="fw-bold voter-table-width">
                                        Diperbaharui pada
                                    </div>
                                    <div style="flex: 1 1 0%">
                                        {{ $voter->updated_at->translatedFormat('d M Y H:i:s') }}
                                    </div>
                                </div>


                            </td>
                            <td class="text-center">
                                @if ($voter->ktp)
                                    <span class="text-success" data-bs-toggle="tooltip" title="Ada!">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @else
                                    <span class="text-danger" data-bs-toggle="tooltip" title="Tidak ada!">
                                        <i class="fas fa-times"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($voter->kk)
                                    <span class="text-success" data-bs-toggle="tooltip" title="Ada!">
                                        <i class="fas fa-check"></i>
                                    </span>
                                @else
                                    <span class="text-danger" data-bs-toggle="tooltip" title="Tidak ada!">
                                        <i class="fas fa-times"></i>
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center align-items-center">
                                    <a type="button" href="{{ route('voters.show', $voter->id) }}"
                                        data-bs-toggle="tooltip" class="btn btn-sm btn-info text-white"
                                        title="Lihat selengkapnya!">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @haspermission('update voter')
                                        <a type="button" href="{{ route('voters.edit', $voter->id) }}"
                                            data-bs-toggle="tooltip" class="btn btn-sm btn-warning text-white"
                                            title="Edit!">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endhaspermission
                                    @haspermission('delete voter')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus!"
                                            data-bs-toggle="tooltip"
                                            wire:click="$emit('trigger_destroy','{{ $voter->id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endhaspermission
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan=16>Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 mx-auto">
            {{ $voters->onEachSide(1)->links() }}
        </div>
    </div>
</div>

@once
    @push('heads')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    @endpush
@endonce
@push('scripts')
    <script type="text/javascript">
        const lightbox = GLightbox({
            closeEffect: 'fade',
            zoomable: true
        });

        document.addEventListener("votersLoaded", () => {
            lightbox.reload();
        });

        document.addEventListener('DOMContentLoaded', function() {
            @this.on('trigger_destroy', destroy => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan menghapus pemilih ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {
                        // calling destroy method to delete
                        @this.call('destroy', destroy)
                        // success response
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
        })
    </script>
@endpush
