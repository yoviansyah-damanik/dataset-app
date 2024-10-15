<div id="districts">
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Data Rekap Regional
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Data Rekap Regional
            </li>
        </ol>
    </div>

    <div class="card-2">
        <div class="mb-4">
            <div class="d-flex">
                <div style="width: 180px" class="fw-bold">
                    Total Kecamatan
                </div>
                <div>
                    {{ $districts->count() }} Kecamatan
                </div>
            </div>
            <div class="d-flex">
                <div style="width: 180px" class="fw-bold">
                    Total Kelurahan/Desa
                </div>
                <div>
                    {{ $districts->sum(fn($q) => $q->villages->count()) }} Kelurahan/Desa
                </div>
            </div>
            <div class="d-flex">
                <div style="width: 180px" class="fw-bold">
                    Total TPS
                </div>
                <div>
                    {{ $districts->sum(fn($q) => $q->villages->sum(fn($r) => $r->tpses->count())) }} TPS
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="text-center">
                    <tr>
                        <th colspan=5 width=60px>Kecamatan</th>
                        <th colspan=5 width=60px>Kelurahan/Desa</th>
                        <th colspan=5 width=60px>TPS</th>
                    </tr>
                    <tr>
                        <th width=60px>#</th>
                        <th>Nama</th>
                        <th data-bs-toggle="tooltip" title="Jumlah pemilih Kecamatan">Pemilih</th>
                        <th data-bs-toggle="tooltip" title="Total DPT Kecamatan">DPT</th>
                        <th data-bs-toggle="tooltip" title="Persentase Jumlah Pemilih / Total DPT">%</th>

                        <th width=60px>#</th>
                        <th>Kelurahan/Desa</th>
                        <th data-bs-toggle="tooltip" title="Jumlah pemilih Kelurahan/Desa">Pemilih</th>
                        <th data-bs-toggle="tooltip" title="Total DPT Kelurahan/Desa">DPT</th>
                        <th data-bs-toggle="tooltip" title="Persentase Jumlah Pemilih / Total DPT">%</th>

                        <th width=60px>#</th>
                        <th>TPS</th>
                        <th data-bs-toggle="tooltip" title="Jumlah pemilih TPS">Pemilih</th>
                        <th data-bs-toggle="tooltip" title="Total DPT TPS">DPT</th>
                        <th data-bs-toggle="tooltip" title="Persentase Jumlah Pemilih / Total DPT">%</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($districts as $index => $district)
                        <tr>
                            <td class="text-center"
                                rowspan={{ $district->villages->count() > 0 ? $district->villages->count() + $district->tpses->count() + 1 : 2 }}>
                                {{ $loop->iteration }}
                            </td>
                            <td
                                rowspan={{ $district->villages->count() > 0 ? $district->villages->count() + $district->tpses->count() + 1 : 2 }}>
                                {{ $district->name }}
                                <span class="small text-muted ms-1">
                                    @haspermission('read district')
                                        <a class="text-decoration-none"
                                            href="{{ route('region.district', ['s' => $district->name]) }}"
                                            data-bs-toggle="tooltip" title="Lihat Kecamatan!">
                                            <i class="fas fa-database"></i>
                                        </a>
                                    @endhaspermission
                                    <div class="position-relative d-inline text-primary" style="cursor:pointer;"
                                        data-bs-toggle="tooltip" title="Lihat Pemilih!"
                                        wire:click="$emit('set_show_region',{{ $district->id }})">
                                        <i class="fas fa-eye"></i>
                                        <span class="stretched-link" data-bs-toggle="modal"
                                            data-bs-target="[data-modal-target=showVoters]"></span>
                                    </div>
                                </span>
                            </td>
                            <td class="text-center"
                                rowspan={{ $district->villages->count() > 0 ? $district->villages->count() + $district->tpses->count() + 1 : 2 }}>
                                @if ($district->voters_count < $district->dpts_count)
                                    <span class="text-danger" data-bs-toggle="tooltip"
                                        title="Jumlah pemilih kurang dari total DPT!">
                                        <i class="fas fa-arrow-down"></i>
                                    </span>
                                @elseif($district->voters_count > $district->dpts_count)
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
                                {{ GeneralHelper::number_format($district->voters_count) }}
                            </td>
                            <td class="text-center"
                                rowspan={{ $district->villages->count() > 0 ? $district->villages->count() + $district->tpses->count() + 1 : 2 }}>
                                {{ GeneralHelper::number_format($district->dpts_count) }}
                            </td>
                            <td class="text-center"
                                rowspan={{ $district->villages->count() > 0 ? $district->villages->count() + $district->tpses->count() + 1 : 2 }}>
                                {{ GeneralHelper::number_format($district->dpts_count > 0 ? ($district->voters_count / $district->dpts_count) * 100 : 0, true) }}
                            </td>
                        </tr>
                        @if ($district->villages->count() > 0)
                            @foreach ($district->villages as $village)
                                @if ($village->tpses->count() > 0)
                                    <tr>
                                        <td rowspan={{ $village->tpses->count() + 1 }} class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td rowspan={{ $village->tpses->count() + 1 }}>
                                            {{ $village->name }}
                                            <span class="small text-muted ms-1">
                                                @haspermission('read village')
                                                    <a class="text-decoration-none"
                                                        href="{{ route('region.village', ['s' => $village->name, 'district' => $district->id]) }}"
                                                        data-bs-toggle="tooltip" title="Lihat Kelurahan/Desa!">
                                                        <i class="fas fa-database"></i>
                                                    </a>
                                                @endhaspermission
                                                <div class="position-relative d-inline text-primary"
                                                    style="cursor:pointer;" data-bs-toggle="tooltip"
                                                    title="Lihat Pemilih!"
                                                    wire:click="$emit('set_show_region',{{ $district->id }},{{ $village->id }})">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="stretched-link" data-bs-toggle="modal"
                                                        data-bs-target="[data-modal-target=showVoters]"></span>
                                                </div>
                                            </span>
                                        </td>
                                        <td class="text-center" rowspan={{ $village->tpses->count() + 1 }}>
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
                                        <td class="text-center" rowspan={{ $village->tpses->count() + 1 }}>
                                            {{ GeneralHelper::number_format($village->dpts_count) }}
                                        </td>
                                        <td class="text-center" rowspan={{ $village->tpses->count() + 1 }}>
                                            {{ GeneralHelper::number_format($village->dpts_count > 0 ? ($village->voters_count / $village->dpts_count) * 100 : 0, true) }}
                                        </td>
                                    </tr>
                                    @foreach ($village->tpses as $tps)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $tps->name }}
                                                <span class="small text-muted ms-1">
                                                    @haspermission('read tps')
                                                        <a class="text-decoration-none"
                                                            href="{{ route('region.tps', ['s' => $tps->name, 'district' => $district->id, 'village' => $village->id]) }}"
                                                            data-bs-toggle="tooltip" title="Lihat TPS!">
                                                            <i class="fas fa-database"></i>
                                                        </a>
                                                    @endhaspermission
                                                    <div class="position-relative d-inline text-primary"
                                                        style="cursor:pointer;" data-bs-toggle="tooltip"
                                                        title="Lihat Pemilih!"
                                                        wire:click="$emit('set_show_region',{{ $district->id }},{{ $village->id }},{{ $tps->id }})">
                                                        <i class="fas fa-eye"></i>
                                                        <span class="stretched-link" data-bs-toggle="modal"
                                                            data-bs-target="[data-modal-target=showVoters]"></span>
                                                    </div>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($tps->voters_count < $tps->dpts_count)
                                                    <span class="text-danger" data-bs-toggle="tooltip"
                                                        title="Jumlah pemilih kurang dari total DPT!">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </span>
                                                @elseif($tps->voters_count > $tps->dpts_count)
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
                                                {{ GeneralHelper::number_format($tps->voters_count) }}
                                            </td>
                                            <td class="text-center">
                                                {{ GeneralHelper::number_format($tps->dpts_count) }}
                                            </td>
                                            <td class="text-center">
                                                {{ GeneralHelper::number_format($tps->dpts_count > 0 ? ($tps->voters_count / $tps->dpts_count) * 100 : 0, true) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $village->name }}
                                            <span class="small text-muted ms-1">
                                                <a class="text-decoration-none"
                                                    href="{{ route('region.district', ['s' => $district->name]) }}"
                                                    data-bs-toggle="tooltip" title="Lihat Kecamatan!">
                                                    <i class="fas fa-database"></i>
                                                </a>
                                                <a class="text-decoration-none"
                                                    href="{{ route('region.district', ['s' => $district->name]) }}"
                                                    data-bs-toggle="tooltip" title="Lihat Pemilih!">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            {{ $village->voters_count }}
                                            {{-- @if ($village->voters_count == $village->tps_voters->count())
                                                <span class="text-success" data-bs-toggle="tooltip"
                                                    title="Jumlah pemilih di seluruh TPS sesuai.">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            @else
                                                <span class="text-danger" data-bs-toggle="tooltip"
                                                    title="Jumlah pemilih di seluruh TPS tidak sesuai.">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            @endif --}}
                                        </td>
                                        <td colspan=3 class="text-center">-</td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan=6>-</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="text-center" colspan=9>Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="text-center">
                    <th colspan=12>Jumlah Keseluruhan</th>
                    <th>
                        @if ($districts_voters_count < $districts_voters_total)
                            <span class="text-danger" data-bs-toggle="tooltip"
                                title="Jumlah pemilih kurang dari total DPT!">
                                <i class="fas fa-arrow-down"></i>
                            </span>
                        @elseif($districts_voters_count > $districts_voters_total)
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
                        {{ GeneralHelper::number_format($districts_voters_count) }}
                    </th>
                    <th>
                        {{ GeneralHelper::number_format($districts_voters_total) }}
                    </th>
                    <th>
                        {{ GeneralHelper::number_format($districts_voters_total > 0 ? ($districts_voters_count / $districts_voters_total) * 100 : 0, true) }}
                    </th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
