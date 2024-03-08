<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.fields.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($field) ? 'checked="checked"' : (!empty($field) && isset($field->is_active) && $field->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"></span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.fields.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($field) && !empty($field->name) ? $field->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.fields.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($field) && !empty($field->description) ? $field->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="element">
                Element
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.asset_models.element')) !!}
            </label>
            <select name="element" id="element" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Models\Field::ELEMENTS as $value)
                    <option value="{{ $value }}"
                        {{ !empty($field) && $field->element == $value ? 'selected="selected"' : '' }}
                    >{{ ucwords($value) }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div
    class="row element_selection {{ !isset($field) ? 'd-none' : (!empty($field->element) && in_array($field->element, ['select', 'checkbox', 'radio']) ? '' : 'd-none') }}">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="option_1">Option 1</label>
            <input type="text" class="form-control" id="option_1" name="options[]"
                   value="{{ isset($field) && count($field->options) > 0 && isset($field->options[0]) ? $field->options[0]->text : '' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="option_1">Option 2</label>
            <input type="text" class="form-control" id="option_2" name="options[]"
                   value="{{ isset($field) && count($field->options) > 0 && isset($field->options[1]) ? $field->options[1]->text : '' }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="option_1">Option 3</label>
            <input type="text" class="form-control" id="option_3" name="options[]"
                   value="{{ isset($field) && count($field->options) > 0 && isset($field->options[2]) ? $field->options[2]->text : '' }}">
        </div>
    </div>
</div>
