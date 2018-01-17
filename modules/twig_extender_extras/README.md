# Installing

Please add following line in settings.php for using moment object directly in Twig.

```
$settings['twig_sandbox_whitelisted_classes'] = [
  'Drupal\Core\Template\Attribute',
  'Moment\Moment'
];
```

# Using Moment Function

```
{{ moment(date).add('2', ') }}
```