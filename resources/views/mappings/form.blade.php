<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="asset_id">
                Asset
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.tags_mappings.asset_id')) !!}
            </label>
            <select name="asset_id" id="asset_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getAssets() as $asset)
                    <option value="{{ $asset->id }}"
                    >{{ $asset->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="tag_id">
                Tag
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.tags_mappings.tag_id')) !!}
            </label>
            <select name="tag_id" id="tag_id" class="form-control">
                <option value="">Please select a value</option>
                @foreach(\App\Providers\FormList::getTags() as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
