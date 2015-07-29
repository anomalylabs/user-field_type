# Output

This field type returns the user instance as a value. You may access the object as normal.

**Examples:**

```
// Twig usage
{{ entry.example.display_name }} or {{ entry.example.email }}

// API usage
$entry->example->getDisplayName(); or $entry->example->getEmail();
```
