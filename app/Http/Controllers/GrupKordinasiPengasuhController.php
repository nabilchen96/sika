<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GrupKordinasiPengasuh;
use DB;

class GrupKordinasiPengasuhController extends Controller
{
    public function index(){

        $data = DB::table('grup_kordinasi_pengasuhs')
                ->join('kordinator_pengasuhs', 'kordinator_pengasuhs.id_kordinator_pengasuh', '=', 'grup_kordinasi_pengasuhs.id_kordinator_pengasuh',)
                ->join('users', 'users.id', '=', 'kordinator_pengasuhs.id')
                ->join('users as users2', 'users2.id', '=', 'grup_kordinasi_pengasuhs.id')
                ->select(
                    'users.name as kordinator_pengasuh',
                    'users.nip as nip_kordinator',
                    'users2.name as pengasuh',
                    'users2.nip as nip_pengasuh',
                    'grup_kordinasi_pengasuhs.id_grup_kordinasi_pengasuh'
                )
                ->get();

        $pengasuh = DB::table('users')->where('role', 'pengasuh')
                    ->whereNotIn('id', function($query){
                        $query->select('id')->from('kordinator_pengasuhs');
                    })
                    ->whereNotIn('id', function($query){
                        $query->select('id')->from('grup_kordinasi_pengasuhs');
                    })
                    ->get();
        
        $kordinator = DB::table('kordinator_pengasuhs')
                        ->join('users', 'users.id', '=', 'kordinator_pengasuhs.id')
                        ->get();

        return view('grupkordinasipengasuh.index')
            ->with('kordinator', $kordinator)
            ->with('pengasuh', $pengasuh)
            ->with('data', $data);
    }

    public function store(Request $request){


        for ($i=0; $i < count($request->id); $i++) { 
            GrupKordinasiPengasuh::create([
                'id_kordinator_pengasuh' => $request->id_kordinator_pengasuh,
                'id'                     => $request->id[$i]
            ]);
        }

        return back()->with(['sukses' => 'Data berhasil disimpan!']);
    }

    public function destroy($id){

        $data = GrupKordinasiPengasuh::find($id);
        $data->delete();


        return back()->with(['sukses' => 'Data berhasil dihapus!']);

    }
}
