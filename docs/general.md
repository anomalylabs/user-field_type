# URL Field Type

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Output](#output)


<a name="introduction"></a>
## Introduction

`anomaly.field_type.user`

The user field type provides an HTML select input with options from the Users module.


<a name="configuration"></a>
## Configuration

**Example Definition:**

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

### `role`

The role restriction for users to display. Any valid role slug or ID can be used. By default no role restriction is applied.

### `permission`

The permission restriction for users to display. Any valid permission string can be used. By default no permission restriction is applied.

### `handler`

The options handler callable string. Any valid callable class string can be used. The default value is `'Anomaly\UserFieldType\UserFieldTypeOptions@handle'`.

The handler is responsible for setting the available options on the field type instance.

**NOTE:** This option can not be through the GUI configuration. 


<a name="output"></a>
## Output

This field type returns the user instance as a value. You may access the object as normal.

**Examples:**

    // Twig usage
    {{ entry.example.display_name }} or {{ entry.example.email }}
    
    // API usage
    $entry->example->getDisplayName(); or $entry->example->getEmail();
