@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Manage Setting')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active">{{ trans('manage-setting.restricted') }} {{ trans('manage-setting.setting') }}</li>
    </ol>
</section>
<section class="content">
    <!-- Messages -->
    @include('messages.message')  
	<div class="container-fluid spark-screen">        
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

                <!-- Default box Restricted Setting-->
				<div class="form-bar">
                        <div class="setting-title">
                            {{ trans('manage-setting.application_routing') }} {{ trans('manage-setting.setting') }}
                        </div>                    
                        <div class="row mt20">                        
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/route-type') }}">
                                        <i class="fa fa-paper-plane fa-4x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.route_type.route_type') }}</div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/route-controller-type') }}">
                                        <i class="fa fa-sticky-note-o fa-4x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.route_controller_type.route_controller_type') }}</div>
                                    </a>
                                </div>
                            </div>                        
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/menu-type') }}">
                                        <i class="fa fa-star fa-4x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.menu_type.menu_type') }}</div>
                                    </a>
                                </div>                            
                            </div>
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/route-list') }}">
                                        <i class="fa fa-unsorted fa-4x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.route_list.route_list') }}</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>            
                    <!-- /.box -->

                <!-- Default box -->
                
                <!-- Default box User Menu Setting-->
				<div class="form-bar">
                    <div class="setting-title">
                        {{ trans('manage-setting.user_menu') }} {{ trans('manage-setting.setting') }}
                    </div>                    
                    <div class="row mt20">
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/menu') }}">
                                    <i class="fa fa-comments fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.menu_setting.menu') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/user-role') }}">
                                    <i class="fa fa-user fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.role_setting.role') }}</div>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box -->
                
                <!-- Default box Language Setting-->
				<div class="form-bar">
                        <div class="setting-title">
                            {{ trans('manage-setting.application') }} {{ trans('manage-setting.master_data') }}
                        </div>                    
                        <div class="row mt20">                            
                            
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/language') }}">
                                        <i class="fa fa-language fa-5x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.language.language') }} {{ trans('manage-setting.master_data') }}</div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 mb10">
                                <div class="icon-wrapper">
                                    <a href="{{ url('setting/application-theme-color') }}">
                                        <i class="fa fa-tint fa-5x"></i>
                                        <div class="icon-title">{{ trans('manage-setting.application_theme_color.application_theme_color') }} {{ trans('manage-setting.master_data') }}</div>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.box -->

                <!-- Default Application Restrict box -->
				<div class="form-bar">
                    <div class="setting-title">
                        {{ trans('manage-setting.application') }} {{ trans('manage-setting.setting') }}
                    </div>
                    <div class="row mt20">
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href='' data-toggle="modal" data-target="#modal-form-application-language">
                                    <i class="fa fa-language fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.application_language') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href='' data-toggle="modal" data-target="#modal-form-session-timeout">
                                    <i class="fa fa-clock-o fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.session_timeout.session_timeout') }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>            
                <!-- /.box -->

			</div>
		</div>
	</div>
</section>
@include('pages.manage-setting.include.form-modal-session-timeout')
@include('pages.manage-setting.include.form-modal-application-language')

@endsection

@push('more-js')     
    {{--  Select 2 js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush