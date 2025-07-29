<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- Primary Meta Tags -->
    <title>Validasi PIN IAKNPKY</title>
    <meta name="title" content="Validasi PIN IAKNPKY" />
    <meta name="description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Validasi PIN IAKNPKY" />
    <meta property="og:description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />
    <meta property="og:image" content="https://iaknpky.ac.id/wp-content/uploads/2025/04/iakn_icon.png" />
    <meta property="og:image:width" content="72" />
    <meta property="og:image:height" content="72" />
    <meta property="og:image:type" content="image/png" />

    <!-- X (Twitter) -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="Validasi PIN IAKNPKY" />
    <meta property="twitter:description" content="Layanan Penerbitan Surat Validasi PIN Calon Lulusan IAKN Palangka Raya. Dikelola Oleh UPT TIPD IAKN Palangka Raya" />

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3
        -->
    <!-- Set also "landscape" if you need -->
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        @page {
            size: A4
        }

        @import url('https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap');

        * {
            font-family: "Arimo", sans-serif;
        }

        .watermark-draft {
            font-size: 50px;
            display: block;
            position: fixed;
            z-index: 1;
            background: white;
            opacity: 0.1;
            top: 10%;
            left: 34%;
            transform: translate(-50%, -50%);
            transform: rotate(-40deg);
        }

        @media print {

            /* page-break-after works, as well */
            .watermark-draft {
                color: #0a0a0a;
                font-size: 150px;
                display: block;
                position: fixed;
                z-index: 1;
                background: white;
                /* opacity: 0.1; */
                top: 30%;
                left: 12%;
                transform: translate(-50%, -50%);
                transform: rotate(-40deg);
            }

            .noprint {
                visibility: hidden;
            }
        }

        table.customTable {
            width: 100%;
            background-color: #FFFFFF;
            border-collapse: collapse;
            border-width: 0;
            border-color: #0a0a0a;
            border-style: solid;
            color: #000000;
        }

        table.customTable td,
        table.customTable th {
            border-width: 0;
            border-color: #0a0a0a;
            border-style: solid;
            padding: 5px;
        }

        table.customTable thead {
            background-color: #b8b8b8;
        }

        .responsive {
            width: 100%;
            height: auto;
        }

        /* CSS */
        .button-87 {
            margin: 10px;
            padding: 10px 20px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            border-radius: 10px;
            display: block;
            border: 0px;
            font-weight: 400;
            box-shadow: 0px 0px 14px -7px #f019f0;
            background-image: linear-gradient(45deg, #d92fff 0%, #5619f0 51%, #d92fff 100%);
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        .button-87:hover {
            background-position: right center;
            /* change the direction of the change here */
            color: #fff;
            text-decoration: none;
        }

        .button-87:active {
            transform: scale(0.35);
        }

        .absolute {
            position: fixed;
            top: 14px
        }

        .btnedit {
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    @if ($mhs == null)
        <section class="sheet padding-10mm">
            <h2 style="text-align: center;">FORM VALIDASI <br>PIN (PENOMORAN IJAZAH NASIONAL) <br>INSTITUT AGAMA
                KRISTEN NEGERI PALANGKA RAYA</h2>
            <h2 style="text-align: center;">Dokumen Tidak Ditemukan, Silahkan Cek Kembali Kode Dokumen Anda</h2>
        </section>
    @else
        <section class="sheet padding-10mm">
            @if ($mhs->status_eligible != 'Eligible')
                <p class="watermark-draft">DRAFT</p>
            @endif
            @if ($mhs->status_eligible == 'Eligible')
                <button id="buttoncetak" class="button-87 noprint absolute" onclick="window.print()">Cetak</button>
            @else
                <button type="button" class="button-87" role="button" disabled>Belum Bisa Cetak</button>
            @endif
            <h2 style="text-align: center;">FORM VALIDASI <br>PIN (PENOMORAN IJAZAH NASIONAL) <br>INSTITUT AGAMA
                KRISTEN NEGERI PALANGKA RAYA</h2>
            <div>
                <!-- <img class="responsive" src="#" alt="kop_surat"> -->
            </div>
            <p>Saya yang bertanda tangan di bawah ini :</p>
            <table class="customTable" style="width:100%">
                <tbody>
                    {{-- <tr style="padding-top: 100px;">
                        <td style="width: 150px;">Nama</td>
                        <td>: Agri Apriliando, ST </td>
                    </tr> --}}
                    <tr style="padding-top: 100px;">
                        <td style="width: 150px;">Nama</td>
                        <td>: Chrismas Debianto, S.Pd </td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: Operator PISN </td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>: UPT TIPD IAKN Palangka Raya </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 0;" colspan="2">Dengan ini menerangkan bahwa :</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $mhs->nama_mahasiswa }} </td>
                    </tr>
                    <tr>
                        <td>NIM</td>
                        <td>: {{ $mhs->nim }} </td>
                    </tr>
                    <tr>
                        <td>Tempat/ Tgl. Lahir</td>
                        <td>: {{ $mhs->tempat_lahir . ', ' . \Carbon\Carbon::parse($mhs->tgl_lahir)->translatedFormat('j F Y') }} </td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $mhs->alamat }} </td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>: {{ $mhs->prodi }} </td>
                    </tr>
                    <tr x-data="{ edit: false }">
                        <td>No HP</td>
                        <td x-show="!edit">: {{ $mhs->nohp }} <button class="no-print" @click="edit = true" class="btnedit">Edit</button> </td>
                        <td x-show="edit">
                            <form action="{{ url('savenohp/' . $mhs->nim) }}" method="POST">
                                @csrf
                                @method('PUT')
                                : <input name="nohp" type="text" class="form-control d-inline-block" value="{{ $mhs->nohp }}" style="width: 130px">
                                <button type="submit">Simpan</button>
                                <button type="button" @click="edit = false">Batal</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
            @if (session('status'))
                <div style="text-decoration: underline; font-weight: bold; color: red" x-data="{ show: true }" x-init="setTimeout(() => show = false, 7000)" x-show="show" x-transition>
                    {{ session('status') }}
                    <button type="button" @click="show = false">&times;</button>
                </div>
            @endif
            <p>Berdasarkan hasil pengecekan pada sistem Penomoran Ijazah Nasional
                (PIN) bahwa mahasiswa yang bersangkutan :</p>
            @if ($mhs->status_eligible == 'Belum Cek')
                <h5 style="text-align: center; font-weight: bold;">Status Eligible/Non Eligible Belum divalidasi Oleh Admin
                    <br>Silahkan Tunggu 2x24 Jam
                </h5>
            @else
                <h3 style="text-align: center; font-weight: bold;">{{ $mhs->status_eligible }}</h3>
            @endif
            <p>Demikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
            <table class="customTable" style="width:100%">
                <tbody>
                    <tr>
                        <td style="width: 50%;"></td>
                        <td>Palangka Raya, {{ \Carbon\Carbon::parse($mhs->updated_at)->translatedFormat('j F Y') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Yang Menerangkan, </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td id="qrcode" data-url="{{ url('qrcode/' . $mhs->id) }}">
                            @if ($mhs->status_eligible == 'Eligible')
                                <div id="img-div"></div>
                            @endif
                            @if ($mhs->status_eligible != 'Eligible')
                                <p style="font-weight: bold;">QRCODE Tampil Tersedia <br>
                                    Setelah Status Dinyatakan ELIGIBLE</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top: 40px; font-style: italic; color: #ad0000;">
                <p>Kode Dokumen : {{ $mhs->id }}</p>
                <a style="color: #ad0000;" href="#">Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('j F Y H:i') }} melalui www.validasipin.tipdiaknpky.com </a>
            </div>
            <div style="margin-top: 15px">
                <!-- <img class="responsive" src="#" alt="kop_surat"> -->
            </div>

        </section>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.9/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            var idd = document.getElementById("qrcode");
            var url = idd.getAttribute("data-url");
            // console.log(url);
            $.ajax({
                type: "GET",
                url: url,
                data: null,
                dataType: 'text',
                cache: false,
                timeout: 600000,
                success: function(data) {
                    // console.log(data);
                    $('#img-div').html('<img id="img" src="data:image/png;base64,' + data + '" />');
                },
                error: function() {
                    console.log(data);
                    console.log("gagal");
                }
            });
        });
    </script>
</body>

</html>
