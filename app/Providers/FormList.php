<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\AssetCategory;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Group;
use App\Models\Manufacturer;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class FormList extends ServiceProvider
{
    public static function getUsers()
    {
        return User::where('is_active', 1)->get();
    }

    public static function getGroups()
    {
        return Group::where('is_active', 1)->get();
    }

    public static function getManufacturers()
    {
        return Manufacturer::where('is_active', 1)->get();
    }

    public static function getSuppliers()
    {
        return Supplier::where('is_active', 1)->get();
    }

    public static function getAssetCategories()
    {
        return AssetCategory::where('is_active', 1)->get();
    }

    public static function getFields()
    {
        return Field::where('is_active', 1)->get();
    }

    public static function getFieldGroups()
    {
        return FieldGroup::where('is_active', 1)->get();
    }

    public static function getAssetModels()
    {
        return AssetModel::where('is_active', 1)->get();
    }

    public static function getAssets()
    {
        return Asset::where('is_active', 1)->get();
    }

    public static function getTags()
    {
        return Tag::where('is_active', 1)->get();
    }

    public static function getProductCategories()
    {
        return ProductCategory::where('is_active', 1)->get();
    }
}
