<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\Dekan;
use App\Models\PengajuanBeasiswa;
use App\Models\Period;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DekanController extends Controller
{

    public function listPeriod (){
        $datas = Period::with(['beasiswa'])
        ->paginate(10);
        return view('pages.dekan.period.list')->with([
            'datas' => $datas,
        ]);
    }
    public function createPeriod (){
        return view('pages.dekan.period.create');
    }
    public function editPeriod ($id){
        $data = Period::findOrFail($id);
        return view('pages.dekan.period.edit')->with([
            'data' => $data,
        ]);
    }

    public function index (Request $request){
        return redirect()->route('dekan/review');
    }
    public function getDekanByUserId($userId){
        return Dekan::where('user_id','=',$userId)->first();
    }
    public function reviewPage (Request $request){
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

        // $dataBeasiswa = Beasiswa::where('period_id','=',$currentPeriod->id)->paginate(10);
        return view('pages.dekan.main')->with([
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'dataBeasiswa' => $dataBeasiswa,
        ]);
    }

    public function finalizePage (Request $request){
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

        return view('pages.dekan.finalisasi')->with([
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'dataBeasiswa' => $dataBeasiswa,
        ]);
    }

    public function create(Request $request){
        $validation = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::user()->id],
            'phone_number' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required'],
            'password' => ['required','min:8'],
            'fakultas' => ['required'],
            'status' => ['required'],
        ]);

        if ($validation) {
            $user = new User();
            $user->role_id = 2;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->gender = $request->gender;
            $user->password = Hash::make($request->password);
            $user->isActive = true;
            $user->save();

            $dekan = new Dekan();
            $dekan->user_id = $user->id;
            $dekan->fakultas_id = $request->fakultas;
            $dekan->status = $request->status;
            $dekan->save();

            return redirect()->route('listDekan')->with(['status' => 'success', 'title' => 'Daftar Akun Dekan','message' => 'Pendaftaran akun dekan berhasil']);
        }
    }

    public function edit(Request $request,$id){
        $thisAccount = Dekan::findOrFail($id);
        $validation = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . $thisAccount->user_id],
            'phone_number' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required'],
            'password' => ['required','min:8'],
            'fakultas' => ['required'],
            'status' => ['required'],
        ]);
    
        if ($validation) {
            $dekan = Dekan::find($id)->update([
                'fakultas_id' => $request->fakultas,
                'status' => $request->status,
            ]);
            $user = User::find($thisAccount->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('listDekan')->with(['status' => 'success', 'title' => 'Edit Akun Dekan','message' => 'Akun dekan berhasil diubah']);
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('listDekan')->with(['status' => 'success', 'title' => 'Delete Akun Dekan','message' => 'Akun dekan berhasil dihapus']);
    }

    public function reviewBeasiswa(Request $request, $beasiswaId){
        $dekan = $this->getDekanByUserId(auth()->user()->id);
        if($request->review == "Accept"){
            $isApproved = true;
        }else{
            $isApproved = false;
        }
        PengajuanBeasiswa::where('beasiswa_id','=',$beasiswaId)->update([
            'isApprovedByDekan' => $isApproved,
            'dekan_id' => $dekan->id,
            'dekan_update_at' => Carbon::now(),
            'dekan_notes' => $request->note
        ]);
        return redirect()->back()->with(['status' => 'success', 'title' => 'Review Beasiswa','message' => 'Data beasiswa berhasil direview']);
    }

    public function finalize($beasiswaId){
        $data = PengajuanBeasiswa::where('beasiswa_id','=',$beasiswaId)->first()->update([
            'isFinalized' => true
        ]);
        return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil difinalisasi']);
    }

}
