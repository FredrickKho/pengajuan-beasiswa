@extends('layout.main')
@section('title','Administrator - Period List')
@section('content')
<div class="m-3 text-end">
    <a href="{{route('createPeriod')}}" class="btn btn-primary">Buat data baru</a>
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
<table class="table table-striped my-3">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Period</th>
        <th scope="col">Waktu Mulai</th>
        <th scope="col">Waktu Selesai</th>
        <th scope="col">Total pengajuan beasiswa pada period</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ( $datas as $data )
        <tr>
            <th scope="row">{{$loop->index + 1}}</th>
            <td>{{$data->name}}</td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td>{{$data->beasiswa->count()}}</td>
            <td>
                <a href="{{route('editPeriod',$data->id)}}" class="text-decoration-none text-black fa fa-edit"></a>
                <button href="" data-bs-toggle="modal" data-bs-target="#data-{{$loop->index + 1}}" class="text-decoration-none text-black fa fa-trash border-0"></button>
                <!-- Modal -->
                <div class="modal fade" id="data-{{$loop->index + 1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Dekan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah anda ingin menghapus data period '{{$data->name}}' ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form data-bs-remote="true" action="{{route('deletePeriod',$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
          </tr>
        @endforeach
    </tbody>
  </table>
  <div class="d-flex justify-content-center">
      {{ $datas->links() }}
  </div>


@endsection