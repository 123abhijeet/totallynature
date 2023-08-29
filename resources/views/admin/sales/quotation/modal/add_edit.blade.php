<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    @php
    $customer_id = $data->customer_id ?? '';
    $payment_type1 = $data->payment_type ?? '';
    $payment_terms1 = $data->payment_terms ?? '';
    $price_structure = $data->price_structure ?? '';

    @endphp
    <div class="col-md-6">
        <div class="mb-3">
            <input type="hidden" name="quotation_id" value="{{ $data->quotation_id ?? '' }}">
            <input type="hidden" name="price_structure" id="price_structure" value="{{ $data->price_structure ?? '' }}">
            <label>Customer Name*</label> <br>
            <select name="customer_id" id="customer_select_1" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="">Select Customer</option>
                @foreach($customers as $key=>$customer)
                <option value="{{$customer->customer_id}}" {{$customer_id == $customer->customer_id ? 'selected' : ''}}>{{$customer->customer_name!=null?$customer->customer_name:$customer->company_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Customer ID*</label> <br>
            <select id="customer_select_2" name="customer_id" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="">Select Customer</option>
                @foreach($customers as $key=>$customer)
                <option value="{{$customer->customer_id}}" {{$customer_id == $customer->customer_id ? 'selected' : ''}}>{{$customer->customer_id}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Billing Address*</label>
            <textarea name="invoice_address" id="invoice_address" cols="30" rows="10" class="form-control" style="height: 70px;">{{ $data->invoice_address ?? '' }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Shipping Address*</label>
            <textarea name="delivery_address" id="delivery_address" cols="30" rows="10" class="form-control" style="height: 70px;">{{ $data->delivery_address ?? '' }}</textarea>
        </div>
        <input type="checkbox" id="checked_meq">
        <label for="">Check if Billing address is the Shipping address</label>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Payment Types*</label> <br>
            <select id="payment_types_select" name="payment_type" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="">Select Payment Type</option>
                @foreach($payment_types as $key=>$payment_type)
                <option value="{{$payment_type->payment_type_id }}" {{$payment_type1 == $payment_type->payment_type_id ? 'selected' : ''}}>{{$payment_type->payment_type}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Payment Terms*</label> <br>
            <select id="payment_terms_select" name="payment_terms" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="">Select Payment Terms</option>
                @foreach($payment_terms as $key=>$payment_term)
                <option value="{{$payment_term->payment_term_id }}" {{$payment_terms1 == $payment_term->payment_term_id ? 'selected' : ''}}>{{$payment_term->payment_term}} Days</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Due Date*</label>
            <input type="text" class="form-control datepicker2" name="due_date" id="due_date" value="{{ $data->due_date ?? '' }}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Order Date*</label>
            <input type="date" name="order_date" class="form-control" value="{{ $data->order_date ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Sales Person*</label>
            <input type="text" name="sales_person" class="form-control" id="sales_person" value="{{ Auth::user()->name }}" readonly>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Remarks</label>
            <textarea name="remark" id="" cols="30" rows="10" class="form-control" style="height: 70px;">{{ $data->remark ?? '' }}</textarea>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Terms & Condition</label> <br>
            <select id="tandc" name="tandc" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="Sample Terms & Condition">Sample Terms & Condition</option>
                <option value="Payment to be made upon delivery">Payment to be made upon delivery</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="">Tax Inclusive <input type="checkbox" name="tax_inclusive" id="tax_inclusive"></label>
            <input type="text" name="tax" id="tax" placeholder="tax(%)" value="{{$tax->tax}}" class="form-control">
        </div>
    </div>


    <div class="col-md-12">
        <div class="mb-3">
            <label for="">Order Lines</label>
        </div>
    </div>
    <div>
        <button type="button" class="btn btn-success" style="float: right" id="add_product_row_btn">
            <i class="fa fa-plus" aria-hidden="true">
            </i>
        </button>
    </div>
    <div class="overflow-table" style="overflow:auto">
        <table class="table" style="overflow: auto;">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Product ID</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Varriant</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Gross Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="add_product_row">
                @if (!empty($quotation_products))
                @foreach ($quotation_products as $item)
                @php
                $product_id = $item->product_id ?? '';
                $variant_id = $item->variant ?? '';
                @endphp
                <tr>
                    <input type="hidden" class="form-control" name="quotation_product_id[]" value="{{ $item->quotation_product_id ?? '' }}">
                    <td>
                        <select id="product_id" name="product_id[]" class="product_id select_product js-states form-control form-select mySelect2" style="width: 100%;" disabled>
                            @foreach($products as $key=>$product)
                            <option value="{{$product->product_id }}" {{$product_id == $product->product_id ? 'selected' : ''}}>{{$product->product_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control product_unique_id" name="product_unique_id[]" value="{{ $item->product_unique_id ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control description" name="description[]" value="{{ $item->description ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control category" name="category[]" value="{{ $item->category ?? '' }}" readonly>
                    </td>
                    <td>
                        <select id="varriant" name="varriant[]" class="varriant js-states form-control form-select mySelect2" style="width: 100%;">
                            @foreach($variantss = App\Models\ProductVariant::where('product_id',$item->product_id)->get() as $key=>$variant)
                            <option value="{{$variant->product_variant_id }}" {{$variant_id == $variant->product_variant_id ? 'selected' : ''}}>{{$variant->qnt}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control quantity" name="quantity[]" value="{{ $item->quantity ?? '' }}" min="1">
                    </td>
                    <td>
                        <input type="text" class="form-control unit_price" name="unit_price[]" value="{{ $item->unit_price ?? '' }}" readonly>
                    </td>
                    <td>
                        <input type="number" id="gross_amount" class="form-control gross_amount" name="gross_amount[]" value="{{ $item->amount ?? '' }}" readonly>
                    </td>
                    <td>
                        <i class="fa fa-trash " aria-hidden="true"></i>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-9"></div>
        <div class="col-md-3">
            <div class="col-md-12">
                <div class="mr-3">
                    <label for="">Subtotal</label>
                    <input class="form-control sub_total" readonly type="text" value="{{ $data->untaxted_amount ?? '' }}" name="sub_total" id="sub_total" placeholder="0">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mr-3">
                    <label for="">GST</label>
                    <input class="form-control" readonly type="text" value="{{ $data->taxes ?? '' }}" id="total_gst1" name="gst" placeholder="0">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mr-3">
                    <label for="">Total Amount</label>
                    <input class="form-control" readonly type="text" name="total_amount" value="{{ $data->net_total ?? '' }}" id="total_amount1" placeholder="0">
                </div>
            </div>
        </div>
    </div>

    </div>

</form>

{{-- @section('javascript') --}}
<script>
    $('#add_product_row_btn').click(function() {

        var selectedCustomer = $('#customer_select_1').val();
        if (selectedCustomer === "") {
            toastr.error('Please select customer');
            return
        }
        let number = $('#add_product_row tr').length;

        $('#add_product_row').append(`<tr>
                <td>
                    <select id="product_id" name="product_id[]" class="product_id select_product js-states form-control form-select mySelect2" style="width: 100%;">
                    <option value="">Select Product</option>
                        @foreach($products as $key=>$product)
                            <option value="{{$product->product_id }}">{{$product->product_name}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control product_unique_id" name="product_unique_id[]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control description" name="description[]" readonly>
                </td>
                <td>
                    <input type="text" class="form-control category" name="category[]" readonly>
                </td>
                <td>
                    <select id="varriant" name="varriant[]" class="varriant js-states form-control form-select mySelect2" style="width: 100%;">
                       
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity" name="quantity[]" min="1" value="1">
                </td>
                <td>
                    <input type="text" class="form-control unit_price" name="unit_price[]" readonly >
                </td>
                <td>
                    <input type="number" id="gross_amount" class="form-control gross_amount" name="gross_amount[]" readonly>
                </td>
                    <td>
                        <i class="fa fa-trash delete" aria-hidden="true"></i>
                    </td> 
                </tr>`)

        $('.delete').click(function() {
            $(this).closest('tr').remove();
        });
    });

    $('.delete').click(function() {
        $(this).closest('tr').remove();
    });

    $('#customer_select_1').on('change', function(e) {
        var customer_id = $('#customer_select_1').val();
        $('#customer_select_2').val(customer_id);

        $('#delivery_address').val('');
        $('#checked_meq').prop('checked', false);
        @foreach($customers as $key => $value)
        if (customer_id == "{{$value->customer_id}}") {
            $('#price_structure').val("{{$value->price_structure}}");

            $('#payment_terms_select').val("{{$value->payment_terms}}");
            $('#payment_types_select').val("{{$value->payment_type}}");
            $('#invoice_address').val("{{$value->unit_number}} {{$value->address}} {{$value->postal_code}}");


            // if ("{{$value->payment_terms}}" != 2) {
            @foreach($payment_terms as $k => $v)
            if ("{{$value->payment_terms}}" == "{{$v->payment_term_id}}") {
                let total_days = "{{(int)$v->payment_term}}";
                let date = new Date();
                days = date.getDate() + parseInt(total_days);
                var t = new Date(date.setDate(days)).toISOString().slice(0, 10).split('-').reverse().join('-');
                $('#due_date').val(t);
            }
            @endforeach
            // }

            $('#payment_terms_select').select2().trigger('change');
            $('#payment_types_select').select2().trigger('change');
        }
        @endforeach

    });
    $('#customer_select_2').on('change', function(e) {
        var customer_id = $('#customer_select_2').val();
        $('#customer_select_1').val(customer_id);

        $('#delivery_address').val('');
        $('#checked_meq').prop('checked', false);
        @foreach($customers as $key => $value)
        if (customer_id == "{{$value->customer_id}}") {
            $('#price_structure').val("{{$value->price_structure}}");

            $('#payment_terms_select').val("{{$value->payment_terms}}");
            $('#payment_types_select').val("{{$value->payment_type}}");
            $('#invoice_address').val("{{$value->unit_number}} {{$value->address}} {{$value->postal_code}}");


            // if ("{{$value->payment_terms}}" != 2) {
            @foreach($payment_terms as $k => $v)
            if ("{{$value->payment_terms}}" == "{{$v->payment_term_id}}") {
                let total_days = "{{(int)$v->payment_term}}";
                let date = new Date();
                days = date.getDate() + parseInt(total_days);
                var t = new Date(date.setDate(days)).toISOString().slice(0, 10).split('-').reverse().join('-');
                $('#due_date').val(t);
            }
            @endforeach
            // }

            $('#payment_terms_select').select2().trigger('change');
            $('#payment_types_select').select2().trigger('change');
        }
        @endforeach
    });


    $('#checked_meq').on('change', function() {
        if ($(this).prop('checked') == true) {
            var address_id = $('#invoice_address').val();
            $('#delivery_address').val(address_id);
        } else {
            $('#delivery_address').val('');
        }
    });

    $(document).on('change', '.select_product', function() {
        var product_id = $(this).val();
        var price_structure = $('#price_structure').val();
        var $row = $(this).closest('tr');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.sales.get_product_details') }}",
            type: "get",
            data: {
                product_id: product_id,
                price_structure: price_structure,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $row.find('.product_unique_id').val(data.product_unique_id);
                $row.find('.category').val(data.category_name);
                $row.find('.description').val(data.product_description);
                $row.find('.unit_price').val(data.unit_price);
                calculateAmount($row);
                getvariant($row);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });

    });

    function calculateAmount(row) {
        var unit_price = row.find('.unit_price').val();
        var quantity = row.find('.quantity').val();
        var amount;
        amount = unit_price * quantity;
        amount = isNaN(amount) ? 0 : amount.toFixed(2);
        row.find('.gross_amount').val(amount);

        calculateTotal();
    }

    function calculateTotal() {
        var total = 0;
        var tax = $('#tax').val();
        $('.gross_amount').each(function() {
            var amount = parseFloat($(this).val()) || 0;
            total += amount;
        });
        var gstAmount = total * tax / 100;
        var total_amount = total + gstAmount;
        $('#sub_total').val(total.toFixed(2));
        $('#total_gst1').val(gstAmount.toFixed(2));
        $('#total_amount1').val(total_amount.toFixed(2));
    }

    function updateCalculation() {

        var total = 0;
        var total_tax = 0;
        var untaxed = 0;
        var total_amount = 0;
        var tax = parseFloat($('#tax').val());

        $('#add_product_row > tr').each(function() {

            total_amount += parseFloat($(this).find('input[name="gross_amount[]"]').val());

        });

        if ($('#tax_inclusive').prop('checked') == true) {
            total_tax = (parseFloat(total_amount) * tax) / 100;
            total = total_amount + total_tax;
        } else {
            total = total_amount;
        }

        $('#sub_total').val(total_amount.toFixed(2));

        $('#total_gst1').val(total_tax.toFixed(2));

        $('#total_amount1').val(total.toFixed(2));

    }

    $(document).on('change', '#tax_inclusive', function() {

        updateCalculation();

    });

    $(document).ready(function() {
        $('#tax_inclusive').prop('checked', true);
    });

    $(document).on('change', '.quantity', function() {
        $row = $(this).closest('tr');
        calculateAmount($row);
    });

    function getvariant(row) {

        var product_id = row.find('.product_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.sales.get_variant_details') }}",
            type: "get",
            data: {
                product_id: product_id,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                populateSelectBox(data, row);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    }

    function populateSelectBox(data, row) {
        var selectBox = row.find('.varriant');
        selectBox.empty();

        $.each(data, function(index, item) {
            selectBox.append($('<option>', {
                value: item.product_variant_id,
                text: item.qnt
            }));
        });
    }
</script>
{{-- @endsection --}}