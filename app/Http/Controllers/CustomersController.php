<?php

namespace App\Http\Controllers;

use App\Repositories\CustomersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    protected $customers_repository;

    public function __construct()
    {
        $this->customers_repository = new CustomersRepository();
    }

    public function index()
    {
        try {
            $customers = $this->customers_repository->getCustomers();
            return view('customers.index', compact('customers'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('customers.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('name' => 'required', 'phone' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('customers.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->customers_repository->store($data);

            $notification = prepare_notification_array('success', 'Customer has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        $redirect_back = $request->has('redirect_back') ? $request->get('redirect_back') : 'customers.index';
        return redirect()
            ->route($redirect_back)
            ->with('phone', $request->get('phone'))
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($id);
            return view('customers.show', compact('customer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $customer = $this->customers_repository->getCustomerById($id);
            return view('customers.manage', compact('customer'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method');
            $validator = Validator::make($data, array('name' => 'required', 'phone' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('customers.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->customers_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Customer has been updated.');

            $redirect_back = $request->has('redirect_back') ? $request->get('redirect_back') : 'customers.index';
            return redirect()
                ->route($redirect_back)
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('customers.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->customers_repository->delete($id);
            $notification = prepare_notification_array('success', 'Customer has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('customers.index')
            ->with('notification', $notification);
    }

    public function getCustomerByPhone(Request $request)
    {
        try {
            $customer = $this->customers_repository->getCustomerByPhone($request->get('phone'));

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Customer detail has been retrieved for the given phone.',
                    'data'    => [
                        'customer' => [
                            'id'    => $customer->id,
                            'slug'  => $customer->slug,
                            'name'  => $customer->name ?? '',
                            'phone' => $customer->phone ?? '',
                            'email' => $customer->email ?? '',
                            'about' => $customer->about ?? '',
                        ]
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
