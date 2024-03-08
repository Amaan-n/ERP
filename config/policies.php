<?php

return [
    'masters' => [
        'note'         => ['notes.index', 'notes.create', 'notes.edit', 'notes.delete'],
        'manufacturer' => ['manufacturers.index', 'manufacturers.create', 'manufacturers.show', 'manufacturers.edit', 'manufacturers.delete'],
        'supplier'     => ['suppliers.index', 'suppliers.create', 'suppliers.show', 'suppliers.edit', 'suppliers.delete'],
        'department'   => ['departments.index', 'departments.create', 'departments.show', 'departments.edit', 'departments.delete'],
        'field'        => ['fields.index', 'fields.create', 'fields.show', 'fields.edit', 'fields.delete'],
        'field_group'  => ['field_groups.index', 'field_groups.create', 'field_groups.show', 'field_groups.edit', 'field_groups.delete'],
        'category'     => ['categories.index', 'categories.create', 'categories.show', 'categories.edit', 'categories.delete'],
        'asset_model'  => ['asset_models.index', 'asset_models.create', 'asset_models.show', 'asset_models.edit', 'asset_models.delete'],
        'asset'        => ['assets.index', 'assets.create', 'assets.show', 'assets.edit', 'assets.delete', 'assets.allocation'],
        'tag'          => ['tags.index', 'tags.create', 'tags.show', 'tags.mapping'],
    ],

    'administrative_links' => [
        'group'         => ['groups.index', 'groups.create', 'groups.show', 'groups.edit', 'groups.delete'],
        'user'          => ['users.index', 'users.create', 'users.show', 'users.edit', 'users.delete'],
        'miscellaneous' => ['configurations'],
    ],
];
