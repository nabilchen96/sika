<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kuesioner;
use App\DetailKuesioner;
use DB;

class DetailKuesionerController extends Controller
{
    public function index($id){
        $data = Kuesioner::find($id);
        $soal = DetailKuesioner::where('id_kuesioner', $data->id_kuesioner)->get();
        return view('kuesioner.detail')->with('data', $data)->with('soal', $soal);
    }


    public function store(Request $request){
        $request->validate([
            'soal'          => 'required',
            'id_kuesioner'  => 'required',
            'jenis_soal'    => 'required'
        ]);

        $jawaban = !empty($request->jawaban) ? $request->jawaban : [];

        DetailKuesioner::create([
            'soal'          => $request->soal,
            'id_kuesioner'  => $request->id_kuesioner,
            'jenis_soal'    => $request->jenis_soal,
            'jawaban'       => \serialize($jawaban)
        ]);

        return back()->with(['sukses' => 'Data berhasil disimpan!']);

    }

    public function update(Request $request){

        $request->validate([
            'id_detail_kuesioner'   => 'required',
            'soal'                  => 'required',
            'id_kuesioner'          => 'required',
            'jenis_soal'            => 'required'
        ]);

        $jawaban    = !empty($request->jawaban) ? $request->jawaban : [];
        $data       = DetailKuesioner::find($request->id_detail_kuesioner);

        $data->update([
            'soal'          => $request->soal,
            'id_kuesioner'  => $request->id_kuesioner,
            'jenis_soal'    => $request->jenis_soal,
            'jawaban'       => \serialize($jawaban) 
        ]);

        return back()->with(['sukses' => 'Data berhasil diupdate!']);
    }

    public function destroy($id){
        $data = DetailKuesioner::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data berhasil dihapus!']);
    }

    public function statistik($id){

        $data = DB::table('kuesioners')
                ->join('detail_kuesioners', 'detail_kuesioners.id_kuesioner', '=', 'kuesioners.id_kuesioner')
                ->join('jawaban_kuesioners', 'jawaban_kuesioners.id_detail_kuesioner', '=', 'detail_kuesioners.id_detail_kuesioner')
                ->join('alumnis', 'alumnis.id_alumni', '=', 'jawaban_kuesioners.id_alumni')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'alumnis.id_mahasiswa')
                ->where('detail_kuesioners.id_detail_kuesioner', $id)
                ->select('tarunas.nama_mahasiswa', 'jawaban_kuesioners.*', 'detail_kuesioners.soal')
                ->get();

        
        $soal = DB::table('detail_kuesioners')
                ->where('id_detail_kuesioner', $id)
                ->first();

        $jawaban = array();
        $label  = array();

        if($soal->jenis_soal == '1'){

            $label[] = unserialize($soal->jawaban);

            for($i=0; $i<count($label[0]); $i++){
                $jawaban[] = DB::table('jawaban_kuesioners')
                                ->where('jawaban', $label[0][$i])
                                ->count();
            }

        }elseif($soal->jenis_soal == '2'){
            //isian singkat
            //label in array
            //data in array
        }elseif($soal->jenis_soal == '3'){
            //benar salah
            $label[] = ['Ya', 'Tidak'];

            for($i=0; $i<count($label[0]); $i++){
                $jawaban[] = DB::table('jawaban_kuesioners')
                                ->where('jawaban', $label[0][$i])
                                ->count();
            }
        }else{
            //skala
            $label[] = [1,2,3,4,5];
            for($i=0; $i<count($label[0]); $i++){
                $jawaban[] = DB::table('jawaban_kuesioners')
                                ->where('jawaban', $label[0][$i])
                                ->count();
            }

        }



        return view('kuesioner.statistik')
            ->with('jawaban', $jawaban)
            ->with('label', $label)
            ->with('data', $data);
    }
}
