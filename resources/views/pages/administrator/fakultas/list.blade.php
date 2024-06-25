@extends('layout.main')
@section('title','Administrator - Fakultas')
@section('content')
<div class="m-3 text-end">
    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFakultas">Buat data baru</a>
    <!-- Modal -->
    <div class="modal fade" id="createFakultas" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Buat data fakultas</h5>
                </div>
                <form action="{{route('createFakultas')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group my-3 d-flex flex-row align-items-center">
                            <label for="exampleInputEmail1" style="white-space:nowrap" class="me-3">Nama Fakultas</label>
                            <input type="text" required class="form-control"  name="create_name" placeholder="Enter Fakultas Name">
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
@elseif (Session::has('status') == 'failed')
{{dd("dsadsad")}}
    <div class="alert alert-danger" id="failed-alert" role="alert">
        <i type="button" id="close-alert" class="fa fa-close" style=""></i>
        {{ Session::get('message') }}
    </div>
    <script>
        $(document).ready(function() {
            $("#close-alert").click(function () {
                $("#failed-alert").remove();
            });
        });
    </script>
@endif
<table class="table table-striped my-3">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Fakultas</th>
        <th scope="col">Total Dekan Dalam Fakultas</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            <tr>
                <th scope="row">{{$loop->index + 1}}</th>
                <td>{{$data->name}}</td>
                <td>{{$data->dekan->count()}}</td>
                <td>
                    <a data-bs-toggle="modal" data-bs-target="#editFakultas-{{$loop->index + 1}}" class="text-decoration-none text-black fa fa-edit"></a>
                    <!-- Modal -->
                    <div class="modal fade" id="editFakultas-{{$loop->index + 1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit data fakultas</h5>
                                </div>
                                <form action="{{route('editFakultas',$data->id)}}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group my-3 d-flex flex-row align-items-center">
                                            <label for="exampleInputEmail1" style="white-space:nowrap" class="me-3">Nama Fakultas</label>
                                            <div>
                                                <input type="text" required class="form-control" value="{{$data->name}}" name="edit_name" placeholder="Enter Fakultas Name">
                                            </div>
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

                    <button href="" data-bs-toggle="modal" data-bs-target="#data-{{$loop->index + 1}}" class="text-decoration-none text-black fa fa-trash border-0"></button>
                    <!-- Modal -->
                    <div class="modal fade" id="data-{{$loop->index + 1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Fakultas</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda ingin menghapus data Fakultas '{{$data->name}}' ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form data-bs-remote="true" action="{{route('deleteFakultas',$data->id)}}" method="POST" enctype="multipart/form-data">
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