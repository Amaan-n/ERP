<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Department;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Group;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\User;

class HomeRepository
{
    protected $group, $user, $manufacturer, $supplier, $department, $field, $field_group, $category, $asset_model, $asset, $attachment;

    public function __construct()
    {
        $this->group        = new Group();
        $this->user         = new User();
        $this->manufacturer = new Manufacturer();
        $this->supplier     = new Supplier();
        $this->department   = new Department();
        $this->field        = new Field();
        $this->field_group  = new FieldGroup();
        $this->category     = new Category();
        $this->asset_model  = new AssetModel();
        $this->asset        = new Asset();
        $this->attachment   = new Attachment();
    }

    public function removeFile($request)
    {
        switch ($request->get('module')) {
            case 'users':
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
            case 'categories':
                $this->category
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
            case 'categories':
                $model = $this->category;
                break;
            case 'asset_models':
                $model = $this->asset_model;
                break;
            case 'assets':
                $model = $this->asset;
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
