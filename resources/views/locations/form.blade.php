<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.locations.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($location) ? 'checked="checked"' : (!empty($location) && isset($location->is_active) && $location->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.locations.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($location) && !empty($location->name) ? $location->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.locations.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($location) && !empty($location->description) ? $location->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="autocomplete">Location</label>
            <input type="text" id="autocomplete" class="form-control" name="location"
                   placeholder="Enter a location"
                   value="{{ !empty($location->location) ? $location->location : old('location') }}"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude"
                   value="{{ !empty($location->latitude) ? $location->latitude : old('latitude') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude"
                   value="{{ !empty($location->longitude) ? $location->longitude : old('longitude') }}">
        </div>
    </div>
</div>

<div class="row mt-3 mb-3">
    <div class="col-md-12">
        <div class="form-group">
            <div id="map" style="height:200px; width:100%;"></div>
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
