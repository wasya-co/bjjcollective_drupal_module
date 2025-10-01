<?php

namespace Drupal\ish_drupal_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Drupal\ish_drupal_module\Helpers\Youtube;


/**
 *
**/
class YoutubeChannelsController extends ControllerBase {

  /*
  **/
  public function afterCreate(Request $request) {
  }

  /*
  **/
  public function check(Request $request) {
    $n_videos = 50;
    $url = 'https://www.googleapis.com/youtube/v3/search?key='.$api_key.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults='.$n_videos.'&videoDuration=long&type=video';
    // logg($url, '$url');

    $json = file_get_contents($url);
    $decoded_json = json_decode($json, false);
    // logg($decoded_json, '$decoded_json');

    foreach($decoded_json->items as $item) {
      $youtube_id = $item->id->videoId;
      $youtube_title = Youtube::youtube_title($youtube_id);
      $page_youtube = 'page_youtube';

      $outs = [];

      // $issue_uuid = '35'; // '4ac9695b-0854-4972-8528-1f52e21d2235'; // taxonomy_term/35 :: 2024q1-issue
      $node_manager  = \Drupal::entityTypeManager()->getStorage('node');
      $existing_page_youtube = $node_manager->loadByProperties([
        'type' => $page_youtube,
        'field_youtube_id' => $youtube_id,
      ]);
      if (!$existing_page_youtube) {
        $outs[ $item->id->videoId ] = $youtube_title;

        $body = <<<AOL
          <iframe width="560" height="315" src="https://www.youtube.com/embed/$youtube_id" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
            encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen></iframe>
        AOL;

        $new_item = $node_manager->create([
          'author' => $user,
          'body' => [
            'value' => $body,
            'format' => 'full_html',
          ],
          'field_youtube_id' => $youtube_id,
          // 'field_issue' => [ 'target_id' => $issue_uuid ],
          'field_tags_issue' => $tags_issue_ids,
          'status' => 1, // is published
          'title' => $youtube_title,
          'type' => $page_youtube,
        ]);
        $new_item->save();
        \Drupal::messenger()->addMessage('Item From Youtube has been saved.');
      }
    }

    return [
      '#theme' => 'youtube_channels_check',
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

