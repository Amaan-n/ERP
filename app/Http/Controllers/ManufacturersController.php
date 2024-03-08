<?php

namespace App\Http\Controllers;

use App\Repositories\ManufacturersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManufacturersController extends Controller
{
    protected $manufacturers_repository;

    public function __construct()
    {
        $this->manufacturers_repository = new ManufacturersRepository();
    }

    public function index()
    {
        try {
            $manufacturers = $this->manufacturers_repository->getManufacturers();
            return view('manufacturers.index', compact('manufacturers'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('manufacturers.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('manufacturers.manage');
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
                    ->route('manufacturers.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/manufacturers');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->manufacturers_repository->store($data);

            $notification = prepare_notification_array('success', 'Manufacturer has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('manufacturers.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $manufacturer = $this->manufacturers_repository->getManufacturerById($id);
            return view('manufacturers.show', compact('manufacturer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('manufacturers.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $manufacturer = $this->manufacturers_repository->getManufacturerById($id);
            return view('manufacturers.manage', compact('manufacturer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('manufacturers.index')
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
                    ->route('manufacturers.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/manufacturers');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->manufacturers_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Manufacturer has been updated.');
            return redirect()
                ->route('manufacturers.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('manufacturers.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->manufacturers_repository->delete($id);
            $notification = prepare_notification_array('success', 'Manufacturer has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('manufacturers.index')
            ->with('notification', $notification);
    }
}
