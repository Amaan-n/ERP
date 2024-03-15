<?php

namespace App\Http\Controllers;

use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    protected $products_repository;

    public function __construct()
    {
        $this->products_repository = new ProductsRepository();
    }

    public function index()
    {
        try {
            $products = $this->products_repository->getProducts();
            return view('products.index', compact('products'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('products.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('products.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('old_attachment');
            $validator = Validator::make($data, array(
                'product_category_id' => 'required',
                'name'                => 'required',
                'price'               => 'required',
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('products.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/products');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->products_repository->store($data);

            $notification = prepare_notification_array('success', 'Product has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('products.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $product = $this->products_repository->getProductById($id);
            return view('products.show', compact('product'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('products.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $product = $this->products_repository->getProductById($id);
            return view('products.manage', compact('product'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('products.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'old_attachment');
            $validator = Validator::make($data, array(
                'product_category_id' => 'required',
                'name'                => 'required',
                'price'               => 'required',
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('products.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/products');
            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $this->products_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Product has been updated.');
            return redirect()
                ->route('products.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('products.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->products_repository->delete($id);
            $notification = prepare_notification_array('success', 'Product has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('products.index')
            ->with('notification', $notification);
    }
}
