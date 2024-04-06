<?php

namespace App\Repositories;

use App\Models\Field;

class FieldsRepository
{
    protected $field;

    public function __construct()
    {
        $this->field = new Field();
    }

    public function getFields()
    {
        return $this->field->get();
    }

    public function getFieldById($slug)
    {
        $field = $this->field->where('slug', $slug)->first();
        if (!isset($field)) {
            throw new \Exception('No query results for model [App\Models\Field] ' . $slug, 201);
        }

        return $field;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('fields');
        return $this->field->create($data);
    }

    public function update($data, $id)
    {
        return $this->field->findOrFail($id)->update($data);
    }

    public function delete($slug)
    {
        return $this->field->where('slug', $slug)->firstOrFail()->delete();
    }
}
