<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\AssetModel;

class AssetsRepository
{
    protected $asset, $asset_model;

    public function __construct()
    {
        $this->asset       = new Asset();
        $this->asset_model = new AssetModel();
    }

    public function getAssets()
    {
        return $this->asset
            ->with('supplier', 'asset_model', 'parameters', 'allocation')
            ->get();
    }

    public function getAssetById($id)
    {
        return $this->asset
            ->with('supplier', 'asset_model', 'parameters', 'allocation')
            ->findOrFail($id);
    }

    public function store($data)
    {
        $data         = $this->prepare_asset_code($data);
        $data['slug'] = generate_slug('assets');
        return $this->asset->create($data);
    }

    public function update($data, $id)
    {
        $data = $this->prepare_asset_code($data);
        return $this->asset->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->asset->findOrFail($id)->delete();
    }

    private function prepare_asset_code($data)
    {
        $asset_model = $this->asset_model
            ->with('category')
            ->where('id', $data['asset_model_id'])
            ->first();

        if (isset($asset_model)) {
            $configurations      = get_configurations_data();
            $company_code        = $configurations['company_code'] ?? 'AL';
            $asset_count         = $this->asset->where('category_id', $asset_model->category_id)->get()->count();
            $asset_number        = str_pad(($asset_count + 1), 4, '0', STR_PAD_LEFT);
            $data['code']        = $company_code . '-' . strtoupper(str_replace(' ', '-', $asset_model->category->name)) . '-' . $asset_number;
            $data['category_id'] = $asset_model->category_id;
        }

        return $data;
    }
}
