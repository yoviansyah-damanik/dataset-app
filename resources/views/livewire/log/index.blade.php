<div class="card-2">
    @include('partials.loading')
    <h5 class="mb-3">{{ $title }}</h5>

    @haspermission('log_activity config all')
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" wire:model='type'
                value="user">
            <label class="btn btn-outline-primary" for="btnradio1">Log Aktivitas Pengguna</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" wire:model='type'
                value="all">
            <label class="btn btn-outline-primary" for="btnradio2">Log Aktivitas Seluruh Pengguna</label>
        </div>
    @endhaspermission

    <div class="table-responsive  mt-3">
        <table class="table table-sm table-hover" wire:loading.class='opacity-50'>
            <thead>
                <th width=3%>#</th>
                <th width=12%>Waktu</th>
                <th width=15%>Pengguna</th>
                <th width=30%>Deskripsi</th>
                <th width=10%>Aksi</th>
                <th width=7%>Ref Id</th>
                <th width=8%>IP Address</th>
                <th width=8%>Device</th>
                <th width=7%>Browser</th>
            </thead>
            <tbody>
                @forelse($histories as $history)
                    <tr>
                        <td>
                            {{ ($histories->currentPage() - 1) * $histories->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            {{ $history->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td>
                            <strong>
                                {{ $history->user->fullname }}
                            </strong>
                            <br />
                            <em>
                                {{ $history->user->username }}
                            </em>
                        </td>
                        <td>{!! $history->full_description !!}</td>
                        <td>{{ $history->action }}</td>
                        <td>{{ $history->ref_id ?? '-' }}</td>
                        <td>{{ $history->ip_address }}</td>
                        <td>{{ $history->device }}</td>
                        <td>{{ $history->browser }}</td>
                    </tr>
                    <tr>
                        <td colspan="9">
                            <div class="w-100" style="word-break: break-all;">
                                <strong>Payload:</strong> {{ $history?->payload ?? '-' }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan=6>
                            Tidak ada log aktivitas ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
