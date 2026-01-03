<?php

namespace Drupal\ish_drupal_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Drupal\ish_drupal_module\Models\YoutubeVideo;

/*
 *
**/
class YoutubeChannelsController extends ControllerBase {


  /*
   * 2025-10-02 This is used!
  **/
  public function check(Request $request) {
    $youtube_queue = \Drupal::queue('youtube_queue');
    $nid = $request->attributes->get('node');
    $youtube_queue->createItem([
      'nid' => $nid,
    ]);

    return [
      '#theme' => 'youtube_channels_check',
      '#decoded_json' => $json,
      '#abba' => 'given abba',
    ];
  }

  /*
  **/
  public function index(Request $request) {
    return [
      '#theme' => 'youtube_channels_index',
      // '#videos' => $outs,
    ];
  }

}

