<?php

namespace App\Http\Controllers;

use App\Repositories\GroupsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    protected $groups_repository;

    public function __construct()
    {
        $this->groups_repository = new GroupsRepository();
    }

    public function index()
    {
        try {
            $groups = $this->groups_repository->getGroups();
            return view('groups.index', compact('groups'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('groups.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('groups.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data              = $request->except('system_modules');
            $data['is_active'] = isset($data['is_active']) ? 1 : 0;

            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('groups.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $group          = $this->groups_repository->store($data);
            $system_modules = $request->get('system_modules', []);
            $this->groups_repository->storeGroupAccesses($group->id, $system_modules);

            $notification = prepare_notification_array('success', 'Group has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('groups.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $group = $this->groups_repository->getGroupById($id);

            $selected_access = [];
            if (isset($group->accesses) && !empty($group->accesses)) {
                foreach ($group->accesses as $access) {
                    $selected_access[] = ucwords(str_replace('.index', ' ', $access->module));
                }
            }

            return view('groups.show', compact('group', 'selected_access'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('groups.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $group = $this->groups_repository->getGroupById($id);

            $selected_access = [];
            if (isset($group->accesses) && !empty($group->accesses)) {
                foreach ($group->accesses as $access) {
                    $selected_access[] = $access->module;
                }
            }

            return view('groups.manage', compact('group', 'selected_access'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('groups.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except(['_method', 'system_modules']);
            $validator = Validator::make($data, array('name' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('groups.edit', [$request->get('slug')])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 0;
            $this->groups_repository->update($data, $id);
            $system_modules = $request->get('system_modules', []);
            $this->groups_repository->storeGroupAccesses($id, $system_modules);

            DB::commit();
            $notification = prepare_notification_array('success', 'Group has been updated.');
            return redirect()
                ->route('groups.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('groups.edit', [$request->get('slug')])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->groups_repository->delete($id);
            $notification = prepare_notification_array('success', 'Group has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('groups.index')
            ->with('notification', $notification);
    }
}
