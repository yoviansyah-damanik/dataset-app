<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 1cm;
        }

        * {
            position: relative;
            font-size: 14px;
        }

        h3 {
            font-size: 1.2em;
        }

        .page-break {
            page-break-after: always;
        }

        table {
            width: 100%;
        }

        table.bordered,
        table.bordered tr,
        table.bordered th,
        table.bordered td {
            border-collapse: collapse;
            border: 1px solid #000;
        }

        /* table.bordered td {
            padding: .5rem .75rem;
        } */

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .title {
            text-transform: uppercase;
            text-align: center;
            font-weight: 500;
            text-decoration: underline;
        }

        .fw-bold {
            font-weight: 500;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-1 {
            margin-bottom: .5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mt-0 {
            margin-top: 0;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .my-3 {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        #watermark {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100dvh;
            width: 100dvw;
            white-space: normal;
            word-break: break-all;
            word-wrap: break-word;
            text-align: center;
            opacity: .1;
            z-index: -1000;
            font-size: 7em;
            font-weight: 700;
            color: #ffff00;
            margin: -1cm;
            line-height: .8em;
        }
    </style>
</head>

<body>
    {{-- @include('printout/partials/header') --}}
    <div id="watermark">
        {{ Str::of(GeneralHelper::get_abb_app_name())->replace(' ', '')->upper()->repeat(25) }}
    </div>

    <h3 class="title">Data Perhitungan Pemilih</h3>
    <table>
        <tr>
            <td style="width: 150px">
                <span class="fw-bold">ID</span>
            </td>
            <td>
                <span class="fw-bold">:</span>
                {{ $unique_code }}
            </td>
        </tr>
        <tr>
            <td style="width: 150px">
                <span class="fw-bold">Kecamatan</span>
            </td>
            <td>
                <span class="fw-bold">:</span>
                {{ $district }}
            </td>
        </tr>
        <tr>
            <td style="width: 150px">
                <span class="fw-bold">Tanggal Dibuat</span>
            </td>
            <td>
                <span class="fw-bold">:</span>
                {{ $created_at }}
            </td>
        </tr>
    </table>

    <h4 class="mb-1">Rincian Umum Pemilih</h4>
    <table class="bordered mb-3" cellpadding="1">
        {{-- TOTAL SELURUH PEMILIH --}}
        <tr>
            <td class="text-center" colspan=6>
                <p class="title_count">Total Seluruh Pemilih</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </h3>
                <div class="mb-3">
                    Total DPT: {{ GeneralHelper::number_format($data['voters_all_total']) }} DPT
                    ({{ GeneralHelper::number_format($data['voters_all_total'] > 0 ? ($data['voters_all_count'] / $data['voters_all_total']) * 100 : 0, true) }}%)
                </div>
            </td>
        </tr>
        {{-- TOTAL BERDASARKAN JENIS KELAMIN --}}
        <tr>
            <td class="text-center" colspan=6>
                <p class="title_count">Total Pemilih berdasarkan Jenis Kelamin</p>
            </td>
        </tr>
        <tr>
            <td class="text-center" colspan=3>
                <p class="title_count">Laki-laki</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['voters_by_gender']['Laki-laki']) }}
                </h3>
            </td>
            <td class="text-center" colspan=3>
                <p class="title_count">Perempuan</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['voters_by_gender']['Perempuan']) }}
                </h3>
            </td>
        </tr>
        {{-- TOTAL BERDASARKAN UMUR --}}
        <tr>
            <td class="text-center" colspan=6>
                <p class="title_count">Total Pemilih berdasarkan Umur</p>
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <p class="title_count">17 - 25 Tahun</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['age_17_25']) }}
                </h3>
            </td>
            <td class="text-center">
                <p class="title_count">25 - 35 Tahun</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['age_25_35']) }}
                </h3>
            </td>
            <td class="text-center" colspan=2>
                <p class="title_count">35 - 45 Tahun</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['age_35_45']) }}
                </h3>
            </td>
            <td class="text-center">
                <p class="title_count">45 - 55 Tahun</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['age_45_55']) }}
                </h3>
            </td>
            <td class="text-center">
                <p class="title_count">> 55 Tahun</p>
                <h3 class="count">
                    {{ GeneralHelper::number_format($data['age_55_up']) }}
                </h3>
            </td>
        </tr>
    </table>

    <h4 class="mb-1">Rincian Pemilih Per Kecamatan</h4>
    <table class="bordered mb-3" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Wilayah</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 120px">Total DPT</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['total_count_voters'] as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($item['voters_count']) }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($item['voters_total']) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($item['voters_total'] > 0 ? ($item['voters_count'] / $item['voters_total']) * 100 : 0, true) }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold ">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_total']) }}
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_total'] > 0 ? ($data['voters_all_count'] / $data['voters_all_total']) * 100 : 0, true) }}
                </td>
            </tr>
        </tbody>
    </table>

    <h4 class="mb-1">Rincian Pemilih Per Pekerjaan</h4>
    <table class="bordered mb-3" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Pekerjaan</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['voters_by_profession'] as $profession)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $profession->name }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($profession->voters_count) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($data['voters_all_count'] ? ($profession->voters_count / $data['voters_all_count']) * 100 : 0, true) }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold ">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ $data['voters_all_count'] > 0 ? 100 : 0 }}
                </td>
            </tr>
        </tbody>
    </table>

    <h4 class="mb-1">Rincian Pemilih Per Agama</h4>
    <table class="bordered mb-3" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Pekerjaan</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['voters_by_religion'] as $religion)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $religion->name }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($religion->voters_count) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($data['voters_all_count'] ? ($religion->voters_count / $data['voters_all_count']) * 100 : 0, true) }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold ">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ $data['voters_all_count'] > 0 ? 100 : 0 }}
                </td>
            </tr>
        </tbody>
    </table>

    <h4 class="mb-1">Rincian Pemilih Per Status Perkawinan</h4>
    <table class="bordered mb-3" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Pekerjaan</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['voters_by_marital_status'] as $marital_status)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $marital_status->name }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($marital_status->voters_count) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($data['voters_all_count'] ? ($marital_status->voters_count / $data['voters_all_count']) * 100 : 0, true) }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold ">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ $data['voters_all_count'] > 0 ? 100 : 0 }}
                </td>
            </tr>
        </tbody>
    </table>

    <h4 class="mb-1">Rincian Pemilih Per Kewarganegaraan</h4>
    <table class="bordered mb-3" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Pekerjaan</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['voters_by_nasionality'] as $nasionality)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $nasionality->name }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($nasionality->voters_count) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($data['voters_all_count'] ? ($nasionality->voters_count / $data['voters_all_count']) * 100 : 0, true) }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold ">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ $data['voters_all_count'] > 0 ? 100 : 0 }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>
    <h4 class="mb-1 text-center">Rincian Pemilih Per Kelurahan/Desa</h4>
    <table class="bordered" cellpadding="1">
        <thead>
            <th style="width: 40px">No</th>
            <th>Nama Wilayah</th>
            <th style="width: 120px">Jumlah Pemilih</th>
            <th style="width: 120px">Total DPT</th>
            <th style="width: 80px">%</th>
        </thead>
        <tbody>
            @foreach ($data['total_count_voters'] as $idx => $district)
                <tr class="fw-bold">
                    <td class="text-center">
                        {{ $idx + 1 }}
                    </td>
                    <td>
                        &nbsp;{{ $district['name'] }}
                    </td>
                    <td class="text-center">{{ GeneralHelper::number_format($district['voters_count']) }}</td>
                    <td class="text-center">{{ GeneralHelper::number_format($district['voters_total']) }}</td>
                    <td class="text-center">
                        {{ GeneralHelper::number_format($district['voters_total'] > 0 ? ($district['voters_count'] / $district['voters_total']) * 100 : 0, true) }}
                    </td>
                </tr>
                @foreach ($district['villages'] as $idx_ => $village)
                    <tr>
                        <td class="text-center">{{ $idx + 1 . '.' . $idx_ + 1 }}</td>
                        <td>{{ $village['name'] }}</td>
                        <td class="text-center">{{ GeneralHelper::number_format($village['voters_count']) }}</td>
                        <td class="text-center">{{ GeneralHelper::number_format($village['voters_total']) }}</td>
                        <td class="text-center">
                            {{ GeneralHelper::number_format($village['voters_total'] > 0 ? ($village['voters_count'] / $village['voters_total']) * 100 : 0, true) }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="fw-bold">
                <td class="text-end" colspan=2>
                    Total Keseluruhan &nbsp;
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_count']) }}
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_total']) }}
                </td>
                <td class="text-center">
                    {{ GeneralHelper::number_format($data['voters_all_total'] > 0 ? ($data['voters_all_count'] / $data['voters_all_total']) * 100 : 0, true) }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>
    <h4 class="mb-1 text-center">Rincian Pemilih Per TPS</h4>
    @foreach ($data['total_count_voters'] as $idx => $district)
        <div class="fw-bold mb-1">
            {{ $idx + 1 }}.{{ $district['name'] }}
        </div>
        <table class="bordered mb-3" cellpadding="1">
            <tr>
                <td class="text-center">
                    <p class="title_count">Total Pemilih</p>
                    <h3 class="count">
                        {{ GeneralHelper::number_format($district['voters_count']) }}
                    </h3>
                </td>
                <td class="text-center">
                    <p class="title_count">Total DPT</p>
                    <h3 class="count">
                        {{ GeneralHelper::number_format($district['voters_total']) }}
                    </h3>
                </td>
                <td class="text-center">
                    <p class="title_count">%</p>
                    <h3 class="count">
                        {{ GeneralHelper::number_format($district['voters_total'] > 0 ? ($district['voters_count'] / $district['voters_total']) * 100 : 0, true) }}
                    </h3>
                </td>
            </tr>
        </table>

        @foreach ($district['villages'] as $idx_ => $village)
            <div class="fw-bold mb-1">
                {{ $idx + 1 }}.{{ $idx_ + 1 }}.{{ $village['name'] }}
            </div>
            <table class="bordered mb-3" cellpadding="1">
                <thead>
                    <th style="width: 40px">No</th>
                    <th>Nama Wilayah</th>
                    <th style="width: 120px">Jumlah Pemilih</th>
                    <th style="width: 120px">Total DPT</th>
                    <th style="width: 80px">%</th>
                </thead>
                <tbody>
                    @foreach ($village['tpses'] as $tps)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                &nbsp;{{ $tps['name'] }}
                            </td>
                            <td class="text-center">{{ GeneralHelper::number_format($tps['voters_count']) }}</td>
                            <td class="text-center">{{ GeneralHelper::number_format($tps['voters_total']) }}</td>
                            <td class="text-center">
                                {{ GeneralHelper::number_format($tps['voters_total'] > 0 ? ($tps['voters_count'] / $tps['voters_total']) * 100 : 0, true) }}
                            </td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td class="text-end" colspan=2>
                            Total Keseluruhan &nbsp;
                        </td>
                        <td class="text-center">
                            {{ GeneralHelper::number_format($village['voters_count']) }}
                        </td>
                        <td class="text-center">
                            {{ GeneralHelper::number_format($village['voters_total']) }}
                        </td>
                        <td class="text-center">
                            {{ GeneralHelper::number_format($village['voters_total'] > 0 ? ($village['voters_count'] / $village['voters_total']) * 100 : 0, true) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    @include('printout/partials/page_number', [$unique_code])

</body>

</html>
