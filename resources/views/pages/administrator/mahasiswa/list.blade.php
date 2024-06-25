@extends('layout.main')
@section('title','Administrator - Mahasiswa List')
@section('content')
<div class="m-3 text-end">
    <a href="{{route('createMahasiswa')}}" class="btn btn-primary">Buat data baru</a>
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
        <th scope="col">Nama Mahasiswa</th>
        <th scope="col">Email</th>
        <th scope="col">Jenis Kelamin</th>
        <th scope="col">Jurusan</th>
        <th scope="col">Nomor Handphone</th>
        <th scope="col">Status aktif</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
        @foreach ( $datas as $data )
        <tr>
            <th scope="row">{{$loop->index + 1}}</th>
            <td>{{$data->user->name}}</td>
            <td>{{$data->user->email}}</td>
            <td>{{$data->user->gender}}</td>
            <td>{{$data->jurusan->name}}</td>
            <td>{{$data->user->phone_number}}</td>
            <td>
                <select class="form-select" id="activeStatus{{$loop->index + 1}}">
                    <option selected>
                            {{$data->user->isActive ? "Aktif" : "Tidak Aktif"}}
                    </option>
                    <option value="{{$data->user->id}}">
                            {{$data->user->isActive ? "Tidak Aktif" : "Aktif"}}
                    </option>
                </select>
                <script>
                    $(function(){
                        $('#activeStatus'+{{$loop->index + 1}}).on('change',function(){
                            var value= $(this).val();
                            console.log(value);
                            var form = $('<form action="{{route('activateAccount',$data->user->id)}}" method="POST">' +
                                '@method('PUT')'+
                                '@csrf'+
                                '</form>');
                            $('body').append(form);
                            form.submit();
                        })
                    })
                  </script>
            </td>
            <td>
                <a href="{{route('editMahasiswa',$data->id)}}" class="text-decoration-none text-black fa fa-edit"></a>
                <button href="" data-bs-toggle="modal" data-bs-target="#data-{{$loop->index + 1}}" class="text-decoration-none text-black fa fa-trash border-0"></button>
                <!-- Modal -->
                <div class="modal fade" id="data-{{$loop->index + 1}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Mahasiswa</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah anda ingin menghapus data mahasiswa '{{$data->user->name}}' ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form data-bs-remote="true" action="{{route('deleteMahasiswa',$data->user_id)}}" method="POST" enctype="multipart/form-data">
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