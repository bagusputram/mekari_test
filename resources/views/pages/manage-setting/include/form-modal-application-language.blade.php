<form action="{{ route('setting.application-language.update', ['id' => $application_language->hashid]) }}" method="post" class="form-application-language form-application-language" id="theform-application-language">
    {{ csrf_field() }} {{ method_field('PUT') }}
    <div class="modal fade" id="modal-form-application-language" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-form-application-language" class="box-title">{{ trans('app.edit') }} {{ trans('manage-setting.application_language') }}</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="application_language" class="col-md-offset-1 col-md-2 col-form-label">{{ trans('manage-setting.application_language') }}<span class="text-danger">*</span></label>
                            <div class="col-10 col-md-7">
                                <select class="form-control select" name="application_language" id="application_language">
                                    <option value="0">{{ trans('manage-setting.application_language') }}</option>
                                    @foreach ($languages as $language)
                                        <option class="select-font" value="{{$language->id}}" {{ $language->id == $application_language->language ? 'selected' : '' }}>{{$language->language_name}}</option>
                                    @endforeach
                                </select>
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