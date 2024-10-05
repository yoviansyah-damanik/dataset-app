<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 1cm;
        }

        * {
            position: relative;
            font-size: 12px;
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

        table.bordered,
        table.bordered tr,
        table.bordered td {
            vertical-align: top;
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

        .text-nowrap {
            text-wrap: nowrap;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
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
        {{ Str::of(GeneralHelper::get_abb_app_name())->replace(' ', '')->upper()->repeat(100) }}
    </div>

    @foreach ($data as $idx => $district)
        @foreach ($district['villages'] as $idx_ => $village)
            @foreach ($village['tpses'] as $idx__ => $tps)
                @foreach ($tps['teams'] as $idx___ => $team)
                    <h3 class="title">Data Pemilih</h3>
                    <table class="mb-3 mx-auto">
                        <tr>
                            <td style="width: 150px">
                                <span class="fw-bold">ID</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $unique_code }}
                            </td>
                            <td style="width: 150px">
                                <span class="fw-bold">Kecamatan</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $district['name'] }}
                            </td>
                            <td style="width: 150px">
                                <span class="fw-bold">TPS</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $tps['name'] }}
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
                            <td style="width: 150px">
                                <span class="fw-bold">Kelurahan/Desa</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $village['name'] }}
                            </td>
                            <td style="width: 150px">
                                <span class="fw-bold">Tim Bersinar</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $team[0]['team_name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px">
                                <span class="fw-bold">Koordinator Kecamatan</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $team[0]['district_coor_name'] }}
                            </td>
                            <td style="width: 150px">
                                <span class="fw-bold">Koordinator Kelurahan/Desa</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $team[0]['village_coor_name'] }}
                            </td>
                            <td style="width: 150px">
                                <span class="fw-bold">Koordinator TPS</span>
                            </td>
                            <td>
                                <span class="fw-bold">:</span>
                                {{ $team[0]['tps_coor_name'] }}
                            </td>
                        </tr>
                    </table>

                    <table class="bordered mt-3" cellpadding=1>
                        <thead>
                            <th style="width: 30px">No</th>
                            <th style="width: 100px">NIK</th>
                            <th style="width: 140px">Nama Lengkap</th>
                            <th style="width: 160px">Tempat, Tgl Lahir</th>
                            <th>Umur (Tahun)</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th style="width: 100px">No. Telp.</th>
                        </thead>
                        <tbody>
                            @foreach ($team as $voter)
                                <tr class="item">
                                    <td class="text-center" style="width:40px;">{{ $loop->iteration }}</td>
                                    <td>{{ '**' . str($voter['nik'])->substr(2, 8) . '******' }}</td>
                                    <td>{{ $voter['name'] }}</td>
                                    <td>
                                        {{ $voter['place_of_birth'] . ', ' . \Carbon\Carbon::parse($voter['date_of_birth'])->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($voter['date_of_birth'])->age }}
                                    </td>
                                    <td class="text-center">{{ $voter['gender'] }}</td>
                                    <td>{{ $voter['address'] }}</td>
                                    <td class="text-end">{{ $voter['phone_number'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="page-break"></div>
                @endforeach
            @endforeach
        @endforeach
    @endforeach

    @include('printout/partials/page_number_landscape', [$unique_code])
</body>

</html>
