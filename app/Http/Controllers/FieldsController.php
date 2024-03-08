<?php

namespace App\Http\Controllers;

use App\Models\FieldHasOption;
use App\Repositories\FieldsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FieldsController extends Controller
{
    protected $fields_repository;

    public function __construct()
    {
        $this->fields_repository = new FieldsRepository();
    }

    public function index()
    {
        try {
            $fields = $this->fields_repository->getFields();
            return view('fields.index', compact('fields'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('fields.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        return view('fields.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('options');
            $validator = Validator::make($data, array('name' => 'required|unique:fields'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('fields.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $field             = $this->fields_repository->store($data);

            $options = $request->get('options', []);
            if (!empty($options)) {
                foreach ($options as $option) {
                    if (!empty($option)) {
                        FieldHasOption::create([
                            'field_id' => $field->id,
                            'text'     => $option
                        ]);
                    }
                }
            }

            $notification = prepare_notification_array('success', 'Field has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('fields.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $field = $this->fields_repository->getFieldById($id);
            return view('fields.show', compact('field'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('fields.index')
                ->with('notification', $notification);
        }
    }

    public function edit($id)
    {
        try {
            $field = $this->fields_repository->getFieldById($id);
            return view('fields.manage', compact('field'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('fields.index')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'options');
            $validator = Validator::make($data, array('name' => 'required|unique:fields,name,' . $id . ',id'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('fields.edit', [$id])
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;
            $this->fields_repository->update($data, $id);

            FieldHasOption::where('field_id', $id)->delete();
            $options = $request->get('options', []);
            if (!empty($options)) {
                foreach ($options as $option) {
                    if (!empty($option)) {
                        FieldHasOption::create([
                            'field_id' => $id,
                            'text'     => $option
                        ]);
                    }
                }
            }

            DB::commit();
            $notification = prepare_notification_array('success', 'Field has been updated.');
            return redirect()
                ->route('fields.index')
                ->with('notification', $notification);
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('fields.edit', [$id])
                ->withInput()
                ->with('notification', $notification);
        }
    }

    public function destroy($id)
    {
        try {
            $this->fields_repository->delete($id);
            $notification = prepare_notification_array('success', 'Field has been deleted.');
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('fields.index')
            ->with('notification', $notification);
    }
}
