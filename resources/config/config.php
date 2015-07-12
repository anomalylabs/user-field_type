<?php

return [
    'role'       => [
        'type'   => 'anomaly.field_type.relationship',
        'config' => [
            'related' => 'Anomaly\UsersModule\Role\RoleModel'
        ]
    ],
    'permission' => [
        'type' => 'anomaly.field_type.text'
    ]
];
