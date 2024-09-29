@extends('layout.main')

@section('container')
    <div id="general">
        <div class="breadcrumb-area">
            <div class="fw-bold fs-3 text-uppercase">
                Log Aktivitas
            </div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Log Aktivitas
                </li>
            </ol>
        </div>

        @livewire('log.index')
    </div>
@endsection
