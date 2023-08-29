@extends('admin.layouts.main')
@section('content')
<div class="pagetitle">
    <h1>Configuration</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Configuration</a></li>
            <li class="breadcrumb-item active">Tax</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for=""> TAX(%)</label> <br>
                                        <p class="mb-0" style="color:#99abb4; font-size:13px">Tax value in % (percentage)</p>
                                        <hr />
                                        <a href="#" style="color: #48aa66;">TAX:</a> &nbsp; <a href="#" style="color: #48aa66;">{{!empty($tax_detail->tax) ? $tax_detail->tax : '1.00' }}%</a>
                                        <br />
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>
                            <div class="row">
                                <form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}">
                                    @csrf
                                    @method($method)
                                    <div class="col-md-12">
                                        <h5>Update Tax (%)</h5>
                                        <div class="mb-3">
                                            <label for="">Tax</label>
                                            <input name="tax" type="text" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</section>

@section('javascript')
<script>
    tax_list = $('#tax_list').DataTable({
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
            url: "{{ route('admin.config.tax_list') }}",
            type: 'get',
        },
    })
</script>
@endsection

@endsection