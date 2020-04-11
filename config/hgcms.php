<?php

return [
    'url' => [
        'prefix_admin' => 'admin88',
        'prefix_blog'=> 'blog'
    ],
    'format' => [
        'long_time' => 'd/m/Y H:i:s',
        'short_time' => 'd/m/Y'
    ],
    'template' => [
        'status' => [
            'all' =>'All',
            'active' => 'Active',
            'inactive' => 'Inactive',
            'default'=> 'All'
        ],
        'action' => [
            //'edit' => ['icon' => 'fa fa-pencil-alt','route' => 'form','class'=>'primary','name'=>'Edit'],
            'delete' => ['icon' => 'fa fa-trash-alt','route' => 'delete','class'=>'danger','name'=>'Delete']
        ],
        'search' => [
            'all' => 'All',
            'id' => 'ID',
            'title' => 'Title'
        ],
        'bulk' => [
            'post' => [
                'all' => ['name' => 'Bulk Action','route'=>'','key'=>''],
                'active' => ['name'=>'Change Active', 'route'=>'statuses','key'=>'status'],
                'inactive' => ['name'=>'Change Inactive', 'route'=>'statuses','key'=>'status'],
                'delete' => ['name' => 'Delete','route'=>'deletes','key'=>'']
            ],
            'category' => [
                'all' => ['name' => 'Bulk Action','route'=>'','key'=>''],
                'active' => ['name'=>'Change Active', 'route'=>'statuses','key'=>'status'],
                'inactive' => ['name'=>'Change Inactive', 'route'=>'statuses','key'=>'status'],
                'yes' =>['name' => 'Show Home', 'route'=>'ishomese','key'=>'ishome'],
                'no' => ['name' => 'Hide Home','route'=>'ishomese','key' => 'ishome'],
                'display' => ['name' => 'Change Display', 'route' => 'display','key' =>''],
                'ordering' => ['name' => 'Change Order', 'route' => 'ordering','key' =>''],
                'delete' => ['name' => 'Delete','route'=>'deletes','key'=>'']
            ],
            'tag' => [
                'all' => ['name' => 'Bulk Action','route'=>'','key'=>''],
                'active' => ['name'=>'Change Active', 'route'=>'statuses','key'=>'status'],
                'inactive' => ['name'=>'Change Inactive', 'route'=>'statuses','key'=>'status'],
                'yes' =>['name' => 'Show Home', 'route'=>'ishomese','key'=>'ishome'],
                'no' => ['name' => 'Hide Home','route'=>'ishomese','key' => 'ishome'],
                'display' => ['name' => 'Change Display', 'route' => 'display','key' =>''],
                'ordering' => ['name' => 'Change Order', 'route' => 'ordering','key' =>''],
                'delete' => ['name' => 'Delete','route'=>'deletes','key'=>'']
            ],
            'user' => [
                'all' => ['name' => 'Bulk Action','route'=>'','key'=>''],
                'active' => ['name'=>'Change Active', 'route'=>'statuses','key'=>'status'],
                'inactive' => ['name'=>'Change Inactive', 'route'=>'statuses','key'=>'status'],
                'delete' => ['name' => 'Delete','route'=>'deletes','key'=>'']
            ]
        ],
        'display' => [
            'list' => 'List',
            'grid' => 'Grid'
        ],
        'ishome' =>[
            'yes' => 'Show Home',
            'no' => 'Hide Home'
        ]
    ]
];