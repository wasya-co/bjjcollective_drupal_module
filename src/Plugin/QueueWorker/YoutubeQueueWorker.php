<?php

namespace Drupal\ish_drupal_modle\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Processes items in YoutubeQueue. processes within 120 seconds.
 *
 * @QueueWorker(
 *   id = "youtube_queue",
 *   title = @Translation("Youtube Queue Worker"),
 *   cron = {"time" = 120}
 * )
 */
class YoutubeQueueWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    // Do the actual work here.
    // $data is whatever you queued.
  }

}
