@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', '')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        <li class="active"><a href="{{ route('setting.restricted-setting.index')}}">{{ trans('manage-setting.restricted') }} {{ trans('manage-setting.setting') }}</a></li>
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
                                        <span class="badge badge-pill badge-info">{{ $menu_count }}</span>
                                    </a>
                                    &nbsp; | &nbsp;
                                    <a href="{{ route('setting.menu.index') }}?status=trash" class="{{ Request::get('status') != NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.trash') }}
                                        <span class="badge badge-pill badge-danger">{!! $trash->count() !!}</span>
                                    </a>
                                </div>
                                <div class="box-controls pull-right">
                                    @if(in_array('create',$allowed_button))
                                        <button onclick="refreshForm()" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-form"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</button>
                                    @endif
                                    {{-- <a href="{{ route('setting.menu.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</a> --}}
                                    {{--  <button type="button" class="btn btn-sm btn-info" style="margin-right: 0.5rem" data-toggle="modal" data-target="#importFile">
                                        <i class="fa fa-file-excel-o" data-toggle="modal" data-target="#importFile"></i> Import Office Allowance
                                    </button>  --}}
                                </div>
                            </div>
                            <div class="box-body table-responsive">
                                <table id="data-table" class="table table-bordered table-hover">
                                    <thead class="filter-table">
                                        <tr>
                                            <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.menu_name') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.menu_language') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.menu_parent_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.user_role_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.menu_position') }}</th>
                                            <th class="text-center min-width-action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->menu_name }}</td>
                                            <td>{{ $menu->menu_language }}</td>
                                            <td>{{ ($menu->menu_parent_id != null) ? $menu->parent->menu_name : '-'}}</td>
                                            <td>
                                                @foreach ($user_roles as $user_role)
                                                    @if (in_array($user_role->id,json_decode($menu->user_role_id)))
                                                        {{ $user_role->user_role_name }}
                                                        <br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $menu->menu_position }}</td>
                                            <td class="text-center">
                                                @if( $menu->deleted_at == null )
                                                    @if(in_array('edit',$allowed_button))
                                                    <button type="button" onclick="willEdit('{{ $menu->hashid }}', 'PUT')" class="btn btn-primary btn-sm btn-edit" id="btn-edit-{{ $loop->iteration }}" title="{{ __('app.edit') }}">
                                                        <i class="fa fa-pencil" style="pointer-events:none;"></i>
                                                    </button>
                                                    @endif
                                                    @if(in_array('delete',$allowed_button))
                                                    <button type="button" onclick="willRemove('{{ $menu->hashid }}', 'DELETE')" class="btn btn-danger btn-sm btn-delete" id="btn-delete-{{ $loop->iteration }}" title="{{ __('button.remove') }}">
                                                        <i class="fa fa-trash" style="pointer-events:none;"></i>
                                                    </button>
                                                    @endif
                                                @else
                                                    @if($menu->deleted_at != null)
                                                        @if(in_array('restore',$allowed_button))
                                                        <button type="submit" class="btn btn-success btn-sm btn-restore" onclick="restore('{{ $menu->hashid }}')" title="{{ __('button.restore') }}">
                                                            <i class="fa fa-undo" style="pointer-events:none;"></i>
                                                        </button>
                                                        @endif
                                                        @if(in_array('destroy',$allowed_button))
                                                        <button type="button" onclick="willRemove('{{ $menu->hashid }}', 'DESTROY')" class="btn btn-danger btn-sm btn-delete" id="btn-delete-{{ $loop->iteration }}" title="{{ __('button.remove') }}">
                                                            <i class="fa fa-trash" style="pointer-events:none;"></i>
                                                        </button>
                                                        @endif
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

@include('pages.manage-setting.menu.form-modal')

@endsection

@push('more-js')
    {{--  Select 2 js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
        @include('include.sweetalert-button-table')

        function refreshForm(){
            $("#title-form").text("{{ trans('app.add_new') }} {{ trans('manage-setting.menu_setting.menu') }}")
            $("#theform").attr('action', '/setting/menu');
            $("#theform input[name=_method]").val('POST');
            $("#theform input[name=menu_name]").val('');
            $("#theform input[name=menu_language]").val('');
            $("#theform input[name=menu_icon]").val('');
            $("#theform input[name=menu_controller]").val('');
            $("#theform input[name=menu_position]").val('');
            $('#menu_parent_id').val(0).trigger('change');
            $('menu_parent_id').val(0).trigger('change');
            $("#button-form").text("{{ trans('app.save') }}");
            document.getElementById("button-form").classList.remove("btn-primary");
            document.getElementById("button-form").classList.add("btn-success");
            // $('#modal-form').modal('show');
        };

        function execRemove(method, hashid) {
            $("#action-form").attr('action', '/setting/menu/' + hashid);
            $("#action-form input[name=_method]").val(method);
            $("#action-form").submit();
        };

        function execEdit(method, hashid) {
            axios.get('/api/setting/menu/' + hashid).then(response => {
                var data = response.data;
                var show_in = (data[0].user_role_id) ? JSON.parse(data[0].user_role_id) : '';
                $("#title-form").text("{{ trans('app.edit') }} {{ trans('manage-setting.menu_setting.menu') }}")
                $("#theform").attr('action', '/setting/menu/' + hashid + '/edit');
                $("#theform input[name=_method]").val(method);
                $("#theform input[name=menu_name]").val(data[0].menu_name);
                $("#theform input[name=menu_language]").val(data[0].menu_language);
                $("#theform input[name=menu_icon]").val(data[0].menu_icon);
                $("#theform input[name=menu_controller]").val(data[0].menu_controller);
                $("#theform input[name=menu_position]").val(data[0].menu_position);
                $('#menu_parent_id').val(data[0].menu_parent_id).trigger('change');
                $('#user_role_id').val(show_in).trigger('change');
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");
                $('#modal-form').modal('show');
            });
        };

        function restore (hashid) {
            $("#action-form").attr('action', '/setting/menu/' + hashid + "/restore");
            $("#action-form input[name=_method]").val("POST");
            $("#action-form").submit();
        };
    </script>
@endpush
