@extends('layouts.app')

@section('main-content')
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'To Do List')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/')}}"><i class="fa fa-dashboard"></i> {{ trans('message.home') }}</a></li>
        {!! getBreadCrumb($data['current_route']->id) !!}
    </ol>
</section>
<section class="content">
    <!-- Messages -->
    @include('messages.message')

	<div class="container-fluid spark-screen">
		<div class="row">            
            {{-- Form Save --}}
            {{-- Checker If user Can Add --}}
            @if ( allowButton($data['current_route']->menu_id, Auth::user()->user_role_id, 4) )
                <div class="col-lg-12 col-12">
                    <div class="box">
                        <div class="tab-content tab-content-company">
                            <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                                <div class="box-header">
                                    <h3 class="box-title" id="title-form">{{ trans('app.add_new') }} Task</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fa fa-minus"></i></button>
                                    </div>
                                    <div class="box-body">
                                        <form action="{{ route('to-do-list.store') }}" method="post" class="form-setting-gender" id='theform'>
                                            {{ csrf_field() }} {{ method_field('POST') }}
                                            <br>
                                            <div class="row">                                                
                                                <div class="col-lg-10 col-12 col-md-offset-2">
                                                    <div class="form-group row">
                                                        <label for="task" class="col-md-2 col-form-label">Task<span class="text-danger">*</span></label>
                                                        <div class="col-md-5">
                                                            <input class="form-control-app" type="text" id="task" name="task" value="{{ old('task') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10 col-12 col-md-offset-2">
                                                    <div class="form-group row">
                                                        <label for="button" class="col-md-2 col-form-label"></span></label>
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
            @endif
            <div class="col-lg-12 col-12">
                <div class="box">
                    <div class="tab-content tab-content-company">
                        <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                            <div class="box-header with-border">
                                <div class="table-filter" style="display:inline-block">
                                    <a href="{{ route('to-do-list.index') }}" class="{{ Request::get('status') == NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.all_data') }}
                                        <span class="badge badge-pill badge-info">{{ $data['count_data'] }}</span>
                                    </a>
                                    &nbsp; | &nbsp;
                                    <a href="{{ route('to-do-list.index') }}?status=trash" class="{{ Request::get('status') != NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.trash') }}
                                        <span class="badge badge-pill badge-danger">{!! $data['count_trash'] !!}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <table id="ajax-table-no-server-side" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Task</th>
                                            <th class="text-center">Created By</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Modified By</th>
                                            <th class="text-center">Modified At</th>                                            
                                            <th class="text-center">{{ trans('app.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    <script type="text/javascript">
        @include('include.sweetalert-button-table')

        var trash               = {{ $data['is_trash'] ? 1 : 0}};
        var ajax_table_url      = '/api/to-do-list/alldata/' + trash;
        var ajax_table_headers  = {'X-CSRF-TOKEN': '{{csrf_token()}}' };
        var ajax_table_columns  = [
            {data: 'task', name: 'task'},            
            {data: 'creator', name: 'creator'},
            {data: 'created_at_format', name: 'created_at_format'},
            {data: 'modifier', name: 'modifier'},
            {data: 'modified_at_format', name: 'modified_at_format'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: "text-center"}
        ];

        function execRemove(method, hashid) {
            $("#action-form").attr('action', '/to-do-list/' + hashid);
            $("#action-form input[name=_method]").val(method);
            $("#action-form").submit();
        }

        function execEdit(method, hashid) {
            axios.get('/api/to-do-list/singledata/' + hashid).then(response => {
                var data = response.data;
                console.log(data);
                {{--  Change Title Form  --}}
                $("#title-form").text("{{ trans('app.edit') }} Task")
                {{--  Change Form Action  --}}
                $("#theform").attr('action', '/to-do-list/' + hashid + '/edit');
                {{--  Chang Form Method  --}}
                $("#theform input[name=_method]").val(method);
                {{--  Change Form Value  --}}
                $("#theform input[name=task]").val(data.task);                
                {{--  Change Form Button  --}}
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");
            });
        };

        function restore (hashid) {
            $("#action-form").attr('action', '/to-do-list/' + hashid + "/restore");
            $("#action-form input[name=_method]").val("POST");
            $("#action-form").submit();
        };
    </script>
@endpush
