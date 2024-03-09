<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.manufacturers.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($manufacturer) ? 'checked="checked"' : (!empty($manufacturer) && isset($manufacturer->is_active) && $manufacturer->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.manufacturers.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->name) ? $manufacturer->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.manufacturers.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($manufacturer) && !empty($manufacturer->description) ? $manufacturer->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_person">
                Contact Person
                {!! info_circle(config('elements.content.manufacturers.contact_person')) !!}
            </label>
            <input type="text" class="form-control" id="contact_person" name="contact_person"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->contact_person) ? $manufacturer->contact_person : old('contact_person') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                {!! info_circle(config('elements.content.manufacturers.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->phone) ? $manufacturer->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                Email
                {!! info_circle(config('elements.content.manufacturers.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->email) ? $manufacturer->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.manufacturers.attachment')) !!}
            </label>
            {!! preview_and_remove_buttons($manufacturer ?? null, 'manufacturers', 'attachment') !!}
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->attachment) ? $manufacturer->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($manufacturer) && !empty($manufacturer->attachment) ? $manufacturer->attachment : '' }}">
        </div>
    </div>
</div>
