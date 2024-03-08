<?php

namespace App\Http\Controllers;

use App\Repositories\TagsRepository;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    protected $tags_repository;

    public function __construct()
    {
        $this->tags_repository = new TagsRepository();
    }

    public function index(Request $request)
    {
        try {
            $tags = $this->tags_repository->getTags();
            return view('tags.index', compact('tags'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('tags.index')
                ->with('notification', $notification);
        }
    }

    public function create()
    {
        $chip_order_name = $this->tags_repository->generateRandomUniqueIdentifier('chip_order_name');
        return view('tags.manage', compact('chip_order_name'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->all();
            $validator = Validator::make($data, array('quantity' => 'required'));
            if ($validator->fails()) {
                $notification = prepare_notification_array('danger', implode('<br>', $validator->getMessageBag()->all()));
                return redirect()
                    ->route('tags.create')
                    ->withInput()
                    ->with('notification', $notification);
            }

            $data['is_active'] = isset($data['is_active']) ? 1 : 0;

            for ($i = 1; $i <= $data['quantity']; $i++) {
                $uuid          = mt_rand(100000, 999999);
                $qr_code_path  = 'uploads/qr_codes/' . $uuid . '.png';
                $qr_code_value = 'https://erp.internetofweb.com/t/' . $uuid;

                $common_service = new CommonService();
                $common_service->generateQRCode($qr_code_value, public_path($qr_code_path));

                $data['value']      = $qr_code_value;
                $data['attachment'] = $qr_code_path;

                // upload_image_to_bucket($uuid . '.png', 'uploads/qr_codes');
                $this->tags_repository->store($data);
            }

            $notification = prepare_notification_array('success', 'Tag has been added.');
            DB::commit();
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            DB::rollBack();
        }

        return redirect()
            ->route('tags.index')
            ->with('notification', $notification);
    }

    public function show($id)
    {
        try {
            $tag = $this->tags_repository->getTagById($id);
            return view('tags.show', compact('tag'));
        } catch (\Exception $e) {
            $notification = prepare_notification_array('danger', $e->getMessage());
            return redirect()
                ->route('tags.index')
                ->with('notification', $notification);
        }
    }
}
