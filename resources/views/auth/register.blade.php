@extends('layouts.app_plain')
@section('custom_css')
    <style>

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card p-4 rounded-0">
                   <div class="text-center">
                    <img src="{{ asset('image/ninja.png') }}" alt="Ninja HR" class="img-fluid" width="150">
                   </div>
                    <div class="card-body p-1">
                        <div class="text-center">
                            <h5 class="text-secondary">Register</h5>
                            <p class="text-muted">To Be a User!</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <div class="form-outline ">
                                    <input type="text" name="name" id="name"
                                        class="form-control  @error('name') is-invalid @enderror mb-0"
                                        value="{{ old('name') }}" autocomplete="name" autofocus />
                                    <label class="form-label" for="name">Name</label>
                                </div>
                                @error('name')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror mb-0"
                                        value="{{ old('email') }}" />
                                    <label class="form-label" for="email">Email</label>
                                </div>
                                @error('email')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password" id="email"
                                        class="form-control @error('password') is-invalid @enderror mb-0"
                                        value="{{ old('password') }}" />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                @error('password')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-outline">
                                    <input type="password" name="password_confirmation" id="password-confirm"
                                        class="form-control mb-0" />
                                    <label class="form-label" for="password-confirm">Confirm Password</label>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-danger" role="alert"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class=" mb-0">
                                <div class="float-end">
                                    <button type="submit" class="btn btn-secondary">
                                        {{ __('Register') }}
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
