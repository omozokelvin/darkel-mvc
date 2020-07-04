<?php

namespace helpers;

class Handler {
  public static function dumpy($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
  }
}
