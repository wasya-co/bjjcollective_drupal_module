<?

namespace Drupal\ish_drupal_module\Controller;

use Drupal\node\NodeInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Users controller.
**/
class UsersController extends ControllerBase {

  /**
   * index()
  **/
  // public function index() {
  //   return [
  //     '#markup' => "<h1>Locations Index !!!</h1>",
  //   ];
  // }

  public function dance_instructor_dashboard( Request $request ) {
    $build = [
      '#theme' => 'ish_users_dance_instructor_dashboard',
    ];
    return $build;
  }

  /**
   * dashboard()
  **/
  public function dashboard( Request $request ) {
    $form = \Drupal::formBuilder()->getForm('Drupal\ish_drupal_module\Form\ForYoutube');

    $build = [
      '#theme'            => 'ish_users_dashboard',
      '#for_youtube_form' => $form,
    ];
    return $build;
  }


  /**
   * edit() - myself only
  **/
  public function my_edit( Request $request ) {

    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

    return [
      '#theme'   => 'ish_users_edit',
      '#user'    => $user,
      '#request' => $request,
    ];
  }

}
