@extends('layout.main')

@section('container')
    <livewire:region />

    {{-- Modal Lihat Pemilih --}}
    <div class="modal fade" data-modal-target="showVoters" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
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
@endsection
