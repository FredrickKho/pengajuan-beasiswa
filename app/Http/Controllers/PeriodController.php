<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function upsert($data){
        if($data->id == null){
            $result = Period::create([
                'name' => $data->period_name,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date
            ]);
        } else {
            $result = Period::find($data->id)->update([
                'name' => $data->period_name,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date
            ]);
        }
        return $result;
    }
    public function create(Request $request){
        $validation = $request->validate([
            'period_name' => ['required','unique:period,name'],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ],[
            'period_name.unique' => '"'.$request->period_name.'" period telah ada',
        ]);
        if($validation){
            $this->upsert($request);
            return redirect()->route('listPeriod')->with(['status'=> 'success','message'=> 'Data period berhasil dibuat']);
        }
    }

    public function edit(Request $request, $id){
        $oldData = Period::find($id);
        $validation = $request->validate([
            'period_name' => ['required','unique:period,name,'.$id],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ],[
            'period_name.unique' => '"'.$request->period_name.'" period sudah ada',
        ]);
        if($validation){
            $request->merge(['id' => $id]);  
            $this->upsert($request);
            return redirect()->route('listPeriod')->with(['status'=> 'success','message'=> 'Data period berhasil diubah']);
        }
    }
    public function delete($id){
        $period = Period::findOrFail($id);
        $period->delete();
        return back()->with(['status'=> 'success','message'=> 'Data period berhasil dihapus']);;
    }


}
