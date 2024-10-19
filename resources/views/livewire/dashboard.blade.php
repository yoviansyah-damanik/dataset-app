<div id="dashboard">
    @include('partials.loading')
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Dashboard
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/">
                    Beranda
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Dashboard
            </li>
        </ol>
    </div>

    <div class="candidate-information">
        <div class="candidate-box candidate-1">
            <div class="candidate-name">
                {{ GeneralHelper::get_candidate_1_name() }}
            </div>
            <div class="candidate-callsign">
                Calon {{ GeneralHelper::get_candidate_callsign() }}
            </div>
        </div>
        <div class="candidate-picture">
            <img class="candidate candidate-1" src="{{ GeneralHelper::get_candidate_1_picture() }}"
                alt="Candidate 1 Picture">
            {{-- <img class="logo" src="{{ GeneralHelper::get_app_logo() }}" alt="App Logo"> --}}
            <img class="candidate candidate-2" src="{{ GeneralHelper::get_candidate_2_picture() }}"
                alt="Candidate 2 Picture">
        </div>
        <div class="candidate-box candidate-2">
            <div class="candidate-name">
                {{ GeneralHelper::get_candidate_2_name() }}
            </div>
            <div class="candidate-callsign">
                Calon Wakil {{ GeneralHelper::get_candidate_callsign() }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6">
            <div class="card-2">
                <h4 class="mb-3">
                    Selamat datang kembali, {{ auth()->user()->fullname }}!
                </h4>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:150px">
                        Peran
                    </div>
                    <div style="flex: 1 1 0%">
                        <span class="fw-bolder" style="color:var(--bs-red)">{{ auth()->user()->role_name }}</span>
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:150px">
                        Kecamatan
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ auth()->user()?->district->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:150px">
                        Kelurahan/Desa
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ auth()->user()?->village->name ?? '-' }}
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <div class="fw-bold" style="width:150px">
                        TPS
                    </div>
                    <div style="flex: 1 1 0%">
                        {{ auth()->user()?->tps->name ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-2 fill h-100 d-flex justify-content-center align-items-center flex-column">
                <div class="fs-1 fw-bold text-center" style="color: var(--primary-color)">
                    {{ GeneralHelper::number_format($voters_total) }}
                </div>
                <div class="text-center">
                    Total Pemilih di Wilayah Anda
                </div>
            </div>
        </div>
    </div>

    @role('Superadmin')
        {{-- TOTAL KOORDINATOR --}}
        <div class="row" wire:ignore>
            <div class="col-12 my-3">
                <span class="row-title">
                    <span>
                        Umum Aplikasi
                    </span>
                </span>
            </div>
        </div>
        <div class="row" wire:ignore>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-primary">
                    <div class="box-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Pengguna
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($users_total) }}
                        </div>
                    </div>
                    <a class="stretched-link" href="{{ route('users') }}"></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-secondary">
                    <div class="box-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Koordinator Kecamatan
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($coordinator_1_total) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-third">
                    <div class="box-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Koordinator Kelurahan/Desa
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($coordinator_2_total) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-fourth">
                    <div class="box-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Koordinator TPS
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($coordinator_3_total) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-fifth">
                    <div class="box-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Tim Bersinar
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($coordinator_4_total) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" wire:ignore>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-primary">
                    <div class="box-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Kecamatan
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($districts_total) }}
                        </div>
                    </div>
                    <a class="stretched-link" href="{{ route('region.district') }}"></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-secondary">
                    <div class="box-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total Kelurahan/Desa
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($villages_total) }}
                        </div>
                    </div>
                    <a class="stretched-link" href="{{ route('region.village') }}"></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xxl-3">
                <div class="box box-third">
                    <div class="box-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="box-body">
                        <div class="box-title">
                            Total TPS
                        </div>
                        <div class="box-count">
                            {{ GeneralHelper::number_format($tpses_total) }}
                        </div>
                    </div>
                    <a class="stretched-link" href="{{ route('region.tps') }}"></a>
                </div>
            </div>
        </div>
        {{-- Kecamatan Tertinggi --}}
        <div class="row" wire:ignore>
            <div class="col-12 my-3">
                <span class="row-title">
                    <span>
                        Kecamatan Dengan Pemilih Tertinggi
                    </span>
                </span>
            </div>
            @foreach ($most_voters_district as $voters_district)
                <div class="col-md-4">
                    <div @class([
                        'box',
                        'box-third',
                        'box-secondary' =>
                            ($voters_district['voters_total']
                                ? ($voters_district['voters_count'] /
                                        $voters_district['voters_total']) *
                                    100
                                : 0) < 50,
                    ])>
                        <div class="box-icon">
                            @if ($voters_district['voters_count'] > $voters_district['voters_total'])
                                <i class="fas fa-arrow-up"></i>
                            @elseif($voters_district['voters_count'] < $voters_district['voters_total'])
                                <i class="fas fa-arrow-down"></i>
                            @else
                                <i class="fas fa-equals"></i>
                            @endif
                        </div>
                        <div class="box-body">
                            <div class="box-title">
                                {{ $voters_district['label'] }}
                            </div>
                            <div class="box-count">
                                {{ GeneralHelper::number_format($voters_district['voters_count']) }}
                            </div>
                            <div class="box-sub-count">
                                {{ GeneralHelper::number_format($voters_district['voters_total']) }} DPT
                                <div @class([
                                    'text-success',
                                    'text-danger' =>
                                        ($voters_district['voters_total']
                                            ? ($voters_district['voters_count'] /
                                                    $voters_district['voters_total']) *
                                                100
                                            : 0) < 50,
                                ])>
                                    {{ GeneralHelper::number_format($voters_district['voters_total'] ? ($voters_district['voters_count'] / $voters_district['voters_total']) * 100 : 0, true) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Kelurahan/Desa Tertinggi --}}
        <div class="row">
            <div class="col-12 my-3">
                <span class="row-title">
                    <span>
                        Kelurahan/Desa Dengan Pemilih Tertinggi
                    </span>
                </span>
            </div>
            @foreach ($most_voters_village as $voters_village)
                <div class="col-md-4">
                    <div @class([
                        'box',
                        'box-third',
                        'box-secondary' =>
                            ($voters_village['voters_total']
                                ? ($voters_village['voters_count'] /
                                        $voters_village['voters_total']) *
                                    100
                                : 0) < 50,
                    ])>
                        <div class="box-icon">
                            @if ($voters_village['voters_count'] > $voters_village['voters_total'])
                                <i class="fas fa-arrow-up"></i>
                            @elseif($voters_village['voters_count'] < $voters_village['voters_total'])
                                <i class="fas fa-arrow-down"></i>
                            @else
                                <i class="fas fa-equals"></i>
                            @endif
                        </div>
                        <div class="box-body">
                            <div class="box-title">
                                {{ $voters_village['district_name'] . ' / ' . $voters_village['label'] }}
                            </div>
                            <div class="box-count">
                                {{ GeneralHelper::number_format($voters_village['voters_count']) }}
                            </div>
                            <div class="box-sub-count">
                                {{ GeneralHelper::number_format($voters_village['voters_total']) }} DPT
                                <div @class([
                                    'text-success',
                                    'text-danger' =>
                                        ($voters_village['voters_total']
                                            ? ($voters_village['voters_count'] /
                                                    $voters_village['voters_total']) *
                                                100
                                            : 0) < 50,
                                ])>
                                    {{ GeneralHelper::number_format($voters_village['voters_total'] ? ($voters_village['voters_count'] / $voters_village['voters_total']) * 100 : 0, true) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- TPS Tertinggi --}}
        <div class="row">
            <div class="col-12 my-3">
                <span class="row-title">
                    <span>
                        TPS Dengan Pemilih Tertinggi
                    </span>
                </span>
            </div>
            @foreach ($most_voters_tps as $voters_tps)
                <div class="col-md-4">
                    <div @class([
                        'box',
                        'box-third',
                        'box-secondary' =>
                            ($voters_tps['voters_total']
                                ? ($voters_tps['voters_count'] / $voters_tps['voters_total']) * 100
                                : 0) < 50,
                    ])>
                        <div class="box-icon">
                            @if ($voters_tps['voters_count'] > $voters_tps['voters_total'])
                                <i class="fas fa-arrow-up"></i>
                            @elseif($voters_tps['voters_count'] < $voters_tps['voters_total'])
                                <i class="fas fa-arrow-down"></i>
                            @else
                                <i class="fas fa-equals"></i>
                            @endif
                        </div>
                        <div class="box-body">
                            <div class="box-title">
                                {{ $voters_tps['district_name'] . ' / ' . $voters_tps['village_name'] . ' / ' . $voters_tps['label'] }}
                            </div>
                            <div class="box-count">
                                {{ GeneralHelper::number_format($voters_tps['voters_count']) }}
                            </div>
                            <div class="box-sub-count">
                                {{ GeneralHelper::number_format($voters_tps['voters_total']) }} DPT
                                <div @class([
                                    'text-success',
                                    'text-danger' =>
                                        ($voters_tps['voters_total']
                                            ? ($voters_tps['voters_count'] / $voters_tps['voters_total']) * 100
                                            : 0) < 50,
                                ])>
                                    {{ GeneralHelper::number_format($voters_tps['voters_total'] ? ($voters_tps['voters_count'] / $voters_tps['voters_total']) * 100 : 0, true) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endrole

    {{-- CHART PEMILIH --}}
    <div class="row">
        <div class="col-12 my-3">
            <span class="row-title">
                <span>
                    Pemilih Umum
                </span>
            </span>
        </div>
        {{-- PEMILIH BERDASARKAN JENIS KELAMIN --}}
        <div class="col-md-6 col-lg-3">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Jenis Kelamin
                </div>
                <div class="chart-body">
                    <div class="position-relative">
                        <canvas class="voters_by_gender"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PEMILIH BERDASARKAN AGAMA --}}
        <div class="col-md-6 col-lg-3">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Agama
                </div>
                <div class="chart-body">
                    <div class="position-relative">
                        <canvas class="voters_by_religion"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PEMILIH BERDASARKAN STATUS --}}
        <div class="col-md-6 col-lg-3">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Status Perkawinan
                </div>
                <div class="chart-body">
                    <div class="position-relative">
                        <canvas class="voters_by_marital_status"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PEMILIH BERDASARKAN KEWARNAGANEGARAAN --}}
        <div class="col-md-6 col-lg-3">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Kewarnaganegaraan
                </div>
                <div class="chart-body">
                    <div class="position-relative">
                        <canvas class="voters_by_nasionality"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- PEMILIH BERDASARKAN PROFESI --}}
        <div class="col-lg-6">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Profesi
                </div>
                <div class="chart-body">
                    <div class="position-relative">
                        <canvas class="voters_by_profession"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PEMILIH BERDASARKAN UMUR --}}
        <div class="col-lg-6">
            <div class="chart-box" wire:ignore>
                <div class="chart-title">
                    Pemilih berdasarkan Umur
                </div>
                <div class="chart-body">
                    <canvas class="voters_by_age"></canvas>
                </div>
                <div class="description">
                    <div class="fst-italic small">
                        (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                    </div>
                </div>
            </div>
        </div>

        @role(['Superadmin'])
            {{-- PEMILIH PER KECAMATAN --}}
            <div class="col-12">
                <div class="chart-box" wire:ignore>
                    <div class="chart-title">
                        Pemilih per Kecamatan
                    </div>
                    <div class="chart-body">
                        <div class="position-relative">
                            <canvas style="height: 300px;" class="voters_by_district"></canvas>
                        </div>
                        <div class="description">
                            <div class="fst-italic small">
                                (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
    </div>

    {{-- PEMILIH PER KELURAHAN/DESA --}}
    <div class="row">
        <div class="col-12 mt-3">
            <span class="row-title">
                <span>
                    Jumlah Pemilih Per Kelurahan/Desa
                </span>
            </span>
        </div>
        @role('Superadmin')
            <div class="col-12">
                <select wire:model="district" class="form-select" wire:loading.attr='disabled'
                    wire:change="set_district_name">
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
        @endrole
        {{-- PEMILIH PER KELURAHAN/DESA --}}
        <div class="col-12">
            <div class="chart-box">
                <div class="chart-title">
                    Pemilih per Kelurahan/Desa pada {{ $district_name }}
                </div>
                <div class="chart-body">
                    <div class="position-relative" wire:ignore>
                        <canvas style="height: 300px;" class="voters_by_village"></canvas>
                    </div>
                    <div class="description">
                        <div class="fst-italic small">
                            (*) Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PEMILIH PER TPS --}}
        @foreach ($voters_by_tps as $tps)
            <div class="col-12 col-md-6">
                <div class="chart-box">
                    <div class="chart-title">
                        Pemilih per TPS pada Kelurahan/Desa {{ $tps['village_name'] }}
                    </div>
                    <div class="chart-body">
                        <div class="position-relative" style="height: 300px;" wire:ignore.self>
                            <canvas data-canvas="voters_by_tps_canvas" data-id="{{ $tps['village_id'] }}"></canvas>
                        </div>
                        <div class="description">
                            <div class="fst-italic small">
                                (*)
                                Data berdasarkan data pemilih yang telah diinput ke dalam sistem.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"
        integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(window).on('livewire:load', function() {
            const backgroundColorGroup = [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(201, 203, 207)',
                'rgb(54, 162, 235)',
                'rgb(255, 159, 64)',
            ];

            const ctx = document.getElementsByClassName('voters_by_gender');
            const gender = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: $.map(@this.voters_by_gender, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        data: $.map(@this.voters_by_gender, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup,
                    }]
                },
            });

            const ctx_2 = document.getElementsByClassName('voters_by_age');
            const age = new Chart(ctx_2, {
                type: 'bar',
                data: {
                    labels: $.map(@this.voters_by_age, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        axis: 'y',
                        label: 'Jumlah Pemilih',
                        data: $.map(@this.voters_by_age, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup
                    }]
                },
                options: {
                    indexAxis: 'y',
                }
            })

            const ctx_3 = document.getElementsByClassName('voters_by_district');
            const voters_by_district = new Chart(ctx_3, {
                data: {
                    datasets: [{
                            type: 'line',
                            label: 'Total DPT',
                            data: $.map(@this.voters_by_district, function(val, i) {
                                return val.voters_total;
                            }),
                            backgroundColor: '#000',
                        },
                        {
                            type: 'bar',
                            label: 'Jumlah Pemilih',
                            data: $.map(@this.voters_by_district, function(val, i) {
                                return val.voters_count;
                            }),
                            backgroundColor: backgroundColorGroup,
                            // borderWidth: 1,
                            // backgroundColor: $.map(backgroundColorGroup, (val, i) => val.split('')
                            //     .slice(0, -1).join('') + ', .2)'),
                        },

                    ],
                    labels: $.map(@this.voters_by_district, function(val, i) {
                        return val.label;
                    }),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            })

            const ctx_4 = document.getElementsByClassName('voters_by_religion');
            const voters_by_religion = new Chart(ctx_4, {
                type: 'pie',
                data: {
                    labels: $.map(@this.voters_by_religion, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        label: 'Jumlah Pemilih',
                        data: $.map(@this.voters_by_religion, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup
                    }]
                },
            })

            const ctx_5 = document.getElementsByClassName('voters_by_marital_status');
            const voters_by_marital_status = new Chart(ctx_5, {
                type: 'pie',
                data: {
                    labels: $.map(@this.voters_by_marital_status, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        label: 'Jumlah Pemilih',
                        data: $.map(@this.voters_by_marital_status, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup
                    }]
                },
            })

            const ctx_6 = document.getElementsByClassName('voters_by_profession');
            const voters_by_profession = new Chart(ctx_6, {
                type: 'bar',
                data: {
                    labels: $.map(@this.voters_by_profession, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        label: 'Jumlah Pemilih',
                        data: $.map(@this.voters_by_profession, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup
                    }]
                },
            })

            const ctx_7 = document.getElementsByClassName('voters_by_nasionality');
            const voters_by_nasionality = new Chart(ctx_7, {
                type: 'pie',
                data: {
                    labels: $.map(@this.voters_by_nasionality, function(val, i) {
                        return val.label;
                    }),
                    datasets: [{
                        label: 'Jumlah Pemilih',
                        data: $.map(@this.voters_by_nasionality, function(val, i) {
                            return val.data;
                        }),
                        backgroundColor: backgroundColorGroup
                    }]
                },
            })

            const ctx_8 = document.getElementsByClassName('voters_by_village');
            const voters_by_village = new Chart(ctx_8, {
                data: {
                    datasets: [{
                            type: 'line',
                            label: 'Total DPT',
                            data: $.map(@this.voters_by_village, function(val, i) {
                                return val.voters_total;
                            }),
                            backgroundColor: '#000',
                        },
                        {
                            type: 'bar',
                            label: 'Jumlah Pemilih',
                            data: $.map(@this.voters_by_village, function(val, i) {
                                return val.voters_count;
                            }),
                            backgroundColor: backgroundColorGroup,
                            // borderWidth: 1,
                            // backgroundColor: $.map(backgroundColorGroup, (val, i) => val.split('')
                            //     .slice(0, -1).join('') + ', .2)'),
                        },

                    ],
                    labels: $.map(@this.voters_by_village, function(val, i) {
                        return val.label;
                    }),
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            })

            let voters_by_tps_canvas;

            function set_voters_by_village_data() {
                voters_by_tps_canvas = document.querySelectorAll('canvas[data-canvas=voters_by_tps_canvas]');

                voters_by_tps_canvas.forEach((canvas, idx) => {
                    let village_id = canvas.dataset.id;
                    let voters_by_tps_data = @this.voters_by_tps
                    let data = voters_by_tps_data.filter(val => val.village_id == village_id)[0].tpses;

                    let voters_count_data = $.map(data, (val) => val.voters_count)
                    let voters_total_data = $.map(data, (val) => val.voters_total)
                    let voters_label_data = $.map(data, (val) => val.tps_name)

                    if (typeof window['chart_of_voters_by_tps_' + idx] !== 'undefined')
                        window['chart_of_voters_by_tps_' + idx]
                        .destroy()

                    window['chart_of_voters_by_tps_' + idx] = new Chart(canvas, {
                        data: {
                            datasets: [{
                                    type: 'line',
                                    label: 'Total DPT',
                                    data: voters_total_data,
                                    backgroundColor: '#000',
                                },
                                {
                                    type: 'bar',
                                    label: 'Jumlah Pemilih',
                                    data: voters_count_data,
                                    backgroundColor: backgroundColorGroup,
                                    // borderWidth: 1,
                                    // backgroundColor: $.map(backgroundColorGroup, (val, i) => val.split('')
                                    //     .slice(0, -1).join('') + ', .2)'),
                                },

                            ],
                            labels: voters_label_data,
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    })
                })
            }

            set_voters_by_village_data()

            $(document).on('chartLoaded', function() {
                set_voters_by_village_data()
                // Kecamatan
                voters_by_district.data.datasets[1].data = $.map(@this.voters_by_district, function(
                    val, i) {
                    return val.voters_count;
                });
                voters_by_district.data.datasets[0].data = $.map(@this.voters_by_district, function(
                    val, i) {
                    return val.voters_total;
                });
                voters_by_district.update();

                // Kelurahan/Desa
                voters_by_village.data.datasets[1].data = $.map(@this.voters_by_village, function(
                    val, i) {
                    return val.voters_count;
                });
                voters_by_village.data.datasets[0].data = $.map(@this.voters_by_village, function(
                    val, i) {
                    return val.voters_total;
                });
                voters_by_village.data.labels = $.map(@this.voters_by_village, function(
                    val, i) {
                    return val.label;
                });
                voters_by_village.update();

                voters_by_religion.data.datasets[0].data = $.map(@this.voters_by_religion, function(
                    val, i) {
                    return val.data;
                });
                voters_by_religion.update();

                voters_by_marital_status.data.datasets[0].data = $.map(@this
                    .voters_by_marital_status,
                    function(
                        val, i) {
                        return val.data;
                    });
                voters_by_marital_status.update();

                voters_by_profession.data.datasets[0].data = $.map(@this.voters_by_profession,
                    function(
                        val, i) {
                        return val.data;
                    });
                voters_by_profession.update();

                voters_by_nasionality.data.datasets[0].data = $.map(@this.voters_by_nasionality,
                    function(
                        val, i) {
                        return val.data;
                    });
                voters_by_nasionality.update();

                gender.data.datasets[0].data = $.map(@this.voters_by_gender, function(val, i) {
                    return val.data;
                });
                gender.update();

                age.data.datasets[0].data = $.map(@this.voters_by_age, function(val, i) {
                    return val.data;
                });
                age.update();
            })
        })
    </script>
@endpush
