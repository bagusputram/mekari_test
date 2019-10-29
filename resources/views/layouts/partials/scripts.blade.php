<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
      {{--  JQuery JS  --}}
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      @stack('more-js-2')
      {{-- Popper --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
      {{--  Bootstrap Js  --}}
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
      {{--  Apllication JS  --}}
      <script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
      {{--  Jquery Validate Js  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
      {{--  Timezone  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone.min.js"></script>
      {{--  Datatable Js  --}}
      <script src = "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.0/jszip.min.js" ></script>
      <script src = "http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" ></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.js"></script>
      <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
      <script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>
      <script src="https://cdn.datatables.net/scroller/2.0.0/js/scroller.foundation.min.js"></script>
      <script src="https://cdn.datatables.net/scroller/2.0.0/js/dataTables.scroller.min.js"></script>
      {{--  DateTime Picker  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
      

      {{-- Summernote JS --}}
      <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>

      {{-- Select 2 Js --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
      {{--  Sweet Alert  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

      {{--  TagInput JS  --}}
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/typeahead.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.2.1/bloodhound.min.js"></script>

      <script> 
            var ordering = @php echo !empty($ordering) ? 'false' : 'true' @endphp;
            var serverside = @php echo !empty($serverside) ? 'true' : 'false' @endphp;
            var processing = @php echo !empty($processing) ? 'true' : 'false' @endphp;
            var header = @php echo !empty($header) ? 'false' : 'true' @endphp;
      </script>
      <script src="{{asset('js/main.js')}}"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
