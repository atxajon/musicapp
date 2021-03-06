<?php

/**
 * @file
 * Contains \Drupal\form_test\SystemConfigFormTestForm.
 */

namespace Drupal\form_test;

use Drupal\system\SystemConfigFormBase;

/**
 * Tests the SystemConfigFormBase class.
 */
class SystemConfigFormTestForm extends SystemConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'form_test_system_config_test_form';
  }

}
