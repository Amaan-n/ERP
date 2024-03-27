<?php

namespace App\Repositories;

use App\Models\Allocation;
use App\Models\Asset;
use Illuminate\Http\Request;

class AllocationsRepository
{
    protected $allocation, $asset;

    public function __construct()
    {
        $this->allocation = new Allocation();
        $this->asset      = new Asset();
    }

    public function getAllocatedItemsByUser($user_id)
    {
        return $this->allocation
            ->with('asset', 'user')
            ->where('user_id', $user_id)
            ->get();
    }

    public function store(Request $request)
    {
        $asset_ids = $request->get('asset_ids', []);
        foreach ($asset_ids as $asset_id) {
            $this->allocation
                ->create([
                    'user_id'      => $request->get('user_id'),
                    'asset_id'     => $asset_id,
                    'allocated_by' => auth()->user()->id
                ]);

            save_asset_transaction($asset_id, $request->get('user_id'), 'allocated');
        }

        $this->asset
            ->whereIn('id', $asset_ids)
            ->update([
                'status' => 'allocated'
            ]);
    }
}
