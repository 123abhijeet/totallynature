<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Region</label>
        <input type="text" class="form-control" name="region" value="{{ $data->region_name ?? '' }}">
        <input type="hidden" name="region_id" value="{{ $data->region_id ?? '' }}">
    </div>
</form>
