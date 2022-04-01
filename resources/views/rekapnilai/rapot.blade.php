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
        body{
            background-image: url('{{ asset("logoperhubungan.png") }}');
            background-repeat: no-repeat;
            /* background-position-x: center !important; */
            /* background-position-y: top !important; */
            background-position: 50% 30%;
            background-size: 60%;
        }
        td{
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div style="background: #ffffffa1;">
        <table class="table table-bordered">
            <tr>
                <td style="width: 100px">
                    <img src="{{ asset('logosika.png') }}" width="100" alt="">
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <h6>
                        PENILAIAN NON AKADEMIK <br>
                        POLITEKNIK PENERBANGAN PALEMANG <br>
                        TAHUN AKADEMIK {{ $data->nama_semester }}
                    </h6>
                </td>
                <td style="width: 40%; vertical-align: middle;">
                    <p style="font-size: 10px;"> Kode: FM-SPMI-PLP-PD-05 <br>
                    Tanggal: 31-Des-2020</p>
                </td>
            </tr>
        </table>
        <div class="col-12">
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <td style="font-size: 10px;">NIT</td>
                        <td style="font-size: 10px;">:</td>
                        <td style="font-size: 10px;">{{ $data->nim }}</td>
                        <td style="font-size: 10px;">Prodi</td>
                        <td style="font-size: 10px;">:</td>
                        <td style="font-size: 10px;">{{ $data->nama_program_studi }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 10px;">Nama</td>
                        <td style="font-size: 10px;">:</td>
                        <td style="font-size: 10px;">{{ $data->nama_mahasiswa }}</td>
                        <td style="font-size: 10px;">Semester / Kelas</td>
                        <td style="font-size: 10px;">:</td>
                        <td style="font-size: 10px;">{{ $data->nama_semester }} / {{ $data->nama_kelas }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <td style="font-weight: bold" colspan="2">A. JASMANI (40%)</td>
                <td></td>
            </tr>
            <tr>
                <td>Samapta 70%</td>
                <td>:</td>
                <td>{{ $nilai_jasmani->nilai_samapta }}</td>
            </tr>
            <tr>
                <td>Berat Badan Ideal (30%)</td>
                <td>:</td>
                <td>{{ $nilai_jasmani->nilai_bbi }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold" colspan="2">B. SOFT SKILL (60%)</td>
                <td></td>
            </tr>
            <tr>
                <td>Pelanggaran (25%)</td>
                <td>:</td>
                <td>{{ $data->nilai_pelanggaran }}</td>
            </tr>
            <tr>
                <td>Penghargaan (25%)</td>
                <td>:</td>
                <td>{{ $data->nilai_penghargaan }}</td>
            </tr>
            <tr>
                <td>Soft Skill (50%)</td>
                <td>:</td>
                <td>{{ $data->nilai_softskill }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold" colspan="2">C. TOTAL NILAI</td>
                <td></td>
            </tr>
            <tr>
                <td>Nilai Akhir (Jasmani 40% + Soft SKill 60%)</td>
                <td>:</td>
                <td>
                    <?php
                        $nilai1 = $data->nilai_samapta * 40 / 100;
                        $nilai2 = $data->nilai_softskill * 50 / 100;
                        $nilai3 = $data->nilai_penghargaan * 25 / 100;
                        $nilai4 = $data->nilai_pelanggaran * 25 / 100;    
                    ?>
                    {{ 
                        round($nilai1 + (($nilai2 + $nilai3 + $nilai4) * 60 / 100), 2)
                    }}
                </td>
            </tr>
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
                        <td style="height: 100px;"></td>
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