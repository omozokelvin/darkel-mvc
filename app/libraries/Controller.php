<?php

/******************************************
 * Base Controller                        *
 * Loads the models and views             *
 *****************************************/

class Controller {
  //Load model
  public function model(string $model) {
    //Require model file
    require_once '../app/models/' . $model . '.php';

    //instantiate model
    return new $model();
  }

  //Load view
  public function view(string $view, $data = []) {
    //check for view file
    if (file_exists('../app/views/' . $view . '.php')) {
      require_once '../app/views/' . $view . '.php';
    } else {
      //view does not exists
      die('view does not exists');
    }
  }
}
