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
use App\Exports\AsuhanExport;
use Maatwebsite\Excel\Facades\Excel;

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
                $kordinator = DB::table('kordinator_pengasuhs')->where('id', auth::user()->id)->first();

                // if($kordinator){
                //     //jika dia adalah kordinator pengasuh maka tampilkan semua taruna yang diasuh oleh semua pengasuh di bawahnya
                //     $grup_kordinasi = DB::table('grup_kordinasi_pengasuhs')->where('id_kordinator_pengasuh', $kordinator->id_kordinator_pengasuh)->get();

                //     $data= DB::table('asuhans')
                //         ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                //         ->leftjoin('users', 'users.id', '=', 'asuhans.id_pengasuh')
                //         ->where(function($q) use ($grup_kordinasi) {

                //             foreach($grup_kordinasi  as $k) {
                //                 $q->orWhere('asuhans.id_pengasuh', $k->id);
                //             }

                //         })->get();

                // }else{
                //     //jika dia bukan kordinator pengasuh maka tampilkan hanya taruna yang diasuhnya saja
                //     $data = DB::table('asuhans')
                //             ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                //             ->leftjoin('users', 'users.id', '=', 'asuhans.id_pengasuh')
                //             ->where('asuhans.id_pengasuh', Auth::id())            
                //             ->get();
                // }

                $data = DB::table('asuhans')
                            ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                            ->leftjoin('users', 'users.id', '=', 'asuhans.id_pengasuh')
                            ->where('asuhans.id_pengasuh', Auth::id())            
                            ->get();

            }elseif(Auth::user()->role == 'admin' or auth::user()->role == 'pusbangkar'){

                $data = DB::table('asuhans')
                        ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
                        ->leftjoin('users', 'users.id', '=', 'asuhans.id_pengasuh')         
                        ->get();
            }

        }else{
            $data = DB::table('asuhans')
            ->leftjoin('tarunas', 'tarunas.id_mahasiswa', '=', 'asuhans.id_mahasiswa')
            ->leftjoin('users', 'users.id', '=', 'asuhans.id_pengasuh')  
            ->where('id_pengasuh', $request->input('cari'))
            ->get();
        }
        return Datatables::of($data)->make(true);
    }

    public function create(){
        $data = DB::table('users')
                ->leftjoin('kordinator_pengasuhs', 'kordinator_pengasuhs.id', '=', 'users.id')
                ->where('role', 'pengasuh')
                // ->whereNotIn('users.id', function($query){
                //     $query->select('id')->from('kordinator_pengasuhs');
                // })
                ->select(
                    'users.*'
                )
                ->get();

        $taruna = DB::table('tarunas')
            ->whereNotIn('id_mahasiswa', function($query){
                $query->select('id_mahasiswa')->from('asuhans');
            })
            ->get();

        return view('asuhan.create')->with('data', $data)->with('taruna', $taruna);
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


        if($request->id_mahasiswa){
            for($i=0; $i<count($request->input('id_mahasiswa')); $i++){
                Asuhan::create([
                    'id_pengasuh'   => $request->input('id_pengasuh'),
                    'id_mahasiswa'  => $request->input('id_mahasiswa')[$i]
                ]);
            }
        }else{
            return back()->with(['gagal' => 'pilih minimal satu data taruna']);
        }

        return redirect('tarunapengasuh')->with(['sukses' => 'Data Sukses Disimpan']);
    }

    public function destroy($id){
        $data   = Asuhan::find($id);
        $data->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus']);
    }

    public function export(){
        return Excel::download(new AsuhanExport, 'Taruna Pengasuh.xlsx');
    }
}
