@extends('layout.main')
@section('title','Administrator - Create Program Studi')
@section('content')

<div class="text-center mt-3">
    <h1>Pendaftaran akun program studi</h1>
</div>
<div class="d-flex justify-content-center my-4">
    <form accept="{{route('createPStudi')}}" enctype="multipart/form-data" method="POST" class="px-5 py-4 w-50" style="border-radius: 4px;box-shadow: 0 0 20px; background-color: #f4f6f9">
        @csrf
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Enter Name">
            @error('name')
            <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Email</label>
            <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Enter Email">
            @error('email')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Password">
            @error('password')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Jenis Kelamin</label>
            <select class="form-select" name="gender">
                <option value="" selected>Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{old('gender') == "Laki-laki" ? "selected" : ""}}>Laki-laki</option>
                <option value="Perempuan" {{old('gender') == "Perempuan" ? "selected" : ""}}>Perempuan</option>
            </select>
            @error('gender')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" value="{{old('phone_number')}}" placeholder="Enter Name">
            @error('phone_number')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Program Studi/Jurusan</label>
            <select class="form-select" name="jurusan">
                <option value="" {{old('jurusan') ? "" : "selected"}}>Pilih jurusan</option>
                @foreach ($jurusan as $value)
                    <option value="{{$value->id}}" {{old('jurusan') == $value->id ? "selected" : ""}}>{{$value->name}}</option>
                @endforeach
            </select>
            @error('jurusan')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group text-center mt-4 mb-0">
            <button type="submit" class="btn btn-primary w-50">Daftar Akun</button>
        </div>
    </form>
</div>
@endsection