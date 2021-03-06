<?php
/**
 * @file
 */

namespace BackupMigrate\Core\Plugin;

use BackupMigrate\Core\Config\ConfigurableInterface;
use BackupMigrate\Core\Config\ConfigurableTrait;

/**
 * Class PluginOperationTrait
 * @package BackupMigrate\Core\Plugin
 */
abstract class PluginBase implements PluginInterface, ConfigurableInterface {
  use ConfigurableTrait;

  /**
   * Get a list of supported operations and their weight.
   *
   * An array of operations should take the form:
   *
   * array(
   *  'backup' => array('weight' => 100),
   *  'restore' => array('weight' => -100),
   * );
   *
   * @return array
   */
  public function supportedOps() {
    return [];
  }

  /**
   * Does this plugin implement the given operation.
   *
   * @param $op string The name of the operation
   * @return bool
   */
  public function supportsOp($op) {
    // If the function has the method then it supports the op.
    if (method_exists($this, $op)) {
      return TRUE;
    }
    // If the supported ops array contains the op then it is supported.
    $ops = $this->supportedOps();
    return isset($ops[$op]);
  }

  /**
   * What is the weight of the given operation for this plugin.

   * @param $op string The name of the operation
   * @return int
   */
  public function opWeight($op) {
    $ops = $this->supportedOps();
    if (isset($ops[$op]['weight'])) {
      return $ops[$op]['weight'];
    }
    return 0;
  }

}