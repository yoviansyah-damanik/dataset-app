<div>
    <div class="modal-body">
        @if ($is_show)
            <div class="mb-3">
                @if ($user)
                    <div class="d-flex gap-1">
                        <div class="fw-bold" style="width:180px">
                            Nama Pengguna
                        </div>
                        <div style="flex: 1 1 0%">
                            {{ $user->fullname ?? '-' }}
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        <div class="fw-bold" style="width:180px">
                            Peran
                        </div>
                        <div style="flex: 1 1 0%">
                            {{ $user->role_name ?? '-' }}
                        </div>
                    </div>
                @endif
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:180px">
                        Kecamatan
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $district_name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:180px">
                        Kelurahan/Desa
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $village_name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:180px">
                        TPS
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $tps_name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:180px">
                        Jumlah Pemilih
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $voters?->total() ? GeneralHelper::number_format($voters->total()) : 0 }} Pemilih
                        ({{ $voters?->total() ? GeneralHelper::number_format(($voters->total() / $voters_total) * 100, true) : 0 }}%)
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:180px">
                        Total DPT
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ $voters_total ? GeneralHelper::number_format($voters_total) : 0 }} DPT
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-text" id="btnGroupAddon2">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" class="form-control w-50" id="colFormLabelSm" placeholder="Cari..."
                    wire:model="search">
                <select class="form-select" wire:model="attribute_search">
                    <option value="name">Nama</option>
                    <option value="nik">NIK</option>
                </select>
            </div>

            <div class="table-responsive mt-2">
                <table class="table table-striped" wire:loading.class="opacity-50">
                    <thead class="text-center">
                        <th>#</th>
                        <th style="min-width: 550px;" colspan=2>Data Pemilih</th>
                        <th style="min-width: 180px;">Basis</th>
                        <th style="min-width: 80px;">
                            KTP
                        </th>
                        <th style="min-width: 80px;">
                            KK
                        </th>
                        <th style="min-width: 180px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse ($voters as $voter)
                            <tr>
                                <td class="text-center">
                                    {{ ($voters->currentPage() - 1) * $voters->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="mb-4">
                                        <div class="fw-bold text-nowrap">
                                            {{ $voter->name }}
                                        </div>
                                        <div class="fw-light text-nowrap">
                                            NIK. {{ $voter->nik }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TTL
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->place_of_birth . ', ' . $voter->date_of_birth->translatedFormat('d F Y') }}
                                            ({{ $voter->umur }})
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Jenis Kelamin
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->gender }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            No. Telp.
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->phone_number }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Alamat
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->address }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Agama
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->religion->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Status Perkawinan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->marital_status->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Pekerjaan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->profession->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kewarganegaraan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->nasionality->name }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Tim Bersinar
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->team_by->fullname }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kecamatan
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->district->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Kelurahan/Desa
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->village->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            TPS
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->tps->name }}
                                        </div>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <div class="fw-bold voter-table-width">
                                            Diperbaharui pada
                                        </div>
                                        <div style="flex: 1 1 0%">
                                            {{ $voter->updated_at->format('d M Y H:i:s') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($voter->ktp)
                                        <span class="text-success" data-bs-toggle="tooltip" title="Ada!">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="text-danger" data-bs-toggle="tooltip" title="Tidak ada!">
                                            <i class="fas fa-times"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($voter->kk)
                                        <span class="text-success" data-bs-toggle="tooltip" title="Ada!">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="text-danger" data-bs-toggle="tooltip" title="Tidak ada!">
                                            <i class="fas fa-times"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center align-items-center">
                                        <a type="button" href="{{ route('voters.show', $voter->id) }}"
                                            data-bs-toggle="tooltip" class="btn btn-sm btn-info text-white"
                                            title="Lihat selengkapnya!">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @haspermission('update voter')
                                            <a type="button" href="{{ route('voters.edit', $voter->id) }}"
                                                data-bs-toggle="tooltip" class="btn btn-sm btn-warning text-white"
                                                title="Edit!">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endhaspermission
                                        @haspermission('delete voter')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus!"
                                                data-bs-toggle="tooltip"
                                                wire:click="$emit('trigger_destroy','{{ $voter->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endhaspermission
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan=16>Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <div class="modal-footer justify-content-between gap-3">
        @if ($is_show)
            <div style="flex: 1 1 0%;">
                {{ $voters->onEachSide(1)->links() }}
            </div>
        @endif
        <button type="button" class="btn btn-light" wire:loading.attr='disabled'
            data-bs-dismiss="modal">Tutup</button>
    </div>
</div>

@once
    @push('heads')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    @endpush
@endonce
@push('scripts')
    <script type="text/javascript">
        const lightbox = GLightbox({
            closeEffect: 'fade',
            zoomable: true
        });

        document.addEventListener("votersLoaded", () => {
            lightbox.reload();
        });
    </script>
@endpush
