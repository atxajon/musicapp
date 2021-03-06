<?php

/**
 * @file
 * Contains \Drupal\block_test\Plugin\Block\TestXSSTitleBlock.
 */

namespace Drupal\block_test\Plugin\Block;

use Drupal\block\Annotation\Block;

/**
 * Provides a block to test XSS in title.
 *
 * @Block(
 *   id = "test_xss_title",
 *   admin_label = "<script>alert('XSS subject');</script>"
 * )
 */
class TestXSSTitleBlock extends TestCacheBlock {

  /**
   * Overrides \Drupal\block\BlockBase::settings().
   *
   * Sets a different caching strategy for testing purposes.
   */
  public function settings() {
    return array(
      'cache' => DRUPAL_NO_CACHE,
    );
  }

}
