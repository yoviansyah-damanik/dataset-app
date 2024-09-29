<div class="card-2">
    @include('partials/loading')
    <div class="mb-3">
        <button class="btn btn-warning" wire:click="$emit('refresh_print_history')" wire:loading.attr="disabled">
            Refresh
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" wire:loading.class="opacity-50">
            <thead class="text-center">
                <th>#</th>
                <th>Rincian</th>
                <th>Tipe</th>
                <th>Kecamatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                    <tr>
                        <td class="text-center">
                            {{ ($histories->currentPage() - 1) * $histories->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div>
                                <strong>ID:</strong> {{ $history->unique_code }}
                            </div>
                            <div>
                                <strong>Nama Berkas:</strong> {{ $history->filename }}
                            </div>
                            <div>
                                <strong>Tanggal dibuat:</strong>
                                {{ $history->created_at->format('d M Y H:i:s') }}
                            </div>
                        </td>
                        <td class="text-center">
                            {{ $history->type }}
                        </td>
                        <td class="text-center">
                            {{ $history->district_id == 0 ? 'Semua Kecamatan' : $history->district->name }}
                        </td>
                        <td class="text-center">
                            @if ($history->status == 'on_progress')
                                <span class="badge bg-warning">Proses</span>
                            @elseif($history->status == 'failed')
                                <span class="badge bg-danger">Gagal</span>
                            @elseif($history->status == 'completed')
                                <span class="badge bg-success">Berhasil</span>
                            @else
                                <span class="badge bg-success">{{ $history->status }}</span>
                            @endif
                        </td>
                        <td class="text-center" style="width: 120px;">
                            <button class="btn-primary btn btn-sm" wire:click="download('{{ $history->unique_code }}')"
                                title="Unduh!" data-bs-toggle="tooltip" wire:loading.attr="disabled"
                                wire:target="download, destroy, print" @disabled($history->status != 'completed')>
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn-danger btn btn-sm" data-action="hapus-riwayat-laporan" title="Hapus!"
                                data-bs-toggle="tooltip" data-value="{{ $history->unique_code }}"
                                wire:loading.attr="disabled" wire:target="download, destroy, print"
                                @disabled($history->status == 'on_progress')>
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan=6>
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 mx-auto">
        {{ $histories->onEachSide(1)->links() }}
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            $('button[data-action=hapus-riwayat-laporan]').on('click', (e) => {
                let value = $(e.target).data('value')
                e.preventDefault();

                Swal.fire({
                    title: "Perhatian!",
                    text: "Apakah kamu yakin akan menghapus riwayat laporan tersebut?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.destroy(value) // Post the surrounding form
                    }
                });
            })
        })
    </script>
@endpush
