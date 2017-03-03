<?php

/**
 * @file
 * Contains \Drupal\pp\Tests\PpTest.
 */

namespace Drupal\pp\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests Pp installation profile expectations.
 *
 * @group pp
 */
class PpTest extends WebTestBase {

  protected $profile = 'pp';

  /**
   * Tests Pp installation profile.
   */
  public function testPp() {
    $this->drupalGet('');
    // Check the login block is present.
    $this->assertLink(t('Create new account'));
    $this->assertResponse(200);

    // Create a user to test tools and navigation blocks for logged in users
    // with appropriate permissions.
    $user = $this->drupalCreateUser(array('access administration pages', 'administer content types'));
    $this->drupalLogin($user);
    $this->drupalGet('');
    $this->assertText(t('Tools'));
    $this->assertText(t('Administration'));

    // Ensure that there are no pending updates after installation.
    $this->drupalLogin($this->rootUser);
    $this->drupalGet('update.php/selection');
    $this->assertText('No pending updates.');

    // Ensure that there are no pending entity updates after installation.
    $this->assertFalse($this->container->get('entity.definition_update_manager')->needsUpdates(), 'After installation, entity schema is up to date.');
  }

}