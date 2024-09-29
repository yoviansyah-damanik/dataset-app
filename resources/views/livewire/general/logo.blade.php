<div>
    @include('partials.loading')
    <div class="form-group mb-3 position-relative">
        <label for="logo">Logo Utama</label>
        <input type="file" class="form-control" wire:model='logo' accept="image/*">
        <div wire:loading wire:target="logo">Mengunggah...</div>
        @error('logo')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
        <div class="d-flex">
            <div class="preview me-3">
                <div class="preview-text">
                    Saat ini:
                </div>
                <div class="preview-image">
                    <img src="{{ GeneralHelper::get_app_logo() }}">
                </div>
            </div>
            @if ($logo)
                <div class="preview">
                    <div class="preview-text">
                        Preview:
                    </div>
                    <div class="preview-image">
                        <img src="{{ $logo->temporaryUrl() }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group mb-3 position-relative">
        <label for="favicon">Favicon</label>
        <input type="file" class="form-control" wire:model='favicon' accept="image/*">
        <div wire:loading wire:target="favicon">Mengunggah...</div>
        @error('favicon')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
        <div class="d-flex">
            <div class="preview me-3">
                <div class="preview-text">
                    Saat ini:
                </div>
                <div class="preview-image">
                    <img src="{{ GeneralHelper::get_favicon() }}">
                </div>
            </div>
            @if ($favicon)
                <div class="preview">
                    <div class="preview-text">
                        Preview:
                    </div>
                    <div class="preview-image">
                        <img src="{{ $favicon->temporaryUrl() }}">
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group mb-3 position-relative">
        <label for="ads">Ads</label>
        <input type="file" class="form-control" wire:model='ads' accept="image/*">
        <div wire:loading wire:target="ads">Mengunggah...</div>
        @error('ads')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
        <div class="d-flex">
            <div class="preview me-3">
                <div class="preview-text">
                    Saat ini:
                </div>
                <div class="preview-image">
                    <img src="{{ GeneralHelper::get_ads() }}">
                </div>
            </div>
            @if ($ads)
                <div class="preview">
                    <div class="preview-text">
                        Preview:
                    </div>
                    <div class="preview-image">
                        <img src="{{ $ads->temporaryUrl() }}">
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
