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

    public function getTagById($slug)
    {
        $tag = $this->tag->where('slug', $slug)->first();
        if (!isset($tag)) {
            throw new \Exception('No query results for model [App\Models\Tag] ' . $slug, 201);
        }

        return $tag;
    }

    public function store($data)
    {
        $data['slug'] = $this->generateRandomUniqueIdentifier('slug');
        return $this->tag->create($data);
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
