<div>
    <div class="d-flex gap-3 align-items-center mb-3">
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-filter"></i>
                </div>
                <select class="form-select" wire:model='limit'>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-filter"></i>
                </div>
                <select class="form-select" wire:model='district' wire:loading.attr='disabled'>
                    <option value="">--Tidak ada kecamatan dipilih--</option>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" wire:model="s" class="form-control" style="min-width:350px;"
                    placeholder="Cari berdasarkan nama Kelurahan/Desa...">
            </div>
        </div>
        <button class="btn btn-danger" wire:click="resetFilter">
            Reset
        </button>
    </div>

    <table class="table table-sm" wire:loading.class="opacity-50">
        <thead class="text-center">
            <th>#</th>
            <th>Nama Kelurahan/Desa</th>
            <th>Nama Kecamatan</th>
            <th>Total TPS</th>
            <th>Jumlah Pemilih</th>
            <th>Total DPT</th>
            <th data-bs-toggle="tooltip" title="Persentase Jumlah Pemilih / Total DPT">%</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            @forelse ($villages as $village)
                <tr>
                    <td class="text-center">
                        {{ ($villages->currentPage() - 1) * $villages->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        {{ $village->name }}
                        <a href="{{ route('region.tps', ['district' => $village->district_id, 'village' => $village->id]) }}"
                            class="btn btn-sm ml-1" data-bs-toggle="tooltip" title="Lihat TPS!">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <td>{{ $village->district_name }}</td>
                    <td class="text-center">{{ $village->tpses_count }} TPS</td>
                    <td class="text-center">
                        @if ($village->voters_count < $village->dpts_count)
                            <span class="text-danger" data-bs-toggle="tooltip"
                                title="Jumlah pemilih kurang dari total DPT!">
                                <i class="fas fa-arrow-down"></i>
                            </span>
                        @elseif($village->voters_count > $village->dpts_count)
                            <span class="text-warning" data-bs-toggle="tooltip"
                                title="Jumlah pemilih lebih dari total DPT!">
                                <i class="fas fa-arrow-up"></i>
                            </span>
                        @else
                            <span class="text-success" data-bs-toggle="tooltip"
                                title="Jumlah pemilih sama dengan total DPT!">
                                <i class="fas fa-check"></i>
                            </span>
                        @endif
                        {{ GeneralHelper::number_format($village->voters_count) }}
                    </td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($village->dpts_count) }}
                    </td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($village->dpts_count > 0 ? ($village->voters_count / $village->dpts_count) * 100 : 0, true) }}
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-info text-white position-relative" style="cursor:pointer;"
                            data-bs-toggle="tooltip" title="Lihat Pemilih!"
                            wire:click="$emit('set_show_region',{{ $village->district_id }},{{ $village->id }})">
                            <i class="fas fa-eye"></i>
                            <span class="stretched-link" data-bs-toggle="modal"
                                data-bs-target="[data-modal-target=showVoters]"></span>
                        </button>
                        @haspermission('update village')
                            <button class="btn btn-sm btn-warning text-white position-relative" data-bs-toggle="tooltip"
                                title="Edit!"
                                wire:click="$emit('set_edit_village',{{ $village->district_id }},{{ $village->id }})">
                                <i class="fas fa-edit"></i>
                                <span class="stretched-link" data-bs-toggle="modal"
                                    data-bs-target="[data-modal-target=editVillage]"></span>
                            </button>
                        @endhaspermission
                        @haspermission('delete village')
                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus!"
                                wire:click="$emit('trigger_destroy',{{ $village->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endhaspermission
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=7 class="text-center">
                        Tidak ada data ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot class="text-center">
            <th colspan=4>Jumlah Keseluruhan</th>
            <th>
                @if ($villages_voters_count < $villages_voters_total)
                    <span class="text-danger" data-bs-toggle="tooltip" title="Jumlah pemilih kurang dari total DPT!">
                        <i class="fas fa-arrow-down"></i>
                    </span>
                @elseif($villages_voters_count > $villages_voters_total)
                    <span class="text-warning" data-bs-toggle="tooltip" title="Jumlah pemilih lebih dari total DPT!">
                        <i class="fas fa-arrow-up"></i>
                    </span>
                @else
                    <span class="text-success" data-bs-toggle="tooltip" title="Jumlah pemilih sama dengan total DPT!">
                        <i class="fas fa-check"></i>
                    </span>
                @endif
                {{ GeneralHelper::number_format($villages_voters_count) }}
            </th>
            <th>
                {{ GeneralHelper::number_format($villages_voters_total) }}
            </th>
            <th>
                {{ GeneralHelper::number_format($villages_voters_total > 0 ? ($villages_voters_count / $villages_voters_total) * 100 : 0, true) }}
            </th>
        </tfoot>
    </table>

    {{ $villages->onEachSide(2)->links() }}
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).on('DOMContentLoaded', function() {
            @this.on('trigger_destroy', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan menghapus Kelurahan/Desa ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('destroy', id)
                        Swal.fire({
                            text: 'Permintaan sedang diproses!',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            text: 'Aksi dibatalkan!',
                            icon: 'success'
                        });
                    }
                });
            });
        })
    </script>
@endpush
