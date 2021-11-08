<?php

/**
 * @file
 * Contains \Drupal\skytegs\Controller\SkyTegsView.
 */

namespace Drupal\skytegs\Controller;

/**
 * Provides route for custom module
 */
class SkyTegsView {

    private $str = '<div id="wordList"></div>';

    public function setStr($str)
    {
        $this->str = $str;
    }

    /**
     * Displays widget
     */
    public function content(){
        return array(
            '#markup' => $this->str
        );
    }
}