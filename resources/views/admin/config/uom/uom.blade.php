@extends('admin.layouts.main')
@section('content')
    <div class="pagetitle">
        <h1>Configuration</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Configuration</a></li>
                <li class="breadcrumb-item active">Uom</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div style="float: right" class="card-title">
                    <button type="button" class="btn btn-success"
                        onclick="open_modal('{{ route('admin.config.uom.create') }}','add_uom_loder','add_uom_btn','Add Uom')"
                        >
                        <i class="fa fa-refresh fa-spin" id="add_uom_loder" style="display: none"></i>
                        <i class="fa fa-plus" aria-hidden="true" id="add_uom_btn">
                        </i>
                    </button>
                </div>
                <table class="table" id="uom_list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Uom</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                </table>

            </div>
        </div>
    </section>

@section('javascript')
    <script>
        uom_list = $('#uom_list').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            //responsive: 'false',
            dom: "Bfrtip",
            pageLength: 30,
            buttons: [

                {
                    extend: 'copyHtml5',
                    text: '<i class="fas fa-file"></i>',
                    titleAttr: 'Copy',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel"></i>',
                    titleAttr: 'Excel',

                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-text"></i>',
                    titleAttr: 'CSV',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i>',
                    titleAttr: 'PDF',
                    title: $('.download_label').html(),
                    exportOptions: {
                        columns: ':visible'

                    }
                },

                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.download_label').html(),
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },

                {
                    extend: 'colvis',
                    text: '<i class="fa fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.download_label').html(),
                    postfixButtons: ['colvisRestore']
                },
            ],
            ajax: {
                url: "{{ route('admin.config.uom_list') }}",
                type: 'get',
            },
        })
    </script>
@endsection

@endsection
