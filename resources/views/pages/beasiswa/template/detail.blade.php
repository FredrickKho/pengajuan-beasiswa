<div class="m-4 d-flex flex-column text-start" style="border-radius: 4px;box-shadow: 0 0 20px; background-color: #f4f6f9a0;">
    <h1 class="text-center">Data pengajuan beasiswa</h1>
    <div class="p-2 mx-3 mt-3 mb-1 d-flex flex-column border border-2 border-black">
        <div class="row">
            <div class="col">
                <strong>Period : {{$data->period->name}}</strong>
            </div>
            <div class="col">
                <strong>
                    Jenis Beasiswa : {{$data->category->name}}
                </strong>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <strong>Tanggal Pengajuan : {{$data->created_at->format('j F, Y h:i:s A')}}</strong>
            </div>
            <div class="col">
                <strong>
                    Nilai IPK : {{$data->ipk}}
                </strong>
            </div>
        </div>
    </div>
    <div class="p-3 mx-3 mb-2 border border-2 border-black">
        <div class="row mb-2">
            <div class="col">
                <strong>
                    Transkrip Akademik : 
                    <a target="blank" href="{{asset('asset/transkrip-akademik/'.$data->transkrip_akademik)}}">
                        Klik untuk melihat data
                    </a>
                </strong>
            </div>
            <div class="col">
                <strong>
                    Surat Rekomendasi Dosen : 
                    <a target="blank" href="{{asset('asset/surat-rekomendasi-dosen/'.$data->surat_rekomendasi_dosen)}}">
                        Klik untuk melihat data
                    </a>
                </strong>                                
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <strong>
                    Bukti keaktifan Mahasiswa : 
                    <a target="blank" href="{{asset('asset/bukti-keaktifan/'.$data->bukti_keaktifan)}}">
                        Klik untuk melihat data
                    </a>
                </strong>
            </div>
            <div class="col">
                <strong>
                    Dokumen pendukung lainnya : 
                    <a target="blank" href="{{asset('asset/dokumen-pendukung-lain/'.$data->dokumen_pendukung_lain)}}">
                        Klik untuk melihat data
                    </a>
                </strong>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <strong>
                    Surat pernyataan tidak sedang menerima beasiswa dari pihak lain : 
                    <a target="blank" href="{{asset('asset/surat-pernyataan-beasiswa/'.$data->surat_pernyataan_beasiswa)}}">
                        Klik untuk melihat data
                    </a>
                </strong>                                
            </div>
        </div>
    </div>
</div> 