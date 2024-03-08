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
                        <h3 class="card-label">Attachments - {{ ucwords(str_replace('_', ' ', $module_name)) }}</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html($module_name, 'manage') !!}
                    </div>
                </div>
                <div class="card-body">

                    <form action="{{ route('attachments.upload', [$module_name, $reference_id]) }}"
                          method="post" enctype="multipart/form-data" class="attachment_form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="attachments">Attachments</label>
                                    <input type="file" class="form-control" id="attachments" name="attachments[]"
                                           multiple accept="image/*">
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

                    <div class="row">
                        @if(!empty($attachments) && count($attachments) > 0)
                            @foreach($attachments as $index => $attachment)
                                <div class="col-md-2">
                                    <i class="fa fa-times-circle text-danger position-absolute cursor-pointer remove_attachment"
                                       style="right: 10px; top: -5px"
                                       data-module="attachments" data-field="path" data-id="{{ $attachment->id }}"
                                    ></i>
                                    <a href="{{ config('constants.s3.asset_url') . $attachment->path }}"
                                       target="_blank" data-lightbox="image-1">
                                        <img src="{{ config('constants.s3.asset_url') . $attachment->path }}"
                                             alt="{{ $attachment->path }}"
                                             class="img-thumbnail w-150px p-2 my-1 mw-100 w-200px">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-warning">No record found.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.attachment_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    'attachments[]': 'required'
                }
            });
        });
    </script>
@stop
