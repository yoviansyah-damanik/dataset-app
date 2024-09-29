<div>
    <div class="modal-body">
        <div class="p-2">
            @include('partials/loading')
            <div class="row">
                {{-- USERNAME --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="username">Nama Pengguna</label>
                        <input type="text" id="username"class="form-control @error('username') is-invalid @enderror"
                            wire:model="username" placeholder="Masukkan nama pengguna...">
                        @error('username')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- FULLNAME --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" id="fullname"class="form-control @error('fullname') is-invalid @enderror"
                            wire:model="fullname" placeholder="Masukkan nama lengkap...">
                        @error('fullname')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- EMAIL --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            wire:model="email" placeholder="Masukkan nama email...">
                        @error('email')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- ROLE --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="role_name">Role</label>
                        <select id="role_name" class="form-select @error('role_name') is-invalid @enderror"
                            wire:model="role_name" wire:change='set_init'>
                            <option hidden>--Pilih Role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_name')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                @if (in_array($role_name, [
                        'Administrator',
                        'Koordinator Kecamatan',
                        'Koordinator Kelurahan/Desa',
                        'Koordinator TPS',
                        'Tim Bersinar',
                    ]))
                    {{-- DISTRICT --}}
                    <div class="col-12">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="district_id">Kecamatan</label>
                                <select id="district_id" class="form-select">
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
                    </div>
                    @if (in_array($role_name, ['Koordinator Kelurahan/Desa', 'Koordinator TPS', 'Tim Bersinar']))
                        {{-- VILLAGES --}}
                        <div class="col-12">
                            <div class="mb-3 position-relative">
                                <div class="form-group" wire:ignore>
                                    <label for="village_id">Kelurahan/Desa</label>
                                    <select id="village_id" class="form-select ">
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
                        </div>
                    @endif
                    @if (in_array($role_name, ['Koordinator TPS', 'Tim Bersinar']))
                        {{-- TPS --}}
                        <div class="col-12">
                            <div class="mb-3 position-relative">
                                <div class="form-group" wire:ignore>
                                    <label for="tps_id">TPS</label>
                                    <select id="tps_id" class="form-select">
                                        @foreach ($tps_ as $tps__)
                                            <option value="{{ $tps__->id }}">{{ $tps__->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('tps_id')
                                    <div class="invalid-tooltip">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endif
                @endif
                {{-- PASSWORD --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="password">Kata Sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            wire:model="password" placeholder="Masukkan nama kata sandi...">
                        @error('password')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" wire:loading.attr='disabled' data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-primary" wire:click="store" wire:loading.attr='disabled'>
            <i class="fas fa-plus"></i>
            Tambah Pengguna
        </button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        const setVillageSelect = (data) => {
            console.log(data)
            if (data) {
                $('#village_id').empty()
                $('#village_id').select2({
                    placeholder: "Pilih Kelurahan/Desa",
                    theme: "bootstrap-5",
                    data: data,
                    language: "id",
                    dropdownParent: $("#createUser.modal")
                });
            } else {
                if (!@this.get('village_id')) {
                    $('#village_id').val('')
                }
                $('#village_id').select2({
                    placeholder: "Pilih Kelurahan/Desa",
                    theme: "bootstrap-5",
                    language: "id",
                    dropdownParent: $("#createUser.modal")
                });
            }

            $('#village_id').on('change', function(e) {
                var data = $('#village_id').select2("val");
                @this.set('village_id', data);
            });
        }

        const setTpsSelect = (data) => {
            if (data) {
                $('#tps_id').empty()
                $('#tps_id').select2({
                    placeholder: "Pilih TPS",
                    theme: "bootstrap-5",
                    data: data,
                    language: "id",
                    dropdownParent: $("#createUser.modal")
                });
            } else {
                if (!@this.get('tps_id')) {
                    $('#tps_id').val('')
                }
                $('#tps_id').select2({
                    placeholder: "Pilih TPS",
                    theme: "bootstrap-5",
                    language: "id",
                    dropdownParent: $("#createUser.modal")
                });
            }

            $('#tps_id').on('change', function(e) {
                var data = $('#tps_id').select2("val");
                @this.set('tps_id', data);
            });
        }

        const resetDistrict = (isEmpty) => {
            if (isEmpty)
                $('#district_id').val('')

            $('#district_id').select2({
                placeholder: "Pilih Kecamatan",
                theme: "bootstrap-5",
                language: "id",
                dropdownParent: $("#createUser.modal")
            });
        }

        const resetVillage = () => {
            $('#village_id').val('')
            $('#village_id').select2({
                placeholder: "Pilih Kelurahan/Desa",
                theme: "bootstrap-5",
                language: "id",
                dropdownParent: $("#createUser.modal")
            });
        }

        const resetTps = () => {
            $('#tps_id').val('')
            $('#tps_id').select2({
                placeholder: "Pilih TPS",
                theme: "bootstrap-5",
                language: "id",
                dropdownParent: $("#createUser.modal")
            });
        }

        $(window).on('resetDistrict', (data) => {
            resetDistrict(data.detail.is_empty ?? false)
        })

        $(window).on('setVillageData', (data) => {
            setVillageSelect(data.detail)
        })

        $(window).on('setTpsData', (data) => {
            setTpsSelect(data.detail)
        })

        $(document).ready(function() {
            resetDistrict(@this.get('is_empty') ?? true)
            setRegionInput()
        })

        function setRegionInput() {
            $('#district_id').on('change', function(e) {
                let district_id = $('#district_id').select2("val");
                $('#district_id').removeClass('is-invalid');
                $('#village_id').removeClass('is-invalid');
                $('#tps_id').removeClass('is-invalid');
                @this.set('district_id', district_id);
                @this.call('set_villages')
                @this.call('set_tpses')
            });
            setVillageSelect()

            $('#village_id').on('change', function(e) {
                let village_id = $('#village_id').select2("val");
                $('#village_id').removeClass('is-invalid');
                $('#tps_id').removeClass('is-invalid');
                @this.set('village_id', village_id);
                @this.call('set_tpses')
            });
            setTpsSelect()

            $('#tps_id').on('change', function(e) {
                let tps_id = $('#tps_id').select2("val");
                $('#tps_id').removeClass('is-invalid');
                @this.set('tps_id', tps_id);
            });
        }

        $(window).on('reloadDistrict', function(e) {
            resetDistrict(e.detail.is_empty)
            setRegionInput()
        })
    </script>
@endpush
