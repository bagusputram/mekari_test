<form action="{{ route('setting.route-list.store') }}" method="post" class="form-route-list form-route-list-update" id="theform">
    {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal fade" id="modal-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-form" class="box-title">{{ trans('app.add_new') }} {{ trans('manage-setting.route_list.route_list') }}</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.name') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="name" name="name" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="route_controller_type_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.route_controller_type_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="route_controller_type_id" id="route_controller_type_id">
                                <option value="0">{{ trans('app.select') }}</option>
                                @foreach ($route_controller_types as $route_controller_type)
                                    <option class="select-font" value="{{$route_controller_type->id}}">{{$route_controller_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="route_type_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.route_type_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="route_type_id" id="route_type_id">
                                <option value="0">{{ trans('app.select') }}</option>
                                @foreach ($route_types as $route_type)
                                    <option class="select-font" value="{{$route_type->id}}">{{$route_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.menu_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="menu_id" id="menu_id">
                                <option value="0">{{ trans('app.select') }}</option>
                                @foreach ($menus as $menu)
                                    <option class="select-font" value="{{$menu->id}}">{{$menu->menu_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_type_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.menu_type_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="menu_type_id" id="menu_type_id">
                                <option value="0">{{ trans('app.select') }}</option>
                                @foreach ($menu_types as $menu_type)
                                    <option class="select-font" value="{{$menu_type->id}}">{{$menu_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="route_controller_name" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.route_controller_name') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="route_controller_name" name="route_controller_name" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="route_link" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.route_link') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="route_link" name="route_link" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="route_menu_name" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.route_list.route_menu_name') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="route_menu_name" name="route_menu_name" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="button-form" type="submit" class="btn btn-md btn-success pull-right form-modal">{{ trans('app.save') }}</button>
                    <button class="btn btn-md btn-default pull-right form-modal" data-dismiss="modal">{{ trans('app.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
