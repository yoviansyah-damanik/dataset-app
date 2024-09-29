<div>
    <div class="row">
        <div class="col-lg-8">
            <div class="form-group mb-3 position-relative">
                <label for="app_name">
                    Nama Aplikasi
                </label>
                <input type="text" class="form-control" wire:model='app_name'>
                @error('app_name')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group mb-3 position-relative">
                <label for="app_name_abb">
                    Singkatan
                </label>
                <input type="text" class="form-control" wire:model='app_name_abb'>
                @error('app_name_abb')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group mb-3 position-relative">
                <label for="unit_name">
                    Nama Instansi/Organisasi Pengguna Aplikasi
                </label>
                <input type="text" class="form-control" wire:model='unit_name'>
                @error('unit_name')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="mt-4 text-end">
        <button class="btn btn-primary" wire:click='update' wire:loading.attr='disabled'>
            <i class="fas fa-save"></i>
            Simpan
        </button>
    </div>
</div>
