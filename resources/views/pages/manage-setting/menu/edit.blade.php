@extends('layouts.app')

@section('main-content')
<section class="content-header">  
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>  
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active"><a href="{{ route('setting.index')}}">{{ trans('manage-setting.manage_setting') }}</a></li>
        <li class="active"><a href="#">{{ trans('manage-setting.menu_setting.menu') }}</a></li>
    </ol>
</section>
<section class="content">
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-lg-12 col-12">                
                <form action="{{ route('setting-menu.update', ['id' => $menu->hashid]) }}" method="post" class="form-officeallowance form-officeallowance-update" novalidate>
                    {{ csrf_field() }} {{ method_field('PUT') }}
                  
                    <div class="row">                        
                        <div class="col-lg-12 col-12">                                
                                <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ trans('app.add_new') }} {{ trans('manage-setting.menu_setting.menu') }}</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fa fa-minus"></i></button>                                        
                                    </div>
                                </div>
                                
                                        <div class="box-body">
                                            <div class="col-md-12 col-md-offset-2">        
                                                <div class="form-group row">
                                                    <h4 for="menu_name" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_name') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <input class="form-control" type="text" id="menu_name" name="menu_name" value="{{ $menu->menu_name }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="menu_language" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_language') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <input class="form-control" type="text" id="menu_language" name="menu_language" value="{{ $menu->menu_language }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="menu_icon" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_icon') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <input class="form-control" type="text" id="menu_icon" name="menu_icon" value="{{ $menu->menu_icon }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="menu_controller" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_controller') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <input class="form-control" type="text" id="menu_controller" name="menu_controller" value="{{ $menu->menu_controller }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="menu_position" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_position') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <input class="form-control" type="text" id="menu_position" name="menu_position" value="{{ $menu->menu_position }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="menu_parent_id" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.menu_parent_id') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <select class="form-control select" name="menu_parent_id[]" multiple>
                                                            @foreach($menus as $menu_data)
                                                                <option value="{{ $menu_data->id }}" {{ $menu_data->id == $menu->menu_parent_id ? 'selected' : '' }}>{{ $menu_data->menu_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <h4 for="user_role_id" class="col-12 col-md-3 col-form-label">{{ trans('manage-setting.menu_setting.user_role_id') }}<span class="text-danger">*</span></h4>
                                                    <div class="col-10 col-md-5">
                                                        <select class="form-control select" name="user_role_id[]" multiple>
                                                            @foreach($user_roles as $user_role)
                                                                <option value="{{ $user_role->id }}" {{ in_array($user_role->id, json_decode($menu->user_role_id)) ? 'selected' : '' }}>{{ $user_role->user_role_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                            </div>                            
                            <a href="{{ route('setting-menu.index') }}" class="btn btn-md btn-default pull-left">{{ trans('app.back') }}</a>
                            <button type="submit" class="btn btn-md btn-success pull-right">{{ trans('app.save') }}</button>
                            </div>                                                        
                        </div>
                    </div>
                </form>                
            </div>
		</div>
	</div>
</section>
@endsection

@push('more-js')     

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    
@endpush