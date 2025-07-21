@extends('layouts.app')

@section('content')
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <h6 class="mb-0">PT Bisi International Tbk</h6>
                                    <p class="mb-0">Barrier Gate Application Monitoring</p>
                                </div>
                                <div class="card-body">
                                    @if (session()->has('error'))
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <ul class="list-unstyled mb-0">
                                                <strong> {{ session('error') }}</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (isset($errors) && count($errors) > 0)
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </ul>

                                        </div>
                                    @endif


                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="flex flex-col mb-3">
                                            <input type="text" name="username" autofocus placeholder="Email or username"
                                                class="form-control form-control-lg" value="{{ old('username') }}"
                                                aria-label="Username">
                                            @error('username')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="password" placeholder="Password"
                                                class="form-control form-control-lg" aria-label="Password">
                                            @error('password')
                                                <p class="text-danger text-xs pt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="remember" checked value="1"
                                                type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Login</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div
                            class="col-7 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative h-100 d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url({{ asset('img/logo-bisi.png') }}); background-repeat: no-repeat;
                        background-size: cover;width: 75%;">
                                {{-- <h4 class="font-weight-bolder position-relative" style="color: #07a88f">PT Multi Sarana
                                    Indotani</h4>
                                <h6 class="font-weight-bolder position-relative"></h6> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
