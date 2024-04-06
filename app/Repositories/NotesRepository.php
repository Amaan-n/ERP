<?php

namespace App\Repositories;

use App\Models\Note;

class NotesRepository
{
    protected $note;

    public function __construct()
    {
        $this->note = new Note();
    }

    public function store($data)
    {
        regenerate:
        $random_string = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        if ($this->note->where('slug', $random_string)->count()) {
            goto regenerate;
        }

        $data['slug'] = $random_string;
        return $this->note->create($data);
    }

    public function update($data, $id)
    {
        return $this->note->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        return $this->note->where('slug', $slug)->firstOrFail()->delete();
    }
}
