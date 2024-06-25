<?php

namespace App\Http\Controllers;

use App\Models\KategoriJurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function create(Request $request){
        $validation = $request->validate([
            'create_name' => ['required'],
        ]);
        if($validation){
            KategoriJurusan::insert([
                "name" => $request->create_name,
            ]); 
            return redirect()->route('listJurusan')->with(['status'=> 'success','message'=> 'Data jurusan berhasil dibuat']);
        }
    }
    public function edit(Request $request, $id){
        $validation = $request->validate([
            'edit_name' => ['required'],
        ]);
        if($validation){
            $jurusan = KategoriJurusan::find($id)->update([
                'name' => $request->edit_name
            ]);
            return redirect()->route('listJurusan')->with(['status'=> 'success','message'=> 'Data jurusan berhasil diedit']);
        }
    
    }
    public function delete($id){
        $jurusan = KategoriJurusan::findOrFail($id);
        $jurusan->delete();
        return back()->with(['status'=> 'success','message'=> 'Data jurusan berhasil dihapus']);;
    }
}
