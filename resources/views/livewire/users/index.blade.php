<div class="card-2">
    @include('partials/loading')
    <div class="position-relative pb-2">
        <button class="add-data" data-bs-toggle="modal" data-bs-target="#createUser"
            wire:click="$emit('clear_create_validation')">
            <i class="fas fa-plus"></i>
            <div class="small mt-1">
                Tambah Pengguna
            </div>
        </button>
    </div>

    <h5 class="mb-3">Data Pengguna</h5>

    <div class="row justify-content-end mb-3">
        <div class="col-lg-4 mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
                <input type="search" wire:model="s" class="form-control" style="min-width:350px;"
                    placeholder="Cari berdasarkan nama pengguna atau nama lengkap...">
            </div>
        </div>
        <div class="col-lg-2 mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-filter"></i>
                </div>
                <select class="form-select w-32" wire:model="role">
                    <option value="all">--Semua Role--</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 text-start mb-3">
            Status: {{ $is_active ? 'Pengguna Aktif' : 'Pengguna Tidak Aktif' }}
        </div>
        <div class="col-lg-6 text-end mb-3">
            @if ($is_active)
                <button wire:click="set_trashed" class="btn btn-sm btn-danger">
                    <i class="fas fa-user-alt-slash"></i>
                    Lihat Pengguna Tidak Aktif
                </button>
            @else
                <button wire:click="set_trashed" class="btn btn-sm btn-success">
                    <i class="fas fa-user-check"></i>
                    Lihat Pengguna Aktif
                </button>
            @endif
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" wire:loading.class='opacity-50'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Lengkap</th>
                    <th>Peran</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan/Desa</th>
                    <th>TPS</th>
                    <th>Total Pemilih</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            {{ $user->username }}
                        </td>
                        <td>
                            {{ $user->fullname }}
                        </td>
                        <td>
                            {{ $user->role_name }}
                        </td>
                        <td>
                            {{ $user->district ? $user->district->name : '-' }}
                        </td>
                        <td>
                            {{ $user->village ? $user->village->name : '-' }}
                        </td>
                        <td>
                            {{ $user->tps ? $user->tps->name : '-' }}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info text-white fw-bold position-relative"
                                data-bs-toggle="tooltip" title="Lihat Pemilih!"
                                wire:click="$emit('set_data','{{ $user->id }}')">
                                <span class="stretched-link" data-bs-toggle="modal"
                                    data-bs-target="[data-modal-target=showVoters]"></span>
                                <i class="fas fa-eye"></i>
                                {{ GeneralHelper::number_format($user->voters_count) }}
                            </button>
                        </td>
                        <td>
                            @if (!$user->hasRole('Superadmin') && $user->is_active)
                                <button class="btn btn-sm btn-dark dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Aksi</button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" title="Nonaktifkan!"
                                            wire:click="$emit('trigger_nonactive','{{ $user->id }}')">
                                            Nonaktifkan Pengguna
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" title="Ubah Role!" data-bs-toggle="modal"
                                            data-bs-target="#editUser"
                                            wire:click="$emit('set_edit_user','{{ $user->id }}')">
                                            Ubah Role
                                        </button>
                                    </li>
                                </ul>
                            @elseif(!$user->is_active)
                                <button class="btn btn-sm btn-dark dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Aksi</button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <button class="dropdown-item" title="Aktifkan!"
                                            wire:click="$emit('trigger_active',{{ $user->id }})">
                                            Aktifkan Pengguna
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" title="Hapus Permanen!"
                                            wire:click="$emit('trigger_delete',{{ $user->id }})">
                                            Hapus Permanen Pengguna
                                        </button>
                                    </li>
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan=10 class="text-center">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $users->links() }}
    </div>

    {{-- Modal Tambah Pengguna --}}
    <div class="modal fade" id="createUser" data-bs-keyboard="false" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @livewire('users.create')
            </div>
        </div>
    </div>

    {{-- Modal Edit Pengguna --}}
    <div class="modal fade" id="editUser" data-bs-keyboard="false" role="dialog" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Role Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @livewire('users.edit')
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(window).on('closeModal', () => {
            $('#createUser').modal('hide')
            $('#editUser').modal('hide')
        })

        $(document).ready(() => {
            @this.on('trigger_nonactive', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan menonaktifkan pengguna ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('nonactive', id)
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
            @this.on('trigger_active', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan mengaktifkan kembali pengguna ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('active', id)
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
            @this.on('trigger_delete', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan menghapus pengguna ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('delete_user', id)
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
