<div>
    <div class="modal-body">
        <div class="p-2">
            @include('partials/loading')
            <div class="row">
                {{-- NAME --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="name">Nama Kecamatan</label>
                        <input type="text" id="name"class="form-control @error('name') is-invalid @enderror"
                            wire:model.defer="name" placeholder="Masukkan nama kecamatan...">
                        @error('name')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" wire:loading.attr='disabled' data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-warning text-white" wire:click="update" wire:loading.attr='disabled'>
            <i class="fas fa-edit"></i>
            Edit Kecamatan
        </button>
    </div>
</div>
