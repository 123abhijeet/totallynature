@extends('admin.layouts.main')
@section('content')
<div class="pagetitle">
    <h1>Fleet</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Fleet</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="card">
        <div class="card-body">
            <table class="table" id="expired_document_list">
                <thead>
                    <tr>
                        <th scope="col">Document Name</th>
                        <th scope="col">Vehicle Model</th>
                        <th scope="col">License No</th>
                        <th scope="col">Uploaded Date</th> 
                        <th scope="col" style="color: red;">Expired Date</th>
                        <th scope="col">Created By</th>
                    </tr>
                </thead>

            </table>

        </div>
    </div>
</section>

@section('javascript')
<script>
    expired_document_list = $('#expired_document_list').DataTable({
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
            url: "{{ route('admin.fleet.expired_document_list') }}",
            type: 'get',
        },
    })
</script>
@endsection

@endsection