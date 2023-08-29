@extends('admin.layouts.main')
@section('content')
    <div class="pagetitle">
        <h1>Customers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Sales</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div style="float: right" class="card-title">
                    <button type="button" class="btn btn-success"
                        onclick="open_modal('{{ route('admin.sales.customers.create') }}','add_customer_loder','add_customer_btn','Add Customer')"
                        >
                        <i class="fa fa-refresh fa-spin" id="add_customer_loder" style="display: none"></i>
                        <i class="fa fa-plus" aria-hidden="true" id="add_customer_btn">
                        </i>
                    </button>
                </div>
                <div class="overflow-table" style="overflow: auto;">
                    <table class="table table-responsive" id="customer_list" style="overflow: auto;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Customer Type</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Contact Person</th>
                            <th scope="col">Contact Person No</th>
                            <th scope="col">Whatsapp No</th>
                            <th scope="col">Email Id</th>
                            <th scope="col">Address</th>
                            <th scope="col">Region</th>
                            <th scope="col">Payment Terms</th>
                            <th scope="col">Payment Type</th>
                            <th scope="col">Credit Limit</th>
                            <th scope="col">Price Structure</th>
                            <th scope="col">Website</th>
                            <th scope="col">Created By</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                </table>
            </div>
            

            </div>
        </div>
    </section>

@section('javascript')
    <script>
        customer_list = $('#customer_list').DataTable({
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
                url: "{{ route('admin.sales.customer_list') }}",
                type: 'get',
            },
        })
    </script>
@endsection

@endsection
