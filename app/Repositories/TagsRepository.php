<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagsRepository
{
    protected $tag;

    public function __construct()
    {
        $this->tag = new Tag();
    }

    public function getTags()
    {
        return $this->tag->with('mapping', 'mapping.asset')->orderBy('id', 'DESC')->get();
    }

    public function getTagById($id)
    {
        return $this->tag->findOrFail($id);
    }

    public function store($data)
    {
        $data['slug'] = $this->generateRandomUniqueIdentifier('slug');
        return $this->tag->create($data);
    }

    public function update($data, $id)
    {
        return $this->tag->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->tag->findOrFail($id)->delete();
    }

    public function generateRandomUniqueIdentifier($field_name = 'slug')
    {
        regenerate:
        $random_string = $field_name === 'slug'
            ? strtoupper(substr(md5(uniqid(rand(), true)), 0, 5))
            : strtoupper(Str::orderedUuid());

        if ($this->tag->where($field_name, $random_string)->count()) {
            goto regenerate;
        }

        return $random_string;
    }
}
