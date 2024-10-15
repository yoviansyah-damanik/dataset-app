<div id="master">
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Data Master
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Data Master
            </li>
        </ol>
    </div>
    <div class="row">
        <div class="col-12 my-3">
            <span class="row-title">
                <span>
                    Dalam Angka
                </span>
            </span>
        </div>
        <div class="col-md-6 col-lg-4 col-xxl-3">
            <div class="box box-primary">
                <div class="box-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="box-body">
                    <div class="box-title">
                        Total Status Perkawinan
                    </div>
                    <div class="box-count">
                        {{ $total_marital_statuses }}
                    </div>
                </div>

                @haspermission('master marital_status')
                    <a class="stretched-link" href="{{ route('master.marital_status') }}"></a>
                @endhaspermission
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xxl-3">
            <div class="box box-secondary">
                <div class="box-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="box-body">
                    <div class="box-title">
                        Total Pekerjaan
                    </div>
                    <div class="box-count">
                        {{ $total_professions }}
                    </div>
                </div>
                @haspermission('master profession')
                    <a class="stretched-link" href="{{ route('master.profession') }}"></a>
                @endhaspermission
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xxl-3">
            <div class="box box-third">
                <div class="box-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="box-body">
                    <div class="box-title">
                        Total Agama
                    </div>
                    <div class="box-count">
                        {{ $total_religions }}
                    </div>
                </div>
                @haspermission('master religion')
                    <a class="stretched-link" href="{{ route('master.religion') }}"></a>
                @endhaspermission
            </div>
        </div>
        <div class="col-md-6 col-lg-4 col-xxl-3">
            <div class="box box-fourth">
                <div class="box-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="box-body">
                    <div class="box-title">
                        Total Kewarganegaraan
                    </div>
                    <div class="box-count">
                        {{ $total_nasionalities }}
                    </div>
                </div>
                @haspermission('master nasionality')
                    <a class="stretched-link" href="{{ route('master.nasionality') }}"></a>
                @endhaspermission
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 my-3">
            <span class="row-title">
                <span>
                    Grafik
                </span>
            </span>
        </div>
        {{-- PEMILIH BERDASARKAN AGAMA --}}
        <div class="col-md-6 col-lg-3">
            <div class="chart-box">
                <div class="chart-title">
                    Pemilih berdasarkan Agama
                </div>
                <div class="chart-body">
                    <div class="position-relavite">
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
            <div class="chart-box">
                <div class="chart-title">
                    Pemilih berdasarkan Status Perkawinan
                </div>
                <div class="chart-body">
                    <div class="position-relavite">
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
            <div class="chart-box">
                <div class="chart-title">
                    Pemilih berdasarkan Kewarnaganegaraan
                </div>
                <div class="chart-body">
                    <div class="position-relavite">
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

        {{-- PEMILIH BERDASARKAN PROFESI --}}
        <div class="col-12">
            <div class="chart-box">
                <div class="chart-title">
                    Pemilih berdasarkan Profesi
                </div>
                <div class="chart-body">
                    <div class="position-relavite">
                        <canvas style="height: 300px;" class="voters_by_profession"></canvas>
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
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
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
        })
    </script>
@endpush
