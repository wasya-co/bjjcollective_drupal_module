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
    $n_videos = 4;
    $config = \Drupal::config('ish_drupal_module.settings');
    $api_key = $config->get('google_api_youtube_key');

    $node_manager  = \Drupal::entityTypeManager()->getStorage('node');
    $youtube_channel = Node::load($request->attributes->get('node'));
    $channel_id = $youtube_channel->get('field_channel_id')->value;

    // user
    $query = \Drupal::entityQuery('user')
      ->condition('field_channel_id', $channel_id)
      ->range(0, 1);
    $uids = $query->execute();
    if (!empty($uids)) {
      $uid = reset($uids);
    } else {
      $uid = 138; // content-donor
    }
    $user = User::load($uid);


    $tags_contrib_ids = $youtube_channel->get('field_tags_contrib')->getValue();
    $tags_contrib_ids = array_column($tags_contrib_ids, 'target_id');
    $tags_issue_ids = $youtube_channel->get('field_tags_issue')->getValue();
    $tags_issue_ids = array_column($tags_issue_ids, 'target_id');

    $url = 'https://www.googleapis.com/youtube/v3/search?key='.$api_key.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults='.$n_videos.'&videoDuration=long&type=video';
    // logg($url, '$url');
    $json = file_get_contents($url);
    $decoded_json = json_decode($json, false);
    logg($decoded_json, '$decoded_json');
    foreach($decoded_json->items as $item) {

      $youtube_id = $item->id->videoId;
      $youtube_title = YoutubeVideo::title($youtube_id);
      $outs = [];
      $existing_page_youtube = $node_manager->loadByProperties([
        'type' => 'page_youtube',
        'field_youtube_id' => $youtube_id,
        'field_channel_id' => $channel_id,
      ]);
      if (!$existing_page_youtube) {
        $outs[ $item->id->videoId ] = $youtube_title;
        $body = <<<AOL
          <iframe width="560" height="315" src="https://www.youtube.com/embed/$youtube_id" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
            encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen></iframe>
        AOL;
        $new_item = $node_manager->create([
          'uid' => $user->id(),
          'body' => [
            'value' => $body,
            'format' => 'full_html',
          ],
          'field_channel_id' => $channel_id,
          'field_youtube_id' => $youtube_id,
          'field_tags_contrib' => $tags_contrib_ids,
          'field_tags_issue' => $tags_issue_ids,
          'status' => 1, // is published
          'title' => $youtube_title,
          'type' => 'page_youtube',
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

