<?php 

return [
    'permissions' => [
        'dashboards' => [
            'dashboard' => "View",
        ],
        'users' => [
            'users.index' => "View",
            'users.create' => "create",
            'users.edit' => "Edit",
            'users.destroy' => "Delete"
        ],
        'roles' => [
            'roles.index' => "View",
            'roles.create' => "create",
            'roles.edit' => "Edit",
            'roles.destroy' => "Delete"
        ],
    ]
];