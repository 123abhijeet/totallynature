<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Packing</label>
        <input type="text" class="form-control" name="packing" value="{{ $data->packing_name ?? '' }}">
        <input type="hidden" name="packing_id" value="{{ $data->packing_id ?? '' }}">
    </div>
</form>
