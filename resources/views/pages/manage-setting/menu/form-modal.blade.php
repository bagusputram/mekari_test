<form action="{{ route('setting.menu.store') }}" method="post" class="form-officeallowance form-officeallowance-update" id="theform">
    {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal fade" id="modal-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-form" class="box-title">{{ trans('app.add_new') }} {{ trans('manage-setting.menu_setting.menu') }}</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="menu_name" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_name') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="menu_name" name="menu_name" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_language" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_language') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="menu_language" name="menu_language" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_icon" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_icon') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="menu_icon" name="menu_icon" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_controller" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_controller') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="menu_controller" name="menu_controller" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_position" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_position') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="number" min="1" id="menu_position" name="menu_position" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="menu_parent_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.menu_parent_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="menu_parent_id" id="menu_parent_id">
                                <option value="0">{{ trans('manage-setting.menu_setting.no_parent') }}</option>
                                @foreach ($menus as $menu)
                                    <option class="select-font" value="{{$menu->id}}">{{$menu->menu_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_role_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.menu_setting.user_role_id') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="user_role_id[]" id="user_role_id" multiple>
                                @foreach ($user_roles as $user_role)
                                    <option value="{{$user_role->id}}">{{$user_role->user_role_name}}</option>
                                @endforeach
                            </select>
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