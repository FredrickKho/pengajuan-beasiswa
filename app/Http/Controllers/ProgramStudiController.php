<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\PengajuanBeasiswa;
use App\Models\Period;
use App\Models\ProgramStudi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ProgramStudiController extends Controller
{
    public function index (Request $request){
        return redirect()->route('program-studi/review');
    }
    public function getProgramStudiByUserId($userId){
        return ProgramStudi::where('user_id','=',$userId)->first();
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
        return view('pages.program_studi.main')->with([
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

        return view('pages.program_studi.finalisasi')->with([
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
            'jurusan' => ['required'],
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

            $dekan = new ProgramStudi();
            $dekan->user_id = $user->id;
            $dekan->program_studi_id = $request->jurusan;
            $dekan->save();

            return redirect()->route('listPStudi')->with(['status' => 'success', 'title' => 'Daftar Akun Program Studi','message' => 'Pendaftaran akun program studi berhasil']);
        }
    }

    public function edit(Request $request,$id){
        $thisAccount = ProgramStudi::findOrFail($id);
        $validation = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . $thisAccount->user_id],
            'phone_number' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required'],
            'password' => ['required','min:8'],
            'jurusan' => ['required'],
        ]);
    
        if ($validation) {
            $dekan = ProgramStudi::find($id)->update([
                'program_studi_id' => $request->jurusan,
            ]);
            $user = User::find($thisAccount->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('listPStudi')->with(['status' => 'success', 'title' => 'Edit Akun Program Studi','message' => 'Akun program studi berhasil diubah']);
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('listPStudi')->with(['status' => 'success', 'title' => 'Delete Akun Program Studi','message' => 'Akun program studi berhasil dihapus']);
    }

    public function reviewBeasiswa(Request $request, $beasiswaId){
        $dekan = $this->getProgramStudiByUserId(auth()->user()->id);
        if($request->review == "Accept"){
            $isApproved = true;
        }else{
            $isApproved = false;
        }
        PengajuanBeasiswa::where('beasiswa_id','=',$beasiswaId)->update([
            'isApprovedByProgramStudi' => $isApproved,
            'program_studi_id' => $dekan->id,
            'program_studi_update_at' => Carbon::now(),
            'program_studi_notes' => $request->note,
            'isApprovedByDekan' => null,
            'dekan_id' => null,
            'dekan_update_at' => null,
            'dekan_notes' => null
        ]);
        return redirect()->back()->with(['status' => 'success', 'title' => 'Review Beasiswa','message' => 'Data beasiswa berhasil direview']);
    }

}
