<?php

namespace helpers;

use DateTime;

class Date {
  public static function since($since) {
    $chunks = array(
      array(60 * 60 * 24 * 365, 'year'),
      array(60 * 60 * 24 * 30, 'month'),
      array(60 * 60 * 24 * 7, 'week'),
      array(60 * 60 * 24, 'day'),
      array(60 * 60, 'hour'),
      array(60, 'min'),
      array(1, 'sec')
    );

    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
      $seconds = $chunks[$i][0];
      $name = $chunks[$i][1];
      if (($count = floor($since / $seconds)) != 0) {
        break;
      }
    }

    $print = ($count == 1) ? '1 ' . $name : "$count {$name}s";
    return $print;
  }

  public static function format($date, $format = 'F j, Y', bool $showTime = false) {
    $tempDate = date("Y-m-d h:m:s", strtotime($date));
    $tempDate =  new DateTime($tempDate);
    $tempDate = $tempDate->format($format);

    return $showTime ? $tempDate . ' ' . date('h:i A', strtotime($date)) :
      $tempDate;
  }
}
