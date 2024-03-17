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

            <form action="{{ route('mappings.store') }}" method="post"
                  enctype="multipart/form-data" class="map_tag_form" id="map_tag_form">
                {{ csrf_field() }}

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Tags Mapping</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('mappings.form')
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
            $(document).find('select[name="tag_id"]').select2({
                placeholder: 'Please select a tag',
                allowClear: false
            });

            $('.map_tag_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    asset_id: 'required'
                }
            });
        });
    </script>
@stop
