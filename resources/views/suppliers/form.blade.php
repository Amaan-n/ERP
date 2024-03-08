<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.suppliers.is_active')) !!}
            </label><br>
            <label class="checkbox mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($supplier) ? 'checked="checked"' : (!empty($supplier) && isset($supplier->is_active) && $supplier->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.suppliers.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($supplier) && !empty($supplier->name) ? $supplier->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.suppliers.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($supplier) && !empty($supplier->description) ? $supplier->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="contact_person">
                Contact Person
                {!! info_circle(config('elements.content.suppliers.contact_person')) !!}
            </label>
            <input type="text" class="form-control" id="contact_person" name="contact_person"
                   value="{{ !empty($supplier) && !empty($supplier->contact_person) ? $supplier->contact_person : old('contact_person') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                {!! info_circle(config('elements.content.suppliers.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone"
                   value="{{ !empty($supplier) && !empty($supplier->phone) ? $supplier->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                Email
                {!! info_circle(config('elements.content.suppliers.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($supplier) && !empty($supplier->email) ? $supplier->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="attachment">
                Attachment
                {!! info_circle(config('elements.content.suppliers.attachment')) !!}
            </label>
            @if(isset($supplier) && !empty($supplier->attachment))
                <div class="float-right input_action_buttons">
                    <a href="javascript:void(0);" target="_blank" class="remove_attachment"
                       data-module="suppliers" data-field="attachment" data-id="{{ $supplier->id }}">
                        Remove
                    </a>
                    &nbsp; | &nbsp;
                    <a href="{{ config('constants.s3.asset_url') . $supplier->attachment }}"
                       target="_blank">
                        Preview
                    </a>
                </div>
            @endif
            <input type="file" class="form-control" id="attachment" name="attachment"
                   accept="image/*"
                   value="{{ !empty($supplier) && !empty($supplier->attachment) ? $supplier->attachment : '' }}">
            <input type="hidden" name="old_attachment"
                   value="{{ !empty($supplier) && !empty($supplier->attachment) ? $supplier->attachment : '' }}">
        </div>
    </div>
</div>
