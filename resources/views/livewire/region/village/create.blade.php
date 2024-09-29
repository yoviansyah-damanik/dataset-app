<div>
    <div class="modal-body">
        <div class="mb-3 position-relative">
            <div class="form-group" wire:ignore>
                <label for="district_id">Kecamatan</label>
                <select class="form-select" id="district_id">
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('district_id')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3 position-relative">
            <label for="name">Nama Kelurahan/Desa</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama kelurahan/desa..." wire:model="name">
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#district_id').val('')
            $('#district_id').select2({
                placeholder: "Pilih Kecamatan",
                theme: "bootstrap-5",
                language: "id",
            });
            $('#district_id').on('change', function(e) {
                var data = $('#district_id').select2("val");
                @this.set('district_id', data);
            });
        })
    </script>
@endpush
