@extends('layout.main')
@section('title','Program Studi - Main Page')
@section('content')
    @if (auth()->user()->isActive)
        @if ($periods)
            <div class="d-flex flex-row align-items-center">
                <h6 class="me-3" style="white-space:nowrap">Select Period</h6>
                <div class="w-100">
                    <form class="form-horizontal mt-2" periodChange() action="{{ route('dekan/review') }}" method="GET" enctype="multipart/form-data">
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
            </div>
            <div>
                @if (!$dataBeasiswa->isEmpty())
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
                    <table class="table table-striped table-bordered border-black my-3 text-center">
                        <thead>
                        <tr>
                            <th rowspan="2" scope="col">No</th>
                            <th rowspan="2" scope="col">Nama Mahasiswa</th>
                            <th rowspan="2" scope="col">Jenis Beasiswa</th>
                            <th colspan="3">Program Studi</th>
                            <th colspan="3">Dekan</th>
                            <th rowspan="2" scope="col">Aksi</th>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <th>Waktu Update</th>
                            <th>Status Approval</th>
                            <th>Nama</th>
                            <th>Waktu Update</th>
                            <th>Status Approval</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dataBeasiswa as $data)
                            <tr>
                                <th>{{$loop->index+1}}</th>
                                <th>{{$data->mahasiswa->user->name}}</th>
                                <th>{{$data->category->name}}</th>
                                @php
                                    $beasiswaId = $data->id;
                                    $programStudiName = $data->pengajuanBeasiswa->program_studi_id == null ? "-" : $data->pengajuanBeasiswa->programStudi->user->name; 
                                    if($data->pengajuanBeasiswa->programStudi){
                                        $note = true;
                                        $date = date('j F, Y h:i:s A', strtotime($data->pengajuanBeasiswa->program_studi_update_at));
                                        if($data->pengajuanBeasiswa->isApprovedByProgramStudi){
                                            $color = "text-success";
                                            $text = "Accepted";
                                        }else {
                                            $color = "text-danger";
                                            $text = "Rejected";
                                        }
                                    }else {
                                        $note = false;
                                        $color = "text-secondary";
                                        $text = "Unchecked";
                                        $date = "-";
                                    }
                                @endphp
                                <th>{{$programStudiName}}</th>
                                <th style="font-size: small">{{$date}}</th>
                                <th class="{{$color}}">
                                    {{$text}} 
                                    @if ($note)
                                        <a data-bs-toggle="modal" data-bs-target="#programStudiNote-{{$loop->index+1}}" class="fas fa-sticky-note"></a>
                                    @endif
                                </th>

                                @php
                                    $dekanName = $data->pengajuanBeasiswa->dekan_id == null ? "-" : $data->pengajuanBeasiswa->dekan->user->name; 
                                    if($data->pengajuanBeasiswa->dekan){
                                        $date = date('j F, Y h:i:s A', strtotime($data->pengajuanBeasiswa->dekan_update_at));
                                        $note = true;
                                        if($data->pengajuanBeasiswa->isApprovedByDekan){
                                            $color = "text-success";
                                            $text = "Accepted";
                                        }else {
                                            $color = "text-danger";
                                            $text = "Rejected";
                                        }
                                    }else {
                                        $note = false;
                                        $color = "text-secondary";
                                        $text = "Unchecked";
                                        $date = "-";
                                    }
                                @endphp
                                <th>{{$dekanName}}</th>
                                <th style="font-size: small">{{$date}}</th>
                                <th class="{{$color}}">
                                    {{$text}} 
                                    @if ($note)
                                        <a data-bs-toggle="modal" data-bs-target="#dekanNote-{{$loop->index+1}}" class="fas fa-sticky-note"></a>
                                    @endif
                                </th>
                                @php
                                    $color = "btn-primary";
                                    $text = "Review";
                                    if($data->pengajuanBeasiswa->programStudi) {
                                        $text = "Review ulang";
                                    }
                                @endphp
                                <th>
                                    <button data-bs-toggle="modal" data-bs-target="#review-{{$loop->index+1}}" style="font-size: small" class="btn {{$color}}">{{$text}}</button>
                                </th>
                            </tr>
                            
                            <!-- Modal review-->
                            <div class="modal modal-xl fade" id="review-{{$loop->index+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Review Beasiswa "{{$data->mahasiswa->user->name}}"</h5>
                                        </div>
                                        <div class="modal-body">
                                            @include('pages.beasiswa.template.detail',["data" => $data])
                                        </div>
                                        <div class="modal-body d-flex flex-column">
                                            <strong class="text-center">Tambahkan pesan/catatan sebelum melakukan review (Opsional)</strong>
                                            <form id="reviewForm{{$data->id}}" action="{{route('programStudiReviewBeasiswa',$data->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <textarea class="m-4 px-4 py-2" rows="5" name="note" style="resize: none"></textarea>
                                                <div class="d-flex justify-content-around">
                                                    <button type="button" onclick='reviewBeasiswa{{$data->id}}("Accept")' class="btn btn-success w-25 m-auto" data-bs-dismiss="modal">Accept</button>
                                                    <button type="button" onclick='reviewBeasiswa{{$data->id}}("Reject")' class="btn btn-danger w-25 m-auto" data-bs-dismiss="modal">Reject</button>
                                                </div>
                                                <input type="text" name="review" hidden id="reviewInput{{$data->id}}" value="">
                                            </form>
                                            @if($data->pengajuanBeasiswa->programStudi) 
                                                <strong class="text-center text-danger">Melakukan review ulang akan menghapus data approval dari fakultas/dekan</strong> 
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal catatan dekan-->
                            <div class="modal fade" id="dekanNote-{{$loop->index+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Catatan dari dekan</h5>
                                        </div>
                                        <div class="modal-body">
                                            <textarea disabled rows="10" class="w-100 px-3 py-2" style="resize: none">{{$data->pengajuanBeasiswa->dekan_notes}}</textarea>                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal catatan program studi-->
                            <div class="modal fade" id="programStudiNote-{{$loop->index+1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Catatan dari program studi</h5>
                                        </div>
                                        <div class="modal-body">
                                            <textarea disabled rows="10" class="w-100" style="resize: none">{{$data->pengajuanBeasiswa->program_studi_notes}}</textarea>                                                    
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function reviewBeasiswa{{$data->id}}(reviewResult){
                                    form = document.getElementById('reviewForm' + '<?php echo json_encode($data->id)?>')
                                    value = document.getElementById('reviewInput' + '<?php echo json_encode($data->id)?>')
                                    value.value = reviewResult
                                    form.submit(); 
                                }
                            </script>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $dataBeasiswa->links() }}
                    </div>
                    
                @else
                    @include('layout.inactive',[
                        'messageTitle' => 'Data beasiswa tidak ada',
                        'messageBody' => 'Belum ada mahasiswa yang mengajukan beasiswa atau ada kesalahan teknis'
                    ])
                @endif
            </div>
            <script type="text/javascript">
                function periodChange() {
                    let queryString = window.location.search;
                    let params = new URLSearchParams(queryString);
                    params.delete('period');
                    params.append('period', document.getElementById("period").value);
                    document.location.href = "?" + params.toString();
                }
            </script>
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