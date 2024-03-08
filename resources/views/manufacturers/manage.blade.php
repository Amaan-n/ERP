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
            $redirect_route = !empty($manufacturer)
                ? route('manufacturers.update', $manufacturer->id)
                : route('manufacturers.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="manufacturer_form" id="manufacturer_form">
                {{ csrf_field() }}
                @if(isset($manufacturer) && !empty($manufacturer))
                    <input type="hidden" name="_method" value="put">
                @endif

                <input type="hidden" name="id" class="manufacturer_id"
                       value="{{ isset($manufacturer) && isset($manufacturer->id) && $manufacturer->id > 0 ? $manufacturer->id : 0 }}">

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($manufacturer)
                                        ? 'Edit Manufacturer - ' . '<span class="border-bottom border-dark">' . $manufacturer->name . '</span>'
                                        : 'Create Manufacturer' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('manufacturers', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('manufacturers.form')
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
            $('.manufacturer_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });
        });
    </script>
@stop
