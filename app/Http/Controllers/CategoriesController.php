<?php

namespace App\Http\Controllers;

use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    protected $categories_repository;

    public function __construct()
    {
        $this->categories_repository = new CategoriesRepository();
    }

    public function index()
    {
        try {
            $categories = $this->categories_repository->getCategories();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('categories.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('categories.manage');
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
                    ->route('categories.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/categories');
            $this->categories_repository->store($data);

            $notification = prepare_notification_array('success', 'Category has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('categories.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $category = $this->categories_repository->getCategoryById($id);
            return view('categories.show', compact('category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('categories.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->categories_repository->getCategoryById($id);
            return view('categories.manage', compact('category'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('categories.index')
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
                    ->route('categories.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active']  = isset($data['is_active']) ? 1 : 0;
            $data['attachment'] = upload_attachment($request, 'attachment', 'uploads/categories');
            $this->categories_repository->update($data, $id);

            $notification = prepare_notification_array('success', 'Category has been updated.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('categories.index')
            ->with('notification', $notification);
    }

    public function destroy($id)
    {
        try {
            $this->categories_repository->delete($id);
            $notification = prepare_notification_array('success', 'Category has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('categories.index')
            ->with('notification', $notification);
    }
}
