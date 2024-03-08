<?php

namespace App\Repositories;

use App\Models\FieldGroup;

class FieldGroupsRepository
{
    protected $field_group;

    public function __construct()
    {
        $this->field_group = new FieldGroup();
    }

    public function getFieldGroups()
    {
        return $this->field_group->get();
    }

    public function getFieldGroupById($slug)
    {
        $field_group = $this->field_group->where('slug', $slug)->first();
        if (!isset($field_group)) {
            throw new \Exception('No query results for model [App\Models\Field Group] ' . $slug, 201);
        }

        return $field_group;
    }

    public function store($data)
    {
        $data['slug'] = generate_slug('field_groups');
        return $this->field_group->create($data);
    }

    public function update($data, $id)
    {
        return $this->field_group->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->field_group->findOrFail($id)->delete();
    }
}
