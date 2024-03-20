<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Attachment;
use App\Models\AssetCategory;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Group;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\MeasuringUnit;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\User;

class HomeRepository
{
    protected $group, $user, $manufacturer, $supplier, $department, $field, $field_group, $asset_category, $asset_model,
        $asset, $attachment, $location, $measuring_unit, $product_category, $product, $customer;

    public function __construct()
    {
        $this->group            = new Group();
        $this->user             = new User();
        $this->manufacturer     = new Manufacturer();
        $this->supplier         = new Supplier();
        $this->department       = new Department();
        $this->field            = new Field();
        $this->field_group      = new FieldGroup();
        $this->asset_category   = new AssetCategory();
        $this->asset_model      = new AssetModel();
        $this->asset            = new Asset();
        $this->attachment       = new Attachment();
        $this->location         = new Location();
        $this->measuring_unit   = new MeasuringUnit();
        $this->product_category = new ProductCategory();
        $this->product          = new Product();
        $this->customer         = new Customer();
    }

    public function removeFile($request)
    {
        switch ($request->get('module')) {
            case 'users':
            case 'employees':
                $this->user
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'manufacturers':
                $this->manufacturer
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'suppliers':
                $this->supplier
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'departments':
                $this->department
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'asset_categories':
                $this->asset_category
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'asset_models':
                $this->asset_model
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'assets':
                $this->asset
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'attachments':
                $this->attachment
                    ->where('id', $request->get('id'))
                    ->delete();
                break;
            case 'products':
                $this->product
                    ->where('id', $request->get('id'))
                    ->delete();
                break;
            default:
                break;
        }
    }

    public function updateState($module, $id)
    {
        $model = '';
        switch ($module) {
            case 'groups':
                $model = $this->group;
                break;
            case 'users':
            case 'employees':
                $model = $this->user;
                break;
            case 'manufacturers':
                $model = $this->manufacturer;
                break;
            case 'suppliers':
                $model = $this->supplier;
                break;
            case 'departments':
                $model = $this->department;
                break;
            case 'fields':
                $model = $this->field;
                break;
            case 'field_groups':
                $model = $this->field_group;
                break;
            case 'asset_categories':
                $model = $this->asset_category;
                break;
            case 'asset_models':
                $model = $this->asset_model;
                break;
            case 'assets':
                $model = $this->asset;
                break;
            case 'locations':
                $model = $this->location;
                break;
            case 'measuring_units':
                $model = $this->measuring_unit;
                break;
            case 'product_categories':
                $model = $this->product_category;
                break;
            case 'products':
                $model = $this->product;
                break;
            case 'customers':
                $model = $this->customer;
                break;
        }

        $response = $model->where('id', $id)->first();
        if (!isset($response)) {
            throw new \Exception('No record found.', 201);
        }

        $response->is_active = $response->is_active == 1 ? 0 : 1;
        $response->save();
        return $response->is_active;
    }
}
