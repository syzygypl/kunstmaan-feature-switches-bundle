Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require syzygypl/kunstmaan-feature-switches-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new  SZG\KunstmaanFeatureSwitchesBundle\KunstmaanFeatureSwitchesBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Generate database schema
-------------------------
`bin/console doctrine:migration:diff`
`bin/console doctrine:migration:migrate`

Step 4: Import routes
-------------------------
```yml 
// app/config/routing.yml
KunstmaanFeatureSwitchesBundle:
    resource: "@KunstmaanFeatureSwitchesBundle/Resources/config/routing.yml"
    prefix:   /{_locale}/
    requirements:
        _locale: "%requiredlocales%"
```

Usage
=====

### CREATE A NEW SWITCH

Just enter the /{locale}/admin/settings and select "Feature switches" from the sidebar menu. Then use a big blue button in the right top cornenr. Name and code have to be unique.

### TWIG

```jinja
{% if is_granted('my_special_feature', 'features') %} ENABLED {% endif %}
```

### PHP

In a controller:
```php
/// ...
$this->denyAccessUnlessGranted('my_special_feature', 'features');
// ...
```

Best practices
=====

Create a constants collection for all switches
-----

Create a new file: `app/Features.php`

```php

// app/Features.php

<?php

class Features
{
    const MY_SPECIAL = 'feature_my_special';
}
```

Require just created file in autoloader: 

```php
// app/autoload.php
// ...
require __DIR__.'/Features.php';
// ...
```

Now you can use constants in twig:
```jinja
{% if is_granted(constant(Features::MY_SPECIAL), 'features') %} ENABLED {% endif %}
```

