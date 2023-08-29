<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Price Structure</label>
        <input type="text" class="form-control" name="price_structure" value="{{ $data->price_structure ?? '' }}">
        <input type="hidden" name="price_structure_id" value="{{ $data->price_structure_id ?? '' }}">
    </div>
</form>
