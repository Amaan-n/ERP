<?php

if (!function_exists('prepare_notification_array')) {
    function prepare_notification_array($type = 'warning', $message = 'no message found'): array
    {
        return [
            'type'    => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('prepare_header_html')) {
    function prepare_header_html($module_name, $type, $module = ''): string
    {
        $accesses_urls = [];
        $is_root_user  = 0;
        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $is_root_user        = auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;
            $user_group_accesses = isset($user_group) && !empty($user_group) ? $user_group->accesses : [];
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }

        $header_html = '';
        if (isset($type) && $type == 'listing') {
            if ($is_root_user == 1 || in_array($module_name . '.create', $accesses_urls)) {
                $header_html = '<a href="' . route($module_name . ".create") . '" class="btn btn-outline-primary font-weight-bold">
                                <i class="fa fa-plus-square mr-1"></i>
                                Add New Record</a>';
            }
        }

        if (isset($type) && $type == 'manage') {
            if ($is_root_user == 1 || in_array($module_name . '.index', $accesses_urls)) {
                $header_html .= '<a href="' . route($module_name . ".index") . '" class="btn btn-outline-dark font-weight-bold">
                                    <i class="fa fa-angle-double-left mr-1"></i>
                                    Back</a>';
            }
        }

        if (isset($type) && $type == 'display') {
            if ($is_root_user == 1 || in_array($module_name . '.edit', $accesses_urls)) {
                $header_html = '<a href="' . route($module_name . ".index") . '" class="btn btn-outline-dark font-weight-bold mr-3">
                                    <i class="fa fa-angle-double-left mr-1"></i>
                                    Back
                                </a>';

                $header_html .= '<a href="' . route($module_name . ".edit", [$module->slug]) . '" class="btn btn-outline-primary font-weight-bold">
                                    <i class="fa fa-edit mr-1"></i>
                                    Edit Record</a>';
            }
        }

        return $header_html;
    }
}

if (!function_exists('check_empty')) {
    /**
     * Check if given field is empty or not
     * @param $data
     * @param string $field_name
     * @param null $default_response
     * @return null
     */
    function check_empty($data, $field_name = '', $default_response = null)
    {
        $data = is_object($data) ? $data->toArray() : $data;
        return !empty($data) && !empty($data[ $field_name ]) ? $data[ $field_name ] : $default_response;
    }
}

if (!function_exists('get_configurations_data')) {
    function get_configurations_data($key = '')
    {
        $configuration = new \App\Models\Configuration();

        if ($key !== '') {
            $configurations = $configuration
                ->where('key', $key)
                ->pluck('value', 'key')
                ->toArray();
        } else {
            $configurations = $configuration
                ->pluck('value', 'key')
                ->toArray();
        }

        return $configurations;
    }
}

if (!function_exists('get_open_class')) {
    function get_open_class($current, $array): string
    {
        if (in_array($current, $array)) {
            return 'menu-item-open';
        }
        return '';
    }
}

if (!function_exists('get_active_class')) {
    function get_active_class($current, $array, $sub_menu = false): string
    {
        if (in_array($current, $array)) {
            $return = 'menu-item-active';
            if ($sub_menu) {
                $return .= ' menu-item-open';
            }
            return $return;
        }
        return '';
    }
}

if (!function_exists('prepare_listing_action_buttons')) {
    function prepare_listing_action_buttons($module_name, $module, $accesses_urls = [], $index = 0): string
    {
        $is_root_user = auth()->check() && auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;

        $listing_action_button = '';
        if ($is_root_user == 1 || in_array($module_name . '.show', $accesses_urls)) {
            $listing_action_button .= '<a href="' . route($module_name . ".show", $module->slug) . '">Show</a>';
        }

        if (($is_root_user == 1
                || (in_array($module_name . '.show', $accesses_urls)
                    && in_array($module_name . '.edit', $accesses_urls)))
            && !in_array($module_name, ['tags'])) {
            $listing_action_button .= '<span class="text-primary">&nbsp; | &nbsp;</span>';
        }

        if (($is_root_user == 1 || in_array($module_name . '.edit', $accesses_urls))
            && !in_array($module_name, ['tags'])) {
            $listing_action_button .= '<a href="' . route($module_name . ".edit", $module->slug) . '">Edit</a>';
        }

        if (($is_root_user == 1
                || (in_array($module_name . '.edit', $accesses_urls)
                    && in_array($module_name . '.delete', $accesses_urls)))
            && !in_array($module_name, ['tags'])) {
            $listing_action_button .= '<span class="text-primary">&nbsp; | &nbsp;</span>';
        }

        if (($is_root_user == 1
                || in_array($module_name . '.delete', $accesses_urls))
            && !in_array($module_name, ['tags'])) {
            if ($module_name == 'groups' && $module->id <= 1) {
                $listing_action_button .= '<span class="cursor-pointer" title="You can not delete default user groups">Delete</span>';
            } else {
                $listing_action_button .= '<a href="javascript:void(0);" class="delete_item">Delete</a>
                                    <form class="delete_item_form" action="' . route($module_name . ".destroy", $module->id) . '" method="POST" style="display: none;">
                                    <input type="hidden" name="_method" value="DELETE">' . csrf_field() . '</form>';
            }
        }

        return !empty($listing_action_button) ? $listing_action_button : '';
    }
}

if (!function_exists('info_circle')) {
    function info_circle($content): string
    {
        $info_icon = '';
        if (!empty($content)) {
            $info_icon = '<i class="fa fa-info-circle text-secondary-outline ml-2"
                        data-toggle="popover"
                        data-placement="top"
                        data-content="' . $content . '"></i>';
        }

        return $info_icon;
    }
}

if (!function_exists('upload_attachment')) {
    function upload_attachment($request, $field_name, $path, $request_from = '')
    {
        $file_name_with_directory = $mime_type = '';
        $old_attachment           = $request->get('old_' . $field_name, '');
        if (isset($old_attachment) && !empty($old_attachment)) {
            $file_name_with_directory = $old_attachment;
        }

        if (!empty($request->hasFile($field_name))) {
            $file_name_with_extension = sha1(time() . rand()) . '.' . $request->file($field_name)->getClientOriginalExtension();
            $request->file($field_name)->move(public_path($path), $file_name_with_extension);
            $file_name_with_directory = $path . '/' . $file_name_with_extension;
        }

        return $file_name_with_directory;
    }
}

if (!function_exists('generate_slug')) {
    function generate_slug($for = '')
    {
        $modal = new \App\Models\User();
        switch ($for) {
            case 'manufacturers':
                $modal = new \App\Models\Manufacturer();
                break;
            case 'suppliers':
                $modal = new \App\Models\Supplier();
                break;
            case 'departments':
                $modal = new \App\Models\Department();
                break;
            case 'fields':
                $modal = new \App\Models\Field();
                break;
            case 'field_groups':
                $modal = new \App\Models\FieldGroup();
                break;
            case 'asset_models':
                $modal = new \App\Models\AssetModel();
                break;
            case 'categories':
                $modal = new \App\Models\Category();
                break;
            case 'assets':
                $modal = new \App\Models\Asset();
                break;
            default:
                break;
        }

        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($modal->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        return $random_string;
    }
}

if (!function_exists('prepare_active_button')) {
    function prepare_active_button($module_name, $module): string
    {
        $html = '<a href="javascript:void(0);"
                       class="text-decoration-none update_state"
                       data-module="' . $module_name . '" data-id="' . $module->id . '">';

        if (isset($module->is_active) && $module->is_active == 1) {
            $html   .= '<i class="fa fa-check text-success"></i>';
            $status = 'Active';
        } else {
            $html   .= '<i class="fa fa-times text-danger"></i>';
            $status = 'InActive';
        }

        $html .= '<p class="d-none">' . $status . '</p></a>';
        return $html;
    }
}

if (!function_exists('prepare_imports_exports_button')) {
    function prepare_imports_exports_button($module = ''): string
    {
        $accesses_urls = [];
        $is_root_user  = 0;
        if (auth()->check()) {
            $user_group          = auth()->user()->group;
            $is_root_user        = auth()->user()->is_root_user && auth()->user()->is_root_user > 0 ? 1 : 0;
            $user_group_accesses = isset($user_group) && !empty($user_group) ? $user_group->accesses : [];
            if (isset($user_group_accesses) && !empty($user_group_accesses)) {
                foreach ($user_group_accesses as $access) {
                    $accesses_urls[] = $access->module;
                }
            }
        }

        $header_html = '';
        if (!empty($module)) {
            if ($is_root_user == 1 || in_array($module . '.import', $accesses_urls)) {
                $header_html = '<a href="' . route('imports', [$module]) . '" class="btn btn-outline-dark font-weight-bolder mr-3">
                 <i class="fa fa-file-import mr-1"></i> Import
                 </a>';
            }

            if ($is_root_user == 1 || in_array($module . '.export', $accesses_urls)) {
                $header_html .= '<a href="' . route('exports', [$module]) . '" class="btn btn-outline-dark font-weight-bolder mr-3">
                <i class="fa fa-file-export mr-1"></i> Export
                </a>';
            }
        }

        return $header_html;
    }
}

if (!function_exists('preview_and_remove_buttons')) {
    function preview_and_remove_buttons($module, $module_name, $field_name): string
    {
        $preview_and_remove_buttons = '';
        if (isset($module) && !empty($module->{$field_name})) {
            $preview_and_remove_buttons = '<div class="float-right input_action_buttons d-flex">
                    <a href="javascript:void(0);" target="_blank" class="remove_attachment border border-danger d-flex align-items-center justify-content-center px-1 mr-2"
                       data-module="' . $module_name . '" data-field="attachment" data-id="' . $module->id . '">
                        <i class="fa fa-times text-danger"></i>
                    </a>

                    <a href="' . config('constants.s3.asset_url') . $module->{$field_name} . '"
                       target="_blank" class="border border-primary d-flex align-items-center justify-content-center px-1">
                           <i class="fa fa-image text-primary"></i>
                    </a>
                </div>';
        }

        return $preview_and_remove_buttons;
    }
}
