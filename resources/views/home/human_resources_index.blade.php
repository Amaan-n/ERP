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
                <h1>Human Resource Management Dashboard</h1>
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

