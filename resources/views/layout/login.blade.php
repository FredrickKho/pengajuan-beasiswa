<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    </head>
    <body class="antialiased">
        <div class="b-ground d-flex flex-column justify-content-center" style="min-height: 100vh;">
            <div class="text-center">
                <h1>Pengajuan Beasiswa</h1>
                <h6>Universitas Kristen Maranatha</h6>
            </div>
            <div class="container py-5 h-100" >
                <div class="row d-flex justify-content-center align-items-center" style="background-image: none">
                    <div class="col col-xl-10">
                        <div class="" style="border-radius: 0 1rem 1rem 0; box-shadow: 0 0 20px; background-color: #f4f6f9">
                            <div class="d-flex" style="">
                                <div class="col-md-6 col-lg-5 d-none d-md-block pl-0" style="align-content: center">
                                    <img src="{{ asset('asset/OIP.jpeg') }}" alt="login-role" class="img-fluid w-100 h-100"  />
                                </div>
                                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                    <div class="card-body py-lg-5 text-black">
                                        <form method="POST" action="{{route('login')}}" enctype="multipart/form-data">
                                            @csrf
                                            @if (Session::has('status') == 'failed')
                                                <div class="alert alert-danger" role="alert">
                                                    {{ Session::get('message') }}
                                                </div>
                                            @endif
                                            <div class="form-group my-4">
                                                <h1 class="m-0">Login</h1>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" aria-describedby="emailHelp" placeholder="Enter email">
                                                @error('email')
                                                    <p class="text-danger mb-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" name="password" value="{{old('password')}}" id="password" placeholder="Password">
                                                @error('password')
                                                    <p class="text-danger mb-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="form-group text-center mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary w-50">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
