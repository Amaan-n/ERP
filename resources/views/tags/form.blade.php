<div class="card card-custom gutter-b">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="checkbox mb-2">
                        <input type="checkbox" value="1" name="is_active"
                            {{ (!isset($tag) ? 'checked="checked"' : (!empty($tag) && isset($tag->is_active) && $tag->is_active == 1 ? 'checked="checked"' : '')) }}>
                        <span class="mr-3"> </span>
                        Is Active
                        {!! info_circle(config('elements.content.tags.is_active')) !!}
                    </label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="chip_order_name">
                        Chip Order Name
                        <span class="text-danger">*</span>
                        {!! info_circle(config('elements.content.tags.chip_order_name')) !!}
                    </label>
                    <input type="text" class="form-control" id="chip_order_name" name="chip_order_name"
                           value="{{ !empty($tag) && !empty($tag->chip_order_name) ? $tag->chip_order_name : old('chip_order_name', $chip_order_name) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="quantity">
                        Quantity
                        <span class="text-danger">*</span>
                        {!! info_circle(config('elements.content.tags.quantity')) !!}
                    </label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="100"
                           value="{{ !empty($tag) && !empty($tag->quantity) ? $tag->quantity : old('quantity', 1) }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom gutter-b">
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-primary">{{ isset($tag) && isset($tag->id) && $tag->id > 0 ? 'Save' : 'Submit' }}</button>
                    <a href="{{ route('tags.index') }}" class="btn btn-secondary ml-3"
                       data-id="tags">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
