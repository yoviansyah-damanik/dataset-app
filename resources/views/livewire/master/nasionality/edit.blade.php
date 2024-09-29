<div>
    <div class="modal-body">
        <div class="form-group mb-3 position-relative">
            <label for="name">Nama Kewarganegaraan</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama Kewarganegaraan..." wire:model="name">
            @error('name')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" wire:loading.attr='disabled' data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-warning text-white" wire:click="update" wire:loading.attr='disabled'>
            <i class="fas fa-edit"></i>
            Edit Kewarganegaraan
        </button>
    </div>
</div>
