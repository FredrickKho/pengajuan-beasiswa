<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Dekan;
use App\Models\KategoriBeasiswa;
use App\Models\KategoriFakultas;
use App\Models\KategoriJurusan;
use App\Models\Mahasiswa;
use App\Models\Period;
use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function activateAccount ($id){
        $data = User::findOrFail($id);
        $activeValue = $data->isActive ? false : true;
        $data->update([
            'isActive' => $activeValue
        ]);
        return back();
    }
    public function listMahasiswa (){
        $datas = Mahasiswa::paginate(10);
        return view('pages.administrator.mahasiswa.list')->with([
            'datas' => $datas,
        ]);
    }
    public function createMahasiswa (){
        $jurusan = KategoriJurusan::all();
        return view('pages.administrator.mahasiswa.create')->with([
            'jurusan' => $jurusan,
        ]);
    }
    public function editMahasiswa ($id){
        $data = Mahasiswa::findOrFail($id);
        $jurusan = KategoriJurusan::all();
        return view('pages.administrator.mahasiswa.edit')->with([
            'data' => $data,
            'jurusan' => $jurusan,
        ]);
    }
    public function listDekan (){
        $datas = Dekan::paginate(10);
        return view('pages.administrator.dekan.list')->with([
            'datas' => $datas,
        ]);
    }
    public function createDekan (){
        $fakultas = KategoriFakultas::all();
        return view('pages.administrator.dekan.create')->with([
            'fakultas' => $fakultas,
        ]);
    }
    public function editDekan ($id){
        $data = Dekan::findOrFail($id);
        $fakultas = KategoriFakultas::all();
        return view('pages.administrator.dekan.edit')->with([
            'data' => $data,
            'fakultas' => $fakultas,
        ]);
    }
    public function listPStudi (){
        $datas = ProgramStudi::paginate(10);
        return view('pages.administrator.program_studi.list')->with([
            'datas' => $datas,
        ]);
    }
    public function createPStudi (){
        $jurusan = KategoriJurusan::all();
        return view('pages.administrator.program_studi.create')->with([
            'jurusan' => $jurusan,
        ]);
    }
    public function editPStudi ($id){
        $data = ProgramStudi::findOrFail($id);
        $jurusan = KategoriJurusan::all();
        return view('pages.administrator.program_studi.edit')->with([
            'data' => $data,
            'jurusan' => $jurusan,
        ]);
    }
        public function listFakultas (){
        $datas = KategoriFakultas::with(['dekan'])
            ->paginate(10);
        return view('pages.administrator.fakultas.list')->with([
            'datas' => $datas,
        ]);
    }

    public function listJurusan (){
        $datas = KategoriJurusan::with(['mahasiswa'])
            ->paginate(10);
        return view('pages.administrator.jurusan.list')->with([
            'datas' => $datas,
        ]);
    }
    public function listBeasiswa (){
        $datas = KategoriBeasiswa::with((['beasiswa']))
            ->paginate(10);
        return view('pages.administrator.beasiswa.list')->with([
            'datas' => $datas,
        ]);
    }

    public function listPengajuanBeasiswa (Request $request){
        $periods = Period::all();
        if($request->period){
            $currentPeriod = Period::findOrFail($request->period);
        } else{
            $currentPeriod = $periods[0];
        }

        $dataBeasiswa = Beasiswa::whereHas('pengajuanBeasiswa',function($x){
            return $x->where('isFinalized','=',false);
        })
        ->where('period_id','=',$currentPeriod->id)
        ->paginate(10);

        return view('pages.administrator.pengajuan-beasiswa.list')->with([
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'dataBeasiswa' => $dataBeasiswa,
        ]);
    }

    public function listFinalisasi (Request $request){
        $periods = Period::all();
        if($request->period){
            $currentPeriod = Period::findOrFail($request->period);
        } else{
            $currentPeriod = $periods[0];
        }

        $dataBeasiswa = Beasiswa::whereHas('pengajuanBeasiswa',function($x){
            return $x->where('isFinalized','=',true);
        })
        ->where('period_id','=',$currentPeriod->id)
        ->paginate(10);
        return view('pages.administrator.finalisasi.list')->with([
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'dataBeasiswa' => $dataBeasiswa,
        ]);
    }

}
