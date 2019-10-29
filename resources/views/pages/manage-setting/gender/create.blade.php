@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Gender Setting')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active"><a href="{{ route('setting.index')}}">{{ trans('manage-setting.manage_setting') }}</a></li>
        <li class="active"><a href="#">{{ trans('manage-setting.gender') }}</li>
    </ol>
</section>
<section class="content">
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-lg-12 col-12">                
                    <form action="{{ route('setting-gender.store') }}" method="post" class="form-officeallowance form-officeallowance-update" novalidate>
                        {{ csrf_field() }} {{ method_field('POST') }}
                  
                        <div class="row">
                          <div class="col-lg-3 col-12">
                            <div class="box">
                              <div class="box-body no-padding mailbox-nav company-form-nav">
                                <div class="panel">
                                  <div class="panel-body">
                                    <div class="list-group faq-list" role="tablist">
                                      <a class="list-group-item active" data-toggle="tab" href="#tab-basic" aria-controls="tab-basic" role="tab"><i class="fa fa-building"></i> {{ __('company.create.sidebar') }}</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <a href="{{ route('setting-gender.index') }}" class="btn btn-lg btn-default btn-block">{{ __('ownership.button.back') }}</a>
                          </div>
                          <div class="col-lg-9 col-12">
                            <div class="box">
                              <div class="tab-content tab-content-company">
                                <div class="tab-pane tab-main active" id="tab-basic" role="tabpanel">
                                  <div class="box-body">
                                                      
                                    
                                    <div class="form-group row {{ ($errors->has('grade-allowance') ? 'has-error' : '' ) }}">
                                      <label for="grade-allowance" class="col-12 col-md-3 col-form-label">Grade Allowance <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="grade-allowance" name="grade-allowance"
                                          value="{{ old('grade-allowance', 0) }}">
                                      </div>
                                    </div>
                  
                                    <div class="form-group row {{ ($errors->has('transportation-allowance') ? 'has-error' : '' ) }}">
                                      <label for="transportation-allowance" class="col-12 col-md-3 col-form-label">Transportation Allowance <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="transportation-allowance" name="transportation-allowance"
                                          value="{{ old('transportation-allowance', 0) }}">
                                      </div>
                                    </div>
                  
                                    <div class="form-group row {{ ($errors->has('communication-allowance') ? 'has-error' : '' ) }}">
                                      <label for="communication-allowance" class="col-12 col-md-3 col-form-label">Communication Allowance <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="communication-allowance" name="communication-allowance"
                                          value="{{ old('communication-allowance', 0) }}">
                                      </div>
                                    </div>
                  
                                    <div class="form-group row {{ ($errors->has('leave-allowance') ? 'has-error' : '' ) }}">
                                      <label for="leave-allowance" class="col-12 col-md-3 col-form-label">Leave Allowance <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="leave-allowance" name="leave-allowance"
                                          value="{{ old('leave-allowance', 0) }}">
                                      </div>
                                    </div>
                  
                                    <div class="form-group row {{ ($errors->has('fuel-allowance-office') ? 'has-error' : '' ) }}">
                                      <label for="fuel-allowance-office" class="col-12 col-md-3 col-form-label">Fuel Office Based Allowance <span class="text-danger">*</span></label> 
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="fuel-allowance-office" name="fuel-allowance-office"
                                          value="{{ old('fuel-allowance', 0) }}">
                                      </div>
                                    </div>
                  
                                    <div class="form-group row {{ ($errors->has('fuel-allowance-mobile') ? 'has-error' : '' ) }}">
                                      <label for="fuel-allowance-mobile" class="col-12 col-md-3 col-form-label">Fuel Mobile Based Allowance <span class="text-danger">*</span></label>
                                      <div class="col-12 col-md-9">
                                          <input class="form-control type_accounting" type="text" min="0" id="fuel-allowance-mobile" name="fuel-allowance-mobile"
                                          value="{{ old('fuel-allowance-mobile', 0) }}">
                                      </div>
                                    </div>               
                  
                                  </div>
                                </div>
                              </div>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary pull-right">{{ __('officeallowance.create.button') }}</button>
                          </div>
                        </div>
                      </form>                
            </div>
		</div>
	</div>
</section>
@endsection
