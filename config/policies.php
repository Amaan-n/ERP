<?php

return [
    'masters' => [
        'note'             => ['notes.index', 'notes.create', 'notes.edit', 'notes.delete'],
        'employee'         => ['employees.index', 'employees.create', 'employees.show', 'employees.edit', 'employees.delete'],
        'manufacturer'     => ['manufacturers.index', 'manufacturers.create', 'manufacturers.show', 'manufacturers.edit', 'manufacturers.delete'],
        'supplier'         => ['suppliers.index', 'suppliers.create', 'suppliers.show', 'suppliers.edit', 'suppliers.delete'],
        'department'       => ['departments.index', 'departments.create', 'departments.show', 'departments.edit', 'departments.delete'],
        'field'            => ['fields.index', 'fields.create', 'fields.show', 'fields.edit', 'fields.delete'],
        'field_group'      => ['field_groups.index', 'field_groups.create', 'field_groups.show', 'field_groups.edit', 'field_groups.delete'],
        'asset_category'   => ['asset_categories.index', 'asset_categories.create', 'asset_categories.show', 'asset_categories.edit', 'asset_categories.delete'],
        'asset_model'      => ['asset_models.index', 'asset_models.create', 'asset_models.show', 'asset_models.edit', 'asset_models.delete'],
        'asset'            => ['assets.index', 'assets.create', 'assets.show', 'assets.edit', 'assets.delete', 'assets.allocation'],
        'tag'              => ['tags.index', 'tags.create', 'tags.show', 'tags.mapping'],
        'customer'         => ['customers.index', 'customers.create', 'customers.show', 'customers.edit', 'customers.delete'],
        'location'         => ['locations.index', 'locations.create', 'locations.show', 'locations.edit', 'locations.delete'],
        'measuring_unit'   => ['measuring_units.index', 'measuring_units.create', 'measuring_units.show', 'measuring_units.edit', 'measuring_units.delete'],
        'product_category' => ['product_categories.index', 'product_categories.create', 'product_categories.show', 'product_categories.edit', 'product_categories.delete'],
        'product'          => ['products.index', 'products.create', 'products.show', 'products.edit', 'products.delete'],
    ],

    'administrative_links' => [
        'group'         => ['groups.index', 'groups.create', 'groups.show', 'groups.edit', 'groups.delete'],
        'user'          => ['users.index', 'users.create', 'users.show', 'users.edit', 'users.delete'],
        'miscellaneous' => ['configurations'],
    ],
];
