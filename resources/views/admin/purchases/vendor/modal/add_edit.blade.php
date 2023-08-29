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
        top: 167px;
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
        $vendor_type = $data->vendor_type ?? '';
        $image = !empty($data->vendor_image) ? asset($data->vendor_image) :  'https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg';
    @endphp
    <div class="row mb-2">
        <div class="col-12">
            {{-- <label for="inputNanme4" class="form-label">Payment Term</label>
        <input type="text" class="form-control" name="payment_type" value="{{ $data->payment_type ?? '' }}">
        <input type="hidden" name="payment_type_id" value="{{ $data->payment_type_id ?? '' }}"> --}}
            
            <label for="inputNanme4" class="form-label">Vendor Type</label>
            <select name="vendor_type" id="vendor_type" class="form-control">
                <option value="">Select</option>
                <option value="individual" {{ $vendor_type == 'individual' ? 'selected' : ''}}>Individual</option>
                <option value="company" {{ $vendor_type == 'company' ? 'selected' : ''}}>Company</option>
            </select>
            <input type="hidden" name="vendor_id" value="{{ $data->vendor_id ?? '' }}">
        </div>
    </div>

    

    <div class="row" style="display: {{ $vendor_type == 'individual' ? '' : 'none'}}" id="individual_section">

        <div class="small-12 medium-2 large-2 columns">
            <div class="circle">
                <img class="profile-pic"
                    src="{{ $image }}">

            </div>
            <div class="p-image">
                <i class="fa fa-camera upload-button"></i>
                <input class="file-upload" type="file" accept="image/*" name="individual_file"/>
            </div>
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Vendor Id *</label>
            <input type="text" class="form-control" name="individual_vendor_id" value="{{ $data->vendor_unique_id ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Vendor Name *</label>
            <input type="text" class="form-control" name="individual_vendor_name" value="{{ $data->vendor_name ?? '' }}">
        </div>

        {{-- <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Contact Person *</label>
            <input type="text" class="form-control" name="contact_person" value="{{ $data->contact_person ?? '' }}">
        </div> --}}
        {{-- <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Job Position *</label>
            <input type="text" class="form-control" name="job_position" value="{{ $data->job_position ?? '' }}">
        </div> --}}

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Contact Number *</label>
            <input type="text" class="form-control" name="individual_contact_number" value="{{ $data->contact_number ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Whatsapp No</label>
            <input type="text" class="form-control" name="individual_whatsapp_no" value="{{ $data->whatsapp_no ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Email ID</label>
            <input type="text" class="form-control" name="individual_email_id" value="{{ $data->email_id ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Postal Code *</label>
            <input type="text" class="form-control" name="individual_postal_code" value="{{ $data->postal_code ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Address *</label>
            <input type="text" class="form-control" name="individual_address" value="{{ $data->address ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Unit Number *</label>
            <input type="text" class="form-control" name="individual_unit_number" value="{{ $data->unit_number ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Region *</label>
            {{-- <input type="text" class="form-control" name="region" value="{{ $data->region ?? '' }}"> --}}
            @php
                $region_value = $data->region ?? '';
                $payment_term_value = $data->payment_terms ?? '';
                $payment_type_value = $data->payment_type ?? '';
                $price_structure_value = $data->price_structure ?? ''
            @endphp
            <select name="individual_region" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($region as $item)
                    <option value="{{ $item->region_id }}" {{ $region_value == $item->region_id ? 'selected' : '' }}>{{ $item->region_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Payment Terms *</label>
            {{-- <input type="text" class="form-control" name="payment_terms"
                value="{{ $data->payment_terms ?? '' }}"> --}}
            <select name="individual_payment_terms" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($payment_term as $item)
                    <option value="{{ $item->payment_term_id }}" {{ $payment_term_value == $item->payment_term_id ? 'selected' : '' }}>{{ $item->payment_term }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Payment Type *</label>
            {{-- <input type="text" class="form-control" name="payment_type" value="{{ $data->payment_type ?? '' }}"> --}}
            <select name="individual_payment_type" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($payment_type as $item)
                    <option value="{{ $item->payment_type_id }}" {{ $payment_type_value == $item->payment_type_id ? 'selected' : '' }}>{{ $item->payment_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Credit Limit</label>
            <input type="text" class="form-control" name="individual_credit_limit" value="{{ $data->credit_limit ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Choose Price Structure *</label>
            {{-- <input type="text" class="form-control" name="price_structure"
                value="{{ $data->price_structure ?? '' }}"> --}}
            <select name="individual_price_structure" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($price_structure as $item)
                    <option value="{{ $item->price_structure_id }}" {{ $price_structure_value == $item->price_structure_id ? 'selected' : '' }}>{{ $item->price_structure }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row" style="display: {{ $vendor_type == 'company' ? '' : 'none'}}" id="company_section">

        <div class="small-12 medium-2 large-2 columns">
            <div class="circle">
                <img class="profile-pic-company"
                src="{{ $image  }}">

            </div>
            <div class="p-image">
                <i class="fa fa-camera upload-button_company"></i>
                <input class="file-upload_company" type="file" accept="image/*" name="company_file"/>
            </div>
        </div>


        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Vendor Id*</label>
            <input type="text" class="form-control" name="company_vendor_id" value="{{ $data->vendor_unique_id ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Vendor Name*</label>
            <input type="text" class="form-control" name="company_company_name" value="{{ $data->company_name ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Postal Code*</label>
            <input type="text" class="form-control" name="company_postal_code" value="{{ $data->postal_code ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Address*</label>
            <input type="text" class="form-control" name="company_address" value="{{ $data->address ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Unit Number*</label>
            <input type="text" class="form-control" name="company_unit_number" value="{{ $data->unit_number ?? '' }}">
        </div>
       

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Office No.*</label>
            <input type="text" class="form-control" name="company_office_no" value="{{ $data->office_no ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Contact Person*</label>
            <input type="text" class="form-control" name="company_contact_person"
                value="{{ $data->contact_person ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Contact Person No.*</label>
            <input type="text" class="form-control" name="company_contact_person_no"
                value="{{ $data->contact_person_no ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Email ID </label>
            <input type="text" class="form-control" name="company_email_id" value="{{ $data->email_id ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Website </label>
            <input type="text" class="form-control" name="company_website" value="{{ $data->website ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Region *</label>
            {{-- <input type="text" class="form-control" name="region" value="{{ $data->region ?? '' }}"> --}}
            <select name="company_region" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($region as $item)
                    <option value="{{ $item->region_id }}" {{ $region_value == $item->region_id ? 'selected' : '' }}>{{ $item->region_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Payment Terms*</label>
            {{-- <input type="text" class="form-control" name="payment_terms"
                value="{{ $data->payment_terms ?? '' }}"> --}}
            <select name="company_payment_terms" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($payment_term as $item)
                    <option value="{{ $item->payment_term_id }}" {{ $payment_term_value == $item->payment_term_id ? 'selected' : '' }}>{{ $item->payment_term }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Payment Type*</label>
            {{-- <input type="text" class="form-control" name="payment_type" value="{{ $data->payment_type ?? '' }}"> --}}
            <select name="company_payment_type" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($payment_type as $item)
                    <option value="{{ $item->payment_type_id }}" {{ $payment_type_value == $item->payment_type_id ? 'selected' : '' }}>{{ $item->payment_type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Credit Limit</label>
            <input type="text" class="form-control" name="company_credit_limit" value="{{ $data->credit_limit ?? '' }}">
        </div>

        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Choose Price Structure *</label>
            {{-- <input type="text" class="form-control" name="price_structure"
                value="{{ $data->price_structure ?? '' }}"> --}}
            <select name="company_price_structure" id="" class="select2 form-control">
                <option value="">Select</option>
                @foreach ($price_structure as $item)
                    <option value="{{ $item->price_structure_id }}" {{ $price_structure_value == $item->price_structure_id ? 'selected' : '' }}>{{ $item->price_structure }}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="row">
        <h3>Bank Account Details</h3>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Bank Name *</label>
            <input type="text" class="form-control" name="bank_name" value="{{ $data->bank_name ?? '' }}">
        </div>
        <div class="col-md-6">
            <label for="inputNanme4" class="form-label">Bank Account No *</label>
            <input type="text" class="form-control" name="bank_account_no" value="{{ $data->bank_account_no ?? '' }}">
        </div>

    </div>



</form>


<script>
    $(document).ready(function() {

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
    $('#vendor_type').change(function() {
        if ($(this).val() == 'individual') {
            $('#individual_section').show();
            $('#company_section').hide();
        } else {
            $('#individual_section').hide();
            $('#company_section').show();
        }
    });
</script>
