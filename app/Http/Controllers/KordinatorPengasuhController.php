<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\KordinatorPengasuh;

class KordinatorPengasuhController extends Controller
{
    public function index(){
        $data = DB::table('kordinator_pengasuhs')
                ->join('users', 'users.id', '=', 'kordinator_pengasuhs.id')
                ->get();

                // dd($data);

        $pengasuh = DB::table('users')
                    ->where('role', 'pengasuh')
                    ->whereNotIn('id', function($query){
                        $query->select('id')->from('kordinator_pengasuhs');
                    })
                    ->get();

        return view('kordinatorpengasuh.index')
            ->with('data', $data)
            ->with('pengasuh', $pengasuh);
    }

    public function store(Request $request){


        foreach($request->id as $i){
            KordinatorPengasuh::create([
                'id' => $i
            ]);
        }

        // DB::table('kordinator_pengasuhs')->insert([$request->id]);
        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function destroy($id){

        $data = KordinatorPengasuh::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }
}
