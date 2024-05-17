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

Create `templates/bundles/OHMediaLogoBundle/logos.html.twig`, which is expected
for rendering the WYSIWYG Twig function `{{ logos(id) }}`.

## Splide Integration

Run `npm install @splidejs/splide` and add these lines to `assets/frontend/frontend.js`:

```js
import { Splide } from '@splidejs/splide';
import '@splidejs/splide/dist/css/splide.min.css';
window.Splide = Splide;
```

Utilize the basic markup in `templates/bundles/OHMediaLogoBundle/logos.html.twig`:

```twig
<section class="splide">
  <div class="splide__track">
    <ul class="splide__list">
      {% for logo in logos %}
      <li class="splide__slide">
        {{ image_tag(logo.image) }}
      </li>
      {% endfor %}
    </ul>
  </div>
</section>
```
