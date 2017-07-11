<?php

namespace Drupal\demo\Controller;

/**
 * Provides route responses for the demo module.
 */
class DemoController {

  /**
   * Display hello world page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function helloWorld() {
    $element = ['#markup' => 'Hello world DevOps!'];
    return $element;
  }

}
