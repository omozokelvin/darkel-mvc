<?php

namespace helpers;

class Session {

  //flash message helper
  //EXAMPLE - flash('register_success', 'you are now registered', 'alert alert-danger')
  //DISPLAY IN VIEW - echo flash('register_success')
  public static function flash(string $name = '', string $message = '', string $class = 'alert alert-success') {
    if (!empty($name)) {
      if (!empty($message) && empty($_SESSION[$name])) {

        if (!empty($_SESSION[$name . '_class'])) {
          unset($_SESSION[$name . '_class']);
        }

        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
      } else if (empty($message) && !empty($_SESSION[$name])) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
        echo '<div class="' . $class . ' alert-dismissible" id="msg-flash"><button type="button" class="close text-light" data-dismiss="alert" aria-hidden="true">×</button>' . $_SESSION[$name] . ' </div>';

        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  //check if a user is logged in
  public static function isLoggedIn() {
    if (!self::exists('user_id')) {
      return false;
    }
    //option db check for user
    return true;
  }


  //check if a session exists
  public static function exists($name) {
    return isset($_SESSION[$name]) ? true : false;
  }

  //add data to session
  public static function set($dataArray) {
    foreach ($dataArray as $key => $value) {
      $_SESSION[$key] = $value;
    }
  }

  //add data to session
  public static function unset($dataArray) {
    foreach ($dataArray as $session) {
      if (!!$_SESSION[$session]) {
        unset($_SESSION[$session]);
      }
    }
  }

  public static function uagent_no_version() {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regex = '/\/[a-zA-Z0-9.]+/';
    $new_uagent = preg_replace($regex, '', $uagent);

    return $new_uagent;
  }
}
