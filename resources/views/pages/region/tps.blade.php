@extends('layout.main')

@section('container')
    <div id="tpses">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Data Master TPS
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('region') }}">
                        Data Rekap
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Data Master TPS
                </li>
            </ol>
        </div>

        <div class="alert alert-warning" role="alert">
            <strong>Perhatian!</strong> Hanya data yang tidak digunakan pada Pemilih yang dapat dihapus.
        </div>

        <div class="card-2 mb-3">
            @haspermission('create tps')
                <div class="position-relative pb-5">
                    <button class="add-data" data-bs-toggle="modal" data-bs-target="[data-modal-target=createTps]">
                        <i class="fas fa-plus"></i>
                        <div class="small mt-1">
                            TPS
                        </div>
                    </button>
                </div>
            @endhaspermission

            <h5 class="mb-3">Data TPS</h5>
            @livewire('region.tps.datalist')
        </div>

        @haspermission('update tps')
            {{-- Modal Edit TPS --}}
            <div class="modal fade" data-modal-target="editTps" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit TPS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('region.tps.edit')
                    </div>
                </div>
            </div>
        @endhaspermission

        @haspermission('create tps')
            {{-- Modal Tambah TPS --}}
            <div class="modal fade" data-modal-target="createTps" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah TPS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        @livewire('region.tps.create')
                    </div>
                </div>
            </div>
        @endhaspermission

        {{-- Modal Lihat Pemilih --}}
        <div class="modal fade" data-modal-target="showVoters" data-bs-keyboard="false"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-2xl modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Lihat Pemilih</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @livewire('voter.show-all')
                </div>
            </div>
        </div>
    </div>
@endsection
