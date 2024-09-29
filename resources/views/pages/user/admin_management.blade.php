@extends('layout.main')

@section('container')
    <div id="user-management">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Manajemen Administrator
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Manajemen Administrator
                </li>
            </ol>
        </div>

        @livewire('users.admin', ['s' => $s])
    </div>
@endsection
