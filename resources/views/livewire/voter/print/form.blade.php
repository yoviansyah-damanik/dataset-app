<div class="card-2">
    @include('partials/loading')
    <div class="form-group mb-3 position-relative">
        <label for="jenis_laporan">
            Jenis Laporan
        </label>
        <select id="jenis_laporan" class="form-select" wire:model='jenis_laporan' wire:change="change_report"
            wire:loading.attr='disabled'>
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

    {{ var_export($district) }}
    {{ var_export($village) }}
    {{ var_export($tps) }}
    {{ var_export($team) }}
    {{ var_export($district != 'semua') }}
    {{ var_export($district != 'semua' && $village != 'semua') }}

    @if ($jenis_laporan)
        @if ($jenis_laporan == 'counter')
            <div class="mb-3">
                <label for="district">
                    Kecamatan
                </label>
                <div class="position-relative">
                    <div class="form-check">
                        <input class="form-check-input" id="district-all" type="checkbox" value="semua"
                            wire:model="all_districts">
                        <label class="form-check-label" for="district-all">
                            Semua
                        </label>
                    </div>
                    @foreach ($districts as $idx => $item)
                        <div class="form-check">
                            <input class="form-check-input" id="district-{{ $item['id'] }}" type="checkbox"
                                value="{{ $item['id'] }}" wire:model="district.{{ $idx }}"
                                @disabled($all_districts)>
                            <label class="form-check-label" for="district-{{ $item['id'] }}">
                                {{ $item['text'] }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('district')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @elseif ($jenis_laporan == 'voters')
            <div class='mb-3'>
                <div class="form-group position-relative">
                    <label for="type">
                        Tipe Tim
                    </label>
                    <select id="type_id" class="form-select" wire:model="type" wire:change="change_type">
                        <option value="tim_bersinar">Tim Bersinar</option>
                        <option value="tim_keluarga">Tim Keluarga</option>
                    </select>
                </div>
                @error('type')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            @if ($type == 'tim_bersinar')
                <div class="mb-3">
                    <div class="form-group position-relative">
                        <label for="district">
                            Kecamatan
                        </label>
                        <select id="district_id" class="form-select" wire:model="district" wire:change="set_villages">
                            @foreach ($districts as $item)
                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('district')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class='mb-3'>
                    <div class="form-group position-relative">
                        <label for="village">
                            Kelurahan/Desa
                        </label>
                        <select id="village_id" class="form-select" wire:model="village" wire:change="set_tpses">
                            @foreach ($villages as $item)
                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('village')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class='mb-3'>
                    <div class="form-group position-relative">
                        <label for="tps">
                            TPS
                        </label>
                        <select id="tps_id" class="form-select" wire:model="tps" wire:change="set_teams">
                            @foreach ($tpses as $item)
                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('tps')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class='mb-3'>
                    <div class="form-group position-relative">
                        <label for="team">
                            Tim Bersinar
                        </label>
                        @foreach ($teams as $idx => $item)
                            <div class="form-check">
                                <input class="form-check-input" id="team-{{ $item['id'] }}" type="checkbox"
                                    value="{{ $item['id'] }}" wire:model="team.{{ $idx }}"
                                    @if ($all_teams === true) checked @endif @disabled($all_teams)>
                                <label class="form-check-label" for="team-{{ $item['id'] }}">
                                    {{ $item['text'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('team')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @else
                <div class='mb-3'>
                    <div class="form-group position-relative">
                        <label for="team">
                            Tim Keluarga
                        </label>
                        <select id="team_id" class="form-select" wire:model="team">
                            @foreach ($teams as $item)
                                <option value="{{ $item['id'] }}">{{ $item['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('team')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            @endif
        @endif
    @endif

    <div class="text-end mt-4">
        <button class="btn btn-danger px-5" wire:click="print" wire:target="print" wire:loading.attr='disabled'>
            <i class="fas fa-print"></i>
            Cetak
        </button>
    </div>
</div>
