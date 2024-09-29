<div class="card-2">
    @include('partials/loading')

    <h5 class="mb-3">Data Administrator</h5>

    <div class="row justify-content-between mb-3">
        <div class="col-lg-4 mb-3">
            <button class="btn btn-primary" wire:click="$emit('trigger_update_password')">
                Ubah Seluruh Kata Sandi Administrator
            </button>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="input-group">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" wire:model="s" class="form-control" style="min-width:350px;"
                    placeholder="Cari berdasarkan nama pengguna atau nama lengkap...">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped" wire:loading.class='opacity-50'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Kecamatan</th>
                    <th>Kata Sandi Baru</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $user['username'] }}
                        </td>
                        <td>
                            {{ $user['fullname'] }}
                        </td>
                        <td>
                            {{ $user['email'] }}
                        </td>
                        <td>
                            {{ $user['district_name'] }}
                        </td>
                        <td>
                            {{ !empty($user['new_password']) ? $user['new_password'] : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan=6 class="text-center">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(() => {
            @this.on('trigger_update_password', id => {
                Swal.fire({
                    text: 'Apakah kamu yakin akan mengubah seluruh kata sandi Administrator?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya!',
                    cancelButtonText: 'Batal!',
                }).then((result) => {
                    if (result.value) {
                        @this.call('refresh_admin_password')
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
