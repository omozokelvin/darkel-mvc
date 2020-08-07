<?php

namespace libraries;

/******************************************
 * Base Controller                        *
 * Loads the models and views             *
 *****************************************/

class Controller {

  //Load view
  public function view(string $view, $data = []) {
    //check for view file
    if (file_exists('app/views/' . $view . '.php')) {
      require_once 'app/views/' . $view . '.php';
    } else {
      //view does not exists
      //Todo: add default error page, don't just die @Kelvin A:Tobi
      die('view does not exists');
    }
  }
}
