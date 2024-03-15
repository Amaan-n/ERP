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
                        <h3 class="card-label">
                            {!! isset($measuring_unit)
                                    ? 'Edit Measuring Unit - <span class="border-bottom border-dark">' . $measuring_unit->name . '</span>'
                                    : 'Create Measuring Unit' !!}
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('measuring_units', 'manage') !!}
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    $redirect_route = !empty($measuring_unit)
                        ? route('measuring_units.update', $measuring_unit->id)
                        : route('measuring_units.store');
                    ?>
                    <form action="{{ $redirect_route }}" method="post"
                          enctype="multipart/form-data" class="measuring_unit_form" id="measuring_unit_form">
                        {{ csrf_field() }}
                        @if(isset($measuring_unit) && !empty($measuring_unit))
                            <input type="hidden" name="_method" value="put">
                        @endif

                        <input type="hidden" name="id" class="measuring_unit_id"
                               value="{{ isset($measuring_unit) && isset($measuring_unit->id) && $measuring_unit->id > 0 ? $measuring_unit->id : 0 }}">

                        <input type="hidden" name="slug"
                               value="{{ isset($measuring_unit) && !empty($measuring_unit->slug) ? $measuring_unit->slug : '' }}">

                        @include('measuring_units.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).find('.measuring_unit_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required',
                }
            });
        });
    </script>
@stop
