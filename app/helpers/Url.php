<?php

namespace helpers;
//Simple page redirect

class Url {
  public static function redirect(string $page) {
    header('location: ' . URLROOT . '/' . $page);
  }
}
