<form action="{{ route('setting.session-timeout.update', ['id' => $session_timeout->hashid]) }}" method="post" class="form-session-timeout form-session-timeout" id="theform-session-timeout">
    {{ csrf_field() }} {{ method_field('PUT') }}
    <div class="modal fade" id="modal-form-session-timeout" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-form-session-timeout" class="box-title">{{ trans('app.edit') }} {{ trans('manage-setting.session_timeout.session_timeout') }}</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="session_timeout" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.session_timeout.session_timeout') }}<span class="text-danger">*</span></label>
                            <div class="col-10 col-md-7">
                                <input class="form-control-app" type="number" min="0" id="session_timeout" name="session_timeout" value="{{ $session_timeout->session_timeout }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-offset-1 col-md-2 col-form-label"></div>
                            <div class="col-10 col-md-7">
                                <p>{{ trans('manage-setting.session_timeout.message') }}</p>
                                <p>{{ trans('manage-setting.session_timeout.message2') }}</p>
                            </div>                                
                        </div>
                    </div>                        
                </div>
                <div class="modal-footer">
                    <button id="button-form" type="submit" class="btn btn-md btn-primary pull-right form-modal">{{ trans('app.edit') }}</button>
                    <button class="btn btn-md btn-default pull-right form-modal" data-dismiss="modal">{{ trans('app.close') }}</button>                    
                </div>
            </div>
        </div>
    </div>
</form>