<?php

namespace Drupal\user\Tests\Views;

use Drupal\views\Tests\ViewTestBase;
use Drupal\views\Tests\ViewTestData;

/**
 * Checks if user fields access permissions can be modified by other modules.
 *
 * @group user
 */
class UserFieldsAccessChangeTest extends UserTestBase {

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['test_user_fields_access'];

  /**
   * Tests if another module can change field access.
   */
  public function testUserFieldAccess() {
    $path = 'test_user_fields_access';
    $this->drupalGet($path);

    // User has access to name and created date by default.
    $this->assertText(t('Name'));
    $this->assertText(t('Created'));

    // User does not by default have access to init, mail and status.
    $this->assertNoText(t('Init'));
    $this->assertNoText(t('Email'));
    $this->assertNoText(t('Status'));

    // Install user_access_test module to grant extra access.
    \Drupal::service('module_installer')->install(['user_access_test']);
    $this->drupalGet($path);

    // Access for init, mail and status is added in hook_entity_field_access().
    $this->assertText(t('Init'));
    $this->assertText(t('Email'));
    $this->assertText(t('Status'));
  }
}
