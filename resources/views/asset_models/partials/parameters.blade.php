<div class="row">
    @if(isset($field_group) && !empty($field_group->fields) && count($field_group->fields) > 0)
        @foreach($field_group->fields as $key => $field)
            @if(isset($field->field))
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label" for="parameter_{{ $key }}">{{ $field->field->name ?? '' }}</label>
                        <input type="text" class="form-control" id="parameter_{{ $key }}"
                               name="parameters[{{ $field->field->name }}]"
                               value="">
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
