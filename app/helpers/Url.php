<?php

namespace helpers;
//Simple page redirect

class Url {
  public static function redirect(string $page) {
    header('location: ' . URL_ROOT . '/' . $page);
    exit();
  }
}
