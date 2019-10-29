@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active"><a href="#">{{ trans('manage-setting.user-application-profile.user-application-profile') }}</a></li>
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
                                <h3 class="box-title">{{ trans('manage-setting.user-application-profile.user-application-profile') }} {{ trans('manage-setting.setting') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- User Application Language --}}
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header">
                                <h3 class="box-title" id="title-form">{{ trans('app.edit') }} {{ trans('manage-setting.user-application-profile.user-application-profile') }}</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                </div>
                                <div class="box-body">
                                    <form action="{{ route('setting.user-application-profile.update', ["id" => $user_profile->hashid]) }}" method="post" class="form-setting-user-application-profile" id='theform'>
                                        {{ csrf_field() }} {{ method_field('PUT') }}
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="application_language" class="col-md-2 col-form-label">{{ trans('manage-setting.user-application-profile.application-language') }}<span class="text-danger">*</span></label>
                                                    <div class="col-md-5">
                                                        <select class="form-control select" name="application_language" id="application_language">
                                                            <option value="0">{{ trans('manage-setting.application_language') }}</option>
                                                            @foreach ($languages as $language)
                                                                <option class="select-font" value="{{$language->id}}" {{ $language->id == $user_profile->application_language ? 'selected' : '' }}>{{$language->language_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="application_theme_color" class="col-md-2 col-form-label">{{ trans('manage-setting.user-application-profile.application-theme-color') }}<span class="text-danger">*</span></label>
                                                    <div class="col-md-5">
                                                        <select class="form-control select" name="application_theme_color" id="application_theme_color">
                                                            <option value="0">{{ trans('manage-setting.user-application-profile.application-theme-color') }}</option>
                                                            @foreach ($application_theme_colors as $application_theme_color)
                                                                <option class="select-font" value="{{$application_theme_color->id}}" {{ $application_theme_color->id == $user_profile->application_theme_color ? 'selected' : '' }}>{{$application_theme_color->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="gender_name" class="col-md-2 col-form-label"></span></label>
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
            {{-- User Application Profile Picture --}}
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header">
                                <h3 class="box-title" id="title-form">{{ trans('app.edit') }} {{ trans('manage-setting.user-application-profile.photo') }}</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>
                                </div>
                                <div class="box-body">
                                    <form action="{{ route('setting.user-application-profile.updatephoto', ["id" => $user_profile->hashid]) }}" method="post" class="form-setting-user-application-profile" id='theform' enctype="multipart/form-data">
                                        {{ csrf_field() }} {{ method_field('PUT') }}
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="profile_picture" class="col-md-2 col-form-label">{{ trans('manage-setting.user-application-profile.photo') }}<span class="text-danger">*</span></label>
                                                    <div class="col-md-5">
                                                        <input type="file" class="form-control-file" name="userFile" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-10 col-12 col-md-offset-2">
                                                <div class="form-group row">
                                                    <label for="gender_name" class="col-md-2 col-form-label"></span></label>
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
