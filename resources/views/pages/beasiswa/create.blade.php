@extends('layout.main')
@section('title','Mahasiswa - Ajukan Beasiswa')
@section('content')
    <div class="text-center mt-3">
        <h1>Pengajuan beasiswa</h1>
        <h5>Periode {{$period->name}}</h5>
    </div>
    <div class="d-flex justify-content-center my-4">
        <form accept="{{route('ajuanBeasiswa',$period->id)}}" enctype="multipart/form-data" method="POST" class="px-5 py-4 w-50" style="border-radius: 4px;box-shadow: 0 0 20px; background-color: #f4f6f9; width:85% !important">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col">
                    <div class="form-group my-3">
                        <label for="exampleInputEmail1">Jenis beasiswa</label>
                        <select class="form-select" name="jenis_beasiswa">
                            <option value="" {{old('jenis_beasiswa') ? "" : "selected"}}>Pilih Jenis Beasiswa</option>
                            @foreach ($jenisBeasiswa as $value)
                                <option value="{{$value->id}}" {{old('jenis_beasiswa') == $value->id ? "selected" : ""}}>{{$value->name}}</option>
                            @endforeach
                        </select>
                        @error('jenis_beasiswa')
                            <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="form-group my-3">
                        <label for="exampleInputEmail1">IPK <i>example format: 4.00 || 3.85</i></label>
                        <input type="text" class="form-control" name="ipk" value="{{old('ipk')}}" placeholder="Enter IPK">
                        @error('ipk')
                        <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Dokumen transkrip akademik <i>(pdf,docx)</i></label>
                        <input class="form-control" name="transkrip_akademik" value="{{old('transkrip_akademik')}}" type="file" id="formFile">
                        @error('transkrip_akademik')
                            <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Surat rekomendasi dosen <i>(pdf,docx)</i></label>
                        <input class="form-control" name="surat_rekomendasi_dosen" value="{{old('surat_rekomendasi_dosen')}}" type="file" id="formFile">
                        @error('surat_rekomendasi_dosen')
                            <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Bukti keaktifan mahasiswa <i>(pdf,docx)</i></label>
                        <input class="form-control" name="bukti_keaktifan" value="{{old('bukti_keaktifan')}}" type="file" id="formFile">
                        @error('bukti_keaktifan')
                            <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Surat pernyataan tidak sedang menerima beasiswa dari pihak lain <i>(pdf,docx)</i></label>
                        <input class="form-control" name="surat_pernyataan_beasiswa" value="{{old('surat_pernyataan_beasiswa')}}" type="file" id="formFile">
                        @error('surat_pernyataan_beasiswa')
                            <p class="text-danger mb-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Dokumen pendukung lain (jika ada) <i>(pdf,docx)</i></label>
                <input class="form-control" name="dokumen_pendukung_lain" value="{{old('dokumen_pendukung_lain')}}" type="file" id="formFile">
                @error('dokumen_pendukung_lain')
                    <p class="text-danger mb-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="text-danger">
                CATATAN: PASTIKAN MENGISI DATA DENGAN BENAR KARENA KETIKA MELAKUKAN PERUBAHAN DATA, MAKA DATA APPROVAL DEKAN DAN PROGRAM STUDI JUGA AKAN DIRESET
            </div>
            <div class="form-group text-center mt-4 mb-0">
                <button type="submit" class="btn btn-primary w-50">Ajukan beasiswa</button>
            </div>
        </form>
    </div>
@endsection