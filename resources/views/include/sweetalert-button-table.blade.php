    $(function(){
        $('#theform').submit(function(){
            $("button[type='submit']", this)
            .val("Processing")
            .attr('disabled', 'disabled');
            return true;
        });
    });

    function willRemove(id, method) {
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willDelete) {
            if (willDelete) {
                if (method === "DELETE")
                    execRemove('PATCH', id)
                else execRemove('DELETE', id)
            }
        });
    };

    function willEdit(id, method) {
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text_edit') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willEdit) {
            if (willEdit) {
                execEdit(method, id);
            }
        });
    };

    //Edit
    $('#ajax-table').on( 'click', 'button.btn-edit', function (e) {
        var id = $(this).attr('edit_id');
        var method = 'PUT';
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text_edit') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willEdit) {
            if (willEdit) {
                execEdit(method, id)
            }
        });
    });
    //Delete
    $('#ajax-table').on( 'click', 'button.btn-delete', function (e) {
        var id = $(this).attr('delete_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willDelete) {
            if (willDelete) {
                execRemove('PATCH', id)
            }
        });
    });
    //Restore
    $('#ajax-table').on( 'click', 'button.btn-restore', function (e) {
        var id = $(this).attr('restore_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text_restore') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willRestore) {
            if (willRestore) {
                restore(id)
            }
        });
    });
    $('#ajax-table').on( 'click', 'button.btn-destroy', function (e) {
        var id = $(this).attr('destroy_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willDelete) {
            if (willDelete) {
                execRemove('DELETE', id)
            }
        });
    });

    //Edit
    $('#ajax-table-no-server-side').on( 'click', 'button.btn-edit', function (e) {
        var id = $(this).attr('edit_id');
        var method = 'PUT';
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text_edit') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willEdit) {
            if (willEdit) {
                execEdit(method, id)
            }
        });
    });
    //Delete
    $('#ajax-table-no-server-side').on( 'click', 'button.btn-delete', function (e) {
        var id = $(this).attr('delete_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willDelete) {
            if (willDelete) {
                execRemove('PATCH', id)
            }
        });
    });
    //Restore
    $('#ajax-table-no-server-side').on( 'click', 'button.btn-restore', function (e) {
        var id = $(this).attr('restore_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text_restore') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willRestore) {
            if (willRestore) {
                restore(id)
            }
        });
    });
    $('#ajax-table-no-server-side').on( 'click', 'button.btn-destroy', function (e) {
        var id = $(this).attr('destroy_id');
        swal({
            title: "{{ __('app.sweetalert.title') }}",
            text: "{{ __('app.sweetalert.text') }}",
            icon: "warning",
            buttons: ["{{ __('app.sweetalert.btn-cancel') }}", "{{ __('app.sweetalert.btn-ok') }}"]
        }).then(function(willDelete) {
            if (willDelete) {
                execRemove('DELETE', id)
            }
        });
    });
