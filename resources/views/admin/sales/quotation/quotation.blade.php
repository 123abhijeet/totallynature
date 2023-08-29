@extends('admin.layouts.main')
@section('content')
<div class="pagetitle">
    <h1>Sales</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Sales</a></li>
            <li class="breadcrumb-item active">Quotation</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="card">
        <div class="card-body">
            <div style="float: right" class="card-title">
                <button type="button" class="btn btn-success" onclick="open_modal('{{ route('admin.sales.quotation.create') }}','add_quotation_loder','add_quotation_btn','Create Quotation')">
                    <i class="fa fa-refresh fa-spin" id="add_quotation_loder" style="display: none"></i>
                    <i class="fa fa-plus" aria-hidden="true" id="add_quotation_btn">
                    </i>
                </button>
            </div>
            <table class="table" id="quotation_list">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quotation Number</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Quotation Value</th>
                        <th scope="col">Updated On</th>
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
    quotation_list = $('#quotation_list').DataTable({
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
            url: "{{ route('admin.sales.quotation_list') }}",
            type: 'get',
        },
    })
</script>
@endsection

@endsection