@extends('layout.main')
@section('title','Administrator - Create Period')
@section('content')

<div class="text-center mt-3">
    <h1>Pembuatan data period</h1>
</div>
<div class="d-flex justify-content-center my-4">
    <form accept="{{route('createPeriod')}}" enctype="multipart/form-data" method="POST" class="px-5 py-4 w-50" style="border-radius: 4px;box-shadow: 0 0 20px; background-color: #f4f6f9">
        @csrf
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Nama Period</label>
            <input type="text" class="form-control" name="period_name" value="{{old('period_name')}}" placeholder="Enter Name">
            @error('period_name')
            <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">Start Date</label>
            <input type="date" id="startDate" class="form-control" placeholder="Start Date" name="start_date" value="{{old('start_date')}}" onchange=check() />
            @error('start_date')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group my-3">
            <label for="exampleInputEmail1">End Date</label>
            <input type="date" id="endDate" class="form-control" placeholder="End Date" name="end_date" {{old('start_date') ? '' : 'disabled'}} value="{{old('end_date')}}"/>
            @error('end_date')
                <p class="text-danger mb-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group text-center mt-4 mb-0">
            <button type="submit" class="btn btn-primary w-50">Buat data period</button>
        </div>
        <script type="text/javascript">
            var startDate = document.getElementById('startDate');
            var endDate = document.getElementById('endDate');
            function check(){
                if(startDate.value){
                    endDate.removeAttribute('disabled')
                    if(startDate.value > endDate.value)
                        endDate.value = ""
                    endDate.setAttribute('min',startDate.value)
                }else{
                    endDate.setAttribute('disabled','')
                    endDate.value = ""
                }
            }
        </script>
    </form>
</div>
@endsection