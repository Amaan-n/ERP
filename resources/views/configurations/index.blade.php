@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card card-custom gutter-b">

                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Configurations</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('configurations', 'configurations') !!}
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('configurations.update') }}" method="post"
                          enctype="multipart/form-data" class="configuration_form" id="configuration_form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs tabs" role="tablist">
                                    @if(isset($configurations) && count($configurations) > 0)
                                        @foreach($configurations as $configuration_key => $configuration)
                                            <li class="nav-item">
                                                <a class="nav-link <?php echo $configuration_key == 0 ? 'active' : '' ?>"
                                                   data-toggle="tab" href="#tab_{{ $configuration_key }}"
                                                   role="tab">{{ ucwords($configuration->display_text) }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="tab-content tabs card-block py-10">
                                    @if(isset($configurations) && count($configurations) > 0)
                                        @foreach($configurations as $configuration_key => $configuration)
                                            <div
                                                class="tab-pane <?php echo $configuration_key == 0 ? 'active' : '' ?>"
                                                id="tab_{{ $configuration_key }}" role="tabpanel">

                                                @if(isset($configuration->child_configurations) && count($configuration->child_configurations) > 0)
                                                    <div class="row">
                                                        @foreach($configuration->child_configurations as $child)
                                                            @if($child->input_type == 'text')
                                                                <div class="col-md-{{ $child->grid ?? 4 }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child->key }}">
                                                                            {{ ucwords($child->display_text) }}
                                                                            {!! info_circle(config('elements.content.configurations.' . $child->key)) !!}
                                                                        </label>
                                                                        <input type="text"
                                                                               class="form-control"
                                                                               id="{{ $child->key }}"
                                                                               name="configurations[{{ $child->parent_id }}][{{ $child->key }}]"
                                                                               value="{{ $child->value }}">
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child->input_type == 'timepicker')
                                                                <div class="col-md-{{ $child->grid ?? 4 }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child->key }}">
                                                                            {{ ucwords($child->display_text) }}
                                                                            {!! info_circle(config('elements.content.configurations.' . $child->key)) !!}
                                                                        </label>
                                                                        <input type="text"
                                                                               class="form-control time_picker"
                                                                               id="{{ $child->key }}"
                                                                               name="configurations[{{ $child->parent_id }}][{{ $child->key }}]"
                                                                               value="{{ $child->value }}">
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child->input_type == 'select')
                                                                <div class="col-md-{{ $child->grid ?? 4 }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child->key }}">
                                                                            {{ ucwords($child->display_text) }}
                                                                            {!! info_circle(config('elements.content.configurations.' . $child->key)) !!}
                                                                        </label>

                                                                        <?php $options = !empty($child->options) ? json_decode($child->options) : [] ?>
                                                                        <select
                                                                            name="configurations[{{ $child->parent_id }}][{{ $child->key }}][]"
                                                                            class="form-control select2"
                                                                            id="{{ $child->key }}" multiple>
                                                                            @foreach($options as $option)
                                                                                <option value="{{ $option }}"
                                                                                    {{ in_array($option, explode(', ', $child->value)) ? 'selected="selected"' : '' }}
                                                                                >{{ ucwords(str_replace('_', ' ', $option)) }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child->input_type == 'file')
                                                                <div class="col-md-{{ $child->grid ?? 4 }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child->key }}">
                                                                            {{ ucwords($child->display_text) }}
                                                                        </label>

                                                                        @if(isset($child->value) && !empty($child->value))
                                                                            <a
                                                                                href="{{ config('constants.s3.asset_url') . $child->value }}"
                                                                                target="_blank" class="float-right" data-lightbox="image-1">
                                                                                <i class="fa fa-image"></i>
                                                                            </a>
                                                                        @endif

                                                                        <input
                                                                            type="file" class="form-control"
                                                                            id="{{ $child->key }}"
                                                                            name="configurations[{{ $child->parent_id }}][{{ $child->key }}]"
                                                                            value="{{ $child->value }}">
                                                                        <input
                                                                            type="hidden"
                                                                            name="configurations[{{ $child->parent_id }}][{{ $child->key }}]"
                                                                            value="{{ $child->value }}">
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            @if($child->input_type == 'textarea')
                                                                <div class="col-md-{{ $child->grid ?? 12 }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label"
                                                                               for="{{ $child->key }}">
                                                                            {{ ucwords($child->display_text) }}
                                                                        </label>
                                                                        <textarea rows="1" cols="5" class="form-control"
                                                                                  name="configurations[{{ $child->parent_id }}][{{ $child->key }}]"
                                                                                  id="{{ $child->key }}"
                                                                                  placeholder="Type here something...">{{ $child->value }}</textarea>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Submit
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).find('.select2').select2({
                placeholder: 'Please select a value',
                allowClear: true,
                closeOnSelect: false
            });

            $('.time_picker').timepicker({
                minuteStep: 30,
                defaultTime: '',
                showSeconds: false,
                showMeridian: true,
                snapToStep: true,
                dropdown: true
            });
        });
    </script>
@stop
