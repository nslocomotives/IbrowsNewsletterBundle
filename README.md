IbrowsNewsletterBundle
======================

A nice Symfony2 Newsletter Bundle

Features:
- Different Templates
- Handling different chanels and groups
- E-Mail Body richt text editor
- Wizard for creating Newsletters
- Body-Block handling
- E-Mail messages queuing
- Statistics
- Different Users for each Newsletter

How to install
==============

### Add Bundle to your composer.json

```js
{
    "require": {
        "ibrows/newsletter-bundle": "*"
    }
}
```

### Install the bundle from console with composer.phar

``` bash
$ php composer.phar update ibrows/newsletter-bundle
```

### Enable the bundle in AppKernel.php

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ibrows\Bundle\NewsletterBundle\IbrowsNewsletterBundle(),
    );
}
```

### Configuration