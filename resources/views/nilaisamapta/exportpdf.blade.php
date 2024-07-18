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
                        PENILAIAN JASMANI NON AKADEMIK <br>
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

        <table class="table table-bordered">
            <tr>
                <td style="font-size: 10px;">Nama</td>
                <td style="font-size: 10px;">{{ $data->nama_mahasiswa }}</td>
                <td style="font-size: 10px;">NIT</td>
                <td style="font-size: 10px;">{{ $data->nim }}</td>
                <td style="font-size: 10px; vertical-align: middle;" rowspan="2" class="text-center">
                    <h6><u>Nilai Jasmani</u> </h6>
                    <br>
                    <h3>{{ $data->nilai_samapta }}</h3>
                </td>
            </tr>
            <tr>
                <td style="font-size: 10px;">Prodi</td>
                <td style="font-size: 10px;">{{ $data->nama_program_studi }}</td>
                <td style="font-size: 10px;">Semester</td>
                <td style="font-size: 10px;">{{ $data->nama_semester }}</td>
            </tr>
        </table>
        
        <h6>a. Samapta</h6>
        <table class="table table-bordered">
            <tr>
                <td  style="font-size: 10px;" width="10px;">Nomor</td>
                <td style="font-size: 10px;">Kegiatan</td>
                <td style="font-size: 10px;">Jumlah yang Diperoleh</td>
                <td style="font-size: 10px;">Nilai</td>
            </tr>
            <tr>
                <td style="font-size: 10px;">1</td>
                <td style="font-size: 10px;">Sit-Up</td>
                <td style="font-size: 10px;">{{ $data->jumlah_sit_up }} Kali</td>
                <td style="font-size: 10px;">{{ $data->nilai_sit_up }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;" >2</td>
                <td style="font-size: 10px;" >Push-Up</td>
                <td style="font-size: 10px;" >{{ $data->jumlah_push_up }} Kali</td>
                <td style="font-size: 10px;" >{{ $data->nilai_push_up }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;">3</td>
                <td style="font-size: 10px;">Shuttle-Run</td>
                <td style="font-size: 10px;">{{ $data->jumlah_shuttle_run }} Detik</td>
                <td style="font-size: 10px;">{{ $data->nilai_shuttle_run }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;">4</td>
                <td style="font-size: 10px;">Lari (12 Menit)</td>
                <td style="font-size: 10px;">{{ $data->jarak_lari }} Meter</td>
                <td style="font-size: 10px;">{{ $data->nilai_lari }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;" colspan="3" class="text-center"><b>Total</b></td>
                <td style="font-size: 10px;">
                    <b>
                        {{ round(($data->nilai_lari + (($data->nilai_push_up + $data->nilai_sit_up + $data->nilai_shuttle_run) / 3)) / 2, 2) }}
                    </b>
                </td>
            </tr>
        </table>

        <h6 class="mt-4">b. BBI</h6>
        <table class="table table-bordered">
            <tr>
                <td style="font-size: 10px;">Tinggi Badan</td>
                <td style="font-size: 10px;">{{ $data->tinggi_badan }}</td>
            </tr>
            <tr>
                <td style="font-size: 10px;">Berat Badan</td>
                <td style="font-size: 10px;">{{ $data->berat_badan }}</td>
            </tr>
           <tr>
               <td style="font-size: 10px;">Stakes</td>
               <td style="font-size: 10px;">{{ $data->stakes }}</td>
           </tr> 
          <tr>
              <td style="font-size: 10px;"><b>Nilai BBI</b> </td>
              <td style="font-size: 10px;"><b>{{ $data->nilai_bbi }}</b></td>
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