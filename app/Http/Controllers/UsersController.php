<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    protected $users_repository;

    public function __construct()
    {
        $this->users_repository = new UsersRepository();
    }

    public function index()
    {
        try {
            $users = $this->users_repository->getUsers();
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('users.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('users.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'group_id' => 'required',
                'name'     => 'required',
                'phone'    => 'required|unique:users',
                'email'    => 'required|email|unique:users'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('users.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['picture']           = upload_attachment($request, 'picture', 'uploads/users');
            $data['password']          = bcrypt($data['password']);
            $data['is_active']         = isset($data['is_active']) ? 1 : 0;
            $data['email_verified_at'] = Carbon::now();
            $this->users_repository->store($data);

            $notification = prepare_notification_array('success', 'User has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('users.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $user = $this->users_repository->getUserById($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('users.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->users_repository->getUserById($id);
            return view('users.manage', compact('user'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('users.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array(
                'group_id' => 'required',
                'name'     => 'required',
                'phone'    => 'required|unique:users,phone,' . $id . ',id',
                'email'    => 'required|email|unique:users,email,' . $id . ',id'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('users.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['picture']   = upload_attachment($request, 'picture', 'uploads/users');
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;

            $password         = $request->get('password', '');
            $confirm_password = $request->get('confirm_password', '');
            if (!empty($password)) {
                if ($password != $confirm_password) {
                    throw new \Exception('The password and its confirm are not the same', 201);
                }

                $data['password'] = bcrypt($password);
            }

            $this->users_repository->update($data, $id);
            DB::commit();

            $redirect_to  = 'users.index';
            $notification = prepare_notification_array('success', 'User has been updated.');
            if ($request->has('request_from') && $request->get('request_from') == 'profile') {
                $redirect_to  = 'profile';
                $notification = prepare_notification_array('success', 'Your profile has been updated.');
            }

            return redirect()
                ->route($redirect_to)
                ->withInput()
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('users.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->users_repository->delete($id);
            $notification = prepare_notification_array('success', 'User has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('users.index')
            ->with('notification', $notification);
    }
}
