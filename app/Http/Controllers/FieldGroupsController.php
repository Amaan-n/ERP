<?php

namespace App\Http\Controllers;

use App\Models\FieldGroupHasField;
use App\Repositories\FieldGroupsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FieldGroupsController extends Controller
{
    protected $field_groups_repository;

    public function __construct()
    {
        $this->field_groups_repository = new FieldGroupsRepository();
    }

    public function index()
    {
        try {
            $field_groups = $this->field_groups_repository->getFieldGroups();
            return view('field_groups.index', compact('field_groups'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('field_groups.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('field_groups.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('fields');
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('field_groups.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $field_group       = $this->field_groups_repository->store($data);

            $fields = $request->get('fields', []);
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    FieldGroupHasField::create([
                        'field_group_id' => $field_group->id,
                        'field_id'       => $field
                    ]);
                }
            }

            $notification = prepare_notification_array('success', 'Field group has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('field_groups.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $field_group = $this->field_groups_repository->getFieldGroupById($id);
            return view('field_groups.show', compact('field_group'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('field_groups.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $field_group = $this->field_groups_repository->getFieldGroupById($id);
            return view('field_groups.manage', compact('field_group'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('field_groups.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'fields');
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('field_groups.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->field_groups_repository->update($data, $id);

            $fields = $request->get('fields', []);
            FieldGroupHasField::where('field_group_id', $id)->delete();
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    FieldGroupHasField::create([
                        'field_group_id' => $id,
                        'field_id'       => $field
                    ]);
                }
            }

            DB::commit();
            $notification = prepare_notification_array('success', 'Field group has been updated.');
            return redirect()
                ->route('field_groups.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('field_groups.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->field_groups_repository->delete($id);
            $notification = prepare_notification_array('success', 'Field group has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('field_groups.index')
            ->with('notification', $notification);
    }
}
