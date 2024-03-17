@extends('layouts.master')

@section('content')
    <div class="subheader">
        <div class="container-fluid w-100">
            <div class="d-flex align-items-center justify-content-between flex-wrap mr-2">
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                    Dashboard - {{ auth()->user()->group->name ?? 'N/A' }}
                </h5>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid py-8">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div
                            class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <a href="{{ route('hrms.home') }}"
                   class="border border-primary text-primary text-hover-primary rounded-pill p-5 px-10 mr-3 font-weight-bold font-size-h3 d-flex flex-column align-items-center">
                    <i class="fa fa-users text-primary fa-2x mb-5"></i>
                    Human Resource Management
                </a>

                <a href="{{ route('warehouses.home') }}"
                   class="border border-primary text-primary text-hover-primary rounded-pill p-5 px-10 mr-3 font-weight-bold font-size-h3 d-flex flex-column align-items-center">
                    <i class="fa fa-warehouse text-primary fa-2x mb-5"></i>
                    Warehouse Management
                </a>

                <a href="{{ route('home') }}"
                   class="border border-primary text-primary text-hover-primary rounded-pill p-5 px-10 mr-3 font-weight-bold font-size-h3 d-flex flex-column align-items-center">
                    <i class="fa fa-desktop text-primary fa-2x mb-5"></i>
                    Point Of Sale
                </a>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@stop

