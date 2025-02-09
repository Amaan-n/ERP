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
        return $this->asset->with('supplier', 'asset_model', 'parameters')->get();
    }

    public function getAssetById($slug)
    {
        $asset = $this->asset->with('supplier', 'asset_model', 'parameters')->where('slug', $slug)->first();
        if (!isset($asset)) {
            throw new \Exception('No query results for model [App\Models\Asset] ' . $slug, 201);
        }

        return $asset;
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

    public function delete($slug)
    {
        return $this->asset->where('slug', $slug)->firstOrFail()->delete();
    }

    private function prepare_asset_code($data)
    {
        $asset_model = $this->asset_model
            ->with('asset_category')
            ->where('id', $data['asset_model_id'])
            ->first();

        if (isset($asset_model)) {
            $configurations            = get_configurations_data();
            $company_code              = $configurations['company_code'] ?? 'AL';
            $asset_count               = $this->asset->where('asset_category_id', $asset_model->asset_category_id)->get()->count();
            $asset_number              = str_pad(($asset_count + 1), 4, '0', STR_PAD_LEFT);
            $data['code']              = $company_code . '-' . strtoupper(str_replace(' ', '-', $asset_model->asset_category->name)) . '-' . $asset_number;
            $data['asset_category_id'] = $asset_model->asset_category_id;
        }

        return $data;
    }
}
