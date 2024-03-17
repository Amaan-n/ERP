<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeesRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{
    protected $employees_repository;

    public function __construct()
    {
        $this->employees_repository = new EmployeesRepository();
    }

    public function index()
    {
        try {
            $employees = $this->employees_repository->getEmployees();
            return view('employees.index', compact('employees'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('employees.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('employees.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'name'  => 'required',
                'phone' => 'required|unique:users',
                'email' => 'required|email|unique:users'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('employees.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['picture']           = upload_attachment($request, 'picture', 'uploads/employees');
            $data['password']          = bcrypt($data['password']);
            $data['is_active']         = isset($data['is_active']) ? 1 : 0;
            $data['email_verified_at'] = Carbon::now();
            $this->employees_repository->store($data);

            $notification = prepare_notification_array('success', 'Employee has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('employees.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $employee = $this->employees_repository->getEmployeeById($id);
            return view('employees.show', compact('employee'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('employees.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $employee = $this->employees_repository->getEmployeeById($id);
            return view('employees.manage', compact('employee'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('employees.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'name'  => 'required',
                'phone' => 'required|unique:users,phone,' . $id . ',id',
                'email' => 'required|email|unique:users,email,' . $id . ',id'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('employees.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['picture']   = upload_attachment($request, 'picture', 'uploads/employees');
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;

            $password         = $request->get('password', '');
            $confirm_password = $request->get('confirm_password', '');
            if (!empty($password)) {
                if ($password != $confirm_password) {
                    throw new \Exception('The password and its confirm are not the same', 201);
                }

                $data['password'] = bcrypt($password);
            }

            $this->employees_repository->update($data, $id);
            DB::commit();

            $notification = prepare_notification_array('success', 'Employee has been updated.');

            return redirect()
                ->route('employees.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('employees.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->employees_repository->delete($id);
            $notification = prepare_notification_array('success', 'Employee has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('employees.index')
            ->with('notification', $notification);
    }
}
