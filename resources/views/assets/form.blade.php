<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.assets.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($asset) ? 'checked="checked"' : (!empty($asset) && isset($asset->is_active) && $asset->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"> </span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="supplier_id">
                Supplier
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.assets.supplier_id')) !!}
            </label>
            <select name="supplier_id" id="supplier_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getSuppliers() as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ !empty($asset) && $asset->supplier_id == $supplier->id ? 'selected="selected"' : '' }}
                    >{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="asset_model_id">
                Asset Model
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.assets.asset_model_id')) !!}
            </label>
            <select name="asset_model_id" id="asset_model_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getAssetModels() as $asset_model)
                    <option value="{{ $asset_model->id }}"
                        {{ !empty($asset) && $asset->asset_model_id == $asset_model->id ? 'selected="selected"' : '' }}
                    >{{ $asset_model->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.assets.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($asset) && !empty($asset->name) ? $asset->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="purchase_date">
                Purchase Date
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.assets.purchase_date')) !!}
            </label>
            <input type="text" class="form-control date_picker" id="purchase_date" name="purchase_date"
                   value="{{ !empty($asset) && !empty($asset->purchase_date) ? $asset->purchase_date : old('purchase_date') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="purchase_cost">
                Purchase Cost
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.assets.purchase_cost')) !!}
            </label>
            <div class="input-group">
                <input type="number" class="form-control" id="purchase_cost" name="purchase_cost"
                       value="{{ !empty($asset) && !empty($asset->purchase_cost) ? $asset->purchase_cost : old('purchase_cost') }}">
                <div class="input-group-append">
                    <span class="input-group-text">KWD</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="order_number">
                Order Number
                {!! info_circle(config('elements.content.assets.order_number')) !!}
            </label>
            <input type="text" class="form-control" id="order_number" name="order_number"
                   value="{{ !empty($asset) && !empty($asset->order_number) ? $asset->order_number : old('order_number') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="warranty_in_months">
                Warranty
                {!! info_circle(config('elements.content.assets.warranty_in_months')) !!}
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="warranty_in_months" name="warranty_in_months"
                       value="{{ !empty($asset) && !empty($asset->warranty_in_months) ? $asset->warranty_in_months : old('warranty_in_months') }}">
                <div class="input-group-append">
                    <span class="input-group-text">MONTHS</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.assets.attachment')) !!}
            </label>
            {!! preview_and_remove_buttons($asset ?? null, 'assets', 'attachment') !!}
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($asset) && !empty($asset->attachment) ? $asset->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($asset) && !empty($asset->attachment) ? $asset->attachment : '' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="notes">
                Notes
                {!! info_circle(config('elements.content.assets.notes')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="notes" id="notes"
                      placeholder="Type here something...">{{ !empty($asset) && !empty($asset->notes) ? $asset->notes : old('notes') }}</textarea>
        </div>
    </div>
</div>

<div class="card card-custom gutter-b bg-light mt-5 asset_parameters">
    <div class="card-header flex-wrap py-3">
        <div class="card-title">
            <h3 class="card-label">Parameters</h3>
        </div>
    </div>
    <div class="card-body">
        @if(isset($asset) && !empty($asset->parameters) && count($asset->parameters) > 0)
            <div class="row">
                @foreach($asset->parameters as $key => $parameter)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="parameter_{{ $key }}">{{ $parameter->key ?? '' }}</label>
                            <input
                                type="text" class="form-control" id="parameter_{{ $key }}"
                                name="parameters[{{ $parameter->key }}]"
                                value="{{ $parameter->value }}">
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-danger">Please select an asset model first.</p>
        @endif
    </div>
</div>
