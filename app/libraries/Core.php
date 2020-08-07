<?php

namespace libraries;

/******************************************
 * App Core Class                         *
 * Creates Url & Loads core controller    *
 * URL FORMAT - /controller/method/params *
 *****************************************/

class Core {
  protected $currentController = 'Home';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct() {
    // print_r($this->getUrl());

    $url = $this->getUrl();

    //Look in controllers for first value
    if (file_exists('app/controllers/' . ucwords($url[0]) . '.php')) {
      //if exists, set as controller
      $this->currentController = ucwords($url[0]);
      //unset 0 index of url
      unset($url[0]);
    }

    //require the controller
    require_once 'app/controllers/' . $this->currentController . '.php';

    //Instantiate controller class
    $this->currentController = new $this->currentController;

    //Check for second part of url
    if (isset($url[1])) {
      //Check to see if method exists in controller 
      if (method_exists($this->currentController, str_replace('-', '', $url[1]))) {
        $this->currentMethod = str_replace('-', '', $url[1]);
        //unset 1 index of url
        unset($url[1]);
      }
    }

    //Get params
    $this->params = $url ? array_values($url) : [];

    //Call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function getUrl() {
    if (isset($_GET['url']) || isset($_SERVER['REQUEST_URI'])) {
      $uri = $_GET['url'] ?? $_SERVER['REQUEST_URI'];
      $url = trim($uri, '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
    return [$this->currentController];
  }
}
