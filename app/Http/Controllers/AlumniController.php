<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Taruna;
use App\Alumni;
use DB;

class AlumniController extends Controller
{
    public function index(){
        return view('alumni.index');
    }

    public function json(){

        // dd(Request('tahun_lulus'));

        $alumni = DB::table('alumnis')
                    ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'alumnis.id_mahasiswa')
                    ->whereYear('alumnis.tgl_lulus', '=', Request('tahun_lulus'))
                    ->get();  

                    // dd($alumni);

        return Datatables::of($alumni)->make(true);
    }

    public function create(){
        return view('alumni.create');
    }

    public function tarunajson(Request $request){
        $taruna = Taruna::where('id_prodi', $request->input('id_prodi'))
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('alumnis')
                  ->whereColumn('alumnis.id_mahasiswa', 'tarunas.id_mahasiswa');
        })
        ->get();

        return Datatables::of($taruna)->make(true);
    }

    public function store(Request $request){

        for($i=0; $i<count($request->input('id_mahasiswa')); $i++){

            Alumni::create([
                'id_mahasiswa'  => $request->input('id_mahasiswa')[$i],
                'tgl_lulus'     => $request->tgl_lulus
            ]);
        }

        return redirect('alumni')->with(['sukses' => 'Data Sukses Disimpan']);
    }

    public function delete(Request $request){

        $data = Alumni::find($request->id)->delete();

        $data = [
            'responCode'    => 1,
            'respon'        => 'Data Sukses Dihapus'
        ];

        return response()->json($data);
    }
}
