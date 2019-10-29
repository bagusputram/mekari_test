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
        <li class="active"><a href="{{ route('setting.user-role.index')}}">{{ trans('manage-setting.role_setting.role') }}</a></li>
        <li class="active"><a>{{ trans('manage-setting.user-menu-permission.user-menu-permission') }}</a></li>
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
                                <h3 class="box-title">{{ trans('manage-setting.user-menu-permission.user-menu-permission') }} {{ trans('manage-setting.setting') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('setting.user-menu-permission.update', ['id' => $user_role[0]->hashid]) }}" method="post" class="form-officeallowance form-officeallowance-update" id="theform">
            {{ csrf_field() }} {{ method_field('PATCH') }}
                <div class="col-lg-12 col-12">
                    <div class="box">
                        <div class="tab-content tab-content-company">
                            <div class="tab-pane tab-main active" id="tab-company" role="tabpanel">
                                <div class="box-body">
                                    <h4>{{ $user_role[0]->user_role_name }}</h4>
                                    <br>
                                    <table id="user-permission-table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{ trans('manage-setting.menu_setting.menu') }} {{ trans('manage-setting.menu_setting.menu_name') }}</th>
                                                @foreach ($menu_types as $menu_type)
                                                    <th class="text-center">{{ $menu_type->name }}</th>
                                                @endforeach
                                                <th>Check All</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($menus as $menu)
                                            <tr>
                                                <td>{{ $menu->menu_name}}</td>
                                                @foreach ($menu_types as $menu_type)
                                                    @if(in_array($menu->menu_language.'.'.$menu_type->name,$is_true))
                                                        <th class="text-center"><input class="form-control-app checkboxtext aCheckbox" checked type="checkbox" name="permission[]" value="{{$menu->menu_language}}.{{$menu_type->name}}" /></th>
                                                    @else
                                                        <th class="text-center"><input class="form-control-app checkboxtext aCheckbox" type="checkbox" name="permission[]" value="{{$menu->menu_language}}.{{$menu_type->name}}" /></th>
                                                    @endif
                                                @endforeach
                                                <th class="text-center"><input class="form-control-app checkboxtext selectAll" type="checkbox"/></th>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <button id="button-form" type="submit" class="btn btn-md btn-success pull-right form-modal">{{ trans('app.save') }}</button>
                </div>
            </form>
		</div>
	</div>
</section>
@endsection

@push('more-js')
    {{-- Select 2 Js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    {{--  Sweet Alert  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- Other JS --}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#user-permission-table').DataTable({
                bAutoWidth: false,
                aaSorting: [],
                sScrollX: '100%',
                sScrollXInner: '120%',
                bScrollCollapse: true,
                paging: false,
                bFilter: false,
                bInfo: false
            });

            $('table').on('change', '.selectAll', function (e) {
                $(this).closest('tr').find(".aCheckbox").prop('checked', this.checked);
            });
        });
    </script>
@endpush
