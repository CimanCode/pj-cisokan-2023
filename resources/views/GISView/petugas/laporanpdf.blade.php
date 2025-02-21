<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengaduan/Keluhan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 20px;
        }
        .container {
            width: 100%;
            border: 1px solid #000;
            padding: 10px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header img {
            width: 50px;
        }
        .header-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            text-align: center;
            flex: 1;
            position: relative;
            top: -65px;
            border: 1px solid #000;
            padding: 2px;
        }
        .asli-box {
            border: 1px solid #000;
            padding: 5px 10px;
            font-weight: bold;
            width: 50px;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: -75px;
        }
        .table td {
            padding: 5px;
            vertical-align: top;
        }
        .table .label {
            width: 30%;
            white-space: nowrap;
            font-weight: bold;
        }

        .table .value {
            width: 70%;
            word-wrap: break-word;
        }
        .footer {
            margin-top: 20px;
            text-align: left;
            font-size: 12px;
        }
        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .sign-box {
            text-align: center;
            width: 40%;
        }
        .sign-box p {
            margin-bottom: 30px;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div>
            <img src="{{ public_path('logo_pln.png') }}" alt="PLN Logo">
            <div style="position: relative; top: -50px; right: -50px;">
                <h3>
                    PT PLN (Persero)<br>
                    <span>UIP JBT</span>
                </h3>
            </div>
            <div class="asli-box" style="position: relative; top: -100px; left: 590px;">ASLI</div>
        </div>
        <div class="header-title">FORMULIR PENGADUAN/KELUHAN</div>
    </div>

    <!-- Form Data -->
    <table class="table">
        <tr>
            <td class="label bold">Hari / Tanggal</td>
            <td>:</td>
            <td class="value">{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label bold">Nomor Kode Aduan</td>
            <td>:</td>
            <td class="value">{{$data->grievance_num}}</td>
        </tr>
        <tr>
            <td class="label bold">Lokasi Aduan</td>
            <td>:</td>
            <td class="value">
                {{$data->locations}}<br>
                S:{{$data->lattitude}}<br>
                E:{{$data->longitude}}<br>
                (di mark dengan GPS)
            </td>
        </tr>
        <tr>
            <td class="label bold">RT/RW</td>
            <td>:</td>
            <td class="value">{{$data->rt_rw}}</td>
        </tr>
        <tr>
            <td class="label bold">Dusun/Kampung</td>
            <td>:</td>
            <td class="value">{{$data->kampung}}</td>
        </tr>
        <tr>
            <td class="label bold">Desa</td>
            <td>:</td>
            <td class="value">{{$data->desa}}</td>
        </tr>
        <tr>
            <td class="label bold">Nama Pelapor</td>
            <td>:</td>
            <td class="value">{{$data->complainants}}</td>
        </tr>
        <tr>
            <td class="label bold">No. KTP</td>
            <td>:</td>
            <td class="value">{{$data->no_ktp ?? ""}}</td>
        </tr>
        <tr>
            <td class="label bold">No. Kontak Pelapor</td>
            <td>:</td>
            <td class="value">{{$data->no_telp ?? ""}}</td>
        </tr>
        <tr>
            <td class="label bold">Kategori Aduan</td>
            <td>:</td>
            <td class="value">
                1. LARAP <br>
                2. ESIA, BMP, FPAP <br>
                3. Gender, KBG, dan KTA <br>
                4. Covid-19 <br>
                5. Ketenagakerjaan, kecelakaan kerja, pelanggaran kode etik (K3L) <br>
                <strong>Dipilih: {{$data->category}}</strong>
            </td>
        </tr>
        <tr>
            <td class="label bold">Uraian Aduan</td>
            <td>:</td>
            <td class="value">{{$data->issue}}</td>
        </tr>
        <tr>
            <td class="label bold">Jalur Aduan</td>
            <td>:</td>
            <td class="value">{{$data->jalur_aduan}}</td>
        </tr>
        <tr>
            <td class="label bold">Uraian Rencana Tindak Lanjut</td>
            <td>:</td>
            <td class="value">{{$data->tindak_lanjut ?? "Belum ada tindak lanjut"}}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Mohon dilengkapi dengan foto kondisi aduan dan foto KTP pelapor</strong></p>
    </div>

    <!-- Signature Section -->
    <div class="signatures" style="position: relative; left: 30px;">
        <p>PT PLN (Persero)<br>
            <span>UIP JBT</span></p>
        <div class="sign-box" style="position: relative; top: -45px; right: -90px;">
            <p>Penerima Aduan,</p>
            <img src="{{ public_path('storage/image/' . $data->image_ttd) }}" alt="" style="width: 100px; position: relative; top: -20;">
        </div>
        <div class="sign-box" style="position: relative; top: -148px; left: 350px;">
            <p>Pelapor,</p>
        </div>
    </div>
</div>

</body>
</html>
