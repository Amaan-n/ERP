<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Models\Group;
use App\Models\User;

class HomeRepository
{
    protected $group, $user, $attachment;

    public function __construct()
    {
        $this->group      = new Group();
        $this->user       = new User();
        $this->attachment = new Attachment();
    }

    public function removeFile($request)
    {
        switch ($request->get('module')) {
            case 'users':
                $this->user
                    ->where('id', $request->get('id'))
                    ->update([
                        $request->get('field') => ''
                    ]);
                break;
            case 'attachments':
                $this->attachment
                    ->where('id', $request->get('id'))
                    ->delete();
                break;
            default:
                break;
        }
    }

    public function updateState($module, $id)
    {
        $model = '';
        switch ($module) {
            case 'groups':
                $model = $this->group;
                break;
            case 'users':
                $model = $this->user;
                break;
        }

        $response = $model->where('id', $id)->first();
        if (!isset($response)) {
            throw new \Exception('No record found.', 201);
        }

        $response->is_active = $response->is_active == 1 ? 0 : 1;
        $response->save();
        return $response->is_active;
    }
}
