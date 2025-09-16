
  ./vendor/drush/drush/drush cc router

== Test ==

From: https://www.drupal.org/docs/develop/automated-testing/phpunit-in-drupal/running-phpunit-tests

DO NOT RUN THIS IN PRODUCTION!

  composer require --dev phpunit/phpunit
  composer require --dev phpunit/phpunit:^9.5 --with-all-dependencies
  composer require --dev drupal/core-dev
  composer require --dev behat/mink:1.8.0 --with-all-dependencies
  composer require --dev symfony/phpunit-bridge
  composer require --dev phpspec/prophecy-phpunit

  composer require --dev mikey179/vfsstream

  composer require drupal/core-dev --dev
  composer require drupal/core-dev --dev --update-with-all-dependencies

  phpunit --testsuite unit --filter CurrentUserBlock

  export PATH="$PATH:/var/www/html/vendor/bin"


