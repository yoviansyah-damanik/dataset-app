@extends('layout.main')

@section('container')
    <div class="position-relative">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Lihat Pemilih
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
                    Lihat Data
                </li>
            </ol>
        </div>
        <div class="card-2">
            <div class="d-block d-lg-flex gap-3">
                <div class="order-2 row d-lg-block" style="min-width: 250px;">
                    @if ($voter->ktp)
                        <div class="col-6 col-lg-12">
                            <a href="{{ $voter->ktp_path }}" class="glightbox foto_ktp mb-3">
                                <img src="{{ $voter->ktp_path }}" alt="Foto KTP {{ $voter->name }}"
                                    style="width:100%; max-width:450px;">
                            </a>
                        </div>
                    @endif
                    @if ($voter->kk)
                        <div class="col-6 col-lg-12">
                            <a href="{{ $voter->kk_path }}" class="glightbox foto_kk order-2">
                                <img src="{{ $voter->kk_path }}" alt="Foto KK {{ $voter->name }}"
                                    style="width:100%; max-width:450px;">
                            </a>
                        </div>
                    @endif
                    <div class="col-12 text-center">
                        @haspermission('update voter')
                            <a type="button" href="{{ route('voters.edit', $voter->id) }}" data-bs-toggle="tooltip"
                                class="btn btn-sm btn-warning text-white" title="Edit!">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endhaspermission
                        @haspermission('delete voter')
                            <form class="d-inline" action="{{ route('voters.delete', $voter->id) }}">
                                @csrf
                                <button id="delete-button" type="submit" class="btn btn-sm btn-danger" title="Hapus!"
                                    data-bs-toggle="tooltip">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endhaspermission
                    </div>
                </div>
                <table class="table table-borderless order-1">
                    <tr>
                        <th style="background-color: var(--topbar-color); text-align: center; color:#fff;" colspan=2>
                            Data Pemilih
                        </th>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $voter->nik }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $voter->name }}</td>
                    </tr>
                    <tr>
                        <th>No. Telp.</th>
                        <td>{{ $voter?->phone_number ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $voter?->address ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>RT: {{ $voter->rt }} / RW: {{ $voter->rw }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tempat, Tgl Lahir</th>
                        <td>{{ $voter->place_of_birth . ', ' . $voter->date_of_birth->translatedFormat('d F Y') }}
                            ({{ $voter->umur }})
                        </td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $voter->gender }}
                        </td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>{{ $voter->religion->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status Perkawinan</th>
                        <td>{{ $voter->marital_status->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $voter->profession->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Kewarganegaraan</th>
                        <td>{{ $voter->nasionality->name }}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: var(--topbar-color); text-align: center; color:#fff;" colspan=2>
                            Data DPT
                        </th>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $voter->dpt->name }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $voter->dpt->address }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $voter->dpt->genderFull }}
                        </td>
                    </tr>
                    <tr>
                        <th>TPS</th>
                        <td>TPS {{ $voter->dpt->tps->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Kelurahan/Desa</th>
                        <td>{{ $voter->dpt->village->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $voter->dpt->district->name }}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: var(--topbar-color); text-align: center; color:#fff;" colspan=2>
                            Data Basis
                        </th>
                    </tr>
                    <tr>
                        <th>Kecamatan</th>
                        <td>{{ $voter->district->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>Kelurahan/Desa</th>
                        <td>{{ $voter->village->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>TPS</th>
                        <td>{{ $voter->tps->name }}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: var(--topbar-color); text-align: center; color:#fff;" colspan=2>
                            Data Koordinator
                        </th>
                    </tr>
                    <tr>
                        <th>Koordinator Kecamatan</th>
                        <td>{{ $voter->district_coor->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>Koordinator Kelurahan/Desa</th>
                        <td>{{ $voter->village_coor->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>Koordinator TPS</th>
                        <td>{{ $voter->tps_coor->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>Tim Bersinar</th>
                        <td>{{ $voter->team_by->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: var(--topbar-color); text-align: center; color:#fff;" colspan=2>
                            Data Lainnya
                        </th>
                    </tr>
                    <tr>
                        <th>Ditambahkan oleh</th>
                        <td>{{ $voter->created_by->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>Terakhir diperbaharui</th>
                        <td>{{ $voter->updated_at->format('d M Y H:i:s') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('heads')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
@endpush
@push('scripts')
    <script type="text/javascript">
        const lightbox = GLightbox({
            zoomable: true,
            closeEffect: 'fade',
        });

        $('#delete-button').on('click', (e) => {
            e.preventDefault();

            Swal.fire({
                title: "Perhatian!",
                text: "Apakah kamu yakin akan menghapus data pemilih tersebut?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.clear()
                    $('.loading-area').fadeIn()
                    $(e.target).closest("form").submit(); // Post the surrounding form
                }
            });
        })
    </script>
@endpush
