<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use App\Models\KategoriBeasiswa;
use App\Models\PengajuanBeasiswa;
use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BeasiswaController extends Controller
{
    public function transkripAkademikFileProcess($rawFile){
        $extension = $rawFile->getClientOriginalExtension();
        $file = auth()->user()->id . '_' . auth()->user()->name . '_' . 'transkrip-akademik' . '_' . now()->timestamp . '.' . $extension;
        $rawFile->move('asset/transkrip-akademik', $file);
        return $file;
    }

    public function suratRekomendasiDosenFileProcess($rawFile){
        $extension = $rawFile->getClientOriginalExtension();
        $file = auth()->user()->id . '_' . auth()->user()->name . '_' . 'surat-rekomendasi-dosen' . '_' . now()->timestamp . '.' . $extension;
        $rawFile->move('asset/surat-rekomendasi-dosen', $file);
        return $file;
    }

    public function buktiKeaktifanFileProcess($rawFile){
        $extension = $rawFile->getClientOriginalExtension();
        $file = auth()->user()->id . '_' . auth()->user()->name . '_' . 'bukti-keaktifan' . '_' . now()->timestamp . '.' . $extension;
        $rawFile->move('asset/bukti-keaktifan', $file);
        return $file;
    }

    public function suratPernyataanBeasiswaFileProcess($rawFile){
        $extension = $rawFile->getClientOriginalExtension();
        $file = auth()->user()->id . '_' . auth()->user()->name . '_' . 'surat-pernyataan-beasiswa' . '_' . now()->timestamp . '.' . $extension;
        $rawFile->move('asset/surat-pernyataan-beasiswa', $file);
        return $file;
    }

    public function dokumenPendukungLainFileProcess($rawFile){
        $extension = $rawFile->getClientOriginalExtension();
        $file = auth()->user()->id . '_' . auth()->user()->name . '_' . 'dokumen-pendukung-lain' . '_' . now()->timestamp . '.' . $extension;
        $rawFile->move('asset/dokumen-pendukung-lain', $file);
        return $file;
    }

    public function create(Request $request){
        $validation = $request->validate([
            'create_name' => ['required'],
        ]);
        if($validation){
            KategoriBeasiswa::insert([
                "name" => $request->create_name,
            ]); 
            return redirect()->route('listBeasiswa')->with(['status'=> 'success','message'=> 'Data beasiswa berhasil dibuat']);
        }
    }
    public function edit(Request $request, $id){
        $validation = $request->validate([
            'edit_name' => ['required'],
        ]);
        if($validation){
            $beasiswa = KategoriBeasiswa::find($id)->update([
                'name' => $request->edit_name
            ]);
            return redirect()->route('listBeasiswa')->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diedit']);
        }
    
    }
    public function delete($id){
        $beasiswa = KategoriBeasiswa::findOrFail($id);
        $beasiswa->delete();
        return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil dihapus']);
    }

    public function recreatePengajuanBeasiswa ($beasiswaId){
        PengajuanBeasiswa::where('beasiswa_id','=',$beasiswaId)->delete();

        $pengajuanBeasiswa = new PengajuanBeasiswa();
        $pengajuanBeasiswa->beasiswa_id = $beasiswaId;
        $pengajuanBeasiswa->isApprovedByDekan = false;
        $pengajuanBeasiswa->dekan_id = null;
        $pengajuanBeasiswa->dekan_notes = null;
        $pengajuanBeasiswa->isApprovedByProgramStudi = false;
        $pengajuanBeasiswa->program_studi_id = null;
        $pengajuanBeasiswa->program_studi_notes = null;
        $pengajuanBeasiswa->save();
    }

    public function createDataBeasiswa(Request $request, $periodId){
        $validation = $request->validate([
            'jenis_beasiswa' => ['required'],
            'ipk' => ['required','min:4','max:4',function (string $attribute, mixed $value, Closure $fail) use ($request){
                $getIpk = $request->ipk;
                if(!(is_numeric($getIpk[0]) && $getIpk[1]=='.' && is_numeric($getIpk[2]) && is_numeric($getIpk[3]))){
                    $fail("Format must be [number]+.+[number][number]");
                }
                if($getIpk[0] == '4'){
                    if($getIpk[2] != '0' || $getIpk[3] != '0'){
                        $fail("Max ipk value allowed is 4.00");
                    }
                };
            }],
            'transkrip_akademik' => ['required','mimes:pdf,docx','max:1024'],
            'surat_rekomendasi_dosen' => ['required','mimes:pdf,docx','max:1024'],
            'bukti_keaktifan' => ['required','mimes:pdf,docx','max:1024'],
            'surat_pernyataan_beasiswa' => ['required','mimes:docx,pdf','max:1024'],
            'dokumen_pendukung_lain' => ['nullable','mimes:docx,pdf','max:1024'],
        ]);

        if ($validation){
            $transkrip_akademik = $this->transkripAkademikFileProcess($request->file('transkrip_akademik'));
            $surat_rekomendasi_dosen = $this->suratRekomendasiDosenFileProcess($request->file('surat_rekomendasi_dosen'));
            $bukti_keaktifan = $this->buktiKeaktifanFileProcess($request->file('bukti_keaktifan'));
            $surat_pernyataan_beasiswa = $this->suratPernyataanBeasiswaFileProcess($request->file('surat_pernyataan_beasiswa'));
            $dokumen_pendukung_lain = $this->dokumenPendukungLainFileProcess($request->file('dokumen_pendukung_lain'));
            $mahasiswa = (new MahasiswaController)->getMahasiswaByUserId(auth()->user()->id); 
            $beasiswa = new Beasiswa();
            $beasiswa->mahasiswa_id = $mahasiswa->id;
            $beasiswa->period_id = $periodId;
            $beasiswa->category_id = $request->jenis_beasiswa;
            $beasiswa->ipk = $request->ipk;
            $beasiswa->transkrip_akademik = $transkrip_akademik;
            $beasiswa->surat_rekomendasi_dosen = $surat_rekomendasi_dosen;
            $beasiswa->surat_pernyataan_beasiswa = $surat_pernyataan_beasiswa;
            $beasiswa->bukti_keaktifan = $bukti_keaktifan;
            $beasiswa->dokumen_pendukung_lain = $dokumen_pendukung_lain;
            $beasiswa->save();

            $this->recreatePengajuanBeasiswa($beasiswa->id);
            
            return redirect()->route('mahasiswa/home')->with(['status'=> 'success','message'=> 'Beasiswa berhasil diajukan. silahkan dicek kembali']);
        }
    }

    public function editPengajuanBeasiswa (Request $request, $type, $beasiswaId){
        if($type == "jenisBeasiswa"){
            Beasiswa::find($beasiswaId)->update([
                'category_id' => $request->jenis_beasiswa
            ]);
            $this->recreatePengajuanBeasiswa($beasiswaId);
            return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
        }else if ($type == "ipk"){
            $validate = Validator::make($request->all(),[
                'ipk' => ['required','min:4','max:4',function (string $attribute, mixed $value, Closure $fail) use ($request){
                    $getIpk = $request->ipk;
                    if(!(is_numeric($getIpk[0]) && $getIpk[1]=='.' && is_numeric($getIpk[2]) && is_numeric($getIpk[3]))){
                        $fail("Format must be [number]+.+[number][number]");
                    }
                    if(!((int)$getIpk[0] >= 1 && (int)$getIpk <= 4)){
                        $fail("Max ipk value allowed is 4.00");
                    };
                    if($getIpk[0] == '4'){
                        if($getIpk[2] != '0' || $getIpk[3] != '0'){
                            $fail("Max ipk value allowed is 4.00");
                        }
                    };
                }],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 1)->withErrors($validate);
            }else{
                Beasiswa::find($beasiswaId)->update([
                    'ipk' => $request->ipk
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }else if($type == "transkrip-akademik"){
            $validate = Validator::make($request->all(),[
                'transkrip_akademik' => ['required','mimes:pdf,docx','max:1024'],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 2)->withErrors($validate);
            }else{
                $oldData = Beasiswa::find($beasiswaId);
                File::delete(public_path('asset/transkrip-akademik/'.$oldData->transkrip_akademik));
                $transkrip_akademik = $this->transkripAkademikFileProcess($request->file('transkrip_akademik'));
                Beasiswa::find($beasiswaId)->update([
                    'transkrip_akademik' => $transkrip_akademik
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }else if($type == "bukti-keaktifan"){
            $validate = Validator::make($request->all(),[
                'bukti_keaktifan' => ['required','mimes:pdf,docx','max:1024'],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 3)->withErrors($validate);
            }else{
                $oldData = Beasiswa::find($beasiswaId);
                File::delete(public_path('asset/bukti-keaktifan/'.$oldData->bukti_keaktifan));
                $bukti_keaktifan = $this->buktiKeaktifanFileProcess($request->file('bukti_keaktifan'));
                Beasiswa::find($beasiswaId)->update([
                    'bukti_keaktifan' => $bukti_keaktifan
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }else if($type == "surat-pernyataan-beasiswa"){
            $validate = Validator::make($request->all(),[
                'surat_pernyataan_beasiswa' => ['required','mimes:pdf,docx','max:1024'],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 4)->withErrors($validate);
            }else{
                $oldData = Beasiswa::find($beasiswaId);
                File::delete(public_path('asset/surat-pernyataan-beasiswa/'.$oldData->surat_pernyataan_beasiswa));
                $surat_pernyataan_beasiswa = $this->suratPernyataanBeasiswaFileProcess($request->file('surat_pernyataan_beasiswa'));
                Beasiswa::find($beasiswaId)->update([
                    'surat_pernyataan_beasiswa' => $surat_pernyataan_beasiswa
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }else if($type == "surat-rekomendasi-dosen"){
            $validate = Validator::make($request->all(),[
                'surat_rekomendasi_dosen' => ['required','mimes:pdf,docx','max:1024'],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 5)->withErrors($validate);
            }else{
                $oldData = Beasiswa::find($beasiswaId);
                File::delete(public_path('asset/surat-rekomendasi-dosen/'.$oldData->surat_rekomendasi_dosen));
                $surat_rekomendasi_dosen = $this->suratRekomendasiDosenFileProcess($request->file('surat_rekomendasi_dosen'));
                Beasiswa::find($beasiswaId)->update([
                    'surat_rekomendasi_dosen' => $surat_rekomendasi_dosen
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }else if($type == "dokumen-pendukung-lain"){
            $validate = Validator::make($request->all(),[
                'dokumen_pendukung_lain' => ['required','mimes:pdf,docx','max:1024'],
            ]);
            if($validate->fails()){
                return redirect()->back()->with('error_code', 6)->withErrors($validate);
            }else{
                $oldData = Beasiswa::find($beasiswaId);
                File::delete(public_path('asset/dokumen-pendukung-lain/'.$oldData->dokumen_pendukung_lain));
                $dokumen_pendukung_lain = $this->dokumenPendukungLainFileProcess($request->file('dokumen_pendukung_lain'));
                Beasiswa::find($beasiswaId)->update([
                    'dokumen_pendukung_lain' => $dokumen_pendukung_lain
                ]);
                $this->recreatePengajuanBeasiswa($beasiswaId);
                return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil diubah']);
            }
        }
    }

    public function deleteBeasiswa($beasiswaId){
        $oldData = Beasiswa::findOrFail($beasiswaId);
        File::delete(public_path('asset/dokumen-pendukung-lain/'.$oldData->dokumen_pendukung_lain));
        File::delete(public_path('asset/surat-rekomendasi-dosen/'.$oldData->surat_rekomendasi_dosen));
        File::delete(public_path('asset/surat-pernyataan-beasiswa/'.$oldData->surat_pernyataan_beasiswa));
        File::delete(public_path('asset/bukti-keaktifan/'.$oldData->bukti_keaktifan));
        File::delete(public_path('asset/transkrip-akademik/'.$oldData->transkrip_akademik));
        $oldData->delete();
        return back()->with(['status'=> 'success','message'=> 'Data beasiswa berhasil dihapus']);
    }
}
