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

            <?php
            $redirect_route = !empty($asset_model)
                ? route('asset_models.update', $asset_model->id)
                : route('asset_models.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="asset_model_form" id="asset_model_form">
                {{ csrf_field() }}
                @if(isset($asset_model) && !empty($asset_model))
                    <input type="hidden" name="_method" value="put">
                @endif

                <input type="hidden" name="id" class="asset_model_id"
                       value="{{ isset($asset_model) && isset($asset_model->id) && $asset_model->id > 0 ? $asset_model->id : 0 }}">

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($asset_model)
                                        ? 'Edit Asset Model - ' . '<span class="border-bottom border-dark">' . $asset_model->name . '</span>'
                                        : 'Create Asset Model' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('asset_models', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('asset_models.form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg">
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.asset_model_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    manufacturer_id: 'required',
                    category_id: 'required',
                    field_group_id: 'required',
                    name: 'required',
                }
            });
        });
    </script>
@stop
