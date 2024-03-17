@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
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
                        <h3 class="card-label">Import - {{ ucwords(str_replace('_', ' ', $module_name)) }}</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ \Illuminate\Support\Facades\URL::to('/uploads/configurations/sample_'.$module_name.'.csv') }}"
                           class="btn btn-outline-secondary mr-3">
                            Download Sample CSV File
                        </a>
                        {!! prepare_header_html($module_name, 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('imports.parse', [$module_name]) }}" method="post"
                          enctype="multipart/form-data" class="import_form" id="import_form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="import_type">
                                        Actions
                                        <span class="text-danger">*</span>
                                        {!! info_circle(config('elements.content.'.$module_name.'.import.type')) !!}
                                    </label>
                                    <div class="radio-inline">
                                        <label class="radio">
                                            <input type="radio" name="import_type" value="Append" checked="checked">
                                            <span class="mr-2"></span>
                                            Append
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="import_type" value="Override"
                                                {{ session()->get('import_type') === 'Override' ? 'checked="checked"' : '' }}>
                                            <span class="mr-2"></span>
                                            Override
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="attachment">
                                        Attachment ( CSV )
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" class="form-control" id="attachment" name="attachment" value="">
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
                    </form>

                    @if(!empty($response) && count($response) > 0)
                        <div class="d-flex align-items-center">
                            <div class="text-info font-size-h6 mr-2">
                                {{ count($response) . ' ' . $module_name  . '  found. Click' }}
                            </div>

                            <form action="{{ route('imports.parse', [$module_name]) }}" method="post"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" name="request_for" value="store_imported_data">
                                <button type="submit"
                                        class="btn btn-outline-info font-weight-bold font-size-lg">
                                    HERE
                                </button>
                            </form>

                            <div class="text-info font-size-h6 ml-2">
                                save the items.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.import_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    attachment: 'required'
                }
            });
        });
    </script>
@stop
