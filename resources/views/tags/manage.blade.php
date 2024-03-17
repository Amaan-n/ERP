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

            <?php
            $redirect_route = !empty($tag)
                ? route('tags.update', $tag->id)
                : route('tags.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="tag_form" id="tag_form">
                {{ csrf_field() }}
                @if(isset($tag) && !empty($tag))
                    <input type="hidden" name="_method" value="put">
                @endif

                <input type="hidden" name="id" class="tag_id"
                       value="{{ isset($tag) && isset($tag->id) && $tag->id > 0 ? $tag->id : 0 }}">

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($tag)
                                        ? 'Edit Tag - ' . '<span class="border-bottom border-dark">' . $tag->name . '</span>'
                                        : 'Create Tag' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('tags', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('tags.form')
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
            $('.tag_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    provider: 'required',
                    chip_order_name: 'required',
                    value: 'required',
                    quantity: {
                        number: true,
                        min: 1,
                        max: 100
                    }
                }
            });
        });
    </script>
@stop
