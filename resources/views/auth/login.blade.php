@extends('layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box">
            <div class="login-logo">
                <img src="{{asset('img/wonderful-indonesia.png')}}" height="200px" class="logo-login" alt=""/>
            </div><!-- /.login-logo -->
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="login-box-body">
          <p class="login-box-msg"> {{ trans('message.siginsession') }} </p>
          <login-form name="{{ config('auth.providers.users.field','email') }}"
                      domain="{{ config('auth.defaults.domain','') }}"></login-form>
          {{--  @include('auth.partials.social_login')  --}}
          <div class="top-10">
            <a href="{{ url('/password/reset') }}">{{ trans('message.forgotpassword') }}</a>
          </div>
        </div>
    </div>
    </div>
    @include('layouts.partials.scripts_auth')
</body>

@endsection

@push('more-js')
    {{--  Select 2 js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush
