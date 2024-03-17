<?php

namespace App\Http\Controllers;

use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssetCategoriesController extends Controller
{
    protected $asset_categories_repository;

    public function __construct()
    {
        $this->asset_categories_repository = new CategoriesRepository();
    }

    public function index()
    {
        try {
            $asset_categories = $this->asset_categories_repository->getAssetCategories();
            return view('asset_categories.index', compact('asset_categories'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_categories.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('asset_categories.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('old_attachment');
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('asset_categories.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/asset_categories');
            $this->asset_categories_repository->store($data);

            $notification = prepare_notification_array('success', 'Asset category has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('asset_categories.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $asset_category = $this->asset_categories_repository->getAssetCategoryById($id);
            return view('asset_categories.show', compact('asset_category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_categories.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $asset_category = $this->asset_categories_repository->getAssetCategoryById($id);
            return view('asset_categories.manage', compact('asset_category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_categories.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'old_attachment');
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('asset_categories.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/asset_categories');
            $this->asset_categories_repository->update($data, $id);

            $notification = prepare_notification_array('success', 'Asset category has been updated.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('asset_categories.index')
            ->with('notification', $notification);
    }

    public function destroy($id)
    {
        try {
            $this->asset_categories_repository->delete($id);
            $notification = prepare_notification_array('success', 'Asset category has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('asset_categories.index')
            ->with('notification', $notification);
    }
}
