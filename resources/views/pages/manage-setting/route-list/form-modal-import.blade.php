    <form action="{{ route('setting.route-list.import') }}" method="post" class="form-import" enctype="multipart/form-data">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal fade" id="modal-import" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="title-form" class="box-title">{{ trans('app.import') }} {{ trans('manage-setting.route_list.route_list') }}</h4>
                    </div>
                    <br>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="file" name="file_import" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('setting.route-list.export') }}" class="btn btn-sm btn-warning">{{ trans('app.download') }} {{ trans('app.template') }}</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
