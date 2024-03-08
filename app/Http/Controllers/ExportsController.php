<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Repositories\ExportsRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller
{
    protected $exports_repository;

    public function __construct()
    {
        $this->exports_repository = new ExportsRepository();
    }

    public function export(Request $request, $module_name = '', $id = '')
    {
        if (!in_array($module_name, ['products'])) {
            return redirect()->route('home');
        }

        if ($this->exports_repository->getDataCount($module_name) <= 0) {
            $notification = prepare_notification_array('danger', 'No records found to exports!');
            return redirect()
                ->route($module_name . '.index')
                ->with('notification', $notification);
        }

        $file_name  = ucwords(str_replace('_', ' ', $module_name)) . '_' . date('dS-F-Y_h-i-s') . '.xlsx';
        $class_name = '';
        switch ($module_name) {
            case 'products':
                $class_name = new UsersExport();
                break;
        }

        return Excel::download($class_name, $file_name);
    }
}
