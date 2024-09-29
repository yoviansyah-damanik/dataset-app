<div>
    <div class="modal-body">
        <div class="form-group mb-3 position-relative">
            <label for="name">Nama Agama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama Agama..." wire:model="name">
            @error('name')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" wire:loading.attr='disabled' data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-primary" wire:click='store' wire:loading.attr='disabled'>
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
</div>
