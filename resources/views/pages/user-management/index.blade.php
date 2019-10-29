@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>        
        <li class="active"><a href="#">{{ trans('manage-setting.menu_setting.menu') }}</a></li>
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
                                <h3 class="box-title">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.setting') }}</h3>
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
                                    <a href="{{ route('setting.menu.index') }}" class="{{ Request::get('status') == NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.all_data') }}
                                        <span class="badge badge-pill badge-info">{{ $user_count }}</span>
                                    </a>                                    
                                </div>
                                <div class="box-controls pull-right">
                                    @if(in_array('create',$allowed_button))
                                    <button onclick="refreshForm()" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-form"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</button>
                                    @endif
                                    {{-- <a href="{{ route('user-management.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</a> --}}
                                    {{--  <button type="button" class="btn btn-sm btn-info" style="margin-right: 0.5rem" data-toggle="modal" data-target="#importFile">
                                        <i class="fa fa-file-excel-o" data-toggle="modal" data-target="#importFile"></i> Import Office Allowance
                                    </button>  --}}
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="data-table" class="table table-bordered table-hover">
                                    <thead class="filter-table">
                                        <tr>                                        
                                            <th class="text-center">{{ trans('user-management.name') }}</th>
                                            <th class="text-center">{{ trans('user-management.email') }}</th>
                                            <th class="text-center">{{ trans('user-management.username') }}</th>
                                            <th class="text-center">{{ trans('user-management.created_at') }}</th>
                                            <th class="text-center">{{ trans('user-management.updated_at') }}</th>
                                            <th class="text-center">{{ trans('user-management.auth_last_login') }}</th>
                                            <th class="text-center">{{ trans('user-management.user-role') }}</th>
                                            <th class="text-center min-width-action">{{ trans('app.action') }}</th>
                                        </tr>
                                    </thead>                                    
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ changeTimestampFormat($user->created_at) }}</td>
                                            <td>{{ changeTimestampFormat($user->updated_at) }}</td>
                                            <td>{{ changeTimestampFormat($user->auth_last_login) }}</td>
                                            <td>{{ $user->userRole->user_role_name }}</td>
                                            <td class="text-center">                                                
                                                @if(in_array('edit',$allowed_button))
                                                <button type="button" onclick="willEdit('{{ $user->hashid }}', 'PUT')" class="btn btn-primary btn-sm btn-edit" id="btn-edit-{{ $loop->iteration }}" title="{{ __('app.edit') }}">
                                                    <i class="fa fa-pencil" style="pointer-events:none;"></i>
                                                </button>
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

@include('pages.user-management.form-modal')

@endsection

@push('more-js')
    {{--  Select 2 js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>      
    <script type="text/javascript">  
        @include('include.sweetalert-button-table')

        function refreshForm(){
            $("#title-form").text("{{ trans('app.add_new') }} {{ trans('user-management.user') }}")
            $("#theform").attr('action', '/user-management');
            $("#theform input[name=_method]").val('POST');
            $("#theform input[name=name]").val('');
            $("#theform input[name=email]").val('');
            $("#theform input[name=username]").val('');
            $('#user_role_id').val('').trigger('change');
            $("#theform input[name=password]").prop('required',true);
            $("#theform input[name=password_confirmation]").prop('required',true);
            $("#button-form").text("{{ trans('app.save') }}");            
            document.getElementById("button-form").classList.remove("btn-primary");
            document.getElementById("button-form").classList.add("btn-success");
            $('#modal-form').modal('show');
        };

        function execEdit(method, hashid) {            
            axios.get('/api/user-management/' + hashid).then(response => {                
                var data = response.data;
                console.log(data);                                
                $("#title-form").text("{{ trans('app.edit') }} {{ trans('user-management.user') }}")
                $("#theform").attr('action', 'user-management/' + hashid + '/edit');
                $("#theform input[name=_method]").val(method);
                $("#theform input[name=name]").val(data[0].name);
                $("#theform input[name=email]").val(data[0].email);
                $("#theform input[name=username]").val(data[0].username);
                $("#theform input[name=password]").removeAttr('required');
                $("#theform input[name=password_confirmation]").removeAttr('required');
                $('#menu_parent_id').val(data[0].menu_parent_id).trigger('change');                
                $('#user_role_id').val(data[0].user_role_id).trigger('change');                
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");
                $('#modal-form').modal('show');
            });
            
        };        
    </script>
@endpush