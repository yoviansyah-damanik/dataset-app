@extends('layout.main')

@section('container')
    <div id="nasionalitys">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Data Kewarganegaraan
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('master') }}">
                        Data Rekap
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Data Kewarganegaraan
                </li>
            </ol>
        </div>

        <div class="alert alert-warning" role="alert">
            <strong>Perhatian!</strong> Hanya data yang tidak digunakan pada Pemilih yang dapat dihapus.
        </div>

        <div class="card-2 mb-3">
            @haspermission('create nasionality')
                <div class="position-relative pb-5">
                    <button class="add-data" data-bs-toggle="modal" data-bs-target="[data-modal-target=createNasionality]">
                        <i class="fas fa-plus"></i>
                        <div class="small mt-1">
                            Kewarganegaraan
                        </div>
                    </button>
                </div>
            @endhaspermission

            <h5 class="mb-3">Data Kewarganegaraan</h5>
            @livewire('master.nasionality.datalist')
        </div>

        @haspermission('update nasionality')
            {{-- Modal Edit Kewarganegaraan --}}
            <div class="modal fade" data-modal-target="editNasionality" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Kewarganegaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.nasionality.edit')
                    </div>
                </div>
            </div>
        @endhaspermission

        @haspermission('delete nasionality')
            {{-- Modal Tambah Kewarganegaraan --}}
            <div class="modal fade" data-modal-target="createNasionality" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Kewarganegaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.nasionality.create')
                    </div>
                </div>
            </div>
        @endhaspermission
    </div>
@endsection
