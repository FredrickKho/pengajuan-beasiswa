@extends('layout.main')
@section('title','Mahasiswa - Mahasiswa')
@section('content')
    @if (auth()->user()->isActive)
        @if ($periods)
            <div class="d-flex flex-row align-items-center">
                <h6 class="me-3" style="white-space:nowrap">Select Period</h6>
                <div class="w-100">
                    <form class="form-horizontal mt-2" periodChange() action="{{ route('mahasiswa/home') }}" method="GET" enctype="multipart/form-data">
                        <div class="form-row justify-content-between">
                            <div class="col-sm-4 mb-3">
                                <div class="form-label-group in-border mb-1">
                                    <select id="period" onchange="periodChange()" class="form-control form-control-mb select2" style="width: 100%;"
                                        name="period">
                                        @foreach ($periods as $period)
                                            <option value={{ $period->id }} {{ $currentPeriod->id == $period->id ? 'selected' : '' }}>
                                                {{ $period->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="w-25">
                    @if (!$dataBeasiswa==null)
                        @if(!$dataBeasiswa->pengajuanBeasiswa->isFinalized)
                        <a data-bs-toggle="modal" data-bs-target="#deleteBeasiswa" style="float:right" class="btn btn-primary me-5">Delete Beasiswa</a>
                            <!-- Modal Jenis IPK-->
                            <div class="modal fade" id="deleteBeasiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Beasiswa</h5>
                                        </div>
                                        <form action="{{route('deleteBeasiswa',$dataBeasiswa->id)}}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                <div class="form-group my-3">
                                                    <label for="exampleInputEmail1">Apakah anda ingin menghapus data beasiswa untuk periode ini?</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            @if (Session::has('status') == 'success')
                <div class="alert alert-success" id="success-alert" role="alert">
                    <i type="button" id="close-alert" class="fa fa-close" style=""></i>
                    {{ Session::get('message') }}
                </div>
                <script>
                    $(document).ready(function() {
                        $("#close-alert").click(function () {
                            $("#success-alert").remove();
                        });
                    });
                </script>
            @endif  
            @if ($dataBeasiswa==null)
                <div class="h-75 d-flex flex-column text-center justify-content-center">
                    <div class="">
                        <h2>Anda belum pernah mengajukan beasiswa pada periode "{{$currentPeriod->name}}"</h2>
                        <a href="{{route('ajuanBeasiswa',$currentPeriod->id)}}" class="btn btn-primary my-4">Ajukan Beasiswa Untuk Periode "{{$currentPeriod->name}}"</a>
                    </div>
                </div>
            @else
                @if($dataBeasiswa->pengajuanBeasiswa->isFinalized)
                    <div class="alert alert-success" id="success-alert" role="alert">
                        Selamat, pengajuan beasiswa untuk periode "{{$currentPeriod->name}}" telah diterima
                    </div>
                @endif
                <div class="container">
                    <div class="m-4 d-flex flex-column" style="border-radius: 4px;box-shadow: 0 0 20px; background-color: #f4f6f9a0;">
                        <h1 class="text-center">Data pengajuan beasiswa</h1>
                        <div class="p-2 mx-3 mt-3 mb-1 d-flex flex-column border border-2 border-black">
                            <div class="row">
                                <div class="col">
                                    <strong>Period : {{$dataBeasiswa->period->name}}</strong>
                                </div>
                                <div class="col">
                                    <strong>
                                        Jenis Beasiswa : {{$dataBeasiswa->category->name}}
                                        <a data-bs-toggle="modal" data-bs-target="#jenisBeasiswa" href="" class="text-decoration-none text-black fa fa-edit"></a>
                                    </strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <strong>Tanggal Pengajuan : {{$dataBeasiswa->created_at->format('j F, Y')}}</strong>
                                </div>
                                <div class="col">
                                    <strong>
                                        Nilai IPK : {{$dataBeasiswa->ipk}}
                                        <a href="" data-bs-toggle="modal" data-bs-target="#ipk" class="text-decoration-none text-black fa fa-edit"></a>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 mx-3 mb-2 border border-2 border-black">
                            <div class="row mb-2">
                                <div class="col">
                                    <strong>
                                        Transkrip Akademik : 
                                        <a target="blank" href="{{asset('asset/transkrip-akademik/'.$dataBeasiswa->transkrip_akademik)}}">
                                            Klik untuk melihat data
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#transkrip-akademik" href="" class="text-decoration-none text-black fa fa-edit"></a>                                            
                                    </strong>
                                </div>
                                <div class="col">
                                    <strong>
                                        Surat Rekomendasi Dosen : 
                                        <a target="blank" href="{{asset('asset/surat-rekomendasi-dosen/'.$dataBeasiswa->surat_rekomendasi_dosen)}}">
                                            Klik untuk melihat data
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#surat-rekomendasi-dosen" href="" class="text-decoration-none text-black fa fa-edit"></a>                                            
                                    </strong>                                
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <strong>
                                        Bukti keaktifan Mahasiswa : 
                                        <a target="blank" href="{{asset('asset/bukti-keaktifan/'.$dataBeasiswa->bukti_keaktifan)}}">
                                            Klik untuk melihat data
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#bukti-keaktifan" href="" class="text-decoration-none text-black fa fa-edit"></a>                                            
                                    </strong>
                                </div>
                                <div class="col">
                                    <strong>
                                        Dokumen pendukung lainnya : 
                                        <a target="blank" href="{{asset('asset/dokumen-pendukung-lain/'.$dataBeasiswa->dokumen_pendukung_lain)}}">
                                            Klik untuk melihat data
                                        </a>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#dokumen-pendukung-lain" class="text-decoration-none text-black fa fa-edit"></a>                                            
                                    </strong>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <strong>
                                        Surat pernyataan tidak sedang menerima beasiswa dari pihak lain : 
                                        <a target="blank" href="{{asset('asset/surat-pernyataan-beasiswa/'.$dataBeasiswa->surat_pernyataan_beasiswa)}}">
                                            Klik untuk melihat data
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#surat-pernyataan-beasiswa" href="" class="text-decoration-none text-black fa fa-edit"></a>                                            
                                    </strong>                                
                                </div>
                            </div>
                        </div>
                        <h1 class="text-center">Data Approval Fakultas dan Program Studi</h1>
                        <div class="p-2 mx-3 mt-3 mb-1 d-flex flex-column border border-2 border-black">
                            <div class="row">
                                <div class="col">
                                    <strong>Nama pengguna fakultas : {{$dataBeasiswa->pengajuanBeasiswa->dekan ? $dataBeasiswa->pengajuanBeasiswa->dekan->user->name : "Belum dicheck oleh fakultas" }} </strong>
                                </div>
                                <div class="col">
                                    <strong>Nama pengguna program studi : {{$dataBeasiswa->pengajuanBeasiswa->programStudi ? $dataBeasiswa->pengajuanBeasiswa->programStudi->user->name : "Belum dicheck oleh program studi" }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <strong>Tanggal update status : {{$dataBeasiswa->pengajuanBeasiswa->dekan ? date('j F, Y h:i:s A', strtotime($dataBeasiswa->pengajuanBeasiswa->dekan_update_at)) : "-" }} </strong>
                                </div>
                                <div class="col">
                                    <strong>Tanggal update status : {{$dataBeasiswa->pengajuanBeasiswa->programStudi ? date('j F, Y h:i:s A', strtotime($dataBeasiswa->pengajuanBeasiswa->program_studi_update_at)) : "-" }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    @php
                                        $color = "";
                                        $text = "";
                                        if($dataBeasiswa->pengajuanBeasiswa->dekan){
                                            if($dataBeasiswa->pengajuanBeasiswa->isApprovedByDekan){
                                                $color = "text-success";
                                                $text = "Approved";
                                                if ($dataBeasiswa->pengajuanBeasiswa->isApprovedByDekan && $dataBeasiswa->pengajuanBeasiswa->isApprovedByProgramStudi && !$dataBeasiswa->pengajuanBeasiswa->isFinalized) {
                                                    $text = $text." (Menunggu finalisasi oleh dekan)";
                                                }
                                            }else {
                                                $color = "text-danger";
                                                $text = "Not Approved";
                                            }
                                        }else {
                                            $text = "-";
                                        }
                                    @endphp
                                    <strong>Status approval : <span class="{{$color}}">{{$text}}</span></strong>
                                </div>
                                <div class="col">
                                    @php
                                        $color = "";
                                        $text = "";
                                        if($dataBeasiswa->pengajuanBeasiswa->programStudi){
                                            if($dataBeasiswa->pengajuanBeasiswa->isApprovedByProgramStudi){
                                                $color = "text-success";
                                                $text = "Approved";
                                                if ($dataBeasiswa->pengajuanBeasiswa->isApprovedByDekan && $dataBeasiswa->pengajuanBeasiswa->isApprovedByProgramStudi && !$dataBeasiswa->pengajuanBeasiswa->isFinalized) {
                                                    $text = $text." (Menunggu finalisasi oleh dekan)";
                                                }
                                            }else{
                                                $color = "text-danger";
                                                $text = "Not Approved";
                                            }
                                        }else {
                                            $text = "-";
                                        }
                                    @endphp
                                    <strong>Status approval : <span class="{{$color}}">{{$text}}</span></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <strong>Catatan dari fakultas : </strong>
                                    <br>
                                    <textarea class="w-100 px-2 text-black mt-2" disabled cols="10" rows="5" style="resize: none">{{$dataBeasiswa->pengajuanBeasiswa->dekan_notes}}</textarea>
                                </div>
                                <div class="col">
                                    <strong>Catatan dari program studi : </strong>
                                    <br>
                                    <textarea class="w-100 mt-2 px-2 text-black" disabled cols="10" rows="5" style="resize: none">{{$dataBeasiswa->pengajuanBeasiswa->program_studi_notes}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Jenis Beasiswa-->
                <div class="modal fade" id="jenisBeasiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Jenis Beasiswa</h5>
                            </div>
                            <form action="{{route('editPengajuanBeasiswa',['jenisBeasiswa',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label class="mb-2" for="exampleInputEmail1">Jenis beasiswa</label>
                                        <select class="form-select" name="jenis_beasiswa">
                                            @foreach ($jenisBeasiswa as $value)
                                                <option value="{{$value->id}}" {{$dataBeasiswa->category_id == $value->id ? "selected" : ""}}>{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_beasiswa')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Jenis IPK-->
                <div class="modal fade" id="ipk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit ipk</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['ipk',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="exampleInputEmail1">IPK <i>example format: 4.00 || 3.85</i></label>
                                        <input type="text"  class="form-control" name="ipk" placeholder="Enter IPK">
                                        @error('ipk')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal Transkrip Akademik-->
                <div class="modal fade" id="transkrip-akademik" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit transkrip akademik</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['transkrip-akademik',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">Dokumen transkrip akademik <i>(pdf)</i></label>
                                        <input class="form-control" name="transkrip_akademik" value="{{old('transkrip_akademik')}}" type="file" id="formFile">
                                        @error('transkrip_akademik')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Bukti Keaktifan Mahasiswa-->
                <div class="modal fade" id="bukti-keaktifan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit bukti keaktifan mahasiswa</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['bukti-keaktifan',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">Bukti keaktifan mahasiswa <i>(pdf)</i></label>
                                        <input class="form-control" name="bukti_keaktifan" value="{{old('bukti_keaktifan')}}" type="file" id="formFile">
                                        @error('bukti_keaktifan')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Surat Pernyataan-->
                <div class="modal fade" id="surat-pernyataan-beasiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit surat pernyataan beasiswa</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['surat-pernyataan-beasiswa',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">Surat pernyataan tidak sedang menerima beasiswa dari pihak lain <i>(pdf)</i></label>
                                        <input class="form-control" name="surat_pernyataan_beasiswa" value="{{old('surat_pernyataan_beasiswa')}}" type="file" id="formFile">
                                        @error('surat_pernyataan_beasiswa')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal rekomendasi dosen-->
                <div class="modal fade" id="surat-rekomendasi-dosen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit surat rekomendasi dosen</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['surat-rekomendasi-dosen',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">Surat rekomendasi dosen <i>(pdf)</i></label>
                                        <input class="form-control" name="surat_rekomendasi_dosen" value="{{old('surat_rekomendasi_dosen')}}" type="file" id="formFile">
                                        @error('surat_rekomendasi_dosen')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal dokumen pendukung lain-->
                <div class="modal fade" id="dokumen-pendukung-lain" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit dokumen pendukung lain</h5>
                            </div>
                            <form id="editForm" action="{{route('editPengajuanBeasiswa',['dokumen-pendukung-lain',$dataBeasiswa->id])}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group my-3">
                                        <label for="formFile" class="form-label">Dokumen pendukung lain (jika ada) <i>(pdf)</i></label>
                                        <input class="form-control" name="dokumen_pendukung_lain" value="{{old('dokumen_pendukung_lain')}}" type="file" id="formFile">
                                        @error('dokumen_pendukung_lain')
                                            <p class="text-danger mb-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="text-danger">
                                        CATATAN: MELAKUKAN PERUBAHAN DATA AKAN MENGRESET DATA APPROVAL DEKAN DAN PROGRAM STUDI
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <script type="text/javascript">
                function periodChange() {
                    let queryString = window.location.search;
                    let params = new URLSearchParams(queryString);
                    params.delete('period');
                    params.append('period', document.getElementById("period").value);
                    document.location.href = "?" + params.toString();
                }
            </script>

            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 1)
                <script>
                    $(function() {
                        $('#ipk').modal('show');
                    });
                </script>
            @endif
            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 2)
                <script>
                    $(function() {
                        $('#transkrip-akademik').modal('show');
                    });
                </script>
            @endif
            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 3)
                <script>
                    $(function() {
                        $('#bukti-keaktifan').modal('show');
                    });
                </script>
            @endif
            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 4)
                <script>
                    $(function() {
                        $('#surat-pernyataan-beasiswa').modal('show');
                    });
                </script>
            @endif
            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 5)
                <script>
                    $(function() {
                        $('#surat-rekomendasi-dosen').modal('show');
                    });
                </script>
            @endif
            @if(!empty(Session::get('error_code')) && Session::get('error_code') == 6)
            <script>
                $(function() {
                    $('#dokumen-pendukung-lain').modal('show');
                });
            </script>
        @endif
        @else
            @include('layout.inactive',[
                'messageTitle' => 'Data period tidak ada',
                'messageBody' => 'Silahkan hubungi administrator untuk menambahkan data period.'
            ])
        @endif
    @else
        @include('layout.inactive',[
            'messageTitle' => 'Akun anda dalam keadaan tidak aktif',
            'messageBody' => 'Silahkan hubungi administrator untuk mengaktifkan kembali akun anda.'
        ])
    @endif
@endsection