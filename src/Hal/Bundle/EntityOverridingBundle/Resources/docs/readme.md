# Override entity properties in Doctrine

By default, it is not possible to override any Entity's property with Doctrine

Details:

we cannot use oneToMany relations when we use [mapped Superclasses](http://docs.doctrine-project.org/en/latest/reference/inheritance-mapping.html),
even if this [feature is often discuted](https://github.com/symfony/symfony-docs/issues/978).

# Installation

Install the bundle

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Hal\Bundle\EntityOverridingBundle(),
        );
    }

# Usage

In yours bundle, simply create a `Resources/config/doctrine-override` folder, then create a file named with the overrided class name.
Remember to replace each separator with `.`.

For example:

    # file Acme/MyBundle/config/doctrine-override/Acme.AnotherBunde.Entity.User.orm.yml
    Acme\AnotherBundle\Entity\User:
      fields:
        name:
          type: string


# Limits

Today, this bundle only supports yam configuration. But it's easy to suport other formats. All contributions are welcome :)