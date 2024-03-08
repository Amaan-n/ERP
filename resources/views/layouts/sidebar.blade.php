@php $current = \Route::currentRouteName(); @endphp

<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto hide_print" id="kt_aside">
    <div class="brand flex-column-auto {{ $current === 'home1' ? 'h-auto' : '' }}" id="kt_brand">
        @if($current === 'home1')
            @if(!empty($configuration['logo']) && !empty($configuration['name']))
                <a href="{{ route('home') }}" class="brand-logo">
                    <img
                        src="{{ config('constants.s3.asset_url') . $configuration['logo'] }}"
                        alt="{{ $configuration['name'] }}"
                        style="margin-top: 10px;margin-bottom: 10px;max-width: 150px;">
                </a>
            @endif
        @else
            @if(!empty($configuration['name']))
                <a href="{{ route('home') }}" class="brand-logo">
                    <span class="text-white font-size-h5">
                        {{ $configuration['name'] }}
                    </span>
                </a>
            @endif
        @endif

        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"></path>
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"></path>
                    </g>
                </svg>
            </span>
        </button>
    </div>

    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <ul class="menu-nav {{ \Illuminate\Support\Facades\App::getLocale() === 'ar' ? 'arabic_text' : '' }}">
                <li class="menu-item {{ get_active_class($current, ['home']) }}" aria-haspopup="true">
                    <a href="{{ route('home') }}" class="menu-link">
                        <i class="fa fa-chart-line mr-5"></i>
                        <span class="menu-text">Admin Dashboard</span>
                    </a>
                </li>

                @if(!empty(request()->route()->action) && request()->route()->action['prefix'] === '/admin')
                    @if($is_root_user == 1
                        || (in_array('groups.index', $accesses_urls)
                            || in_array('users.index', $accesses_urls)
                            || in_array('configurations', $accesses_urls)))
                        <li class="menu-section">
                            <h4 class="menu-text">Administrative Links</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('groups.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['groups.index', 'groups.edit', 'groups.create', 'groups.show']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{ route('groups.index') }}" class="menu-link menu-toggle">
                                <i class="fa fa-lock mr-5"></i>
                                <span class="menu-text">User Groups ( Policies )</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('users.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['users.index', 'users.edit', 'users.create', 'users.show']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{ route('users.index') }}" class="menu-link menu-toggle">
                                <i class="fa fa-user mr-5"></i>
                                <span class="menu-text">Users</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('configurations', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['configurations']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{ route('configurations') }}" class="menu-link menu-toggle">
                                <i class="fa fa-cog mr-5"></i>
                                <span class="menu-text">Configurations</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if(!empty(request()->route()->action) && request()->route()->action['prefix'] === '/assets_management')
                    @if($is_root_user == 1 || in_array('assets_management.home', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['assets_management.home']) }}" aria-haspopup="true">
                            <a href="{{ route('assets_management.home') }}" class="menu-link">
                                <i class="fa fa-chart-line mr-5"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1
                        || (in_array('groups.index', $accesses_urls)
                            || in_array('users.index', $accesses_urls)
                            || in_array('configurations', $accesses_urls)))
                        <li class="menu-section">
                            <h4 class="menu-text">Masters</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
