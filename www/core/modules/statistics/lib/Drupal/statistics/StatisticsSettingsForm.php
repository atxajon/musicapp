<?php
/**
 * @file
 * Contains \Drupal\statistics\StatisticsSettingsForm.
 */

namespace Drupal\statistics;

use Drupal\Core\Config\Context\ContextInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\system\SystemConfigFormBase;
use Drupal\Core\Config\ConfigFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure statistics settings for this site.
 */
class StatisticsSettingsForm extends SystemConfigFormBase {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs a \Drupal\user\StatisticsSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Core\Config\Context\ContextInterface $context
   *   The configuration context to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler.
   */
  public function __construct(ConfigFactory $config_factory, ContextInterface $context, ModuleHandlerInterface $module_handler) {
    parent::__construct($config_factory, $context);

    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('config.context.free'),
      $container->get('module_handler')
    );
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::getFormID().
   */
  public function getFormID() {
    return 'statistics_settings_form';
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::buildForm().
   */
  public function buildForm(array $form, array &$form_state) {
    $config = $this->configFactory->get('statistics.settings');

    // Content counter settings.
    $form['content'] = array(
      '#type' => 'details',
      '#title' => t('Content viewing counter settings'),
    );
    $form['content']['statistics_count_content_views'] = array(
      '#type' => 'checkbox',
      '#title' => t('Count content views'),
      '#default_value' => $config->get('count_content_views'),
      '#description' => t('Increment a counter each time content is viewed.'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::submitForm().
   */
  public function submitForm(array &$form, array &$form_state) {
    $this->configFactory->get('statistics.settings')
      ->set('count_content_views', $form_state['values']['statistics_count_content_views'])
      ->save();

    // The popular statistics block is dependent on these settings, so clear the
    // block plugin definitions cache.
    if ($this->moduleHandler->moduleExists('block')) {
      \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
    }

    parent::submitForm($form, $form_state);
  }

}
