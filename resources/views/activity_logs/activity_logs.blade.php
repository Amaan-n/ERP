@extends('layouts.master')
@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="card-label">Activity Logs</h3>
                    <hr>
                </div>
                <form action="{{ route('activity.logs.index') }}" method="POST">
                    <div class="row">
                        @csrf
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">Select Date Range</label>
                                    <input class="form-control form-control-solid" name='date_range' placeholder="Pick date range" id="kt_daterangepicker_1"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Model Name</label>
                                    <input type="text" class="form-control kt-input" name="model_name" id="modelNameInput" placeholder="E.g: Customer" data-col-index="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control" id="filterButton">Filter Logs</button>
                                </div>
                            </div>    
                    </div>
                </form>          
                    <table class="table table-bordered activity_logs_table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Model</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Attribute</th>
                                <th>Performed By</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($activity_logs as $activity)
                                    @php
                                        $properties = json_decode($activity->properties, true);
                                        $oldValues = $properties['old'] ?? [];
                                        $newValues = $properties['attributes'] ?? [];
                                    @endphp
                                        @if ($activity->description == 'created')
                                            <tr>
                                                <td>Created</td>
                                                <td>{{ $activity->subject_type }}</td>
                                                <td>N/A</td>
                                                <td>
                                                    @php
                                                        $exclude_keys = ['created_at', 'updated_at', 'slug', 'updated_by', 'password', 'remember_token', 'deleted_at', 'reset_password_token', 'is_root_user'];
                                                        $filtered_values = array_filter($newValues, function($key) use ($exclude_keys) {
                                                            return !in_array($key, $exclude_keys);
                                                        }, ARRAY_FILTER_USE_KEY);
                                                
                                                
                                                        if (isset($filtered_values['product_category_id'])) {
                                                            $product_category_name = \App\Models\ProductCategory::find($filtered_values['product_category_id']); 
                                                            $filtered_values['product_category_id'] = $product_category_name ? $product_category_name->name : '';
                                                        }
                                              
                                                        if (isset($filtered_values['created_by'])) {
                                                            $user = \App\Models\User::find($filtered_values['created_by']); 
                                                            $filtered_values['created_by'] = $user ? $user->name : '';
                                                        }
                                                        if (isset($filtered_values['field_group_id'])) {
                                                            $field_group = \App\Models\FieldGroup::find($filtered_values['field_group_id']); 
                                                            $filtered_values['field_group_id'] = $field_group ? $field_group->name : '';
                                                        }
                                                        if (isset($filtered_values['manufacturer_id'])) {
                                                            $manufacturer = \App\Models\Manufacturer::find($filtered_values['manufacturer_id']); 
                                                            $filtered_values['manufacturer_id'] = $manufacturer ? $manufacturer->name : '';
                                                        }
                                                        if (isset($filtered_values['asset_category_id'])) {
                                                            $assetCategory = \App\Models\AssetCategory::find($filtered_values['asset_category_id']); 
                                                            $filtered_values['asset_category_id'] = $assetCategory? $assetCategory->name : '';
                                                        }
                                                        if (isset($filtered_values['field_id'])) {
                                                            $field = \App\Models\Field::find($filtered_values['field_id']); 
                                                            $filtered_values['field_id'] = $field ? $field->name : '';
                                                        }
                                                
                                                        if (isset($filtered_values['is_active'])) {
                                                            $filtered_values['is_active'] = ($filtered_values['is_active'] == 1) ? 'Active' : 'Inactive';
                                                        }
                                                
                                                        if (isset($filtered_values['group_id'])) {
                                                            switch ($filtered_values['group_id']) {
                                                                case 1:
                                                                $filtered_values['group_id'] = 'Super Admin';
                                                                    break;
                                                                case 2:
                                                                $filtered_values['group_id'] = 'Employee';
                                                                    break;
                                                                case 3:
                                                                $filtered_values['group_id'] = 'User';
                                                                    break;
                                                            }
                                                        }
                                                
                                                        $filtered_values = json_encode($filtered_values);
                                                        echo str_replace(',', ',<br>', $filtered_values);
                                                    @endphp
                                                </td>
                                                
                                                <td>N/A</td>
                                                <td>
                                                    @php
                                                         echo "Performed By - " . (isset($user->name) ? $user->name : "-");
                                                         if(isset($properties['ip']))
                                                         {
                                                         echo "<br>IP - " . $properties['ip'];
                                                         } 
                                                    @endphp
                                                </td>  
                                                <td>{{ $activity->created_at }}</td>
                                            </tr>
                                        @elseif ($activity->description == 'deleted')
                                            <tr>
                                                <td>Deleted</td>
                                                <td>{{ $activity->subject_type }}</td>
                                                <td>
                                                    @php
                                                        $exclude_keys = ['slug','password',
                                                        'remember_token','deleted_at','reset_password_token','is_root_user',"email_verified_at"];
                                                        $filtered_values = array_filter($oldValues, function($key) use ($exclude_keys) {
                                                            return !in_array($key, $exclude_keys);
                                                        }, ARRAY_FILTER_USE_KEY);

                                                        if (isset($filtered_values['product_category_id'])) {
                                                            $product_category_name = \App\Models\ProductCategory::find($filtered_values['product_category_id']); 
                                                            $filtered_values['product_category_id'] = $product_category_name ? $product_category_name->name : '';
                                                        }
                                                        if (isset($filtered_values['field_group_id'])) {
                                                            $field_group = \App\Models\FieldGroup::find($filtered_values['field_group_id']); 
                                                            $filtered_values['field_group_id'] = $field_group ? $field_group->name : '';
                                                        }
                                                        if (isset($filtered_values['field_id'])) {
                                                            $field = \App\Models\Field::find($filtered_values['field_id']); 
                                                            $filtered_values['field_id'] = $field ? $field->name : '';
                                                        }
                                                        if (isset($filtered_values['manufacturer_id'])) {
                                                            $manufacturer = \App\Models\Manufacturer::find($filtered_values['manufacturer_id']); 
                                                            $filtered_values['manufacturer_id'] = $manufacturer ? $manufacturer->name : '';
                                                        }
                                                        if (isset($filtered_values['asset_category_id'])) {
                                                            $assetCategory = \App\Models\AssetCategory::find($filtered_values['asset_category_id']); 
                                                            $filtered_values['asset_category_id'] = $assetCategory? $assetCategory->name : '';
                                                        }
                                                        if (isset($filtered_values['created_by'])) {
                                                            $user = \App\Models\User::find($filtered_values['created_by']);
                                                            $filtered_values['created_by'] = $user ? $user->name : '';
                                                        } else {
                                                            $filtered_values['created_by'] = '';
                                                        }
                                                        $user = \App\Models\User::find($filtered_values['updated_by']);
                                                        $filtered_values['updated_by'] = isset($user) ? $user->name : '';
                                                        $filtered_values['is_active'] = ($filtered_values['is_active'] == 1) ? 'Active' : 'Inactive';
                                                        if (isset($filtered_values['group_id'])) {
                                                            switch ($filtered_values['group_id']) {
                                                                case 1:
                                                                    $filtered_values['group_id'] = 'Super Admin';
                                                                    break;
                                                                case 2:
                                                                    $filtered_values['group_id'] = 'Employee';
                                                                    break;
                                                                case 3:
                                                                    $filtered_values['group_id'] = 'User';
                                                                    break;
                                                            }
                                                        }
                                                        $json = json_encode($filtered_values);
                                                        echo str_replace(',', ',<br>', $json);
                                                    @endphp
                                                </td>
                                                <td>N/A</td>
                                                <td>N/A</td>
                                                <td>
                                                    @php
                                                         echo  "Performed By - "  . (isset($user) && !empty($user->name) ? $user->name : '');
                                                         if(isset($properties['ip']))
                                                         {
                                                         echo "<br>IP - " . $properties['ip'];
                                                         } 
                                                    @endphp
                                                </td>  
                                                <td>{{ $activity->created_at }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>Updated</td>
                                                <td>{{ $activity->subject_type }}</td>
                                                <td>
                                                    
                                                        @php      
                                                        $exclude_keys = ['created_at', 'updated_at', 'slug'];
                                                        $filtered_values = array_filter($oldValues, function($key) use ($exclude_keys) {
                                                            return !in_array($key, $exclude_keys);
                                                        }, ARRAY_FILTER_USE_KEY);
                                                        if (isset($filtered_values['product_category_id'])) {
                                                            $product_category_name = \App\Models\ProductCategory::find($filtered_values['product_category_id']); 
                                                            $filtered_values['product_category_id'] = $product_category_name ? $product_category_name->name : '';
                                                        }
                                                        if (isset($filtered_values['field_group_id'])) {
                                                            $field_group = \App\Models\FieldGroup::find($filtered_values['field_group_id']); 
                                                            $filtered_values['field_group_id'] = $field_group ? $field_group->name : '';
                                                        }
                                                        if (isset($filtered_values['field_id'])) {
                                                            $field = \App\Models\Field::find($filtered_values['field_id']); 
                                                            $filtered_values['field_id'] = $field ? $field->name : '';
                                                        }
                                                        if (isset($filtered_values['manufacturer_id'])) {
                                                            $manufacturer = \App\Models\Manufacturer::find($filtered_values['manufacturer_id']); 
                                                            $filtered_values['manufacturer_id'] = $manufacturer ? $manufacturer->name : '';
                                                        }
                                                        if (isset($filtered_values['asset_category_id'])) {
                                                            $assetCategory = \App\Models\AssetCategory::find($filtered_values['asset_category_id']); 
                                                            $filtered_values['asset_category_id'] = $assetCategory? $assetCategory->name : '';
                                                        }
                                                    
                                                        if (array_key_exists('is_active', $filtered_values)) {
                                                            $filtered_values['is_active'] = ($filtered_values['is_active'] == 1) ? 'Active' : 'Inactive';
                                                        }
                                                    
                                                        $json = json_encode($filtered_values);
                                                        echo str_replace(',', ',<br>', $json);
                                                        @endphp
                                                    
                                                </td>
                                                <td>
                                                    @php      
                                                    $exclude_keys = ['created_at', 'updated_at', 'slug'];
                                                    $filtered_values = array_filter($newValues, function($key) use ($exclude_keys) {
                                                        return !in_array($key, $exclude_keys);
                                                    }, ARRAY_FILTER_USE_KEY);
                                                    if (isset($filtered_values['product_category_id'])) {
                                                            $product_category_name = \App\Models\ProductCategory::find($filtered_values['product_category_id']); 
                                                            $filtered_values['product_category_id'] = $product_category_name ? $product_category_name->name : '';
                                                        }
                                                        if (isset($filtered_values['field_group_id'])) {
                                                            $field_group = \App\Models\FieldGroup::find($filtered_values['field_group_id']); 
                                                            $filtered_values['field_group_id'] = $field_group ? $field_group->name : '';
                                                        }
                                                        if (isset($filtered_values['field_id'])) {
                                                            $field = \App\Models\Field::find($filtered_values['field_id']); 
                                                            $filtered_values['field_id'] = $field ? $field->name : '';
                                                        }
                                                        if (isset($filtered_values['manufacturer_id'])) {
                                                            $manufacturer = \App\Models\Manufacturer::find($filtered_values['manufacturer_id']); 
                                                            $filtered_values['manufacturer_id'] = $manufacturer ? $manufacturer->name : '';
                                                        }
                                                        if (isset($filtered_values['asset_category_id'])) {
                                                            $assetCategory = \App\Models\AssetCategory::find($filtered_values['asset_category_id']); 
                                                            $filtered_values['asset_category_id'] = $assetCategory? $assetCategory->name : '';
                                                        }
                                                    
                                                    if (array_key_exists('is_active', $filtered_values)) {
                                                        $filtered_values['is_active'] = ($filtered_values['is_active'] == 1) ? 'Active' : 'Inactive';
                                                    }

                                                    $json = json_encode($filtered_values);
                                                    echo str_replace(',', ',<br>', $json);
                                                    @endphp
                                                </td>  
                                                <td>
                                                    @php
                                                    $keys = array_keys($newValues);
                                                    $keys = array_filter($keys, function($key) {
                                                        return $key !== 'updated_at';
                                                    });
                                                    echo implode(',<br>', $keys);
                                                    @endphp
                                                    <br>
                                                </td>  
                                                <td> 
                                                    @php
                                                        $causer_id = $activity->causer_id;
                                                        $user = App\Models\User::find($causer_id);
                                                        $performed_by = isset($user) ? $user->name : '';
                                                        if (isset($user)) {
                                                            echo "Performed By - " . $user->name;
                                                        }
                                                        if(isset($properties['ip']))
                                                        {
                                                        echo "<br>IP - " . $properties['ip'];
                                                        } 
                                                    @endphp 
                                                </td>
                                                <td>{{ $activity->created_at }}</td>
                                            </tr>
                                        @endif
                                @endforeach
                        </tbody>
                    </table>   
            </div>
        </div>
    </div>
</div>
@endsection