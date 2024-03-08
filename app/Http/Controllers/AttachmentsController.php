<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttachmentsController extends Controller
{
    protected $attachment;

    public function __construct()
    {
        $this->attachment = new Attachment();
    }

    public function attachments($module_name = '', $reference_id = 0)
    {
        if (!in_array($module_name, ['products'])) {
            return redirect()->route('home');
        }

        $attachments = $this->attachment
            ->where('module_name', $module_name)
            ->where('reference_id', $reference_id)
            ->get();

        return view('attachments.manage', compact('module_name', 'reference_id', 'attachments'));
    }

    public function upload(Request $request, $module_name, $reference_id)
    {
        DB::beginTransaction();
        try {
            $attachments = $request->file('attachments');
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    if (is_object($attachment) && $attachment->isValid() && $attachment->getSize() < 10000000
                        && in_array($attachment->getMimeType(), ['image/jpeg', 'image/png', 'image/bmp', 'image/x-icon'])) {

                        $attachment_file_with_ext = sha1(time() . rand()) . '.' . $attachment->getClientOriginalExtension();
                        $attachment->move(public_path('uploads/attachments'), $attachment_file_with_ext);
                        $path = 'uploads/attachments/' . $attachment_file_with_ext;

                        $this->attachment
                            ->create([
                                'module_name'  => $module_name,
                                'reference_id' => $reference_id,
                                'path'         => $path
                            ]);
                    }
                }
            }

            DB::commit();
            $notification = prepare_notification_array('success', 'Attachments have been added for ' . str_replace('_', ' ', $module_name));
        } catch (\Exception $e) {
            DB::rollBack();
            $notification = prepare_notification_array('danger', $e->getMessage());
        }

        return redirect()
            ->route('attachments', [$module_name, $reference_id])
            ->with('notification', $notification);
    }
}
