<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sistem Informasi Ketarunaan</title>

  <!-- Custom fonts for this template-->
  <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link rel="icon" href="{{asset('logopoltekbang.png')}}">
  <!-- Custom styles for this template-->
  <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  @stack('style')

  <style>
    .gambarlatar {
      background-image: url('{{ asset("poltekbang.jpg") }}');
      background-size: cover
    }

    @media only screen and (max-width: 600px) {
      .gambarlatar{
        display: none;
      }
    }
  </style>

</head>

<body id="page-top">
  <div class="d-flex flex-wrap align-items-stretch">
    <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
      <div class="p-4 m-3">
        <img src="{{ asset('logosika.png') }}" alt="logo" width="150" class="shadow-light rounded-circle mb-5 mt-2">
        <h2 class="text-dark font-weight-normal mb-4"><span class="font-weight-bold">Sistem Informasi Ketarunaan</span>
        </h2>
        {{-- <p class="text-muted">Before you get started, you must login or register if you don't already have an account.</p> --}}
        <form method="POST" action="{{ route('login')}}" class="needs-validation mt-4" novalidate="">
          @csrf
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
              value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="form-group">
            <div class="d-block">
              <label for="password" class="control-label">Password</label>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
              name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

              <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>
          </div>

          <div class="form-group text-right">
            {{-- <a href="auth-forgot-password.html" class="float-left mt-3">
                  Forgot Password?
                </a> --}}
            <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
              Login
            </button>
          </div>

          <div class="mt-5 text-center">
            {{-- Don't have an account? <a href="auth-register.html">Create new one</a> --}}
          </div>
        </form>
        <br>
        <div class="text-center mt-5 text-small">
          Copyright &copy; Politeknik Penerbangan Palembang. Theme made with 💙 by Stisla, redesigned by Mustechs
          {{-- <div class="mt-2">
                <a href="#">Privacy Policy</a>
                <div class="bullet"></div>
                <a href="#">Terms of Service</a>
              </div> --}}
        </div>
      </div>
    </div>
    <div
      class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom gambarlatar">
      <div class="absolute-bottom-left index-2">
        <div class="text-light p-5 pb-2">
          <div class="mb-5 pb-3">
            <h1 class="mb-2 display-4 font-weight-bold"></h1>
            <h5 class="font-weight-normal text-muted-transparent"></h5>
          </div>
          {{-- Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a> --}}
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
  @stack('scripts')
</body>

</html>