<div class="card-2">
    @include('partials/loading')
    <div class="form-group mb-3 position-relative">
        <label for="jenis_laporan">
            Jenis Laporan
        </label>
        <select id="jenis_laporan" class="form-select" wire:model='jenis_laporan' wire:loading.attr='disabled'>
            <option hidden>--Pilih Jenis Laporan--</option>
            @foreach ($available_reports as $report)
                <option value="{{ $report['value'] }}">{{ $report['title'] }}</option>
            @endforeach
        </select>
        @error('jenis_laporan')
            <div class="invalid-tooltip">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <div class="form-group position-relative" wire:ignore>
            <label for="district">
                Kecamatan
            </label>
            <select id="district_id" class="form-select">
                <option value="semua">Semua Kecamatan</option>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        @error('district')
            <div class="invalid-tooltip">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="text-end mt-4">
        <button class="btn btn-danger px-5" wire:click="print" wire:target="print" wire:loading.attr='disabled'>
            <i class="fas fa-print"></i>
            Cetak
        </button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#district_id').val(@this.district)
            $('#district_id').select2({
                placeholder: "Pilih Kecamatan",
                theme: "bootstrap-5",
                language: "id",
            });

            $('#district_id').on('change', function(e) {
                var data = $('#district_id').select2("val");
                @this.set('district', data);
            });
        })
    </script>
@endpush
