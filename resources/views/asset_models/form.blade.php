<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.asset_models.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($asset_model) ? 'checked="checked"' : (!empty($asset_model) && isset($asset_model->is_active) && $asset_model->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"> </span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="manufacturer_id">
                Manufacturer
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.asset_models.manufacturer_id')) !!}
            </label>
            <select name="manufacturer_id" id="manufacturer_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getManufacturers() as $manufacturer)
                    <option value="{{ $manufacturer->id }}"
                        {{ !empty($asset_model) && $asset_model->manufacturer_id == $manufacturer->id ? 'selected="selected"' : '' }}
                    >{{ $manufacturer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="asset_category_id">
                Asset Category
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.asset_models.asset_category_id')) !!}
            </label>
            <select name="asset_category_id" id="asset_category_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getAssetCategories() as $asset_category)
                    <option value="{{ $asset_category->id }}"
                        {{ !empty($asset_model) && $asset_model->asset_category_id == $asset_category->id ? 'selected="selected"' : '' }}
                    >{{ $asset_category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="field_group_id">
                Field Group
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.asset_models.field_group_id')) !!}
            </label>
            <select name="field_group_id" id="field_group_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getFieldGroups() as $field_group)
                    <option value="{{ $field_group->id }}"
                        {{ !empty($asset_model) && $asset_model->field_group_id == $field_group->id ? 'selected="selected"' : '' }}
                    >{{ $field_group->name }}</option>
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
                {!! info_circle(config('elements.content.asset_models.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($asset_model) && !empty($asset_model->name) ? $asset_model->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="model_number">
                Model Number
                {!! info_circle(config('elements.content.asset_models.model_number')) !!}
            </label>
            <input type="text" class="form-control" id="model_number" name="model_number"
                   value="{{ !empty($asset_model) && !empty($asset_model->model_number) ? $asset_model->model_number : old('model_number') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.asset_models.attachment')) !!}
            </label>
            {!! preview_and_remove_buttons($asset_model ?? null, 'asset_models', 'attachment') !!}
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($asset_model) && !empty($asset_model->attachment) ? $asset_model->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($asset_model) && !empty($asset_model->attachment) ? $asset_model->attachment : '' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="notes">
                Notes
                {!! info_circle(config('elements.content.asset_models.notes')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="notes" id="notes"
                      placeholder="Type here something...">{{ !empty($asset_model) && !empty($asset_model->notes) ? $asset_model->notes : old('notes') }}</textarea>
        </div>
    </div>
</div>
