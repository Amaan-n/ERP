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

                @if(!empty(request()->route()->action)
                        && in_array(request()->route()->action['prefix'], ['/admin', 'admin/configurations']))
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

                @if(!empty(request()->route()->action)
                        && in_array(request()->route()->action['prefix'], ['/hrms', 'hrms/assets/allocation']))
                    @if($is_root_user == 1 || in_array('hrms.home', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['hrms.home']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('hrms.home') }}" class="menu-link">
                                <i class="fa fa-chart-line mr-5"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1
                        || (in_array('employees.index', $accesses_urls)
                            || in_array('calendar', $accesses_urls)
                            || in_array('manufacturers.index', $accesses_urls)
                            || in_array('suppliers.index', $accesses_urls)
                            || in_array('departments.index', $accesses_urls)
                            || in_array('fields.index', $accesses_urls)
                            || in_array('field_groups.index', $accesses_urls)
                            || in_array('asset_categories.index', $accesses_urls)
                            || in_array('asset_models.index', $accesses_urls)
                            || in_array('assets.index', $accesses_urls)
                            || in_array('tags.index', $accesses_urls)
                            || in_array('tags.mapping', $accesses_urls)
                            || in_array('assets.allocation', $accesses_urls)
                        ))
                        <li class="menu-section">
                            <h4 class="menu-text">Masters</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('calendar.show', $accesses_urls))
                    <li class="menu-item {{ get_active_class($current, ['calendar']) }}"
                        aria-haspopup="true">
                        <a href="{{ route('calendar.show') }}" class="menu-link">
                            <i class="fa fa-calendar mr-5"></i>
                            <span class="menu-text"> Calendar </span>
                        </a>
                    </li>
                    @endif

                    @if($is_root_user == 1 || in_array('employees.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['employees.index', 'employees.edit', 'employees.create', 'employees.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('employees.index') }}" class="menu-link">
                                <i class="fa fa-users mr-5"></i>
                                <span class="menu-text">Employees</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('manufacturers.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['manufacturers.index', 'manufacturers.edit', 'manufacturers.create', 'manufacturers.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('manufacturers.index') }}" class="menu-link">
                                <i class="fa fa-industry mr-5"></i>
                                <span class="menu-text">Manufacturers</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('suppliers.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['suppliers.index', 'suppliers.edit', 'suppliers.create', 'suppliers.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('suppliers.index') }}" class="menu-link">
                                <i class="fa fa-building mr-5"></i>
                                <span class="menu-text">Suppliers</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('departments.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['departments.index', 'departments.edit', 'departments.create', 'departments.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('departments.index') }}" class="menu-link">
                                <i class="fa fa-id-card mr-5"></i>
                                <span class="menu-text">Departments</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('fields.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['fields.index', 'fields.edit', 'fields.create', 'fields.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('fields.index') }}" class="menu-link">
                                <i class="fa fa-pager mr-5"></i>
                                <span class="menu-text">Fields</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('field_groups.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['field_groups.index', 'field_groups.edit', 'field_groups.create', 'field_groups.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('field_groups.index') }}" class="menu-link">
                                <i class="fa fa-file-code mr-5"></i>
                                <span class="menu-text">Field Groups</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('asset_categories.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['asset_categories.index', 'asset_categories.edit', 'asset_categories.create', 'asset_categories.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('asset_categories.index') }}" class="menu-link">
                                <i class="fa fa-list mr-5"></i>
                                <span class="menu-text">Asset Categories</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('asset_models.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['asset_models.index', 'asset_models.edit', 'asset_models.create', 'asset_models.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('asset_models.index') }}" class="menu-link">
                                <i class="fa fa-mobile-alt mr-5"></i>
                                <span class="menu-text">Asset Models</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('assets.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['assets.index']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{ route('assets.index') }}" class="menu-link menu-toggle">
                                <i class="fa fa-mobile-alt mr-5"></i>
                                <span class="menu-text">Assets</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('tags.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['tags.index', 'tags.edit', 'tags.create', 'tags.show', 'imports.tags', 'imports.parse.tags']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{ route('tags.index') }}" class="menu-link menu-toggle">
                                <i class="fa fa-qrcode mr-5"></i>
                                <span class="menu-text">Tags</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('tags.mapping', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['tags.mapping']) }}"
                            aria-haspopup="true" data-menu-toggle="hover">
                            <a href="{{route('tags.mapping')}}" class="menu-link">
                                <i class="fa fa-link mr-5"></i>
                                <span class="menu-text">Tags Mapping</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('assets.allocation', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['assets.allocation']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('assets.allocation') }}" class="menu-link">
                                <i class="fa fa-shopping-bag mr-5"></i>
                                <span class="menu-text">Allocations</span>
                            </a>
                        </li>
                    @endif
                @endif

                @if(!empty(request()->route()->action)
                    && in_array(request()->route()->action['prefix'], ['/orders', '/pos']))
                    @if($is_root_user == 1 || in_array('orders.home', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['orders.home']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('orders.home') }}" class="menu-link">
                                <i class="fa fa-chart-line mr-5"></i>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('pos.create', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['pos.create']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('pos.create') }}" class="menu-link">
                                <i class="fa fa-desktop mr-5"></i>
                                <span class="menu-text">POS</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1
                        || (in_array('customers.index', $accesses_urls)
                            || in_array('locations.index', $accesses_urls)
                            || in_array('measuring_units.index', $accesses_urls)
                            || in_array('product_categories.index', $accesses_urls)
                            || in_array('products.index', $accesses_urls)
                        ))
                        <li class="menu-section">
                            <h4 class="menu-text">Masters</h4>
                            <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('customers.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['customers.index', 'customers.edit', 'customers.create', 'customers.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('customers.index') }}" class="menu-link">
                                <i class="fa fa-user-friends mr-5"></i>
                                <span class="menu-text">Customers</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('locations.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['locations.index', 'locations.edit', 'locations.create', 'locations.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('locations.index') }}" class="menu-link">
                                <i class="fa fa-map-marker-alt mr-5"></i>
                                <span class="menu-text">Locations</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('measuring_units.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['measuring_units.index', 'measuring_units.edit', 'measuring_units.create', 'measuring_units.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('measuring_units.index') }}" class="menu-link">
                                <i class="fa fa-filter mr-5"></i>
                                <span class="menu-text">Measuring Units</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('product_categories.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['product_categories.index', 'product_categories.edit', 'product_categories.create', 'product_categories.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('product_categories.index') }}" class="menu-link">
                                <i class="fa fa-list mr-5"></i>
                                <span class="menu-text">Product Categories</span>
                            </a>
                        </li>
                    @endif

                    @if($is_root_user == 1 || in_array('products.index', $accesses_urls))
                        <li class="menu-item {{ get_active_class($current, ['products.index', 'products.edit', 'products.create', 'products.show']) }}"
                            aria-haspopup="true">
                            <a href="{{ route('products.index') }}" class="menu-link">
                                <i class="fa fa-shopping-basket mr-5"></i>
                                <span class="menu-text">Products</span>
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
