<?php

namespace App\Http\Controllers;

use App\Models\AssetHasParameter;
use App\Repositories\AssetsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssetsController extends Controller
{
    protected $assets_repository;

    public function __construct()
    {
        $this->assets_repository = new AssetsRepository();
    }

    public function index()
    {
        try {
            $assets = $this->assets_repository->getAssets();
            return view('assets.index', compact('assets'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('assets.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('assets.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('old_attachment', 'parameters');
            $validator = Validator::make($data, array(
                'supplier_id'    => 'required',
                'asset_model_id' => 'required',
                'name'           => 'required',
                'purchase_date'  => 'required',
                'purchase_cost'  => 'required',
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('assets.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/assets');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $asset              = $this->assets_repository->store($data);

            $parameters = $request->get('parameters', []);
            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    AssetHasParameter::create([
                        'asset_id' => $asset->id,
                        'key'      => $key,
                        'value'    => $value
                    ]);
                }
            }

            $notification = prepare_notification_array('success', 'Asset has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('assets.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $asset = $this->assets_repository->getAssetById($id);
            return view('assets.show', compact('asset'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('assets.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $asset = $this->assets_repository->getAssetById($id);
            return view('assets.manage', compact('asset'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('assets.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'old_attachment', 'parameters');
            $validator = Validator::make($data, array(
                'supplier_id'    => 'required',
                'asset_model_id' => 'required',
                'name'           => 'required',
                'purchase_date'  => 'required',
                'purchase_cost'  => 'required',
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('assets.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/assets');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->assets_repository->update($data, $id);

            $parameters = $request->get('parameters', []);
            AssetHasParameter::where('asset_id', $id)->delete();
            if (!empty($parameters)) {
                foreach ($parameters as $key => $value) {
                    AssetHasParameter::create([
                        'asset_id' => $id,
                        'key'      => $key,
                        'value'    => $value
                    ]);
                }
            }

            DB::commit();
            $notification = prepare_notification_array('success', 'Asset has been updated.');
            return redirect()
                ->route('assets.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('assets.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->assets_repository->delete($id);
            $notification = prepare_notification_array('success', 'Asset has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('assets.index')
            ->with('notification', $notification);
    }
}
