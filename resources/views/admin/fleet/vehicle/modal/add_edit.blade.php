<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    @php
        $fuel_type = $data->fuel_type ?? '';
    @endphp
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Vehicle Model*</label>
            <input type="text" class="form-control" name="vehicle_modal" value="{{ $data->vehicle_modal ?? '' }}" placeholder="Vehicle Model">
            <input type="hidden" name="vehicle_id" value="{{ $data->vehicle_id ?? '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">License Plate*</label>
            <input type="text" class="form-control" name="license_plate" value="{{ $data->license_plate ?? '' }}" placeholder="License Plate">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Current Odometer</label>
            <input type="text" class="form-control" name="current_odometer" value="{{ $data->current_odometer ?? '' }}" placeholder="Current Odometer">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Next Servicing Odometer</label>
            <input type="text" class="form-control" name="last_odometer" value="{{ $data->last_odometer ?? '' }}" placeholder="Next Servicing Odometer">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Last Odometer</label>
            <input type="text" class="form-control" name="next_servicing_odometer" value="{{ $data->next_servicing_odometer ?? '' }}" placeholder="Last Odometer">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Model Year</label>
            <input type="text" class="form-control" name="servicing_status" value="{{ $data->servicing_status ?? '' }}" placeholder="Model Year">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Model Color</label>
            <input type="text" class="form-control" name="model_year" value="{{ $data->model_year ?? '' }}" placeholder="Model Color">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Horsepower</label>
            <input type="text" class="form-control" name="horsepower" value="{{ $data->horsepower ?? '' }}" placeholder="Horsepower">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="fuel_type">Fuel Type</label>
            <select name="fuel_type" id="fuel_type" class="form-control">
                <option value="">Fuel Type</option>
                <option value="Petrol" {{ $fuel_type == 'Petrol' ? 'selected' : '' }}>Petrol</option>
                <option value="Diesel" {{ $fuel_type == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="CNG" {{ $fuel_type == 'CNG' ? 'selected' : '' }}>CNG</option>
                <option value="EV" {{ $fuel_type == 'EV' ? 'selected' : '' }}>EV</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="">Documents</label>
        </div>
    </div>
    <div>
        <button type="button" class="btn btn-success" style="float: right" id="add_vehicle_document_btn">
            <i class="fa fa-plus" aria-hidden="true">
            </i>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Document Title</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Document</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="add_vehicle_document">
            @if (!empty($vehicles))
            @foreach ($vehicles as $item)
            <tr>
                <!-- <td> -->
                    <input type="hidden" class="form-control" name="vehicle_document_id[]" value="{{ $item->vehicle_document_id ?? '' }}">
                <!-- </td> -->
                <td>
                    <input type="text" class="form-control" name="document_title[]" placeholder="Enter Title" value="{{ $item->document_title ?? '' }}" >
                </td>
                <td>
                    <input type="date" class="form-control" name="document_issue_date[]" value="{{ $item->document_issue_date ?? '' }}">
                </td>
                <td>
                    <input type="date" class="form-control" name="document_expiry_date[]" value="{{ $item->document_expiry_date ?? '' }}">
                </td>
                <td>
                    <input type="file" class="form-control" name="document_file[]" value="{{ $item->document_file ?? '' }}" accept="image/*">
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
    $('#add_vehicle_document_btn').click(function() {
        $('#add_vehicle_document').append(`<tr>
                    <td>
                        <input type="text" class="form-control" name="document_title[]" placeholder="Enter Title">
                    </td>
                    <td>
                        <input type="date" class="form-control" name="document_issue_date[]">
                    </td> 
                    <td>
                        <input type="date" class="form-control" name="document_expiry_date[]">
                    </td>
                    <td>
                        <input type="file" class="form-control" name="document_file[]" accept="image/*">
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