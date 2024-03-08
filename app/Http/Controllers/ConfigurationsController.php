<?php

namespace App\Http\Controllers;

use App\Repositories\ConfigurationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigurationsController extends Controller
{
    protected $configurations_repository;

    public function __construct()
    {
        $this->configurations_repository = new ConfigurationsRepository();
    }

    public function index()
    {
        try {
            $configurations = $this->configurations_repository->getConfigurations();
            return view('configurations.index', compact('configurations'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('configurations')
                ->with('notification', $notification);
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->configurations_repository->update($request);
            $notification = prepare_notification_array('success', 'Configurations has been updated.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('configurations')
            ->withInput()
            ->with('notification', $notification);
    }
}
