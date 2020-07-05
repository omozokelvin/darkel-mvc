<?php

namespace libraries;

/******************************************
 * Base Controller                        *
 * Loads the models and views             *
 *****************************************/

class Controller {
  //Load model

  //Load view
  public function view(string $view, array $data = []) {
    //check for view file
    if (file_exists('../app/views/' . $view . '.php')) {
      require_once '../app/views/' . $view . '.php';
    } else {
      //view does not exists
      die('view does not exists');
    }
  }
}
