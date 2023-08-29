<form class="row g-3" action="{{ $action }}" id="add_resion_form" method="{{ $method }}"
    data-table="{{ $table }}">
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Unit of Measure Category*</label>
        <input type="text" class="form-control" name="uom_category_name" value="{{ $data->uom_category_name ?? '' }}"
            placeholder="Unit of Measure Category">
        <input type="hidden" name="uom_category_id" value="{{ $data->uom_category_id ?? '' }}">
    </div>
    <div>
        <button type="button" class="btn btn-success" style="float: right" id="add_unit_of_measure_btn">
            <i class="fa fa-plus" aria-hidden="true">
            </i>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Unit of Measure</th>
                <th>Ratio</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="add_unit_of_measure">
            @if (!empty($uom))
                @foreach ($uom as $item)
                    <tr>
                        {{-- <td> --}}
                            <input type="hidden" class="form-control" name="unit_of_measure_id[]" 
                                placeholder="Enter Unit of Measure" value="{{ $item->uom_id ?? '' }}">
                        {{-- </td> --}}
                        <td>
                            <input type="text" class="form-control" name="unit_of_measure[]"
                                placeholder="Enter Unit of Measure" value="{{ $item->uom ?? '' }}">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="ratio[]" placeholder="Enter Ratio"
                                value="{{ $item->ratio ?? '' }}">
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
    $('#add_unit_of_measure_btn').click(function() {
        $('#add_unit_of_measure').append(`<tr>
                    <td>
                        <input type="text" class="form-control" name="unit_of_measure[]" placeholder="Enter Unit of Measure">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="ratio[]" placeholder="Enter Ratio">
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
