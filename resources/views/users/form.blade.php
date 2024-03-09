@if(!isset($request_from))
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="is_active">
                    Is Active
                    {!! info_circle(config('elements.content.users.is_active')) !!}
                </label><br>
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                    <input type="checkbox" value="1" name="is_active"
                        {{ (!isset($user) ? 'checked="checked"' : (!empty($user) && isset($user->is_active) && $user->is_active == 1 ? 'checked="checked"' : '')) }}>
                    <span class="mr-3"></span>
                </label>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="group_id">
                Group
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.group')) !!}
            </label>

            @if(isset($request_from) && $request_from == 'profile')
                <p>{{ isset($user->group) && !empty($user->group->name) ? $user->group->name : '-' }}</p>
                <input type="hidden" name="group_id" value="{{ $user->group_id }}">
            @else
                <select name="group_id" id="group_id" class="form-control">
                    <option value="">Please select a value</option>
                    @foreach(\App\Providers\FormList::getGroups() as $group)
                        @if(($is_root_user == 0 || auth()->user()->group_id != 1) && in_array($group->id, [1]))
                            <?php continue; ?>
                        @endif

                        <option value="{{ $group->id }}"
                            {{ !empty($user) && $user->group_id == $group->id ? 'selected="selected"' : '' }}
                        >{{ $group->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="name">
                Name
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ isset($user) && !empty($user->name) ? $user->name : old('name') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="phone">
                Phone
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.phone')) !!}
            </label>
            <input type="text" class="form-control" id="phone" name="phone" maxlength="10"
                   value="{{ !empty($user) && !empty($user->phone) ? $user->phone : old('phone') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="email">
                Email
                <span class="text-danger">*</span>
                {!! info_circle(config('elements.content.users.email')) !!}
            </label>
            <input type="text" class="form-control" id="email" name="email"
                   value="{{ !empty($user) && !empty($user->email) ? $user->email : old('email') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="designation">
                Designation
                {!! info_circle(config('elements.content.users.designation')) !!}
            </label>
            <input type="text" class="form-control" id="designation" name="designation"
                   value="{{ !empty($user) && !empty($user->designation) ? $user->designation : old('designation') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="picture">
                Picture
                {!! info_circle(config('elements.content.users.picture')) !!}
            </label>
            {!! preview_and_remove_buttons($user ?? null, 'users', 'picture') !!}
            <input type="file" class="form-control" id="picture" name="picture"
                   accept="image/*"
                   value="{{ !empty($user) && !empty($user->picture) ? $user->picture : '' }}">
            <input type="hidden" name="old_picture"
                   value="{{ !empty($user) && !empty($user->picture) ? $user->picture : '' }}">
        </div>
    </div>
</div>

@if(!isset($user))
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="password">
                    Password
                    {!! info_circle(config('elements.content.users.password')) !!}
                </label>
                <input type="password" class="form-control" id="password" name="password" value="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    Confirm Password
                    {!! info_circle(config('elements.content.users.confirm_password')) !!}
                </label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="LinkedIn_URL">
                LinkedIn
                {!! info_circle(config('elements.content.users.LinkedIn_URL')) !!}
            </label>
            <input type="text" class="form-control" id="LinkedIn_URL" name="LinkedIn_URL"
                   value="{{ !empty($user) && !empty($user->LinkedIn_URL) ? $user->LinkedIn_URL : old('LinkedIn_URL') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="twitter_URL">
                Twitter
                {!! info_circle(config('elements.content.users.twitter_URL')) !!}
            </label>
            <input type="text" class="form-control" id="twitter_URL" name="twitter_URL"
                   value="{{ !empty($user) && !empty($user->twitter_URL) ? $user->twitter_URL : old('twitter_URL') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="instagram_URL">
                Instagram
                {!! info_circle(config('elements.content.users.instagram_URL')) !!}
            </label>
            <input type="text" class="form-control" id="instagram_URL" name="instagram_URL"
                   value="{{ !empty($user) && !empty($user->instagram_URL) ? $user->instagram_URL : old('instagram_URL') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="about">
                About
                {!! info_circle(config('elements.content.users.about')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="about" id="about"
                      placeholder="Type here something...">{{ !empty($user) && !empty($user->about) ? $user->about : old('about') }}</textarea>
        </div>
    </div>
</div>
