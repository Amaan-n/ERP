<?php

namespace App\Http\Controllers;

use App\Repositories\MappingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MappingsController extends Controller
{
    protected $mappings_repository;

    public function __construct()
    {
        $this->mappings_repository = new MappingsRepository();
    }

    public function create()
    {
        return view('mappings.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('asset_id' => 'required', 'tag_id' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('tags.mapping')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $this->mappings_repository->store($data);
            $notification = prepare_notification_array('success', 'Selected asset has been mapped with the tag.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('tags.mapping')
            ->withInput()
            ->with('notification', $notification);
    }
}
