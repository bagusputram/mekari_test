@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>               
        <li class="active"><a href="#">{{ trans('manage-setting.edit-user-data-authentication.edit-user-data-authentication') }}</a></li>
    </ol>
</section>
<section class="content">
    <!-- Messages -->
    @include('messages.message')    

	<div class="container-fluid spark-screen">
		<div class="row">                
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header">
                                <h3 class="box-title">{{ trans('manage-setting.edit-user-data-authentication.edit-user-data-authentication') }} {{ trans('manage-setting.setting') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header">
                                <h3 class="box-title" id="title-form">{{ trans('app.edit') }} {{ trans('manage-setting.edit-user-data-authentication.edit-user-data-authentication') }}</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>                                        
                                </div>
                                <div class="box-body">
                                    <form action="{{ route('setting.edit-user-data-authentication.update', ["id" => $user->hashid]) }}" method="post" class="form-setting-edit-user-data-authentication" id='theform'>
                                        {{ csrf_field() }} {{ method_field('PUT') }}        
                                        <br>
                                        <div class="row">                                        
                                            <div class="col-lg-10 col-12 col-md-offset-2">        
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 col-form-label">{{ trans('manage-setting.edit-user-data-authentication.name') }}<span class="text-danger">*</span></label>
                                                    <div class="col-md-5">                                                        
                                                        <input class="form-control-app" type="text" id="name" name="name" value="{{$user->name}}" required>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="password" class="col-md-2 col-form-label">{{ trans('manage-setting.edit-user-data-authentication.password') }}</label>
                                                    <div class="col-md-5">
                                                    <input class="form-control-app" type="password" id="password" name="password" value="" placeholder="{{ trans('manage-setting.edit-user-data-authentication.not_change_password') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-md-2 col-form-label">{{ trans('manage-setting.edit-user-data-authentication.password_confirmation') }}</label>
                                                    <div class="col-md-5">
                                                        <input class="form-control-app" type="password" id="password_confirmation" name="password_confirmation" value="" placeholder="{{ trans('manage-setting.edit-user-data-authentication.not_change_password') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="save" class="col-md-2 col-form-label"></span></label>
                                                    <div class="col-md-5">
                                                        <button id="button-form" type="submit" class="btn btn-sm btn-primary pull-left">{{ __('app.edit') }}</button>
                                                    </div>
                                                </div>
                                            </div>
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
</section>
@endsection

@push('more-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush