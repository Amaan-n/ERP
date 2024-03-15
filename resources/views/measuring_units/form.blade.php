<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active?
                {!! info_circle(config('elements.content.measuring_units.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($measuring_unit) ? 'checked="checked"' : (!empty($measuring_unit) && isset($measuring_unit->is_active) && $measuring_unit->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.measuring_units.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ isset($measuring_unit) && !empty($measuring_unit->name) ? $measuring_unit->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.measuring_units.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($measuring_unit) && !empty($measuring_unit->description) ? $measuring_unit->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg">
            Submit
        </button>
    </div>
</div>
