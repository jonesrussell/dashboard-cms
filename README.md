[![](https://www.drupal.org/files/styles/grid-3/public/project-images/Medium-Logo%20Color%20with%20padding.png)](http://www.drupal.org/project/varbase)

[![Build Status](https://travis-ci.org/Vardot/varbase.svg?branch=8.x-8.4)](https://travis-ci.com/github/Vardot/varbase/builds/156296724) Varbase 8.8.4

# Varbase Project

Project template for [Varbase distribution](http://www.drupal.org/project/varbase).

## Create a Varbase project with [Composer](https://getcomposer.org/download/):

To install the most recent stable release of Varbase 8.8.x run this command:

```
composer create-project Vardot/varbase-project:^8.8.4 PROJECT_DIR_NAME --no-dev --no-interaction
```

To install the dev version of Varbase 8.8.x run this command:

```
composer create-project vardot/varbase-project:8.8.x-dev PROJECT_DIR_NAME --stability dev --no-interaction
```

## [Create a new Vartheme sub theme for a project](https://github.com/Vardot/varbase/tree/8.x-8.x/scripts/README.md)

## [Automated Functional Testing](https://github.com/Vardot/varbase/blob/8.x-8.x/tests/README.md)

## [Varbase Gherkin features](https://github.com/Vardot/varbase/blob/8.x-8.x/tests/features/varbase/README.md)

## [Varbase 8.8.x Developer Guide](https://docs.varbase.vardot.com)

## [CHANGELOG for Varbase](https://github.com/Vardot/varbase/blob/8.x-8.x/CHANGELOG.md)

## [General instructions on how to update Varbase](https://github.com/Vardot/varbase/blob/8.x-8.x/UPDATE.md)

## Drupal Console site install

drupal site:install varbase \
 --langcode="en" \
 --db-type="mysql" \
 --site-name="Dashboard CMS" \
 --site-mail="admin@example.com" \
 --account-name="admin" \
 --account-mail="admin@example.com" \
 --account-pass="p455w0rd"
