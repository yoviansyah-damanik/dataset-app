@extends('layout.main')

@section('container')
    @livewire('voter.edit', ['voter' => $voter])
@endsection
