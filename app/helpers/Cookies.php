<?php

namespace helpers;

class Cookies {
  public static function setCookies($name, $value, $duration) {
    if (setcookie($name, $value, time() + $duration, '/')) {
      return true;
    }
    return false;
  }

  public static function cookieExists($name) {
    return isset($_COOKIE[$name]);
  }

  public static function unsetCookie($name) {
    unset($_COOKIE[$name]);
  }

  public static function cookieEnabled() {
    return (count($_COOKIE) > 0);
  }
}
