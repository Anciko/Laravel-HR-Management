@extends('layouts.app_plain')
@section('custom_css')
    <style>

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card py-4 px-5 rounded-0">
                    <a href="{{ url()->previous() }}" class="text-dark"> <i class="fa-solid fa-angle-left fa-lg"></i> </a>
                    <div class="text-center">
                        <img src="{{ asset('image/ninja.png') }}" alt="Ninja HR" class="img-fluid" width="150">
                    </div>
                    <div class="card-body p-1">
                        <div class="text-center">
                            <h5 class="text-secondary">Login Option</h5>
                            <p class="text-muted">Please choose the login option!</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                            @csrf

                            <input type="hidden" name="phone" value="{{request()->phone}}" id="phone">
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3 d-flex justify-content-center" id="ex-with-icons" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="ex-with-icons-tab-1" data-mdb-toggle="tab"
                                        href="#password-tab" role="tab"
                                        aria-selected="true"><i class="fas fa-chart-pie fa-fw me-2"></i>Sales</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="ex-with-icons-tab-2" data-mdb-toggle="tab"
                                        href="#ex-with-icons-tabs-2" role="tab" aria-controls="ex-with-icons-tabs-2"
                                        aria-selected="false"><i class="fas fa-chart-line fa-fw me-2"></i>Subscriptions</a>
                                </li>
                            </ul>
                            <!-- Tabs navs -->

                            <!-- Tabs content -->
                            <div class="tab-content" id="ex-with-icons-content">
                                <div class="tab-pane fade show active" id="password-tab" role="tabpanel">
                                    <div class="mb-3">
                                        <div class="form-outline ">
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror mb-0" />
                                            <label class="form-label" for="password">Password</label>
                                        </div>
                                        @error('password')
                                            <span class="text-danger" role="alert"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel"
                                    aria-labelledby="ex-with-icons-tab-2">
                                    Tab 2 content
                                </div>
                            </div>
                            <!-- Tabs content -->


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
