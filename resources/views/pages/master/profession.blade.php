@extends('layout.main')

@section('container')
    <div id="professions">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Data Pekerjaan
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
                    Data Pekerjaan
                </li>
            </ol>
        </div>

        <div class="alert alert-warning" role="alert">
            <strong>Perhatian!</strong> Hanya data yang tidak digunakan pada Pemilih yang dapat dihapus.
        </div>

        <div class="card-2 mb-3">
            @haspermission('create profession')
                <div class="position-relative pb-5">
                    <button class="add-data" data-bs-toggle="modal" data-bs-target="[data-modal-target=createProfession]">
                        <i class="fas fa-plus"></i>
                        <div class="small mt-1">
                            Pekerjaan
                        </div>
                    </button>
                </div>
            @endhaspermission

            <h5 class="mb-3">Data Pekerjaan</h5>
            @livewire('master.profession.datalist')
        </div>

        @haspermission('update profession')
            {{-- Modal Edit Pekerjaan --}}
            <div class="modal fade" data-modal-target="editProfession" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Pekerjaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.profession.edit')
                    </div>
                </div>
            </div>
        @endhaspermission

        @haspermission('delete profession')
            {{-- Modal Tambah Pekerjaan --}}
            <div class="modal fade" data-modal-target="createProfession" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Pekerjaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.profession.create')
                    </div>
                </div>
            </div>
        @endhaspermission
    </div>
@endsection
