<?

use Drupal\Tests\BrowserTestBase;

class CurrentUserBlockFuncTest extends BrowserTestBase {

  protected static $modules = ['node'];

  public function test_CurrentUserBlock() {
    $user = $this->drupalCreateUser([
      'access content',
    ]);

    $this->drupalLogin($user);

    $this->assertEquals($user->id(), $this->loggedInUser->id());
  }

}
