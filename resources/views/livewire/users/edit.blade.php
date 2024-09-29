<div>
    @include('partials/loading')
    <div class="modal-body">
        <div class="p-2">
            @include('partials/loading')
            <div class="row">
                {{-- ROLE --}}
                <div class="col-12">
                    <div class="form-group mb-3 position-relative">
                        <label for="role_name">Role</label>
                        <select id="role_name" class="form-select @error('role_name') is-invalid @enderror"
                            wire:model="role_name" wire:change='set_role'>
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
                @if (in_array($role_name, ['Koordinator Kecamatan', 'Koordinator Kelurahan/Desa', 'Koordinator TPS']))
                    {{-- DISTRICT --}}
                    <div class="col-12">
                        <div class="mb-3 position-relative">
                            <div class="form-group" wire:ignore>
                                <label for="edit_district_id">Kecamatan</label>
                                <select id="edit_district_id" class="form-select"></select>
                            </div>
                            @error('district_id')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    @if (in_array($role_name, ['Koordinator Kelurahan/Desa', 'Koordinator TPS']))
                        {{-- VILLAGES --}}
                        <div class="col-12">
                            <div class="mb-3 position-relative">
                                <div class="form-group" wire:ignore>
                                    <label for="edit_village_id">Kelurahan/Desa</label>
                                    <select id="edit_village_id" class="form-select "></select>
                                </div>
                                @error('village_id')
                                    <div class="invalid-tooltip">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @if (in_array($role_name, ['Koordinator TPS']))
                            {{-- TPS --}}
                            <div class="col-12">
                                <div class="mb-3 position-relative">
                                    <div class="form-group" wire:ignore>
                                        <label for="edit_tps_id">TPS</label>
                                        <select id="edit_tps_id" class="form-select"></select>
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
                @endif
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" wire:loading.attr='disabled' data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-primary" wire:click="update" wire:loading.attr='disabled'>
            <i class="fas fa-edit"></i>
            Edit Role Pengguna
        </button>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        const setDistrictEmpty = (e) => {
            $("#edit_district_id").val('')
        }
        const setVillageEmpty = (e) => {
            $("#edit_village_id").val('')
        }
        const setTpsEmpty = (e) => {
            $("#edit_tps_id").val('')
        }

        $(window).on('setDistrictEmpty', () => {
            setDistrictEmpty()
        })
        $(window).on('setVillageEmpty', () => {
            setVillageEmpty()
        })
        $(window).on('setTpsEmpty', () => {
            setTpsEmpty()
        })

        $(window).on('setDistricts', (e) => {
            $("#edit_district_id").empty()
            $("#edit_district_id").select2({
                dropdownParent: $('#editUser .modal-content'),
                placeholder: "Pilih Kecamatan",
                theme: "bootstrap-5",
                language: "id",
                data: e.detail.districts
            });

            $('#edit_district_id').on('change', function(e) {
                var data = $('#edit_district_id').select2("val");
                @this.set('district_id', parseInt(data))
                @this.call('set_villages', true)
            });
        })

        $(window).on('setVillages', (e) => {
            $("#edit_village_id").empty()
            $("#edit_village_id").select2({
                dropdownParent: $('#editUser .modal-content'),
                placeholder: "Pilih Kelurahan/Desa",
                theme: "bootstrap-5",
                language: "id",
                data: e.detail.villages
            });

            $('#edit_village_id').on('change', function(e) {
                var data = $('#edit_village_id').select2("val");
                @this.set('village_id', parseInt(data))
                @this.call('set_tpses', true)
            });
        })

        $(window).on('setTpses', (e) => {
            $("#edit_tps_id").empty()
            $("#edit_tps_id").select2({
                dropdownParent: $('#editUser .modal-content'),
                placeholder: "Pilih TPS",
                theme: "bootstrap-5",
                language: "id",
                data: e.detail.tpses
            });

            $('#edit_tps_id').on('change', function(e) {
                var data = $('#edit_tps_id').select2("val");
                @this.set('tps_id', parseInt(data))
            });
        })
    </script>
@endpush
