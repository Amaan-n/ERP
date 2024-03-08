<?php
return [
    [
        'grid'         => 4,
        'key'          => 'general',
        'display_text' => 'General',
        'is_visible'   => 1,
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'grid'         => 4,
                'key'          => 'name',
                'display_text' => 'Name',
                'is_visible'   => 1,
                'value'        => 'Subah Al Nasser',
                'input_type'   => 'text',
            ],
            [
                'grid'         => 4,
                'key'          => 'email',
                'display_text' => 'Email',
                'is_visible'   => 1,
                'value'        => 'hakim@almerak.com',
                'input_type'   => 'text',
            ],
            [
                'grid'         => 4,
                'key'          => 'phone',
                'display_text' => 'Phone',
                'is_visible'   => 1,
                'value'        => '67685242',
                'input_type'   => 'text',
            ],
            [
                'grid'         => 12,
                'key'          => 'address',
                'display_text' => 'Address',
                'is_visible'   => 1,
                'value'        => 'Ahmedabad, India - 380018.',
                'input_type'   => 'textarea',
            ],
            [
                'grid'         => 12,
                'key'          => 'working_days',
                'display_text' => 'Working Days',
                'is_visible'   => 1,
                'value'        => 'Monday, Tuesday, Wednesday, Thursday, Saturday, Sunday',
                'input_type'   => 'select',
                'options'      => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            ],
            [
                'grid'         => 4,
                'key'          => 'start_time',
                'display_text' => 'Start Time',
                'is_visible'   => 1,
                'value'        => '10:00 AM',
                'input_type'   => 'timepicker'
            ],
            [
                'grid'         => 4,
                'key'          => 'end_time',
                'display_text' => 'End Time',
                'is_visible'   => 1,
                'value'        => '07:00 PM',
                'input_type'   => 'timepicker'
            ],
        ]
    ],
    [
        'grid'         => 4,
        'key'          => 'assets',
        'display_text' => 'Assets',
        'is_visible'   => 1,
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'grid'         => 4,
                'key'          => 'logo',
                'display_text' => 'Logo',
                'is_visible'   => 1,
                'value'        => 'uploads/configurations/logo.png',
                'input_type'   => 'file',
            ],
            [
                'grid'         => 4,
                'key'          => 'banner_logo',
                'display_text' => 'Banner Logo',
                'is_visible'   => 1,
                'value'        => 'uploads/configurations/banner_logo.png',
                'input_type'   => 'file'
            ],
            [
                'grid'         => 4,
                'key'          => 'favicon',
                'display_text' => 'Favicon',
                'is_visible'   => 1,
                'value'        => 'uploads/configurations/favicon.ico',
                'input_type'   => 'file',
            ]
        ]
    ],
    [
        'grid'         => 4,
        'key'          => 'social_media',
        'display_text' => 'Social Media',
        'is_visible'   => 1,
        'value'        => '',
        'input_type'   => 'text',
        'children'     => [
            [
                'grid'         => 4,
                'key'          => 'LinkedIn_URL',
                'display_text' => 'LinkedIn',
                'is_visible'   => 1,
                'value'        => 'https://www.linkedin.com/',
                'input_type'   => 'text',
            ],
            [
                'grid'         => 4,
                'key'          => 'twitter_URL',
                'display_text' => 'Twitter',
                'is_visible'   => 1,
                'value'        => 'https://twitter.com/',
                'input_type'   => 'text',
            ],
            [
                'grid'         => 4,
                'key'          => 'instagram_URL',
                'display_text' => 'Instagram',
                'is_visible'   => 1,
                'value'        => 'https://www.instagram.com/',
                'input_type'   => 'text',
            ]
        ]
    ]
];
