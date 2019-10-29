<form action="{{ route('user-management.store') }}" method="post" class="form-user-management form-user-management-update" id="theform">
    {{ csrf_field() }} {{ method_field('POST') }}
    <div class="modal fade" id="modal-form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-form" class="box-title">{{ trans('app.add_new') }} {{ trans('user-management.user') }}</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.name') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="name" name="name" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.email') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="email" id="email" name="email" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.username') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="text" id="username" name="username" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.password') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="password" id="password" name="password" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_confirmation" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.password_confirmation') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <input class="form-control-app" type="password" id="password_confirmation" name="password_confirmation" value="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_role_id" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('user-management.user-role') }}<span class="text-danger">*</span></label>
                        <div class="col-10 col-md-7">
                            <select class="form-control select" name="user_role_id" id="user_role_id">
                                <option value="">{{ trans('user-management.select-user-role') }}</option>
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