# Twig Extender

Drupal module for pluggable twig functions.

## Versions

Drupal 8.2 or lower: Use Twig Extender 8.1
Drupal 8.3 or higher: Use Twig Extender 8.2

## Twig Extensions

### Function: Create Block

Using for creating a block configuration on the fly

```
{{ block_create('plugin_id', [<plugin-config>]) }}
```

### Function: View Block

Using a exisiting block configuration

```
{{ block_view('config_entity_id') }}
```

### Function: Is user logged in

```
{% if user_is_logged_in() %}
  Hello user
{% else %}
  Please login
{% endif %}
```

### Function: Is front

```
{% if is_front() %}
On frontpage
{% endif %}
```

### Filter: To url

```
{{ node|to_url }}
{{ urlObject|to_url }}
```