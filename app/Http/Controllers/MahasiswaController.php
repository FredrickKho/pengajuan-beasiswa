<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\KategoriBeasiswa;
use App\Models\Mahasiswa;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function getMahasiswaByUserId($userId){
        return Mahasiswa::where('user_id','=',$userId)->first();
    }

    public function index (Request $request){
        $periods = Period::all();
        if($request->period){
            $currentPeriod = Period::findOrFail($request->period);
        } else{
            $currentPeriod = $periods[0];
        }
        $dataBeasiswa = Beasiswa::with(['pengajuanBeasiswa'])
        ->where('mahasiswa_id','=',$this->getMahasiswaByUserId(auth()->user()->id)->id)
        ->where('period_id', '=', $currentPeriod->id)
        ->first();

        $jenisBeasiswa = KategoriBeasiswa::all();
        return view('pages.mahasiswa.main')->with([
            'periods' => $periods,
            'currentPeriod' => $currentPeriod,
            'dataBeasiswa' => $dataBeasiswa,
            'jenisBeasiswa' => $jenisBeasiswa,
        ]);
    }

    public function beasiswa ($periodId){
        $period = Period::findOrFail($periodId);
        $jenisBeasiswa = KategoriBeasiswa::all();
        return view('pages.beasiswa.create')->with([
            'period' => $period,
            'jenisBeasiswa' => $jenisBeasiswa,
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

            $mahasiswa = new Mahasiswa();
            $mahasiswa->user_id = $user->id;
            $mahasiswa->jurusan_id = $request->jurusan;
            $mahasiswa->save();

            return redirect()->route('listMahasiswa')->with(['status' => 'success', 'title' => 'Daftar Akun Mahasiswa','message' => 'Pendaftaran akun mahasiswa berhasil']);
        }
    }

    public function edit(Request $request,$id){
        $thisAccount = Mahasiswa::findOrFail($id);
        $validation = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email,' . $thisAccount->user_id],
            'phone_number' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required'],
            'password' => ['required','min:8'],
            'jurusan' => ['required'],
        ]);

        if ($validation) {
            $mahasiswa = Mahasiswa::find($id)->update([
                'jurusan_id' => $request->jurusan,
            ]);
            $user = User::find($thisAccount->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('listMahasiswa')->with(['status' => 'success', 'title' => 'Edit Akun Mahasiswa','message' => 'Akun mahasiswa berhasil diubah']);
        }
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('listMahasiswa')->with(['status' => 'success', 'title' => 'Delete Akun Mahasiswa','message' => 'Akun mahasiswa berhasil dihapus']);
    }

}
