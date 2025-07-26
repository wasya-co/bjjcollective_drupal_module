<?php

namespace Drupal\ish_drupal_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
* @Block(
*   id = "current_user_block",
*   admin_label = "current_user_block",
* )
*/
class CurrentUserBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);
    $email = $user->getEmail();

    return [
      // '#markup' => $email,
      '#theme' => 'current_user_block',
      '#email' => $email,
    ];
  }

}
