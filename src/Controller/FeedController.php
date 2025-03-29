<?

namespace Drupal\ish_drupal_module\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Drupal\node\NodeInterface;
use \Drupal\taxonomy\Entity\Term;
use \Symfony\Component\HttpFoundation\Request;

function logg($object, $label=null) {
  print($label . ":");
  echo "<br />";
  dump($object);
}

/**
 * FeedController
**/
class FeedController extends ControllerBase {

  /*
   * /my/feed
   *
  **/
  public function myFeed() {
    $cuId = \Drupal::currentUser()->id();

    // $user = \Drupal::currentUser();
    // $user = User::load(\Drupal::currentUser()->id());

    // test-1
    $bid = 35;
    $block = \Drupal\block_content\Entity\BlockContent::load($bid);
    $render = \Drupal::entityTypeManager()->getViewBuilder('block_content')->view($block);

    // @TODO: get locations that I subscribed to

    $nodes = \Drupal::entityTypeManager()->getStorage('node');
    $nodes_query  = \Drupal::entityQuery('node');

    $my_locations = $nodes_query->condition('type', 'location');
    $my_locations->condition('field_users', $cuId);

    // logg($my_locations, 'my_locations');

    return [
      '#theme' => 'my_feed',
      '#test_var_1' => $render,
      // 'content' => [
      // ],
      // 'system_main' => $render,
      // 'sidebar_first' => $render,
      // '#markup' => "<h1>myFeed()</h1>",
    ];
  }

}
