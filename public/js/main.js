$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); },    
});

axios.interceptors.request.use(function (config) {
  // spinning start to show
  // UPDATE: Add this code to show global loading indicator
    $body.addClass("loading");

    const token = window.localStorage.token;
    if (token) {
        config.headers.Authorization = `token ${token}`
    }
    return config}, function (error) {
        return Promise.reject(error);
});

axios.interceptors.response.use(function (response) {

  // spinning hide
  // UPDATE: Add this code to hide global loading indicator
  $body.removeClass("loading");

  return response;
}, function (error) {
  return Promise.reject(error);
});


$(document).ready(function() {
    //DataTable for non Ajax data
    // Setup - add a text input to each footer cell
    $('#data-table thead tr').clone(true).appendTo( '#data-table thead' );
    $('#data-table thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        if( title != 'Action'){
            $(this).html( '<input class="filter" type="text" placeholder="Type to Filter" />' );
        }
        else(
            $(this).html( '<th></th>' )
        )
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        });
    });

    var table = $('#data-table').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        bAutoWidth: false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis',
        ],
        "aaSorting": [],


        // "bProcessing": true,
        // "bServerSide": true,
        // "sAjaxSource": "http://127.0.0.1/table.php"   ,

        //,
        //"sScrollY": "200px",
        //"bPaginate": false,
        //"processing": true,
        //"serverSide": true,

        "sScrollX": "100%",
        "scrollY": "400px",
        "bScrollCollapse": true,
        //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
        //you may want to wrap the table inside a "div.dataTables_borderWrap" element

        //"iDisplayLength": 50


        // select: {
        //     style: 'multi'
        // },
    });
    //

    // DataTable for AJAX Style using ajax-table id
    if(document.getElementById("ajax-table")){
        $('#ajax-table thead tr').clone(true).appendTo( '#ajax-table thead' );
        $('#ajax-table thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            if( title != 'Action'){
                $(this).html( '<input class="filter" type="text" placeholder="Type to Filter" />' );
            }
            else(
                $(this).html( '<th></th>' )
            )
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
                //console.log(table.column(i).search( this.value ));
            });
        });

        var table = $('#ajax-table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            processing: true,
            serverSide: true,
            sScrollX: "100%",
            sScrollXInner: "120%",
            bScrollCollapse: true,
            dom: 'Bfrtip',
            // scrollY: 500,
            // deferRender: true,
            // scroller: {
            //     loadingIndicator: true
            // },
            buttons: [
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis',
            ],
            ajax: {
                url: ajax_table_url,
                headers: ajax_table_headers,
            },
            oLanguage: {"sProcessing": "<div id='loader'></div>"},
            columns: ajax_table_columns,
        });
    }
    //

    // DataTable for using API
    if(document.getElementById("ajax-table-no-server-side")){        
        if( header === true ){
            $('#ajax-table-no-server-side thead tr').clone(true).appendTo( '#ajax-table-no-server-side thead' );
            $('#ajax-table-no-server-side thead tr:eq(1) th').each( function (i) {            
                var title = $(this).text();
                if( title != 'Action'){
                    if( title === 'No' ){
                        $(this).html( '' );
                    } else if( title === 'Aksi') {
                        $(this).html( '' );                    
                    } else {
                        $(this).html( '<input class="filter" type="text" placeholder="Type to Filter" />' );
                    }
                }
                else(
                    $(this).html( '<th></th>' )
                )
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                    //console.log(table.column(i).search( this.value ));
                });
            });
        }        

        var table = $('#ajax-table-no-server-side').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            processing: processing,
            serverSide: serverside,
            sScrollX: "100%",
            sScrollXInner: "120%",
            // bScrollCollapse: true,
            dom: 'Bfrtip',
            ordering: ordering,
            scrollY: 450,
            // deferRender: true,
            // scroller: {
            //     loadingIndicator: true
            // },
            buttons: [
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis',
            ],
            ajax: {
                url: ajax_table_url,
                headers: ajax_table_headers,
            },
            oLanguage: {"sProcessing": "<div id='loader'></div>"},
            columns: ajax_table_columns,
        }).on( 'draw.dt', function () {
            // $($.fn.dataTable.tables(true)).css('width', '100%');
            // $($.fn.dataTable.tables(true)).DataTable().columns.adjust().responsive.recalc();;
        } );;
    }
    //

    // Resize Search Field Width and make select to be select2
    $('.select2-search__field').width("100%")
    $(".select").select2({
        templateResult: function (data, container) {
          if (data.element) {
            $(container).addClass($(data.element).attr("class"));
          }
          return data.text;
        }
      });

    //

    //Auto Resize Datatable
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).css('width', '100%');
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
    });

    window.onload = function() {
        $($.fn.dataTable.tables(true)).css('width', '100%');
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
    };
    //

    // Filter Indonesia Area
    $('#province_id').change(function () {
        province_id = $('#province_id').val();
        axios.get('/api/setting/city/' + province_id +'/filter-province').then(response => {
            var datas = response.data;
            $('#city_id option').remove()
            datas.forEach(data => {
                $('#city_id').append($('<option>', {value:data.id, text:data.name}));
            });
            if(city_id != 0){
                $('#city_id').val(city_id).trigger('change');
            }
        });
    });

    $('#city_id').change(function () {
        city_id = $('#city_id').val();
        axios.get('/api/setting/district/' + city_id +'/filter-city').then(response => {
            var datas = response.data;
            $('#district_id option').remove()
            datas.forEach(data => {
                $('#district_id').append($('<option>', {value:data.id, text:data.name}));
            });
            if(district_id != 0){
                $('#district_id').val(district_id).trigger('change');
            }
        });
    });


    $('#district_id').change(function () {
        district_id = $('#district_id').val();
        axios.get('/api/setting/subdistrict/' + district_id +'/filter-district').then(response => {
            var datas = response.data;
            $('#subdistrict_id option').remove()
            datas.forEach(data => {
                $('#subdistrict_id').append($('<option>', {value:data.id, text:data.name}));
            });
            if(district_id != 0){
                $('#subdistrict_id').val(subdistrict_id).trigger('change');
            }
        });
    });
    //

    // setup for publish date    
    $('#publish_date').datetimepicker({        
        format: 'YYYY-MM-DD HH:mm:ss',        
    });
});
