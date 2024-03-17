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
            $redirect_route = !empty($field)
                ? route('fields.update', $field->id)
                : route('fields.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="field_form" id="field_form">
                {{ csrf_field() }}

                @if(isset($field) && !empty($field))
                    <input type="hidden" name="_method" value="put">
                @endif

                <input type="hidden" name="id" class="field_id"
                       value="{{ isset($field) && isset($field->id) && $field->id > 0 ? $field->id : 0 }}">

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($field)
                                        ? 'Edit Field - ' . '<span class="border-bottom border-dark">' . $field->name . '</span>'
                                        : 'Create Field' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('fields', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('fields.form')
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
            $('.field_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: {
                        required: true,
                        remote: {
                            url: '{{ route('validate.unique') }}',
                            method: 'post',
                            data: {
                                'table': 'fields',
                                'field': 'name',
                                'id': $(document).find('input[name="id"]').val()
                            }
                        }
                    },
                    element: 'required',
                }
            });

            $(document).off('change', 'select[name="element"]');
            $(document).on('change', 'select[name="element"]', function () {

                $(document).find('input[name="options[]"]').each(function (key, element) {
                    $(element).val('');
                });

                $(document).find('.element_selection').addClass('d-none');
                if ($.inArray($(this).val(), ['select', 'radio', 'checkbox']) !== -1) {
                    $(document).find('.element_selection').removeClass('d-none');
                }
            });
        });
    </script>
@stop
