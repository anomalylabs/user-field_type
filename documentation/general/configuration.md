# Configuration

**Example Definition:**

```
protected $fields = [
    'example' => [
        'type'   => 'anomaly.field_type.user',
        'config' => [
            'role'       => 'user',
            'permission' => 'anomaly.module.pages::pages.*',
            'handler'    => 'Anomaly\UserFieldType\UserFieldTypeOptions@handle'
        ]
    ]
];
```

### `role`

The role restriction for users to display. Any valid role slug or ID can be used. By default no role restriction is applied.

### `permission`

The permission restriction for users to display. Any valid permission string can be used. By default no permission restriction is applied.

### `handler`

The options handler callable string. Any valid callable class string can be used. The default value is `'Anomaly\UserFieldType\UserFieldTypeOptions@handle'`.

The handler is responsible for setting the available options on the field type instance.

**NOTE:** This option can not be through the GUI configuration. 
