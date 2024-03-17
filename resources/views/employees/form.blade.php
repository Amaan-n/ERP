<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.employees.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($employee) ? 'checked="checked"' : (!empty($employee) && isset($employee->is_active) && $employee->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.employees.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ isset($employee) && !empty($employee->name) ? $employee->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.employees.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($employee) && !empty($employee->phone) ? $employee->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="email">
                Email
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.employees.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($employee) && !empty($employee->email) ? $employee->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="picture">
                Picture
                {!! info_circle(config('elements.content.employees.picture')) !!}
            </label>
            {!! preview_and_remove_buttons($employee ?? null, 'employees', 'picture') !!}
            <input type="file" class="form-control" id="picture" name="picture"
                   accept="image/*"
                   value="{{ !empty($employee) && !empty($employee->picture) ? $employee->picture : '' }}">
            <input type="hidden" name="old_picture"
                   value="{{ !empty($employee) && !empty($employee->picture) ? $employee->picture : '' }}">
        </div>
    </div>

    @if(!isset($employee))
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label" for="password">
                    Password
                    {!! info_circle(config('elements.content.employees.password')) !!}
                </label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    Confirm Password
                    {!! info_circle(config('elements.content.employees.confirm_password')) !!}
                </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="about">
                About
                {!! info_circle(config('elements.content.employees.about')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="about" id="about"
                      placeholder="Type here something...">{{ !empty($employee) && !empty($employee->about) ? $employee->about : old('about') }}</textarea>
        </div>
    </div>
</div>
