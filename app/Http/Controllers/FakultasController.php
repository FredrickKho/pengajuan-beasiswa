<?php

namespace App\Http\Controllers;

use App\Models\KategoriFakultas;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    public function create(Request $request){
        $validation = $request->validate([
            'create_name' => ['required'],
        ]);
        if($validation){
            KategoriFakultas::insert([
                "name" => $request->create_name,
            ]); 
            return redirect()->route('listFakultas')->with(['status'=> 'success','message'=> 'Data fakultas berhasil dibuat']);
        }
    }

    public function edit(Request $request, $id){
        $validation = $request->validate([
            'edit_name' => ['required'],
        ]);
        if($validation){
            $fakultas = KategoriFakultas::find($id)->update([
                'name' => $request->edit_name
            ]);
            return redirect()->route('listFakultas')->with(['status'=> 'success','message'=> 'Data fakultas berhasil diedit']);
        }
    
    }
    public function delete($id){
        $fakultas = KategoriFakultas::findOrFail($id);
        $fakultas->delete();
        return back()->with(['status'=> 'success','message'=> 'Data fakultas berhasil dihapus']);;
    }
}
