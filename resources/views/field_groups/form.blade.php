<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.field_groups.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($field_group) ? 'checked="checked"' : (!empty($field_group) && isset($field_group->is_active) && $field_group->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.field_groups.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($field_group) && !empty($field_group->name) ? $field_group->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.field_groups.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($field_group) && !empty($field_group->description) ? $field_group->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="fields">
                Fields
                {!! info_circle(config('elements.content.field_groups.fields')) !!}
            </label>
            <select name="fields[]" id="fields" class="form-control" multiple>
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getFields() as $field)
                    <option value="{{ $field->id }}"
                        {{ isset($field_group) && !empty($field_group->fields) && in_array($field->id, $field_group->fields->pluck('field_id')->toArray()) ? 'selected="selected"' : '' }}
                    >{{ $field->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
