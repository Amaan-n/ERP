<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.customers.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($customer) ? 'checked="checked"' : (!empty($customer) && isset($customer->is_active) && $customer->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.customers.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($customer) && !empty($customer->name) ? $customer->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.customers.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone"
                   value="{{ !empty($customer) && !empty($customer->phone) ? $customer->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="email">
                Email
                {!! info_circle(config('elements.content.customers.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($customer) && !empty($customer->email) ? $customer->email : old('email') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="about">
                About
                {!! info_circle(config('elements.content.customers.about')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="about" id="about"
                      placeholder="Type here something...">{{ !empty($customer) && !empty($customer->about) ? $customer->about : old('about') }}</textarea>
        </div>
    </div>
</div>
