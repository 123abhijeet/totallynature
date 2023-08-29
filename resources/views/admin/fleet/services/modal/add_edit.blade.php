<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    @php
    $driver_id = $data->driver_id ?? '';
    $vehicle_id = $data->vehicle_id ?? '';
    @endphp
    <div class="col-12">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Description*</label>
            <input type="text" class="form-control" name="description" value="{{ $data->description ?? '' }}" placeholder="Description">
            <input type="hidden" name="service_id" value="{{ $data->service_id ?? '' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Service Type</label>
            <input type="text" class="form-control" name="service_type" value="{{ $data->service_type ?? '' }}" placeholder="Service Type">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4">Driver</label>
            <select name="driver_id" id="inputNanme4" class="form-select form-control">
                @foreach($drivers = App\Models\Driver::all() as $driver)
                <option value="{{$driver->driver_id}}" {{$driver_id == $driver->driver_id ? 'selected' : ''}}>{{$driver->driver_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4">Vehicle</label>
            <select name="vehicle_id" id="inputNanme4" class="form-select form-control">
                @foreach($vehicles = App\Models\Vehicle::all() as $vehicle)
                <option value="{{$vehicle->vehicle_id}}" {{$vehicle_id == $vehicle->vehicle_id ? 'selected' : ''}}>{{$vehicle->vehicle_modal}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ $data->date ?? '' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Odometer Value</label>
            <input type="text" class="form-control" name="odometer_value" value="{{ $data->odometer_value ?? '' }}" placeholder="Odometer Value">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Odometer Photo</label>
            <input type="file" class="form-control" name="odometer_file" value="{{ $data->odometer_file ?? '' }}">
            @if(!empty($data->odometer_file))
            <img src="{{asset($data->odometer_file)}}" alt="" height="40px" width="40px">
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Cost</label>
            <input type="text" class="form-control" name="cost" value="{{ $data->cost ?? '' }}" placeholder="Cost">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="inputNanme4" class="form-label">Invoice</label>
            <input type="file" class="form-control" name="invoice_file" value="{{ $data->invoice_file ?? '' }}">
            @if(!empty($data->invoice_file))
            <img src="{{asset($data->invoice_file)}}" alt="" height="40px" width="40px">
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="mb-3">
            <label for="inputNanme4">Notes</label>
            <textarea name="notes" id="" cols="30" rows="10" class="form-control" style="height: 70px;">{{ $data->notes ?? '' }}</textarea>
        </div>
    </div>
</form>