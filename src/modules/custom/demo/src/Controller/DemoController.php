<?php
/**
 * @file
 * @author Prashanth
 * Contains \Drupal\demo\Controller\DemoController.
 */
namespace Drupal\demo\Controller;
/**
 * Provides route responses for the demo module.
 */
class DemoController {
  /**
   * Returns a Hello world page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function helloWorld() {
    $element = array(
      '#markup' => 'Hello world!',
    );
    return $element;
  }
}
?>
