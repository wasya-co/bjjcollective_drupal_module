
  ./vendor/drush/drush/drush cc router

== Test ==

  export PATH="$PATH:/var/www/html/vendor/bin"

  composer require --dev phpunit/phpunit
  composer require --dev phpunit/phpunit:^9.5 --with-all-dependencies
  composer require --dev drupal/core-dev
  composer require --dev behat/mink:1.8.0 --with-all-dependencies
  composer require --dev symfony/phpunit-bridge
  composer require --dev phpspec/prophecy-phpunit
  composer require --dev behat/mink-browserkit-driver
  composer require --dev drupal/core-dev
  composer require --dev drupal/core-dev --update-with-all-dependencies

  phpunit --testsuite unit --filter CurrentUserBlock
  ../vendor/bin/phpunit  -c ../phpunit.xml modules/ish_drupal_module/tests/src/Functional/CurrentUserBlockTest.php
