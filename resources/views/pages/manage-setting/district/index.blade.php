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
        <li class="active"><a>{{ trans('manage-setting.district.district') }}</a></li>
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
                                <h3 class="box-title">{{ trans('manage-setting.district.district') }} {{ trans('manage-setting.setting') }}</h3>
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
                                    <h3 class="box-title" id="title-form">{{ trans('app.add_new') }} {{ trans('manage-setting.district.district') }}</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                            <i class="fa fa-minus"></i></button>
                                    </div>
                                    <div class="box-body">
                                        <form action="{{ route('setting.district.store') }}" method="post" class="form-setting-district" id='theform'>
                                            {{ csrf_field() }} {{ method_field('POST') }}
                                            <div class="row">
                                                <br>
                                                <div class="col-lg-10 col-12 col-md-offset-2">
                                                    <div class="form-group row">
                                                        <label for="province_id" class="col-md-2 col-form-label">{{ trans('manage-setting.province.province') }}<span class="text-danger">*</span></label>
                                                        <div class="col-md-5">
                                                            <select class="form-control select" name="province_id" id="province_id">
                                                                <option value="0">{{ trans('app.select') }}</option>
                                                                @foreach ($provinces as $province)
                                                                    <option class="{{$province->id}}" value="{{$province->id}}">{{$province->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                            <label for="city_id" class="col-md-2 col-form-label">{{ trans('manage-setting.city.city') }}<span class="text-danger">*</span></label>
                                                            <div class="col-md-5">
                                                                <select class="form-control select" name="city_id" id="city_id">
                                                                    <option value="0">{{ trans('manage-setting.district.choose_province') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-2 col-form-label">{{ trans('manage-setting.city.name') }}<span class="text-danger">*</span></label>
                                                        <div class="col-md-5">
                                                            <input class="form-control-app" type="text" id="name" name="name" value="" required>
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
                                    <a href="{{ route('setting.district.index') }}" class="{{ Request::get('status') == NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.all_data') }}
                                        <span class="badge badge-pill badge-info">{{ $district_count }}</span>
                                    </a>
                                    &nbsp; | &nbsp;
                                    <a href="{{ route('setting.district.index') }}?status=trash" class="{{ Request::get('status') != NULL ? 'text-green' : 'text-muted' }}">
                                        {{ __('app.trash') }}
                                        <span class="badge badge-pill badge-danger">{!! $trash->count() !!}</span>
                                    </a>
                                </div>
                                {{--  <div class="box-controls pull-right">
                                    <a href="{{ route('setting-user-role.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> {{ trans('app.add_new') }}</a>
                                    <button type="button" class="btn btn-sm btn-info" style="margin-right: 0.5rem" data-toggle="modal" data-target="#importFile">
                                        <i class="fa fa-file-excel-o" data-toggle="modal" data-target="#importFile"></i> Import Office Allowance
                                    </button>
                                </div>  --}}
                            </div>
                            <div class="box-body">
                                <table id="ajax-table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">{{ trans('manage-setting.district.district') }} {{ trans('manage-setting.city.name') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.city.city') }} {{ trans('manage-setting.city.name') }}</th>
                                            <th class="text-center">{{ trans('manage-setting.province.province') }} {{ trans('manage-setting.city.name') }}</th>
                                            <th class="text-center">{{ trans('app.action') }}</th>
                                        </tr>
                                    </thead>
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

        var city_id             = 0;
        var trash               = {{ $is_trash ? 1 : 0}};
        var ajax_table_url      = '/api/setting/district/alldata/' + trash;
        var ajax_table_columns  = [
            {data: 'name', name: 'districts.name'},
            {data: 'cityname', name: 'districts.city_id'},
            {data: 'provincename', name: 'districts.province_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ];
        var ajax_table_headers  = {'X-CSRF-TOKEN': '{{csrf_token()}}' };

        function execRemove(method, hashid) {
            $("#action-form").attr('action', '/setting/district/' + hashid);
            $("#action-form input[name=_method]").val(method);
            $("#action-form").submit();
        };

        function execEdit(method, hashid) {
            axios.get('/api/setting/district/' + hashid).then(response => {
                var data = response.data;
                {{--  Change Title Form  --}}
                $("#title-form").text("{{ trans('app.edit') }} {{ trans('manage-setting.district.district') }}")
                {{--  Change Form Action  --}}
                $("#theform").attr('action', '/setting/district/' + hashid + '/edit');
                {{--  Chang Form Method  --}}
                $("#theform input[name=_method]").val(method);
                {{--  Change Form Value  --}}
                $("#theform input[name=name]").val(data[0].name);
                $('#province_id').val(data[0].province_id).trigger('change');
                {{--  Change Form Button  --}}
                $("#button-form").text("{{ trans('app.edit') }}");
                document.getElementById("button-form").classList.remove("btn-success");
                document.getElementById("button-form").classList.add("btn-primary");

                city_id = data[0].city_id;
            });
        };

        function restore (hashid) {
            $("#action-form").attr('action', '/setting/district/' + hashid + "/restore");
            $("#action-form input[name=_method]").val("POST");
            $("#action-form").submit();
        };

    </script>
@endpush
