<?php

namespace Drupal\ish_drupal_module\Helpers;

class Youtube {

  public static function youtube_title(string $id) {
    $config = \Drupal::config('ish_drupal_module.settings');
    $api_key = $config->get('google_api_youtube_key');

    $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.$id.'&key='.$api_key;
    $json = file_get_contents($url);
    $decoded_json = json_decode($json, false);
    // logg($decoded_json, '$decoded_json');
    $title = $decoded_json->items[0]->snippet->title;
    // logg($title, 'ze title');
    return $title;
  }

  /**
   * https://stackoverflow.com/questions/18953499/youtube-api-to-fetch-all-videos-on-a-channel
   * https://www.googleapis.com/youtube/v3/search?key={your_key_here}&channelId={channel_id_here}&part=snippet,id&order=date&maxResults=5
   * $channel_id = '@Campbellteaching';
   * tucker carlson: UCGttrUON87gWfU6dMWm1fcA
  **/
  public static function check_channel(string $channel_id) {
    $user = \Drupal\user\Entity\User::load( 138 ); // content-donor
    $config = \Drupal::config('ish_drupal_module.settings');
    $api_key = $config->get('google_api_youtube_key');

    $n_videos = 3;
    $url = 'https://www.googleapis.com/youtube/v3/search?key='.$api_key.'&channelId='.$channel_id.'&part=snippet,id&order=date&maxResults='.$n_videos.'&videoDuration=long&type=video';
    // logg($url, '$url');
    $json = file_get_contents($url);
    $decoded_json = json_decode($json, false);
    // logg($decoded_json, '$decoded_json');

    foreach($decoded_json->items as $item) {
      // $item = $decoded_json->items[0];
      // logg($item, '$item');

      $youtube_id = $item->id->videoId;
      $youtube_title = Youtube::youtube_title($youtube_id);
      $content_type = 'page_youtube';

      $outs = [];

      $issue_uuid = '35'; // '4ac9695b-0854-4972-8528-1f52e21d2235'; // taxonomy_term/35 :: 2024q1-issue
      $node_manager  = \Drupal::entityTypeManager()->getStorage('node');
      $existing = $node_manager->loadByProperties([
        'type' => $content_type,
        'field_youtube_id' => $youtube_id,
      ]);
      if (!$existing) {
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
          'field_issue' => [ 'target_id' => $issue_uuid ],
          'status' => 1,
          'title' => $youtube_title,
          'type' => $content_type,
        ]);
        $new_item->save();
        \Drupal::messenger()->addMessage('Item From Youtube has been saved.');
      }

      // $title = $decoded_json->items[0]->snippet->title;
      // logg($title, 'ze title');
    }

    // logg($outs, '$outs');
    return $outs;
  }

}
