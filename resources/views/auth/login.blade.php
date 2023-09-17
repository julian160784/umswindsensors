@extends('layouts.login')

@section('content')
<div class="d-flex flex-row">
    <div class="flex-fill bg">
        <div style="width:700px;margin:200px auto 0;" class="text-white">
            <h1 style="font-weight:bold">Selamat Datang di Mandalika Wind</h1>
            <p style="font-size:18px;font-weight:bold">Akses data lingkungan dan suhu di Mandalika dalam satu tempat</p>

            <br>

            <a href="#" class="btn btn-success"><strong>Pelajari Lebih Lanjut</strong></a>
        </div>
    </div>
    <div class="login-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h2 style="margin:50px 0">LOG IN</h2>
            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-top:50px;">
                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
