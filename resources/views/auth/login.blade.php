@extends('layouts.app_plain')
@section('custom_css')
    <style>

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card py-4 px-5 rounded-0">
                    <div class="text-center">
                        <img src="{{ asset('image/ninja.png') }}" alt="Ninja HR" class="img-fluid" width="150">
                       </div>
                    <div class="card-body p-1">
                        <div class="text-center">
                            <h5 class="text-secondary">Login</h5>
                        <p class="text-muted">Please fill the login from!</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror mb-0" autofocus/>
                                    <label class="form-label" for="phone">Phone</label>
                                </div>
                                @error('phone')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-outline ">
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror mb-0" />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                @error('password')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check p-0">
                                        <input class="" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
