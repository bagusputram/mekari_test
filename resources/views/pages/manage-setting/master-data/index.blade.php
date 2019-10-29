@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Manage Setting')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active">{{ trans('manage-setting.master_data') }} {{ trans('manage-setting.setting') }}</li>
    </ol>
</section>
<section class="content">
    <!-- Messages -->
    @include('messages.message')  
	<div class="container-fluid spark-screen">        
		<div class="row">
			<div class="col-md-10 col-md-offset-1">

                <!-- Default box -->
                <div class="form-bar">
                    <div class="setting-title">
                        Company Information
                    </div>                    
                    <div class="row mt20">
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/company-type') }}">
                                    <i class="fa fa-industry fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.company-type.company-type') }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /.box -->
			
                <!-- Default box -->
				<div class="form-bar">
                    <div class="setting-title">
                        {{ trans('manage-setting.application') }} {{ trans('manage-setting.master_data') }}
                    </div>                    
                    <div class="row mt20">                        
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/gender') }}">
                                    <i class="fa fa-venus-mars fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.gender_setting.gender') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/citizenship') }}">
                                    <i class="fa fa-address-card-o fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.citizenship.citizenship') }}</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>            
                <!-- /.box -->

                <!-- Default box -->
				<div class="form-bar">
                    <div class="setting-title">
                        {{ trans('manage-setting.indonesia_area') }}
                    </div>                    
                    <div class="row mt20">                        
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/province') }}">
                                    <i class="fa fa-map fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.province.province') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/city') }}">
                                    <i class="fa fa-map fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.city.city') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/district') }}">
                                    <i class="fa fa-map fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.district.district') }}</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-2 mb10">
                            <div class="icon-wrapper">
                                <a href="{{ url('setting/subdistrict') }}">
                                    <i class="fa fa-map fa-5x"></i>
                                    <div class="icon-title">{{ trans('manage-setting.subdistrict.subdistrict') }}</div>
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