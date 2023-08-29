<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}"
    data-table="{{ $table }}">
    @csrf
    @method($method)
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Warehouse Code*</label>
        <input type="text" class="form-control" name="warehouse_code" value="{{ $data->warehouse_code ?? '' }}"
            placeholder="Warehouse Code">
        <input type="hidden" name="warehouse_id" value="{{ $data->warehouse_id ?? '' }}">
    </div>

    <div class="col-6">
        <label for="inputNanme4" class="form-label">Warehouse Name *</label>
        <input type="text" class="form-control" name="warehouses_name" value="{{ $data->warehouse_name ?? '' }}"
            placeholder="Warehouse Name ">
    </div>
    <div>
        <button type="button" class="btn btn-success" style="float: right" id="add_warehouses_sub_location_btn">
            <i class="fa fa-plus" aria-hidden="true">
            </i>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Sub Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="add_warehouses_sub_location">
            @if (!empty($sub_location))
                @foreach ($sub_location as $item)
                    <tr>
                        {{-- <td> --}}
                        <input type="hidden" class="form-control" name="warehouses_sub_location_id[]"
                            value="{{ $item->warehouse_sub_location_id ?? '' }}">
                        {{-- </td> --}}
                        <td>
                            <input type="text" class="form-control" name="warehouses_sub_location[]"
                                placeholder="Sub Location" value="{{ $item->sub_location ?? '' }}">
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
    $('#add_warehouses_sub_location_btn').click(function() {
        $('#add_warehouses_sub_location').append(`<tr>
            <tr>
                     
                        <input type="hidden" class="form-control" name="warehouses_sub_location_id[]"
                            value="{{ $item->uom_id ?? '' }}">
                     
                        <td>
                            <input type="text" class="form-control" name="warehouses_sub_location[]"
                                placeholder="Sub Location" value="{{ $item->uom ?? '' }}">
                        </td>
                        <td>
                            <i class="fa fa-trash delete" aria-hidden="true"></i>
                        </td>
                    </tr>
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
