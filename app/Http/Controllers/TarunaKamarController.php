<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kamar;
use DB;
use Exception;
use App\TarunaKamar;
use Session;
use DataTables;

class TarunaKamarController extends Controller
{
    public function index(){
        return view('tarunakamar.index');
    }

    public function kamarjson(Request $request){
        if ($request->has('q')) {
    		$cari = $request->q;
            if($cari != ''){
                $data = DB::table('kamars')
                        ->select('id_kamar', 'nama_kamar')->where('nama_kamar', 'LIKE', '%'.$cari.'%')
                        ->get();
                return response()->json($data);
            }
        }
    }

    public function kelompokkamarjson(Request $request){

        if( !$request->input('cari')){
            $data = DB::table('taruna_kamars')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'taruna_kamars.id_mahasiswa')
            ->join('kamars', 'kamars.id_kamar', '=', 'taruna_kamars.id_kamar')
            ->get();
        }else{
            $data = DB::table('taruna_kamars')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'taruna_kamars.id_mahasiswa')
            ->join('kamars', 'kamars.id_kamar', '=', 'taruna_kamars.id_kamar')
            ->where('taruna_kamars.id_kamar', $request->input('cari'))
            ->get();
        }

        return Datatables::of($data)->make(true);
    }

    public function destroy($id){
        $data   = TarunaKamar::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }

    public function create(){
        $kamar = Kamar::all();
        return view('tarunakamar.create')->with('kamar', $kamar);
    }

    public function tambahtarunajson(){

        $data = DB::table('tarunas')
            ->whereNotIn('id_mahasiswa', function($query){
                $query->select('id_mahasiswa')->from('taruna_kamars');
            })
            ->get();
        return Datatables::of($data)->make(true);
    }

    public function store(Request $request){
        $request->validate([
            'id_kamar'  => 'required',
        ]);

        for($i=0; $i<count($request->input('id_mahasiswa')); $i++){
            $total_kamar = DB::table('taruna_kamars')->where('id_kamar', $request->input('id_kamar'))->count();
            if(count($request->input('id_mahasiswa')) > $total_kamar){
                return back()->with(['gagal' => 'Data yang Diinput Melebihi Kapasitas Kamar']);
            }
            TarunaKamar::create([
                'id_kamar'      => $request->input('id_kamar'),
                'id_mahasiswa'  => $request->input('id_mahasiswa')[$i]
            ]);
        }

        return redirect('tarunakamar')->with(['sukses' => 'Data Sukses Disimpan']);
    }
}
