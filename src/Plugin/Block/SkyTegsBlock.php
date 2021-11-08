<?php

namespace Drupal\skytegs\Plugin\Block;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with DrillDown diagram by High Charts.
 *
 * @block(
 *   id = "skytegs_custom_block",
 *   admin_label = @Translation("SkyTegs custom block"),
 * )
 */


class SkyTegsBlock extends BlockBase {
  /**
   * {@block}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['skytegs_custom_block_settings'])) {
      $text = $this->t('<div id="wordList"></div><p>@Description</p>',
        ['@Description' => $config['skytegs_custom_block_settings']]);
    }
    else {
      $text = $this->t('<div id="wordList"></div>');
    }

    return [
      '#markup' => $text,
    ];
  }

  /**
   * {@block}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@block}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    $form['skytegs_custom_block_settings'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Description'),
      '#description' => $this->t('Could you place description?'),
      '#default_value' => !empty($config['skytegs_custom_block_settings']) ? $config['skytegs_custom_block_settings'] : '',
    ];

    return $form;
  }

  /**
   * {@block}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['skytegs_custom_block_settings'] = $form_state->getValue('skytegs_custom_block_settings');
  }
}