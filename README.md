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
// composer.json

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
# app/config/ibrows_newsletter.yml

ibrows_newsletter:
  mandants:
    # generate a secure token for each mandant!
    mandantA:  ThisTokenIsNotSoSecretChangeItMandantA
    mandantB:  ThisTokenIsNotSoSecretChangeItMandantB
  classes:
    # needed entities - see next step for creating them
    model:
      # most likely fos user
      user:         Ibrows\YourBundle\Entity\User
      mandant:      Ibrows\YourBundle\Entity\Newsletter\Mandant
      newsletter:   Ibrows\YourBundle\Entity\Newsletter\Newsletter
      subscriber:   Ibrows\YourBundle\Entity\Newsletter\Subscriber
      design:       Ibrows\YourBundle\Entity\Newsletter\Design
      block:        Ibrows\YourBundle\Entity\Newsletter\Block
      group:        Ibrows\YourBundle\Entity\Newsletter\Group
      readlog:      Ibrows\YourBundle\Entity\Newsletter\Log\ReadLog
      sentlog:      Ibrows\YourBundle\Entity\Newsletter\Log\SentLog
      sendsettings: Ibrows\YourBundle\Entity\Newsletter\SendSettings
      mailjob:      Ibrows\YourBundle\Entity\Newsletter\MailJob

  filesystem:
      block:
        # where to store uploaded files (e.g. image uploads)
        directory:  %kernel.root_dir%/../web/uploads/block
        # absolute path to the uploaded files
        public:     /uploads/block
```

``` yaml
# app/config/routing.yml

# IbrowsNewsletter
ibrows_newsletter:
    resource: "@IbrowsNewsletterBundle/Controller/"
    type:     annotation
    prefix:   /newsletter
```

```yaml
# app/config/stfalcon_tinymce.yml

stfalcon_tinymce:
  include_jquery: false
  tinymce_jquery: true
  textarea_class: "tinymce"
  tinymce_buttons:
    unsubscribelink:
      title: "Unsubscribe link"
      image: "http://placehold.it/30x30"
    now:
      title: "Current date"
      image: "http://placehold.it/30x30"
    gendertitle:
      title: "Gender title"
      image: "http://placehold.it/30x30"
    statisticlogreadimage:
      title: "Statistics image"
      image: "http://placehold.it/30x30"
    readonlinelink:
      title: "Read online link"
      image: "http://placehold.it/30x30"
  theme:
    simple:
      mode: "textareas"
      theme: "advanced"
      plugins: "fullscreen,table"
      theme_advanced_buttons2: "unsubscribelink,now,gendertitle,statisticlogreadimage,readonlinelink"
      #theme_advanced_buttons2: "tablecontrols"
```

``` yaml
# app/config/config.yml

imports:
    # ...
    - { resource: stfalcon_tinymce.yml }
    - { resource: ibrows_newsletter.yml }

    # Doctrine Configuration
    doctrine:
        dbal:
            types:
                nostreamblob: Ibrows\Bundle\NewsletterBundle\DBAL\Types\NoStreamBlobType
```

< Do not forget to add the NoStreamBlobType

### Configure mandants

The allowed mandants are already defined under ibrows_newsletter.mandants in ibrows_newsletter.yml.
It is possible to run each mandant on an own database. For that we have to inform doctrine about the different connections:

``` yaml
# app/config/config.yml

# Doctrine Configuration
doctrine:
    dbal:
        types:
            nostreamblob: Ibrows\Bundle\NewsletterBundle\DBAL\Types\NoStreamBlobType
        default_connection:   default
        connections:
            default:
                driver:   %database_driver%
                host:     %database_host%
                port:     %database_port%
                dbname:   %database_name%
                user:     %database_user%
                password: %database_password%
                charset:  UTF8
            mandantA:
                driver:   %database_driver%
                host:     %database_host%
                port:     %database_port%
                dbname:   newslettersandbox_mandanta
                user:     %database_user%
                password: %database_password%
                charset:  UTF8
            mandantB:
                driver:   %database_driver%
                host:     %database_host%
                port:     %database_port%
                dbname:   newslettersandbox_mandantb
                user:     %database_user%
                password: %database_password%
                charset:  UTF8

    orm:
        auto_generate_proxy_classes: %kernel.debug%
        default_entity_manager: default
        entity_managers:
            default:
                connection: default
                mappings:
                    IbrowsNewsletterSandboxBundle: ~
                    IbrowsNewsletterBundle: ~
                    FOSUserBundle: ~
            mandantA:
                connection: mandantA
                mappings:
                    IbrowsNewsletterSandboxBundle: ~
                    IbrowsNewsletterBundle: ~
            mandantB:
                connection: mandantB
                mappings:
                    IbrowsNewsletterSandboxBundle: ~
                    IbrowsNewsletterBundle: ~
```

### Enable configured mandants

``` bash
# create the databases
$ php app/console doctrine:schema:create --em mandantA
$ php app/console doctrine:schema:create --em mandantB

# insert the mandants (already existings will be ignored)
$ php app/console ibrows:newsletter:mandants:enable
```

### Generate needed entities

### Set mandants to specific

``` sql
    UPDATE `fos_user` SET mandant = "default" WHERE username = "YourUsername"
```