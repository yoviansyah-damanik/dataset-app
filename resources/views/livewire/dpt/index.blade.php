<div class="position-relative">
    @include('partials/loading')
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Data DPT
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                DPT
            </li>
        </ol>
    </div>
    <div class="card-2">
        <div class="row mb-3">
            <div class="col-sm-3 mb-3">
                <div class="input-group">
                    <div class="input-group-text" id="per_page">
                        <i class="fas fa-pager"></i>
                    </div>
                    <select class="form-select" wire:model="per_page">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-filter"></i>
                        </div>
                        <select class="form-select" wire:model='district'>
                            <option value="">--Tidak ada kecamatan dipilih--</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-filter"></i>
                        </div>
                        <select class="form-select" wire:model='village'>
                            <option value="">--Tidak ada kelurahan/desa dipilih--</option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->id }}">{{ $village->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-filter"></i>
                        </div>
                        <select class="form-select" wire:model='tps'>
                            <option value="">--Tidak ada TPS dipilih--</option>
                            @foreach ($tpses as $tps)
                                <option value="{{ $tps->id }}">{{ $tps->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="input-group">
                    <div class="input-group-text" id="btnGroupAddon2">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="search" class="form-control w-50" id="colFormLabelSm"
                        placeholder="Cari berdasarkan Nama DPT..." wire:model="search">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="input-group-text" id="per_page">
                        <i class="fas fa-pager"></i>
                    </div>
                    <select class="form-select" wire:model="status">
                        <option value="semua">Semua</option>
                        <option value="terdata">Terdata</option>
                        <option value="belum_terdata">Belum Terdata</option>
                    </select>
                </div>
            </div>
        </div>
        Total: {{ GeneralHelper::number_format($dpts->total()) }} DPT
        <div class="table-responsive mt-2">
            <table class="table table-striped" wire:loading.class="opacity-50">
                <thead class="text-center">
                    <th>#</th>
                    <th>Nama DPT</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur</th>
                    <th>Alamat</th>
                    <th>TPS</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Data Pemilih</th>
                </thead>
                <tbody>
                    @forelse ($dpts as $dpt)
                        <tr>
                            <td class="text-center">
                                {{ ($dpts->currentPage() - 1) * $dpts->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                {{ $dpt->name }}
                            </td>
                            <td>
                                {{ $dpt->genderFull }}
                            </td>
                            <td class="text-center">
                                {{ $dpt->age }}
                            </td>
                            <td>
                                {{ $dpt->address }}, RT: {{ $dpt->rt }}, RW: {{ $dpt->rw }}
                            </td>
                            <td>
                                {{ $dpt->tps->name }}
                            </td>
                            <td>
                                {{ $dpt->village->name }}
                            </td>
                            <td>
                                {{ $dpt->district->name }}
                            </td>
                            <td class="text-center">
                                @if ($dpt->voter)
                                    <a href="{{ route('voters.show', $dpt->voter->id) }}">
                                        <span class="fas fa-check text-success"></span>
                                    </a>
                                @else
                                    <span class="fas fa-times text-danger"></span>
                                @endif
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
        <div class="mt-3 mx-auto">
            {{ $dpts->onEachSide(1)->links() }}
        </div>
    </div>
</div>
