<?php

namespace App\Http\Controllers;

use App\Repositories\DepartmentsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{
    protected $departments_repository;

    public function __construct()
    {
        $this->departments_repository = new DepartmentsRepository();
    }

    public function index()
    {
        try {
            $departments = $this->departments_repository->getDepartments();
            return view('departments.index', compact('departments'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('departments.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('departments.manage');
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
                    ->route('departments.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/departments');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->departments_repository->store($data);

            $notification = prepare_notification_array('success', 'Department has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('departments.index')
            ->withInput()
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $department = $this->departments_repository->getDepartmentById($id);
            return view('departments.show', compact('department'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('departments.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $department = $this->departments_repository->getDepartmentById($id);
            return view('departments.manage', compact('department'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('departments.index')
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
                    ->route('departments.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/departments');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->departments_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Department has been updated.');
            return redirect()
                ->route('departments.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('departments.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->departments_repository->delete($id);
            $notification = prepare_notification_array('success', 'Department has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('departments.index')
            ->with('notification', $notification);
    }
}
