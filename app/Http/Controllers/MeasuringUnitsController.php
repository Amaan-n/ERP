<?php

namespace App\Http\Controllers;

use App\Repositories\MeasuringUnitsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MeasuringUnitsController extends Controller
{
    protected $measuring_units_repository;

    public function __construct()
    {
        $this->measuring_units_repository = new MeasuringUnitsRepository();
    }

    public function index()
    {
        try {
            $measuring_units = $this->measuring_units_repository->getMeasuringUnits();
            return view('measuring_units.index', compact('measuring_units'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('measuring_units.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('measuring_units.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('measuring_units.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->measuring_units_repository->store($data);

            $notification = prepare_notification_array('success', 'Measuring unit has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('measuring_units.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $measuring_unit = $this->measuring_units_repository->getMeasuringUnitById($id);
            return view('measuring_units.show', compact('measuring_unit'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('measuring_units.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $measuring_unit = $this->measuring_units_repository->getMeasuringUnitById($id);
            return view('measuring_units.manage', compact('measuring_unit'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('measuring_units.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method');
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('measuring_units.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->measuring_units_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Measuring unit has been updated.');
            return redirect()
                ->route('measuring_units.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('measuring_units.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->measuring_units_repository->delete($id);
            $notification = prepare_notification_array('success', 'Measuring unit has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('measuring_units.index')
            ->with('notification', $notification);
    }
}
