<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Payment Term</label>
        <input type="text" class="form-control" name="payment_type" value="{{ $data->payment_type ?? '' }}">
        <input type="hidden" name="payment_type_id" value="{{ $data->payment_type_id ?? '' }}">
    </div>
</form>
