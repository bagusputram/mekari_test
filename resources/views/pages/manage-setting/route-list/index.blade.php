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
                                <h3 class="box-title">{{ trans('manage-setting.route_list.route_list') }} {{ trans('manage-setting.setting') }}</h3>
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
                                    <a href="{{ route('setting.route-list.index') }}" class="{{ Request::get('status') == NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.all_data') }}
                                        <span class="badge badge-pill badge-info">{{ $route_list_count }}</span>
                                    </a>
                                    &nbsp; | &nbsp;
                                    <a href="{{ route('setting.route-list.index') }}?status=trash" class="{{ Request::get('status') != NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.trash') }}
                                        <span class="badge badge-pill badge-danger">{!! $trash->count() !!}</span>
                                    </a>
                                </div>
                                <div class="box-controls pull-right">
                                    <button onclick="refreshForm()" type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-form"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</button>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-import"><i class="fa fa-file-excel-o"></i> {{ trans('app.import') }}</button>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="data-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_list') }}
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_controller_type_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_type_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.menu_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.menu_type_id') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_menu_name') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_controller_name') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.route_list.route_link') }}</th>
                                            <th class="text-center min-width-action">{{ trans('app.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($route_lists as $route_list)
                                        <tr>
                                            <td>{{ $route_list->name }}</td>
                                            <td>{{ $route_list->RouteControllerType->name }}</td>
                                            <td>{{ $route_list->RouteType->name }}</td>
                                            <td>{{ ($route_list->Menu) ? $route_list->Menu->menu_name : 'Deleted' }}</td>
                                            <td>{{ $route_list->MenuType->name }}</td>
                                            <td>{{ $route_list->route_menu_name }}</td>
                                            <td>{{ $route_list->route_controller_name }}</td>
                                            <td>{{ $route_list->route_link }}</td>
                                            <td class="text-center">
                                                @if( $route_list->deleted_at == null )
                                                    <button type="button" onclick="willEdit('{{ $route_list->hashid }}', 'PUT')" class="btn btn-primary btn-sm btn-edit" id="btn-edit-{{ $loop->iteration }}" title="{{ __('app.edit') }}">
                                                        <i class="fa fa-pencil" style="pointer-events:none;"></i>
                                                    </button>
                                                    <button type="button" onclick="willRemove('{{ $route_list->hashid }}', 'DELETE')" class="btn btn-danger btn-sm btn-delete" id="btn-delete-{{ $loop->iteration }}" title="{{ __('button.remove') }}">
                                                        <i class="fa fa-trash" style="pointer-events:none;"></i>
                                                    </button>
                                                @else
                                                    @if($route_list->deleted_at != null)
                                                        <button type="submit" class="btn btn-success btn-sm btn-restore" onclick="restore('{{ $route_list->hashid }}')" title="{{ __('button.restore') }}">
                                                            <i class="fa fa-undo" style="pointer-events:none;"></i>
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

@include('pages.manage-setting.route-list.form-modal')
@include('pages.manage-setting.route-list.form-modal-import')

@endsection

@push('more-js')
    {{--  Select 2 js  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript">
        @include('include.sweetalert-button-table')

        function refreshForm(){
            {{--  Change Title Form  --}}
            $("#title-form").text("{{ trans('app.add_new') }} {{ trans('manage-setting.route_list.route_list') }}")
            {{--  Change Form Action  --}}
            $("#theform").attr('action', '/setting/route-list');
            {{--  Change Form Method  --}}
            $("#theform input[name=_method]").val('POST');
            {{--  Change Form Data  --}}
            $("#theform input[name=name]").val('');
            $('#route_controller_type_id').val(0).trigger('change');
            $('#route_type_id').val(0).trigger('change');
            $('#menu_id').val(0).trigger('change');
            $('#menu_type_id').val(0).trigger('change');
            $("#theform input[name=route_controller_name]").val('');
            $("#theform input[name=route_menu_name]").val('');
            $("#theform input[name=route_link]").val('');
            {{--  Change Form Button and Class  --}}
            $("#button-form").text("{{ trans('app.save') }}");
            document.getElementById("button-form").classList.remove("btn-primary");
            document.getElementById("button-form").classList.add("btn-success");
        };

        function execRemove(method, hashid) {
            $("#action-form").attr('action', '/setting/route-list/' + hashid);
            $("#action-form input[name=_method]").val(method);
            $("#action-form").submit();
        };

        function execEdit(method, hashid) {
            axios.get('/api/setting/route-list/' + hashid).then(response => {
                var data = response.data;
                {{--  Change Title Form  --}}
                $("#title-form").text("{{ trans('app.edit') }} {{ trans('manage-setting.gender_setting.gender') }}")
                {{--  Change Form Action  --}}
                $("#theform").attr('action', '/setting/route-list/' + hashid + '/edit');
                {{--  Change Form Method  --}}
                $("#theform input[name=_method]").val(method);
                {{--  Change Form Data  --}}
                $("#theform input[name=name]").val(data[0].name);
                $('#route_controller_type_id').val(data[0].route_controller_type_id).trigger('change');
                $('#route_type_id').val(data[0].route_type_id).trigger('change');
                $('#menu_id').val(data[0].menu_id).trigger('change');
                $('#menu_type_id').val(data[0].menu_type_id).trigger('change');
                $("#theform input[name=route_controller_name]").val(data[0].route_controller_name);
                $("#theform input[name=route_menu_name]").val(data[0].route_menu_name);
                $("#theform input[name=route_link]").val(data[0].route_link);
                {{--  Change Form Button Text and Class  --}}
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");
                {{--  Show Modal  --}}
                $('#modal-form').modal('show');
            });

        };

        function restore (hashid) {
            $("#action-form").attr('action', '/setting/route-list/' + hashid + "/restore");
            $("#action-form input[name=_method]").val("POST");
            $("#action-form").submit();
        };
    </script>
@endpush
