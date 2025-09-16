<?php

namespace Drupal\ish_drupal_module\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

use Drupal\ish_drupal_module\Helpers\Youtube;


/**
 * Youtube controller.
 *
 * the channels I want to check: tucker carlson, dr john campbell
 *
**/
class YoutubeController extends ControllerBase {

  /**
   * Look at the last 5 videos. Each video, if I can find it by youtube_id, then skip it.
   *
  **/
  public function check_channels(Request $request) {

    $channel_ids = [
      'tucker_carlson' => 'UCGttrUON87gWfU6dMWm1fcA',
      'dr_campbell'    => 'UCF9IOB2TExg3QIBupFtBDxg',
      'ivor_cummins'   => 'UCPn4FsiQP15nudug9FDhluA',
    ];
    foreach($channel_ids as $key => $channel_id) {
      $outs  = Youtube::check_channel( $channel_id );
    }

    return [
      '#theme' => 'youtube_check_channels',
      '#videos' => $outs,
    ];
  }

}

