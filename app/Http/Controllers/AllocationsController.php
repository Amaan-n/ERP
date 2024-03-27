<?php

namespace App\Http\Controllers;

use App\Repositories\AllocationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AllocationsController extends Controller
{
    protected $allocations_repository;

    public function __construct()
    {
        $this->allocations_repository = new AllocationsRepository();
    }

    public function index(Request $request)
    {
        $user_id = $request->get('user_id', '');
        return view('allocations.index', compact('user_id'));
    }

    public function getAllocatedItemsByUser(Request $request)
    {
        try {
            $allocations   = $this->allocations_repository->getAllocatedItemsByUser($request->get('user_id'));
            $rendered_html = view('allocations.partials.assets', compact('allocations'))->render();

            return response()
                ->json([
                    'success' => true,
                    'code'    => 200,
                    'message' => 'Parameters for the selected asset model have been retrieved.',
                    'data'    => [
                        'html' => $rendered_html
                    ]
                ]);
        } catch (\Exception $e) {
            return response()
                ->json([
                    'success' => false,
                    'code'    => $e->getCode(),
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), array(
                'user_id'   => 'required',
                'asset_ids' => 'required'
            ));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('assets.allocation')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $this->allocations_repository->store($request);
            $notification = prepare_notification_array('success', 'Selected assets have been allocated.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('assets.allocation')
            ->withInput()
            ->with('notification', $notification);
    }
}
