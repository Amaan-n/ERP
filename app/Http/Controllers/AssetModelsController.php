<?php

namespace App\Http\Controllers;

use App\Repositories\AssetModelsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssetModelsController extends Controller
{
    protected $asset_models_repository;

    public function __construct()
    {
        $this->asset_models_repository = new AssetModelsRepository();
    }

    public function index()
    {
        try {
            $asset_models = $this->asset_models_repository->getAssetModels();
            return view('asset_models.index', compact('asset_models'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_models.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('asset_models.manage');
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
                    ->route('asset_models.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/asset_models');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->asset_models_repository->store($data);

            $notification = prepare_notification_array('success', 'Asset model has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('asset_models.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $asset_model = $this->asset_models_repository->getAssetModelById($id);
            return view('asset_models.show', compact('asset_model'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_models.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $asset_model = $this->asset_models_repository->getAssetModelById($id);
            return view('asset_models.manage', compact('asset_model'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_models.index')
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
                    ->route('asset_models.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/asset_models');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->asset_models_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Asset model has been updated.');
            return redirect()
                ->route('asset_models.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('asset_models.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->asset_models_repository->delete($id);
            $notification = prepare_notification_array('success', 'Asset model has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('asset_models.index')
            ->with('notification', $notification);
    }

    public function getParametersByAssetModel(Request $request)
    {
        try {
            $field_group        = $this->asset_models_repository->getParametersByAssetModel($request->get('asset_model_id'));
            $rendered_html      = view('asset_models.partials.parameters', compact('field_group'))->render();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Parameters for the selected asset model have been retrieved.',
                    'data'    => [
                        'html' => $rendered_html
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }
}
