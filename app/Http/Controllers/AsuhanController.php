<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pengasuh;
use DataTables;
use App\Asuhan;
use App\Taruna;
use DB;
use Auth;

class AsuhanController extends Controller
{
    public function index(){
        return view('asuhan.index');
    }

    public function pengasuh(Request $request)
    {
        if ($request->has('q')) {
    		$cari = $request->q;
            if($cari != ''){
                if(auth::user()->role == 'admin'){
                    $data = DB::table('users')
                    ->where('role', 'pengasuh')
                    ->select('id', 'name')->where('name', 'LIKE', '%'.$cari.'%')
                    ->get();
                }else{
                    $data = null;
                }
                return response()->json($data);
            }
        }
    }

    public function kelompoktaruna(Request $request){

        if( !$request->input('cari') ){
            if(Auth::user()->role == 'pengasuh'){

                $data = DB::table('asuhans')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')
                ->where('asuhans.id_pengasuh', Auth::id())            
                ->get();

            }elseif(Auth::user()->role == 'admin' or auth::user()->role == 'pusbangkar'){

                $data = DB::table('asuhans')
                ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')         
                ->get();
            }

        }else{
            $data = DB::table('asuhans')
            ->join('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
            ->join('users', 'users.id', '=', 'asuhans.id_pengasuh')  
            ->where('id_pengasuh', $request->input('cari'))
            ->get();
        }
        return Datatables::of($data)->make(true);
    }

    public function create(){
        $data = User::where('role', 'pengasuh')->get();
        return view('asuhan.create')->with('data', $data);
    }

    public function tambahtarunajson(){

        $data = DB::table('tarunas')
            ->whereNotIn('id_mahasiswa', function($query){
                $query->select('id_mahasiswa')->from('asuhans');
            })
            ->get();
        return Datatables::of($data)->make(true);
    }

    public function store(Request $request){
        $request->input([
            'id_pengasuh'  => 'required',
        ]);

        for($i=0; $i<count($request->input('id_mahasiswa')); $i++){
            Asuhan::create([
                'id_pengasuh'   => $request->input('id_pengasuh'),
                'id_mahasiswa'  => $request->input('id_mahasiswa')[$i]
            ]);
        }

        return redirect('tarunapengasuh')->with(['sukses' => 'Data Sukses Disimpan']);
    }

    public function destroy($id){
        $data   = Asuhan::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }
}
