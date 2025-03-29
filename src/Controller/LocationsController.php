<?

namespace Drupal\ish_drupal_module\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

// function logg($object, $label=null) {
//   print($label . ":");
//   echo "<br />";
//   dump($object);
// }


/**
 * Locations controller.
**/
class LocationsController extends ControllerBase {

  /**
   * follow()
   *
  **/
  public function follow($id, Request $request) {
    $cuId = \Drupal::currentUser()->id();

    $location = \Drupal::entityTypeManager()->getStorage('node')->load($id);
    $location->field_users[] = [ 'target_id' => $cuId ];
    $location->save();

    return [
      '#markup' => "<h1>Locations#follow()</h1>",
    ];
  }

  /**
   * index()
  **/
  public function index() {
    $cuId = \Drupal::currentUser()->id();

    $my_locations = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'location',
      'field_users' => $cuId,
    ]);
    logg($my_locations, 'my_locations');

    return [
      '#theme' => 'ish_locations_index',
    ];
  }

  /**
   * show()
  **/
  public function show( $slug, Request $request ) {

    $location = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
      'type' => 'location',
      'field_slug' => $slug,
    ]);
    $location = $location[ array_keys($location)[0] ];

    // var_dump($location->title->value);

    return [
      '#theme'    => 'ish_locations_show',
      '#location' => $location,
      '#request'  => $request,
    ];
  }

}
