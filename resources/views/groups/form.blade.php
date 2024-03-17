<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label class="form-label" for="is_active">
                Is Active
                {!! info_circle(config('elements.content.groups.is_active')) !!}
            </label><br>
            <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                <input type="checkbox" value="1" name="is_active"
                    {{ (!isset($group) ? 'checked="checked"' : (!empty($group) && isset($group->is_active) && $group->is_active == 1 ? 'checked="checked"' : '')) }}>
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
                {!! info_circle(config('elements.content.groups.name')) !!}
            </label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ !empty($group) && !empty($group->name) ? $group->name : old('name') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">
                Description
                {!! info_circle(config('elements.content.groups.description')) !!}
            </label>
            <textarea rows="3" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($group) && !empty($group->description) ? $group->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="row system_modules">
    <div class="col-md-12">
        <div class="form-group">
            <?php $prepared_system_modules = config('policies'); ?>

            @if(!empty($prepared_system_modules) && count($prepared_system_modules) > 0)
                <div class="row">
                    <?php $index = 0; ?>
                    @foreach($prepared_system_modules as $navigation_heading => $system_modules)
                        <div class="col-md-12 mt-5 mb-5">
                            <h4><strong>{{ ucwords(str_replace('_', ' ', $navigation_heading)) }}</strong></h4>
                        </div>

                        @if(!empty($system_modules))
                            @foreach($system_modules as $key => $system_module)
                                <div class="col-md-2 parent_module">
                                    <p class="mb-5">
                                        <strong>{{ ucwords(str_replace(array('-', '_'), ' ', $key)) }}</strong></p>

                                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-5">
                                        <input type="checkbox" class="select_all_checkboxes">
                                        <span class="mr-3"></span>
                                        Select ALL
                                    </label>

                                    @foreach($system_module as $module)
                                        <label
                                            class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary mb-2">
                                            <input type="checkbox" class="system_module_checkboxes"
                                                   name="system_modules[]"
                                                   value="{{ $module }}"
                                                {{ isset($selected_access) && in_array($module, $selected_access) ? 'checked="checked"' : '' }}>
                                            <span class="mr-3"></span>

                                            <?php
                                            $exploded_module_name = !empty($module) ? explode('.', $module) : [];
                                            switch (count($exploded_module_name)) {
                                                case 2:
                                                    $module_name = str_replace(array('_', '.'), array(' ', ' '), $exploded_module_name[1]);
                                                    break;
                                                case 3:
                                                    $module_name = str_replace(array('_', '.'), array(' ', ' '), $exploded_module_name[1])
                                                        . ' ' . str_replace(array('_', '.'), array(' ', ' '), $exploded_module_name[2]);
                                                    break;
                                                default:
                                                    $module_name = str_replace(array('_', '.'), array(' ', ' '), $exploded_module_name[0]);
                                                    break;
                                            }

                                            switch ($module_name) {
                                                case 'index':
                                                    $module_display_name = 'listing';
                                                    break;
                                                case 'show':
                                                    $module_display_name = 'read';
                                                    break;
                                                case 'edit':
                                                    $module_display_name = 'update';
                                                    break;
                                                default:
                                                    $module_display_name = $module_name;
                                                    break;
                                            }
                                            ?>

                                            {{ ucwords($module_display_name) }}
                                        </label>
                                    @endforeach
                                    <br>
                                    <?php $index++; ?>
                                </div>
                            @endforeach
                        @endif

                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
