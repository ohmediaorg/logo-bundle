# Installation

Update `composer.json` by adding this to the `repositories` array:

```json
{
    "type": "vcs",
    "url": "https://github.com/ohmediaorg/logo-bundle"
}
```

Then run `composer require ohmediaorg/logo-bundle:dev-main`.

Enable the bundle in `config/bundles.php`:

```php
OHMedia\LogoBundle\OHMediaLogoBundle::class => ['all' => true],
```

Import the routes in `config/routes.yaml`:

```yaml
oh_media_logo:
    resource: '@OHMediaLogoBundle/config/routes.yaml'
```

Run `php bin/console make:migration` then run the subsequent migration.

# Frontend

Create `templates/bundles/OHMediaLogoBundle/grid.html.twig` and
`templates/bundles/OHMediaLogoBundle/slider.html.twig`. Which are expected for
rendering `{{ logo_group_grid(id) }}` and `{{ logo_group_slider(id) }}`.

## Splide Integration

TODO!
