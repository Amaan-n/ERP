<?php

namespace App\Http\Controllers;

use App\Repositories\ProductCategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCategoriesController extends Controller
{
    protected $product_categories_repository;

    public function __construct()
    {
        $this->product_categories_repository = new ProductCategoriesRepository();
    }

    public function index()
    {
        try {
            $product_categories = $this->product_categories_repository->getProductCategories();
            return view('product_categories.index', compact('product_categories'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('product_categories.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('product_categories.manage');
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
                    ->route('product_categories.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->product_categories_repository->store($data);

            $notification = prepare_notification_array('success', 'Product category has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('product_categories.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $product_category = $this->product_categories_repository->getProductCategoryById($id);
            return view('product_categories.show', compact('product_category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('product_categories.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $product_category = $this->product_categories_repository->getProductCategoryById($id);
            return view('product_categories.manage', compact('product_category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('product_categories.index')
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
                    ->route('product_categories.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->product_categories_repository->update($data, $id);

            DB::commit();
            $notification = prepare_notification_array('success', 'Product category has been updated.');
            return redirect()
                ->route('product_categories.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('product_categories.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->product_categories_repository->delete($id);
            $notification = prepare_notification_array('success', 'Product category has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('product_categories.index')
            ->with('notification', $notification);
    }
}
