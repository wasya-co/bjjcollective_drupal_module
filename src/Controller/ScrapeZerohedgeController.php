<?php

namespace Drupal\ish_drupal_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\Request;


class ScrapeZerohedgeController extends ControllerBase {

  public function one(Request $request) {
    $build = [
      '#theme' => 'scrape_zerohedge_one',
    ];
    return $build;
  }

}
