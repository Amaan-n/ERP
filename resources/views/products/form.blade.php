<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.products.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($product) ? 'checked="checked"' : (!empty($product) && isset($product->is_active) && $product->is_active == 1 ? 'checked="checked"' : '')) }}>
                <span class="mr-3"> </span>
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="product_category_id">
                Product Category
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.products.product_category_id')) !!}
            </label>
            <select name="product_category_id" id="product_category_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getProductCategories() as $product_category)
                    <option value="{{ $product_category->id }}"
                        {{ !empty($product) && $product->product_category_id == $product_category->id ? 'selected="selected"' : '' }}
                    >{{ $product_category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.products.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($product) && !empty($product->name) ? $product->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="price">
                Price
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.products.price')) !!}
            </label>
            <div class="input-group">
                <input type="number" class="form-control" id="price" name="price"
                       value="{{ !empty($product) && !empty($product->price) ? $product->price : old('price') }}">
                <div class="input-group-append">
                    <span class="input-group-text">KWD</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="barcode">
                Barcode
                {!! info_circle(config('elements.content.products.barcode')) !!}
            </label>
            <input type="text" class="form-control" id="barcode" name="barcode"
                   value="{{ !empty($product) && !empty($product->barcode) ? $product->barcode : old('barcode') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.products.attachment')) !!}
            </label>
            {!! preview_and_remove_buttons($product ?? null, 'products', 'attachment') !!}
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($product) && !empty($product->attachment) ? $product->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($product) && !empty($product->attachment) ? $product->attachment : '' }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.products.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($product) && !empty($product->description) ? $product->description : old('description') }}</textarea>
        </div>
    </div>
</div>
