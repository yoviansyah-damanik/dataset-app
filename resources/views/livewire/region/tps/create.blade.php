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
        <div class="mb-3 position-relative">
            <div class="form-group" wire:ignore>
                <label for="village_id">Kelurahan/Desa</label>
                <select class="form-select" id="village_id">
                    @foreach ($villages as $village)
                        <option value="{{ $village->id }}">{{ $village->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('village_id')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3 position-relative">
            <label for="name">Nama TPS</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                placeholder="Masukkan nama TPS..." wire:model="name">
            @error('name')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3 position-relative">
            <label for="voters_total">Total DPT</label>
            <input type="text" class="form-control @error('voters_total') is-invalid @enderror"
                placeholder="Masukkan total DPT..." wire:model="voters_total">
            @error('voters_total')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" wire:loading.attr='disabled'
                data-bs-dismiss="modal">Tutup</button>
            <button class="btn btn-primary" wire:click='store' wire:loading.attr='disabled'>
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        const setVillageSelect = (data) => {
            if (data) {
                $('#village_id').empty()
                $('#village_id').select2({
                    placeholder: "Pilih Kelurahan/Desa",
                    theme: "bootstrap-5",
                    data: data,
                    language: "id",
                });
            } else
                $('#village_id').select2({
                    placeholder: "Pilih Kelurahan/Desa",
                    theme: "bootstrap-5",
                    language: "id",
                });

            $('#village_id').on('change', function(e) {
                var data = $('#village_id').select2("val");
                @this.set('village_id', data);
            });
        }

        const resetDistrict = () => {
            $('#district_id').val('')
            $('#district_id').select2({
                placeholder: "Pilih Kecamatan",
                theme: "bootstrap-5",
                language: "id",
            });
        }

        $(window).on('resetDistrict', (data) => {
            resetDistrict()
        })

        $(window).on('setVillageData', (data) => {
            setVillageSelect(data.detail)
        })

        $(document).ready(function() {
            resetDistrict()

            $('#district_id').on('change', function(e) {
                var data = $('#district_id').select2("val");
                @this.set('district_id', data);
                @this.call('set_villages')
            });
            setVillageSelect()
        })
    </script>
@endpush
