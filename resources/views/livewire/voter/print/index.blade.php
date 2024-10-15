<div id="print-voters">
    <div class="breadcrumb-area">
        <div class="fw-bold fs-3 text-uppercase">
            Cetak Data Pemilih
        </div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Cetak Data Pemilih
            </li>
        </ol>
    </div>
    @production
        <div class="row">
            <div class="col-lg-5 col-xxl-4">
                <livewire:voter.print.form />
            </div>
            <div class="col-lg-7 col-xxl-8">
                <livewire:voter.print.datalist />
            </div>
        </div>
    @else
        Sedang dalam pengembangan
    @endproduction
</div>
