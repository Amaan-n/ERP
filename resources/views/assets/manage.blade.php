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
            $redirect_route = !empty($asset)
                ? route('assets.update', $asset->id)
                : route('assets.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="asset_form" id="asset_form">
                {{ csrf_field() }}

                @if(isset($asset))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $asset->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $asset->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($asset)
                                        ? 'Edit Asset - ' . '<span class="border-bottom border-dark">' . $asset->name . '</span>'
                                        : 'Create Asset' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('assets', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('assets.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($asset) ? 'Update Asset' : 'Create Asset' !!}
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
            $('.asset_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    supplier_id: 'required',
                    asset_model_id: 'required',
                    name: 'required',
                    purchase_date: 'required',
                    purchase_cost: 'required',
                }
            });

            let arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

            $('.date_picker').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                templates: arrows,
                endDate: new Date()
            });

            $(document).off('change', 'select[name="asset_model_id"]');
            $(document).on('change', 'select[name="asset_model_id"]', function () {
                let $this = $(this);
                if ($this.val() === '') {
                    $(document).find('.asset_parameters').find('.card-body').html('');
                    return false;
                }

                get_parameters_by_asset_model($this.val());
            });
        });

        function get_parameters_by_asset_model(asset_model_id) {
            $.ajax({
                type: 'get',
                url: "{{ route('asset_model.parameters') }}",
                data: {
                    asset_model_id: asset_model_id
                },
                success: function (response) {
                    if (!response.success) {
                        $(document).find('.asset_parameters').find('.card-body').html('');
                        return false;
                    }

                    $(document).find('.asset_parameters').find('.card-body').html(response.data.html);
                }
            });
        }
    </script>
@stop
