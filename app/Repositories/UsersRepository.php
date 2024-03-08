<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function getUsers()
    {
        return $this->user->with('group')->whereNotIn('id', [auth()->user()->id])->where('is_root_user', 0)->get();
    }

    public function getUserById($slug)
    {
        $user = $this->user->with('group')->where('slug', $slug)->first();
        if (!isset($user)) {
            throw new \Exception('No query results for model [App\Models\User] ' . $slug, 201);
        }

        return $user;
    }

    public function getUser($id)
    {
        $user = $this->user->with('group')->where('id', $id)->first();
        if (!isset($user)) {
            throw new \Exception('No query results for model [App\Models\User] ' . $id, 201);
        }

        return $user;
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->user->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->user->create($data);
    }

    public function update($data, $id)
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($slug)
    {
        $user = $this->user->where('slug', $slug)->first();
        if (!isset($user)) {
            throw new \Exception('No query results for model [App\Models\User] ' . $slug, 201);
        }

        return $user->delete();
    }

    public function updatePassword($data)
    {
        return $this->user
            ->where('id', $data['id'])
            ->update([
                'password' => $data['password']
            ]);
    }
}
