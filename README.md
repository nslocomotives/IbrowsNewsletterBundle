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
# composer.json

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

``` yaml
# app/config/config.yml

imports:
    # ...
    - { resource: ibrows_newsletter.yml }
```

``` yaml
# app/config/ibrows_newsletter.yml

ibrows_newsletter:
  mandants:
    # generate a secure token for each mandant!
    default:  ThisTokenIsNotSoSecretChangeItDefault
    mandantA:  ThisTokenIsNotSoSecretChangeItMandantA
    mandantB:  ThisTokenIsNotSoSecretChangeItMandantB
  classes:
    model:
      mandant:      Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Mandant
      newsletter:   Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Newsletter
      subscriber:   Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Subscriber
      design:       Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Design
      user:         Ibrows\NewsletterSandboxBundle\Entity\Newsletter\User
      block:        Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Block
      group:        Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Group
      readlog:      Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Log\ReadLog
      sentlog:      Ibrows\NewsletterSandboxBundle\Entity\Newsletter\Log\SentLog
      sendsettings: Ibrows\NewsletterSandboxBundle\Entity\Newsletter\SendSettings
      mailjob:      Ibrows\NewsletterSandboxBundle\Entity\Newsletter\MailJob
  filesystem:
      block:
        directory:  %kernel.root_dir%/../web/uploads/block
        public:     /uploads/block
```

### Generate needed entities

