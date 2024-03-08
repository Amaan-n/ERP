<?php

namespace App\Http\Controllers;

use App\Repositories\SuppliersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    protected $suppliers_repository;

    public function __construct()
    {
        $this->suppliers_repository = new SuppliersRepository();
    }

    public function index()
    {
        try {
            $suppliers = $this->suppliers_repository->getSuppliers();
            return view('suppliers.index', compact('suppliers'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('suppliers.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('suppliers.manage');
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
                    ->route('suppliers.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/suppliers');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->suppliers_repository->store($data);

            $notification = prepare_notification_array('success', 'Supplier has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('suppliers.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $supplier = $this->suppliers_repository->getSupplierById($id);
            return view('suppliers.show', compact('supplier'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('suppliers.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $supplier = $this->suppliers_repository->getSupplierById($id);
            return view('suppliers.manage', compact('supplier'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('suppliers.index')
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
                    ->route('suppliers.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/suppliers');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->suppliers_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Supplier has been updated.');
            return redirect()
                ->route('suppliers.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('suppliers.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->suppliers_repository->delete($id);
            $notification = prepare_notification_array('success', 'Supplier has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('suppliers.index')
            ->with('notification', $notification);
    }
}
