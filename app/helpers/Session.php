<?php

namespace helpers;

session_start();

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
        echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . ' </div>';

        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
      }
    }
  }

  //check if a user is logged in
  public static function isLoggedIn() {
    return self::sessionExist('user_id');
  }

  //check if a session exists
  public static function sessionExist($name) {
    return isset($_SESSION[$name]) ? true : false;
  }

  //add data to session
  public static function setSession($dataArray) {
    foreach ($dataArray as $key => $value) {
      $_SESSION[$key] = $value;
    }
  }

  public static function uagent_no_version() {
    $uagent = $_SERVER['HTTP_USER_AGENT'];
    $regex = '/\/[a-zA-Z0-9.]+/';
    $new_uagent = preg_replace($regex, '', $uagent);

    return $new_uagent;
  }
}
