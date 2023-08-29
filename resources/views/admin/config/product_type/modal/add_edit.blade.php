<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Product Type</label>
        <input type="text" class="form-control" name="product_type" value="{{ $data->product_type ?? '' }}">
        <input type="hidden" name="product_type_id" value="{{ $data->product_type_id ?? '' }}">
    </div>
</form>
