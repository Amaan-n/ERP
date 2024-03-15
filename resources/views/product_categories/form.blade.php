<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.product_categories.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($product_category) ? 'checked="checked"' : (!empty($product_category) && isset($product_category->is_active) && $product_category->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.product_categories.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($product_category) && !empty($product_category->name) ? $product_category->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.product_categories.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($product_category) && !empty($product_category->description) ? $product_category->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
