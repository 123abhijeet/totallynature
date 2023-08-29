<style>
    .profile-pic {
        width: 200px;
        max-height: 200px;
        display: inline-block;
    }

    .profile-pic-company {
        width: 200px;
        max-height: 200px;
        display: inline-block;
    }

    .file-upload {
        display: none;
    }

    .file-upload_company {
        display: none;
    }

    .circle {
        border-radius: 100% !important;
        overflow: hidden;
        width: 128px;
        height: 128px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        /* position: absolute; */
        top: 72px;
    }

    .profile-pic {
        max-width: 100%;
        height: auto;
    }

    .profile-pic-company {
        max-width: 100%;
        height: auto;
    }

    .p-image {
        position: absolute;
        top: 93px;
        /* right: 30px; */
        left: 105px;
        color: #666666;
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }

    .p-image:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }

    .upload-button {
        font-size: 1.2em;
    }

    .upload-button:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        color: #999;
    }

    .select2 {
        width: 100% !important;
    }
</style>
<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}"
    data-table="{{ $table }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    @php
        $image = !empty($data->product_image) ? asset($data->product_image) : 'https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg';
    @endphp

    <div class="row">

        {{-- <div class="small-6 medium-2 large-2 columns col-md-12"> --}}
        <div class="circle col-md-6">
            <img class="profile-pic" src="{{ $image }}">

        </div>
        <div class="p-image">
            <i class="fa fa-camera upload-button"></i>
            <input class="file-upload" type="file" accept="image/*" name="individual_file" />
        </div>

        <div class="col-md-6">
            <div>
                <input type="checkbox" name="for_sale" {{ !empty($data->for_sale) ? 'checked' : '' }}>
                <label for="inputNanme4" class="form-label">For Sale</label>
            </div>
            <div>
                <input type="checkbox" name="for_internal_use" {{ !empty($data->for_internal_use) ? 'checked' : '' }}>
                <label for="inputNanme4" class="form-label">For Internal Use</label>
            </div>
            <div>
                <input type="checkbox" name="foc_sample" {{ !empty($data->foc_sample) ? 'checked' : '' }}>
                <label for="inputNanme4" class="form-label">Foc Sample</label>
            </div>
        </div>



        {{-- </div> --}}


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Product Name *</label>
            <input type="text" class="form-control" name="product_name" value="{{ $data->product_name ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Product Id *</label>
            <input type="text" class="form-control" name="product_unique_id"
                value="{{ $data->product_unique_id ?? '' }}">
        </div>

        <h4>General Information</h4>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Product Type *</label>
            {{-- <input type="text" class="form-control" name="product_type" value="{{ $data->product_type ?? '' }}"> --}}
            <select name="product_type" class="form-control">
                <option value="">Select</option>
                @foreach ($product_type as $item)
                    <option value="{{ $item->product_type_id }}"
                        {{ !empty($data->product_type_id) && $data->product_type_id == $item->product_type_id ? 'selected' : '' }}>
                        {{ $item->product_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Internal Reference </label>
            <input type="text" class="form-control" name="internal_reference"
                value="{{ $data->internal_reference ?? '' }}">
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Category *</label>
            {{-- <input type="text" class="form-control" name="category" value="{{ $data->category ?? '' }}"> --}}
            <select name="category" class="form-control">
                <option value="">Select</option>
                @foreach ($category as $item)
                    <option value="{{ $item->category_id }}"
                        {{ !empty($data->category_id) && $data->category_id == $item->category_id ? 'selected' : '' }}>
                        {{ $item->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Description </label>
            <input type="text" class="form-control" name="description"
                value="{{ $data->product_description ?? '' }}">
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">UOM Category *</label>
            {{-- <input type="text" class="form-control" name="uom_category" value="{{ $data->uom_category ?? '' }}"> --}}
            <select name="category" class="form-control" id="category_list">
                <option value="">Select</option>
                @foreach ($uom_category as $item)
                    <option value="{{ $item->uom_category_id }}"
                        {{ !empty($data->uom_category_id) && $data->uom_category_id == $item->uom_category_id ? 'selected' : '' }}>
                        {{ $item->uom_category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Base UOM *</label>
            {{-- <input type="text" class="form-control" name="base_uom" value="{{ $data->base_uom ?? '' }}"> --}}
            <select name="base_uom" class="form-control" id="base_uom_list">
                <option value="">Select</option>
                @php
                    $uom_for_product = DB::table('uoms')
                        ->where('uom_category_id', $data->uom_category_id ?? '')
                        ->get();
                @endphp
                @foreach ($uom_for_product as $item)
                    <option value="{{ $item->uom_id }}"
                        {{ !empty($data->uom_measure_id) && $data->uom_measure_id == $item->uom_id ? 'selected' : '' }}>
                        {{ $item->uom }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Warehouse </label>
            {{-- <input type="text" class="form-control" name="warehouse" value="{{ $data->warehouse ?? '' }}"> --}}
            <select name="warehouse" class="form-control" id="warehouse_list">
                <option value="">Select</option>
                @foreach ($warehouse as $item)
                    <option value="{{ $item->warehouse_id }}"
                        {{ !empty($data->warehouse_id) && $data->warehouse_id == $item->warehouse_id ? 'selected' : '' }}>
                        {{ $item->warehouse_name }}</option>
                @endforeach
            </select>

        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Warehouse Sub Location </label>
            {{-- <input type="text" class="form-control" name="warehouse_sub_location"
                value="{{ $data->warehouse_sub_location ?? '' }}"> --}}
            @php
                $uom = DB::table('warehouse_sub_locations')
                    ->where('warehouse_id', $data->warehouse_id ?? '')
                    ->get();
            @endphp
            <select name="warehouse_sub_location" class="form-control" id="warehouse_sub_location_list">
                <option value="">Select</option>
                @foreach ($uom as $item)
                    <option value="{{ $item->warehouse_sub_location_id }}"
                        {{ !empty($data->warehouse_sub_location_id) && $data->warehouse_sub_location_id == $item->warehouse_sub_location_id ? 'selected' : '' }}>
                        {{ $item->sub_location }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Safety Stock *</label>
            <input type="text" class="form-control" name="safety_stock" value="{{ $data->safety_stock ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Notification for expiry(in days)*</label>
            <input type="text" class="form-control" name="notification_for_expiry"
                value="{{ $data->notification_for_expiry ?? '' }}">
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">HS Code</label>
            <input type="text" class="form-control" name="hs_code" value="{{ $data->hs_code ?? '' }}">
        </div>




        <div class="row">
            <div class="col-md-6">
                <h4>Vendor</h4>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-success" style="float: right" id="add_inventory_btn">
                    <i class="fa fa-plus" aria-hidden="true">
                    </i>
                </button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Avg. Cost Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="add_inventory_section">

                @if (!empty($product_vendor))
                    @foreach ($product_vendor as $item)
                        <tr>
                            <td>
                                <select name="vendor[]" class="form-control vendor_list">
                                    <option value="">Select</option>
                                    @foreach ($vendor as $v)
                                        <option value="{{ $v->vendor_id }}"
                                            {{ $item->vendor_id == $v->vendor_id ? 'selected' : '' }}>
                                            {{ $v->vendor_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="price[]"
                                    value="{{ $item->price }}"></td>
                            <td><input type="text" class="form-control" name="avg_cost_price[]"
                                    value="{{ $item->avg_price }}"></td>
                            <td>
                                <i class="fa fa-trash delete" aria-hidden="true"></i>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>




        <div class="row">
            <div class="col-md-6">
                <h4>Variants</h4>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-success " style="float: right" id="add_variant_btn">
                    <i class="fa fa-plus" aria-hidden="true">
                    </i>
                </button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Qnt</th>
                    <th>Uom</th>
                    <th>Packaging</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="add_variant_section">
                @if (!empty($product_variants))
                    @foreach ($product_variants as $item)
                        <tr>

                            <td>
                                <input type="text" class="form-control" name="qnt[]"
                                    value="{{ $item->qnt }}">
                            </td>
                            <td>
                                <select name="uom_measure_id[]" class="form-control uom_measure_list">
                                    <option value="">Select</option>
                                    @foreach ($uom_select as $u)
                                        <option value="{{ $u->uom_id }}"
                                            {{ $item->uom_measure_id == $u->uom_id ? 'selected' : '' }}>
                                            {{ $u->uom }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="packaging[]" class="form-control packing_list">
                                    <option value="">Select</option>
                                    @foreach ($packaging as $p)
                                        <option value="{{ $p->packing_id }}"
                                            {{ $item->packaging_id == $p->packing_id ? 'selected' : '' }}>
                                            {{ $p->packing_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <i class="fa fa-trash delete" aria-hidden="true"></i>
                            </td>
                        </tr>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>




        <div class="row">
            <div class="col-md-6">
                <h4>Price Structure</h4>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Price Structure</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ print_r($price_structure) }} --}}
                @foreach ($price_structure as $item)
                    <tr>
                        <td>
                            <input type="hidden" class="form-control" name="price_structure_id[]"
                                value="{{ $item->price_structure_id }}">
                            <input type="text" class="form-control" name="{{ $item->price_structure }}"
                                value="{{ $item->price_structure }}" readonly>
                        </td>
                        @if ($data->product_id ?? '')
                            @php
                                $price = DB::table('product_price_structures')
                                    ->where('price_structure_id', $item->price_structure_id)
                                    ->where('product_id', $data->product_id)
                                    ->first();
                            @endphp
                        @endif

                        @if (!empty($price))
                            <td>
                                <input type="text" class="form-control" name="price_structure"
                                    value="{{ $price->price }}">
                            </td>
                        @else
                            <td>
                                <input type="text" class="form-control" name="price_structure">
                            </td>
                        @endif
                        <td>
                            <i class="fa fa-trash delete" aria-hidden="true"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</form>


<script>
    $('#warehouse_list').change(function() {
        get_warehouse_sub_location_list($(this).val())
    });

    function get_warehouse_sub_location_list(id) {
        $.ajax({
            url: "{{ route('admin.config.warehouse_sub_location_list') }}",
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(data) {
                let len = data.length;
                for (let i = 0; i < len; i++) {
                    $('#warehouse_sub_location_list').append(
                        `<option value="${data[i]['warehouse_sub_location_id']}">${data[i]['sub_location']}</option>`
                    )
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    $('#category_list').change(function() {
        get_base_uom($(this).val());
    });

    function get_base_uom(id) {
        $.ajax({
            url: "{{ route('admin.config.get_base_uom') }}",
            type: 'get',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(data) {
                let len = data.length;
                for (let i = 0; i < len; i++) {
                    $('#base_uom_list').append(
                        `<option value="${data[i]['uom_id']}">${data[i]['uom']}</option>`)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    function get_uom_list_for_table() {
        // console.log($('#category').val());
        $.ajax({
            url: "{{ route('admin.config.get_base_uom') }}",
            type: 'get',
            dataType: 'json',
            data: {
                id: $('#category_list').val()
            },
            success: function(data) {
                let len = data.length;
                for (let i = 0; i < len; i++) {
                    $('.uom_measure_list').append(
                        `<option value="${data[i]['uom_id']}">${data[i]['uom']}</option>`)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }



    function get_vendor_list() {
        $.ajax({
            url: "{{ route('admin.purchase.vendor_dropdown') }}",
            type: 'get',
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // $('#add_inventory_section').empty();
                // $('#add_inventory_section').append(`<option value="">Select</option>`);
                let len = data.length;
                for (let i = 0; i < len; i++) {
                    $('.vendor_list').append(
                        `<option value="${data[i]['vendor_id']}">${data[i]['vendor_name']}</option>`)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    function get_packing_list() {
        $.ajax({
            url: "{{ route('admin.config.packing_dropdown') }}",
            type: 'get',
            dataType: 'json',
            success: function(data) {
                let len = data.length;
                for (let i = 0; i < len; i++) {
                    $('.packing_list').append(
                        `<option value="${data[i]['packing_id']}">${data[i]['packing_name']}</option>`)
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    $(document).ready(function() {

        $('#add_variant_btn').click(function() {
            // get_vendor_list();
            get_packing_list();

            get_uom_list_for_table()

            $('#add_variant_section').append(`<tr>
                <td>
                    <input type="text" class="form-control" name="qnt[]">
                </td>
                <td>
                    <select name="uom_measure_id[]" class="form-control uom_measure_list" >

                    </select>      
                </td>
                <td>
                    <select name="packaging[]" class="form-control packing_list" >

                    </select>    
                </td>
                <td>
                    <i class="fa fa-trash delete" aria-hidden="true"></i>
                </td>
                </tr>`)

            $('.delete').click(function() {
                $(this).closest('tr').remove();
            });
        })


        $('#add_inventory_btn').click(function() {
            get_vendor_list();

            $('#add_inventory_section').append(`<tr>
                <td>
                    <select name="vendor[]" class="form-control vendor_list" >

                    </select>
                </td>
                <td><input type="text" class="form-control" name="price[]"></td>
                <td><input type="text" class="form-control" name="avg_cost_price[]"></td>
                <td>
                    <i class="fa fa-trash delete" aria-hidden="true"></i>
                </td>
                </tr>`)

            $('.delete').click(function() {
                $(this).closest('tr').remove();
            });
        })

        $('.delete').click(function() {
            $(this).closest('tr').remove();
        });


        $(".select2").select2({
            placeholder: "Select a state",
            allowClear: true,
            dropdownParent: $('#commonModal')
        });
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
                    $('.file-upload').attr('value', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        var readURL_company = function(input) {
            if (input.files && input.files[0]) {
                var reader_company = new FileReader();

                reader_company.onload = function(e) {
                    $('.profile-pic-company').attr('src', e.target.result);
                    $('.file-upload_company').attr('value', e.target.result);
                }

                reader_company.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });

        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });


        $(".file-upload_company").on('change', function() {
            readURL_company(this);
        });

        $(".upload-button_company").on('click', function() {
            $(".file-upload_company").click();
        });


    });
</script>
