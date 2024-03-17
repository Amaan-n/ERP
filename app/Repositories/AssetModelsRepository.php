<?php

namespace App\Repositories;

use App\Models\AssetModel;
use App\Models\FieldGroup;

class AssetModelsRepository
{
    protected $asset_model, $field_group;

    public function __construct()
    {
        $this->asset_model = new AssetModel();
        $this->field_group = new FieldGroup();
    }

    public function getAssetModels()
    {
        return $this->asset_model
            ->with('manufacturer', 'asset_category', 'field_group', 'assets')
            ->get();
    }

    public function getAssetModelById($slug)
    {
        $asset_model = $this->asset_model->with('manufacturer', 'asset_category', 'field_group')->where('slug', $slug)->first();
        if (!isset($asset_model)) {
            throw new \Exception('No query results for model [App\Models\Asset Model] ' . $slug, 201);
        }

        return $asset_model;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('asset_models');
        return $this->asset_model->create($data);
    }

    public function update($data, $id)
    {
        return $this->asset_model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->asset_model->findOrFail($id)->delete();
    }

    public function getParametersByAssetModel($asset_model_id)
    {
        $field_group_id = $this->asset_model
            ->where('id', $asset_model_id)
            ->pluck('field_group_id')
            ->first();

        return $this->field_group
            ->with('fields.field')
            ->where('id', $field_group_id)
            ->where('is_active', 1)
            ->first();
    }
}
