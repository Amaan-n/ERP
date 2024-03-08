<?php

namespace App\Repositories;

use App\Models\Mapping;

class MappingsRepository
{
    protected $mapping;

    public function __construct()
    {
        $this->mapping = new Mapping();
    }

    public function store($data)
    {
        return $this->mapping
            ->updateOrCreate(
                ['asset_id' => $data['asset_id']],
                [
                    'asset_id' => $data['asset_id'],
                    'tag_id'   => $data['tag_id']
                ]);
    }
}
