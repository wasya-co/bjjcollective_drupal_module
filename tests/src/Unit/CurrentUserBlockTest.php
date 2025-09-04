<?php

namespace Drupal\Tests\ish_drupal_module\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\UnitTestCase;
use \Drupal\ish_drupal_module\Plugin\Block\CurrentUserBlock;

/**
 * @coversDefaultClass \Drupal\ish_drupal_module\Plugin\Block\CurrentUserBlock
 *
 * @group ish_drupal_module
**/
class CurrentUserBlockTest extends UnitTestCase {
  protected function setUp(): void {
    parent::setUp();
    $container = new ContainerBuilder();
    $user = $this->createMock(AccountInterface::class);
    $user->method('id')->willReturn(123);
    $user->method('getEmail')->willReturn('test_email'); // expected
    $container->set('current_user', $user);
    \Drupal::setContainer($container);
  }

  public function test_build() {
    $actual = \Drupal\ish_drupal_module\Plugin\Block\CurrentUserBlock->build();
    // $actual = CurrentUserBlock->build();

    $this->assertSame('test_email', $actual['#email']);
  }

}


