@extends('layout.main')

@section('container')
    <div id="edit-user">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Personalisasi
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Personalisasi
                </li>
            </ol>
        </div>

        @if (!in_array(auth()->user()->role_name, ['Administrator', 'Administrator Keluarga']))
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card-2">
                        <h5 class="mb-3">Profil</h5>
                        @livewire('personalization.profile')
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 mt-3 mt-lg-0">
                    <div class="card-2">
                        <h5 class="mb-3">Kata Sandi</h5>
                        @livewire('personalization.password')
                    </div>
                </div>
            </div>
        @else
            Hubungi Superadmin untuk melakukan perubahan data.
        @endif
    </div>
@endsection
