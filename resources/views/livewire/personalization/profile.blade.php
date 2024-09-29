<div>
    @include('partials.loading')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="username">Nama Pengguna</label>
                <input type="text" id="username" wire:model="username" class="form-control">
                @error('username')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="fullname">Nama Lengkap</label>
                <input type="text" id="fullname" wire:model="fullname" class="form-control">
                @error('fullname')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group position-relative">
                <label for="email">Email</label>
                <input type="email" id="email" wire:model="email" class="form-control">
                @error('email')
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
