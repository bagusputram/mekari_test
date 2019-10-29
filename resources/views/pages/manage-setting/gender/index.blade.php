@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>       
        <li class="active"><a href="{{ route('setting.master-data.index')}}">{{ trans('manage-setting.master_data') }} {{ trans('manage-setting.setting') }}</a></li>
        <li class="active"><a href="#">{{ trans('manage-setting.gender_setting.gender') }}</a></li>
    </ol>
</section>
<section class="content">
    <!-- Messages -->
    @include('messages.message')    

    <passport-clients></passport-clients>
    <passport-authorized-clients></passport-authorized-clients>
    <passport-personal-access-tokens></passport-personal-access-tokens>

	<div class="container-fluid spark-screen">
		<div class="row">                
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header">
                                <h3 class="box-title">{{ trans('manage-setting.gender_setting.gender') }} {{ trans('manage-setting.setting') }}</h3>
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
                                    <h3 class="box-title" id="title-form">{{ trans('app.add_new') }} {{ trans('manage-setting.gender_setting.gender') }}</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fa fa-minus"></i></button>                                        
                                    </div>
                                    <div class="box-body">
                                        <form action="{{ route('setting.gender.store') }}" method="post" class="form-setting-gender" id='theform'>
                                            {{ csrf_field() }} {{ method_field('POST') }}        
                                            <br>
                                            <div class="row">                                        
                                                <div class="col-lg-10 col-12 col-md-offset-2">        
                                                    <div class="form-group row">
                                                        <label for="gender_name" class="col-md-2 col-form-label">{{ trans('manage-setting.gender_setting.gender_name') }}<span class="text-danger">*</span></label>
                                                        <div class="col-md-5">
                                                            <input class="form-control-app" type="text" id="gender_name" name="gender_name" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 col-12 col-md-offset-2">        
                                                    <div class="form-group row">
                                                        <label for="gender_language" class="col-md-2 col-form-label">{{ trans('manage-setting.gender_setting.gender_language') }}<span class="text-danger">*</span></label>
                                                        <div class="col-md-5">
                                                            <input class="form-control-app" type="text" id="gender_language" name="gender_language" value="" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10 col-12 col-md-offset-2">
                                                    <div class="form-group row">
                                                        <label for="gender_name" class="col-md-2 col-form-label"></span></label>
                                                        <div class="col-md-5">
                                                            <button id="button-form" type="submit" class="btn btn-sm btn-success pull-left">{{ __('app.add_new') }}</button>
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
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header with-border">
                                <div class="table-filter" style="display:inline-block">
                                    <a href="{{ route('setting.gender.index') }}" class="{{ Request::get('status') == NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.all_data') }}
                                        <span class="badge badge-pill badge-info">{{ $gender_count }}</span>
                                    </a>
                                    &nbsp; | &nbsp;
                                    <a href="{{ route('setting.gender.index') }}?status=trash" class="{{ Request::get('status') != NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.trash') }}
                                        <span class="badge badge-pill badge-danger">{!! $trash->count() !!}</span>
                                    </a>
                                </div>
                                {{--  <div class="box-controls pull-right">
                                    <a href="{{ route('setting.gender.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</a>
                                    <button type="button" class="btn btn-sm btn-info" style="margin-right: 0.5rem" data-toggle="modal" data-target="#importFile">
                                        <i class="fa fa-file-excel-o" data-toggle="modal" data-target="#importFile"></i> Import Office Allowance
                                    </button>
                                </div>  --}}
                            </div>
                            <div class="box-body">
                                <table id="data-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>                                            
                                            <th class="text-center">Gender Name</th>
                                            <th class="text-center">Gender Language</th>
                                            <th class="text-center">{{ trans('app.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($genders as $gender)
                                        <tr>                                                                                      
                                            <td>{{ trans('manage-setting.gender_setting.'.$gender->gender_language) }}</td>
                                            <td>{{ $gender->gender_language  }}</td>
                                            <td class="text-center">
                                                @if( $gender->deleted_at == null )
                                                <button type="button" onclick="willEdit('{{ $gender->hashid }}', 'PUT')" class="btn btn-primary btn-sm btn-edit" id="btn-edit-{{ $loop->iteration }}" title="{{ __('app.edit') }}">
                                                    <i class="fa fa-pencil" style="pointer-events:none;"></i>
                                                </button>
                                                <button type="button" onclick="willRemove('{{ $gender->hashid }}', 'DELETE')" class="btn btn-danger btn-sm btn-delete" id="btn-delete-{{ $loop->iteration }}" title="{{ __('app.delete') }}">
                                                    <i class="fa fa-trash" style="pointer-events:none;"></i>
                                                </button>
                                                @else
                                                    @if($gender->deleted_at != null)
                                                        <button type="submit" class="btn btn-success btn-sm btn-restore" onclick="restore('{{ $gender->hashid }}')" title="{{ __('button.restore') }}">
                                                            <i class="fa fa-undo" style="pointer-events:none;"></i>
                                                        </button>
                                                        <button type="button" onclick="willRemove('{{ $gender->hashid }}', 'DESTROY')" class="btn btn-danger btn-sm btn-delete" id="btn-delete-{{ $loop->iteration }}" title="{{ __('button.remove') }}">
                                                            <i class="fa fa-trash" style="pointer-events:none;"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</section>
<form id="action-form" action="" method="post">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
</form>
@endsection

@push('more-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>      
    <script type="text/javascript">  
        @include('include.sweetalert-button-table')

        function execRemove(method, hashid) {            
            
            $("#action-form").attr('action', '/setting/gender/' + hashid);
            $("#action-form input[name=_method]").val(method);
            $("#action-form").submit();
            
        }

        function execEdit(method, hashid) {

            axios.get('/api/setting/gender/' + hashid).then(response => {
                var data = response.data;
                console.log(data[0].id);
                $("#title-form").text("{{ trans('app.edit') }} {{ trans('manage-setting.gender_setting.gender') }}")
                $("#theform").attr('action', '/setting/gender/' + hashid + '/edit');
                $("#theform input[name=_method]").val(method);
                $("#theform input[name=gender_name]").val(data[0].gender_name);
                $("#theform input[name=gender_language]").val(data[0].gender_language);
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");                
            });                                    
            
        }

        function restore (hashid) {
            $("#action-form").attr('action', '/setting/gender/' + hashid + "/restore");
            $("#action-form input[name=_method]").val("POST");
            $("#action-form").submit();
        };
    </script>
@endpush