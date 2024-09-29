@extends('layout.main')

@section('container')
    <div id="marital-statuss">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Data Status Perkawinan
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
                    Data Status Perkawinan
                </li>
            </ol>
        </div>

        <div class="alert alert-warning" role="alert">
            <strong>Perhatian!</strong> Hanya data yang tidak digunakan pada Pemilih yang dapat dihapus.
        </div>

        <div class="card-2 mb-3">
            @haspermission('create marital_status')
                <div class="position-relative pb-5">
                    <button class="add-data" data-bs-toggle="modal" data-bs-target="[data-modal-target=createMaritalStatus]">
                        <i class="fas fa-plus"></i>
                        <div class="small mt-1">
                            Status Perkawinan
                        </div>
                    </button>
                </div>
            @endhaspermission

            <h5 class="mb-3">Data Status Perkawinan</h5>
            @livewire('master.marital-status.datalist')
        </div>

        @haspermission('create marital_status')
            {{-- Modal Edit Status Perkawinan --}}
            <div class="modal fade" data-modal-target="editMaritalStatus" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Status Perkawinan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.marital-status.edit')
                    </div>
                </div>
            </div>
        @endhaspermission

        @haspermission('update marital_status')
            {{-- Modal Tambah Status Perkawinan --}}
            <div class="modal fade" data-modal-target="createMaritalStatus" data-bs-keyboard="false"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Status Perkawinan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('master.marital-status.create')
                    </div>
                </div>
            </div>
        @endhaspermission
    </div>
@endsection
