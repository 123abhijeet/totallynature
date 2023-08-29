@include('admin.layouts.header')
<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        /* Safari */
        animation: spin 2s linear infinite;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;
    }

    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>

    @include('admin.layouts.nav')

    @include('admin.layouts.sidebar')

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <div class="modal fade" id="commonModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="show_modal_data">
                    <div class="loader"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="commonModalBtn">
                        <i class="fa fa-refresh fa-spin" id="commonModalBtn_loder" style="display: none"></i>
                        Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="commonDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="commonDeleteForm" method="post">
                        @csrf
                        @method('delete')
                        Are your sure?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="commonDeleteModalBtn">
                        <i class="fa fa-refresh fa-spin" id="commonDeleteModalBtn_loder" style="display: none"></i>
                        Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.footer')
    @yield('javascript')
    <script>
        function errorMsg(msg) {
            toastr.error(msg);

        }


        function successMsg(msg) {
            toastr.success(msg);
        }

        function show_error_msg(error) {
            if (error.status == 422) {
                var err = error.responseJSON.errors;
                var message = "";
                $.each(err, function(index, value) {
                    message += value + '<br>';
                });
                errorMsg(message)
            }
        }




        function open_modal(url, loader_id, btn_id, title) {
            $('#commonModal').modal('show');
            $.ajax({
                url: url,
                type: 'get',
                beforeSend: function() {
                    $('#' + loader_id).show();
                    $('#' + btn_id).hide();
                    $('.loader').show();
                },
                success: function(data) {
                 
                    if (data) {
                        $('.modal-title').html(title);
                        $('#' + loader_id).hide();
                        $('#' + btn_id).show();
                        $('.loader').hide();
                        $('#show_modal_data').html(data)
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.loader').hide();
                }
            })
        }

        function open_edit_modal(url, title) {
            $('#commonModal').modal('show');
            $.ajax({
                url: url,
                type: 'get',
                beforeSend: function() {
                    $('.loader').show();
                },
                success: function(data) {
                    if (data) {
                        // $('.modal-title').html(title);
                        $('#commonModal').modal('show');
                        $('#show_modal_data').html(data)
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('.loader').hide();
                }
            })
        }

        $('#commonModalBtn').click(function(e) {
            e.preventDefault();
            let id = $(this).parent().parent().find("form").attr('id');
            let data = new FormData($('#' + id)[0]);
            let url = $('#' + id).attr('action');
            let method = $('#' + id).attr('method');
            let table = $('#' + id).data('table');
            console.log(table);
            $.ajax({
                url: url,
                type: method,
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#commonModalBtn_loder').show();
                },
                success: function(data) {
                    $('#commonModalBtn_loder').hide();
                    if (data.status == 'success') {
                        successMsg(data.message);
                        $('#commonModal').modal('hide');
                        $('#' + table).DataTable().ajax.reload();

                    }
                    console.log(data);
                },
                error: function(error) {
                    $('#commonModalBtn_loder').hide();
                    console.log(error)
                    show_error_msg(error);
                }
            })

        });


        function delete_modal(url, table) {
            $('#commonDeleteModal').modal('show')
            $('#commonDeleteModal').find('form').attr('action', url)
            $('#commonDeleteModal').find('form').data('table', table)
            // console.log();
        }

        $('#commonDeleteModalBtn').click(function(e) {
            e.preventDefault();
            console.log(1);
            let id = $(this).parent().parent().find("form").attr('id');
            let data = new FormData($('#' + id)[0]);
            let url = $('#' + id).attr('action');
            let method = $('#' + id).attr('method');
            let table = $('#' + id).data('table');
            $.ajax({
                url: url,
                type: method,
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#commonDeleteModalBtn_loder').show();
                },
                success: function(data) {
                    $('#commonDeleteModalBtn_loder').hide();
                    if (data.status == 'success') {
                        successMsg(data.message);
                        $('#commonDeleteModal').modal('hide');
                        $('#' + table).DataTable().ajax.reload();

                    }
                },
                error: function(error) {
                    $('#commonDeleteModalBtn_loder').hide();
                    console.log(error)
                    show_error_msg(error);
                }
            })

        });

        // $(".select2").select2({
        //     placeholder: "Select a state",
        //     allowClear: true,
        //     dropdownParent: $('#commonModal')
        // });
    </script>
</body>

</html>
