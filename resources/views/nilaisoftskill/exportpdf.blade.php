<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            background-image: url('{{ asset('logoperhubungan.png') }}');
            background-repeat: no-repeat;
            background-position: 50% 30%;
            background-size: 60%;
        }

        td {
            font-size: 11px;
        }

    </style>
</head>

<body>
    <div style="background: #ffffffa1; height: fit-content; ">
        <table class="table table-bordered">
            <tr>
                <td style="width: 100px">
                    <img src="{{ asset('logosika.png') }}" width="100" alt="">
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <h6>
                        PENILAIAN JASMANI NON AKADEMIK <br>
                        POLITEKNIK PENERBANGAN PALEMANG <br>
                        TAHUN AKADEMIK {{ $data[0]->nama_semester }}
                    </h6>
                </td>
                <td style="width: 40%; vertical-align: middle;">
                    <p style="font-size: 10px;"> Kode: FM-SPMI-PLP-PD-05 <br>
                        Tanggal: 31-Des-2020</p>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td style="font-size: 10px;">Nomor</td>
                <td style="font-size: 10px;">{{ $data[0]->nama_mahasiswa }}</td>
                <td style="font-size: 10px;">NIT</td>
                <td style="font-size: 10px;">{{ $data[0]->nim }}</td>
                <td style="font-size: 10px; vertical-align: middle;" rowspan="2" class="text-center">
                    <h6><u>Nilai Softskill</u> </h6>
                    <br>
                    <h3></h3>
                </td>
            </tr>
            <tr>
                <td style="font-size: 10px;">Prodi</td>
                <td style="font-size: 10px;">{{ $data[0]->nama_program_studi }}</td>
                <td style="font-size: 10px;">Semester</td>
                <td style="font-size: 10px;">{{ $data[0]->nama_semester }}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td style="font-size: 10px;" width="10px;">Nomor</td>
                <td>Uraian</td>
                <td class="text-center" width="100px;" style="font-size: 10px;">Ya</td>
                <td class="text-center" width="100px;" style="font-size: 10px;">Tidak</td>
            </tr>
            @foreach ($data as $k => $item)
                @if (@$jenis_evaluasi != $item->jenis_softskill)
                    <tr>
                        <td colspan="4">
                            <b>{{ $jenis_evaluasi = $item->jenis_softskill }}</b>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $item->keterangan_softskill }}</td>
                    <td class="text-center">
                        @if ($item->nilai == 100)                            
                            <img src="{{ asset('check-lg.png') }}" alt="">	
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($item->nilai == 0) 
                            <img src="{{ asset('check-lg.png') }}" alt="">                      
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="col-4" style="margin-left: auto;">
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center">
                            Mengetahui <br>
                            Kepala Pusat Pembangunan Karakter <br>
                            Politeknik Penerbangan Palembang
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 70px;"></td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <u>
                                WILDAN NUGRAHA, S.E., MS.ASM.
                            </u>
                            <br>
                            NIP. 19890121 200912 1 002
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
