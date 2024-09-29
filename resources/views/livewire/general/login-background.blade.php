<div>
    @include('partials.loading')
    <div class="form-group mb-3 position-relative">
        <label for="login_background">Background</label>
        <input type="file" class="form-control" wire:model='login_background' accept="image/*">
        <div wire:loading wire:target="login_background">Uploading...</div>
        @error('login_background')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
        <div class="d-flex">
            <div class="preview me-3">
                <div class="preview-text">
                    Saat ini:
                </div>
                <div class="preview-background">
                    <img src="{{ GeneralHelper::get_login_background() }}">
                </div>
            </div>
            @if ($login_background)
                <div class="preview">
                    <div class="preview-text">
                        Preview:
                    </div>
                    <div class="preview-background">
                        <img src="{{ $login_background->temporaryUrl() }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="mt-4 text-end">
        <button class="btn btn-primary" wire:click='update' wire:loading.attr='disabled'>
            <i class="fas fa-save"></i>
            Simpan
        </button>
    </div>
</div>
