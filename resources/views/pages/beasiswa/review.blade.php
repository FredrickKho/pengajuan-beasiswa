<div>
    {{-- {{$dataBeasiswa}} --}}
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
    </div>
</div>