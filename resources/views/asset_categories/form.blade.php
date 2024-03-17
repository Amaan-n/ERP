<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.asset_categories.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($asset_category) ? 'checked="checked"' : (!empty($asset_category) && isset($asset_category->is_active) && $asset_category->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.asset_categories.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($asset_category) && !empty($asset_category->name) ? $asset_category->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.asset_categories.attachment')) !!}
            </label>
            {!! preview_and_remove_buttons($asset_category ?? null, 'asset_categories', 'attachment') !!}
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($asset_category) && !empty($asset_category->attachment) ? $asset_category->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($asset_category) && !empty($asset_category->attachment) ? $asset_category->attachment : '' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.asset_categories.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($asset_category) && !empty($asset_category->description) ? $asset_category->description : old('description') }}</textarea>
        </div>
    </div>
</div>
