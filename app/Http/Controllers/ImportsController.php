<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\ImportsRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;

class ImportsController extends Controller
{
    protected $imports_repository, $users_repository;

    public function __construct()
    {
        $this->imports_repository = new ImportsRepository();
        $this->users_repository   = new UsersRepository();
    }

    public function import($module_name = '')
    {
        if (!in_array($module_name, ['users'])) {
            return redirect()->route('home');
        }

        return view('imports.manage', compact('module_name'));
    }

    public function parse(Request $request, $module_name = '')
    {
        ini_set('max_execution_time', 0);
        try {
            if ($request->hasFile('attachment')) {
                $file_name_with_extension = 'imported_' . $module_name . '.' . $request->file('attachment')->getClientOriginalExtension();
                $request->file('attachment')->move(public_path() . '/uploads', $file_name_with_extension);

                $file_name_string = public_path('uploads/' . $file_name_with_extension);
                if (!file_exists($file_name_string) || !is_readable($file_name_string)) {
                    $notification = prepare_notification_array('danger', 'We are unable to find the attachment.');
                    return redirect()
                        ->route('imports', [$module_name])
                        ->with('notification', $notification);
                }

                session()->put(['imported_csv' => $file_name_string, 'import_type' => $request->get('import_type')]);
            } else {
                $file_name_string = session('imported_csv');
            }

            if (empty($file_name_string)) {
                throw new \Exception('Please select a file first.');
            }

            $validated_fields = [];
            switch ($module_name) {
                case 'users':
                    $validated_fields = ['name'];
                    break;
            }

            $header   = null;
            $response = [];
            if (($handle = fopen($file_name_string, 'r')) !== false) {
                $validation_check = false;
                while (($row = fgetcsv($handle)) !== false) {
                    if (!$validation_check && !empty($validated_fields)) {
                        $required_fields = array_diff($validated_fields, array_values(array_filter($row)));
                        if (isset($required_fields) && count($required_fields) > 0) {
                            foreach ($required_fields as $key => $value) {
                                $notification = prepare_notification_array('danger', ucwords($value) . ' column not found.');
                                return redirect()
                                    ->route('imports', [$module_name])
                                    ->with('notification', $notification);
                            }
                        }
                        $validation_check = true;
                    }

                    if (!$header) {
                        $header = $row;
                    } else {
                        $response[] = array_combine($header, $row);
                    }

                    foreach ($response as $res) {
                        foreach ($res as $data_key => $data_val) {
                            if (in_array($data_key, $validated_fields) && empty($data_val)) {
                                $notification = prepare_notification_array('danger', ucwords($data_key) . ' can\'t be empty.');
                                return redirect()
                                    ->route('imports', [$module_name])
                                    ->with('notification', $notification);
                            }
                        }
                    }
                }
                fclose($handle);
            }

            $request_for = $request->get('request_for', '');
            if (!empty($request_for) && $request_for == 'store_imported_data') {
                if (!empty($response)) {
                    $imported_count = 0;
                    switch ($module_name) {
                        case 'users':
                            if (session()->get('import_type') === 'Override') {
                                User::whereRaw('1=1')->delete();
                            }

                            foreach ($response as $res) {
                                $imported_count   += 1;
                                $res['is_active'] = 1;
                                $this->users_repository->store($res);
                            }
                            break;
                    }

                    if ($imported_count == count($response)) {
                        session()->forget(['imported_csv', 'import_type']);
                        $notification = prepare_notification_array('success', ucwords(str_replace('_', ' ', $module_name)) . ' have been imported.');
                        return redirect()
                            ->route($module_name . '.index')
                            ->with('notification', $notification);
                    } else {
                        $notification = prepare_notification_array('success', $imported_count . ' ' . str_replace('_', ' ', $module_name) . ' have been imported and ' . (count($response) - $imported_count) . ' ' . str_replace('_', ' ', $module_name) . ' having issue.');
                        return redirect()
                            ->route($module_name . '.index')
                            ->with('notification', $notification);
                    }
                }
            }

            return view('imports.manage', compact('response', 'module_name'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('imports', [$module_name])
                ->with('notification', $notification);
        }
    }
}
