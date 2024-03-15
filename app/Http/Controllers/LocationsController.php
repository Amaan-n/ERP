<?php

namespace App\Http\Controllers;

use App\Repositories\LocationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocationsController extends Controller
{
    protected $locations_repository;

    public function __construct()
    {
        $this->locations_repository = new LocationsRepository();
    }

    public function index()
    {
        try {
            $locations = $this->locations_repository->getLocations();
            return view('locations.index', compact('locations'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('locations.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('locations.manage');
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
                    ->route('locations.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->locations_repository->store($data);

            $notification = prepare_notification_array('success', 'Location has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('locations.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $location = $this->locations_repository->getLocationById($id);
            return view('locations.show', compact('location'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('locations.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $location = $this->locations_repository->getLocationById($id);
            return view('locations.manage', compact('location'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('locations.index')
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
                    ->route('locations.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->locations_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Location has been updated.');
            return redirect()
                ->route('locations.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('locations.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->locations_repository->delete($id);
            $notification = prepare_notification_array('success', 'Location has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('locations.index')
            ->with('notification', $notification);
    }
}
