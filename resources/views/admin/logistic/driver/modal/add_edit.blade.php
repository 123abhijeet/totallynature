<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}" enctype="multipart/form-data" data-table="{{ $table }}">
    @csrf
    @method($method)
    @php
    $region = $data->region ?? '';
    $vehicle_id = $data->vehicle_id ?? '';
    @endphp
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Driver Photo</label>
            <input type="file" class="form-control" name="driver_file" value="{{ $data->driver_file ?? '' }}">
            <img src="{{asset($data->driver_file)}}" alt="" height="40px" width="60px">
            <input type="hidden" name="driver_id" value="{{ $data->driver_id ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Driver Name*</label>
            <input type="text" class="form-control" name="driver_name" value="{{ $data->driver_name ?? '' }}" placeholder="Driver Name">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Region</label> <br>
            <select name="region" id="" class="js-states form-control form-select mySelect2" style="width: 100%;">
                <option value="East" {{ $region == 'East' ? 'selected' : '' }}>East</option>
                <option value="West" {{ $region == 'West' ? 'selected' : '' }}>West</option>
                <option value="North" {{ $region == 'North' ? 'selected' : '' }}>North</option>
                <option value="South" {{ $region == 'South' ? 'selected' : '' }}>South</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="" class="form-label">Unit Code</label>
            <input type="text" class="form-control" name="unit_code" value="{{ $data->unit_code ?? '' }}" placeholder="Unit Code">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="" class="form-label">Postal Code*</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $data->postal_code ?? '' }}" placeholder="Postal Code">
        </div>
    </div>
    <div class="col-md-9">
        <div class="mb-3">
            <label for="" class="form-label">Address*</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $data->address ?? '' }}" placeholder="Address">
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="" class="form-label">Date of Birth*</label>
            <input type="date" class="form-control" id="dob" onclick="getpassword()" name="dob" value="{{ $data->dob ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="" class="form-label">Password*</label>
            <input type="text" class="form-control" readonly id="password" name="password" value="{{ $data->password ?? '' }}" placeholder="Password">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="" class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $data->phone_number ?? '' }}" placeholder="Phone Number">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" name="mobile_number" value="{{ $data->mobile_number ?? '' }}" placeholder="Mobile Number">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="" class="form-label">Fax</label>
            <input type="text" class="form-control" name="fax" value="{{ $data->fax ?? '' }}" placeholder="Fax">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="" class="form-label">Email ID</label>
            <input type="email" class="form-control" name="email" value="{{ $data->email ?? '' }}" placeholder="Driver Email">
        </div>
    </div>

    <h5>Fleet Info</h5>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Vehicle</label> <br>
            <select id="vehicle_modal" name="vehicle_id" class="js-states form-control form-select mySelect2" style="width: 100%;">
            <option value="">Choose Vehicle</option>
                @foreach($vehicles = App\Models\Vehicle::all() as $vehicle)
                <option value="{{$vehicle->vehicle_id}}" {{$vehicle_id == $vehicle->vehicle_id ? 'selected' : ''}}>{{$vehicle->vehicle_modal}}</option>
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="" class="form-label">License Plate</label>
            <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ $data->license_plate ?? '' }}" placeholder="License Plate">
        </div>
    </div>
    <div>
        <button type="button" class="btn btn-success" style="float: right" id="add_driver_docs_btn">
            <i class="fa fa-plus" aria-hidden="true">
            </i>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Doument Title</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="add_driver_docs">
            @if (!empty($drivers))
            @foreach ($drivers as $item)
            <tr>
                <input type="hidden" class="form-control" name="driver_document_id[]" value="{{ $item->driver_document_id ?? '' }}">
                <td>
                    <input type="text" class="form-control" name="document_title[]" placeholder="Title" value="{{ $item->document_title ?? '' }}">
                </td>
                <td>
                    <input type="date" class="form-control" name="document_issue_date[]" value="{{ $item->document_issue_date ?? '' }}">
                </td>
                <td>
                    <input type="date" class="form-control" name="document_expiry_date[]" value="{{ $item->document_expiry_date ?? '' }}">
                </td>
                <td>
                    <input type="file" class="form-control" name="document_file[]" value="{{ $item->document_file ?? '' }}">
                </td>
                <td>
                    <img src="{{asset($item->document_file)}}" alt="" height="40px" width="40px">
                </td>
                <td>
                    <i class="fa fa-trash delete" aria-hidden="true"></i>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</form>

{{-- @section('javascript') --}}
<script>
    $(document).on('change', '#vehicle_modal', function() {
        let vehicle_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getlicense_plate') }}",
            type: "get",
            data: {
                vehicle_id: vehicle_id,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data.license_plate);
                $('#license_plate').val(data.license_plate);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });

    function getpassword() {

        const dobInput = document.getElementById('dob');
        const formattedDOBInput = document.getElementById('password');

        dobInput.addEventListener('input', () => {
            const dobValue = dobInput.value;

            if (dobValue) {
                const dateParts = dobValue.split('-');
                const day = dateParts[2];
                const month = dateParts[1];
                const year = dateParts[0];

                formattedDOBInput.value = `${day}${month}${year}`;
            } else {
                formattedDOBInput.value = '';
            }
        });
    }
    // API for Address
    $(document).on('change', '#postal_code', function() {
        let fullAddress = $(this).val();
        if (fullAddress.toString().length == 6) {
            jQuery.ajax({
                url: "{{route('user.apiAddress')}}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },

                beforeSend: function() {
                    $('#address').val('Loading...');
                },
                success: function(response) {
                    if (JSON.parse(response).found == 0) {
                        $('#address').val('');
                        $('#postal_code').val('');
                        toastr.error('Please Enter Valid Postal Code');
                    } else {
                        $('#address').val(JSON.parse(response).results[0].ADDRESS);
                        $('#completeSave').removeAttr('disabled');
                    }
                }
            });
        } else {
            toastr.error('Please Enter 6 digits  Postal Code');
        }
    });

    $('#add_driver_docs_btn').click(function() {
        $('#add_driver_docs').append(`<tr>
                    <td>
                        <input type="text" class="form-control" name="document_title[]" placeholder="Title">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="document_issue_date[]">
                    </td> 
                    <td>
                        <input type="date" class="form-control" name="document_expiry_date[]">
                    </td> 
                    <td>
                    <input type="file" class="form-control" name="document_file[]">
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
</script>
{{-- @endsection --}}