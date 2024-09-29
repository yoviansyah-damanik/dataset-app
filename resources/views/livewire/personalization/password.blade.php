<div>
    @include('partials.loading')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="old_password">Kata Sandi Lama</label>
                <input type="password" id="old_password" wire:model="old_password" class="form-control">
                @error('old_password')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="new_password">Kata Sandi Baru</label>
                <input type="password" id="new_password" wire:model="new_password" class="form-control">
                @error('new_password')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="confirm_new_password">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="confirm_new_password" wire:model="confirm_new_password" class="form-control">
                @error('confirm_new_password')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-end">
            <button class="btn btn-primary" wire:click='update' wire:loading.attr='disabled'>
                <i class="fas fa-upload"></i>
                Simpan
            </button>
        </div>
    </div>
</div>
