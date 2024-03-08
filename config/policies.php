<?php

return [
    'masters' => [
        'note' => ['notes.index', 'notes.create', 'notes.edit', 'notes.delete'],
    ],

    'administrative_links' => [
        'group'         => ['groups.index', 'groups.create', 'groups.show', 'groups.edit', 'groups.delete'],
        'user'          => ['users.index', 'users.create', 'users.show', 'users.edit', 'users.delete'],
        'miscellaneous' => ['configurations', 'subscribers'],
    ],
];
