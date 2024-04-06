<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between hide_print">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="d-none menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active"
                        data-menu-toggle="click" aria-haspopup="true">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <span class="menu-text">Quick Access</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-active" aria-haspopup="true">
                                    <a href="javascript:void(0);" class="menu-link">
                                        <span class="menu-text">Example 1</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="topbar">
            @if($is_root_user == 1 ||  in_array('activity.log.index', $accesses_urls))
                <div class="topbar-item mr-3">
                    <a href="{{ route('activity.logs.index') }}" class="btn btn-outline-primary">
                        <i class="fa fa-history"></i>
                        Activity Logs
                    </a>
                </div>
            @endif    
            <div class="topbar-item mr-3">
                <a href="{{ route('auth.lock') }}" class="btn btn-outline-primary">
                    <i class="fa fa-lock"></i>
                    Lock Screen
                </a>
            </div>

            @if($is_root_user == 1 || in_array('notes.index', $accesses_urls))
                <div class="topbar-item mr-3">
                    <div class="btn btn-outline-primary" id="kt_quick_cart_toggle">
                        <i class="fa fa-paragraph"></i>
                        Notes
                    </div>
                </div>
            @endif

            <div class="topbar-item">
                <div
                    class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2 hide_print"
                    id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-md-inline mr-1">
                        Hi,
                    </span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-md-inline mr-3">
                        {{ auth()->user()->name }}
                        <span class="text-muted">( {{ auth()->user()->group->name }} )</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
