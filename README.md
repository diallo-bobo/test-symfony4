## Gestion agence immobilière

[![pipeline status](https://gitlab.com/adashbob/agence/badges/master/pipeline.svg)](https://gitlab.com/adashbob/agence/-/commits/master)
[![coverage report](https://gitlab.com/adashbob/agence/badges/master/coverage.svg?job=phpunit)](https://gitlab.com/adashbob/agence/-/commits/master)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](https://github.com/thlorenz/doctoc)*

- [Gestion agence immobilière](#gestion-agence-immobili%C3%A8re)
- [Les package essentiels](#les-package-essentiels)
- [Les commandes essentielles](#les-commandes-essentielles)
- [Les commandes pour la persistance](#les-commandes-pour-la-persistance)
- [Les commandes pour la sécurité](#les-commandes-pour-la-s%C3%A9curit%C3%A9)
- [Les commandes pour déploiement](#les-commandes-pour-d%C3%A9ploiement)
- [Bundles Test](#bundles-test)
- [Bundles image](#bundles-image)
- [Code clean](#code-clean)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Les package essentiels
````bash
composer require symfony/maker-bundle --dev
composer require logger
composer require annotations
composer require twig
composer require form validator orm-pack security-csrf
composer require symfony/asset
composer require symfony/var-dumper
composer require symfony/security-bundle
composer require orm-fixtures --dev 
composer require symfony/profiler-pack --dev
composer require --dev symfony/phpunit-bridge
````

## Les commandes essentielles
````bash
# List environnement variables definined on .env file
php bin/console debug:container --env-vars

php bin/console debug:container --parameters
````

## Les commandes pour la persistance

````bash
# Create the database's schema
php bin/console doctrine:database:create

# Generate entity
php bin/console make:entity

# Update entity if new attributes added
php bin/console make:entity --regenerate

# Create the DDL for new tables
php bin/console make:migration

# Run the sql geerated by the make:migration command
php bin/console doctrine:migrations:migrate

# Execute a sql 
php bin/console doctrine:query:sql 'SELECT * FROM product'

# Create a new class to load Doctrine fixtures
php bin/console make:fixtures AppFixtures

# Execute fixtures
php bin/console doctrine:fixtures:load

````

## Les commandes pour la sécurité

````bash
php bin/console make:auth
````

## Les commandes pour déploiement

````bash

# using prod environnement
composer dump-env prod 
````

## Bundles Test

````bash
# Test case
composer require --dev symfony/browser-kit
composer require --dev symfony/css-selector

# Pour les jeux de données
composer require --dev doctrine/doctrine-fixtures-bundle
composer require --dev liip/test-fixtures-bundle:^1.4
composer require --dev theofidry/alice-data-fixtures

# Permet de generer différents type de text
# Utiliser l'un ou l'autre
composer require --dev fzaninotto/faker  
composer require --dev fakerphp/faker

````

## Bundles image
```bash
# Upload d'images
composer require vich/uploader-bundle

# Redimentionnement
composer require liip/imagine-bundle
```
## Code clean

````bash
composer require --dev squizlabs/php_codesniffer
composer require --dev phpstan/phpstan

````
#### NB:
Pour mettre à jour la table des matières, utiliser la commande ``npx doctoc ./README.md``
