@extends('layout.main')

@section('container')
    <div id="general">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Pengaturan Umum
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Pengaturan Umum
                </li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-7 col-md-6">
                <div class="card-2 mb-4">
                    <h5 class="mb-3">Data Calon</h5>
                    @livewire('general.candidate')
                </div>
                <div class="card-2 mb-4">
                    <h5 class="mb-3">Informasi Sistem</h5>
                    @livewire('general.information')
                </div>
                <div class="card-2">
                    <h5>Login Background</h5>
                    <div class="small text-muted mb-3">
                        Gambar yang diupload disarankan memiliki rasio 16:9 (Contoh 1920px * 1080px) dan ukuran file
                        maksimal 1mb (1024kb).
                    </div>
                    @livewire('general.login-background')
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <div class="card-2">
                    <h5>Logo</h5>
                    <div class="small text-muted mb-3">
                        Gambar yang diupload disarankan memiliki rasio 1:1 (Contoh: 400px * 400px / 500px * 500px) dan
                        ukuran file maksimal 1mb (1024kb).
                    </div>
                    @livewire('general.logo')
                </div>
            </div>
        </div>
    </div>
@endsection
