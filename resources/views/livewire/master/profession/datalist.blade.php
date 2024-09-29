<div>
    @include('partials.loading')

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
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" wire:model="s" class="form-control" style="min-width:350px;"
                    placeholder="Cari berdasarkan nama Pekerjaan...">
            </div>
        </div>
        <button class="btn btn-danger" wire:click="resetFilter">
            Reset
        </button>
    </div>

    <table class="table table-sm" wire:loading.class="opacity-50">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>Nama Pekerjaan</th>
                <th>Total Digunakan</th>
                @haspermission(['update profession', 'delete profession'])
                    <th>Aksi</th>
                @endhaspermission
            </tr>
        </thead>
        <tbody>
            @forelse ($professions as $profession)
                <tr>
                    <td class="text-center">
                        {{ ($professions->currentPage() - 1) * $professions->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        {{ $profession->name }}
                    </td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($profession->voters_count) }} Pemilih
                    </td>
                    <td class="text-center">
                        @haspermission('update profession')
                            <button class="btn btn-sm btn-warning text-white position-relative" data-bs-toggle="tooltip"
                                title="Edit!" wire:click="$emit('set_edit_profession',{{ $profession->id }})">
                                <i class="fas fa-edit"></i>
                                <span class="stretched-link" data-bs-toggle="modal"
                                    data-bs-target="[data-modal-target=editProfession]"></span>
                            </button>
                        @endhaspermission
                        @haspermission('delete profession')
                            <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Hapus!"
                                wire:click="$emit('trigger_destroy',{{ $profession->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        @endhaspermission
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan=5 class="text-center">
                        Tidak ada data ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot class="text-center">
            <th colspan=2>Jumlah Keseluruhan</th>
            <th>
                {{ GeneralHelper::number_format($professions_voters_count) }} Pemilih
            </th>
        </tfoot>
    </table>

    {{ $professions->links() }}
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).on('DOMContentLoaded', function() {
            @this.on('trigger_destroy', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan menghapus Pekerjaan ini?',
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
