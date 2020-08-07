<?php

namespace helpers;

use DateTime;
use Exception;

class Date {
  public static function since($since) {

    $since = time() - strtotime($since);

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

  public static function format($date, $format = 'medium') {

    $dateFormatString = $format;
    $availableFormats = ['short', 'medium', 'full', 'shortDate', 'mediumDate', 'longDate', 'fullDate', 'shortTime', 'mediumTime', 'fullTime'];

    if (!in_array($format, $availableFormats)) {
      throw new Exception("Date format '$format' does not exist, available formats: " . implode(', ', $availableFormats) . "", 1);
    }

    switch ($format) {

      case 'short': // 'short': equivalent to 'M/d/yy, h:mm a' (6/15/15, 9:03 AM).
        $dateFormatString = 'n/j/y g:i A';
        break;

      case 'medium': //'medium': equivalent to 'MMM d, y, h:mm:ss a' (Jun 15, 2015, 9:03:01 AM).
        $dateFormatString = 'M j, Y, g:i:s A';
        break;

      case 'full': //'full': equivalent to 'EEEE, MMMM d, y, h:mm:ss a zzzz' (Monday, June 15, 2015, 9:03:01 AM GMT+01:00).
        $dateFormatString = 'l, F j, Y, g:i:s A TP';
        break;

      case 'shortDate': //'shortDate': equivalent to 'M/d/yy' (6/15/15).
        $dateFormatString = 'n/j/y';
        break;

      case 'mediumDate': //'mediumDate': equivalent to 'MMM d, y' (Jun 15, 2015).
        $dateFormatString = 'M j, Y';
        break;

      case 'longDate': //'longDate': equivalent to 'MMMM d, y' (June 15, 2015).
        $dateFormatString = 'F j, Y';
        break;

      case 'fullDate': //'fullDate': equivalent to 'EEEE, MMMM d, y' (Monday, June 15, 2015).
        $dateFormatString = 'l, F j, Y';
        break;

      case 'shortTime': //'shortTime': equivalent to 'h:mm a' (9:03 AM).
        $dateFormatString = 'g:i A';
        break;

      case 'mediumTime': //'mediumTime': equivalent to 'h:mm:ss a' (9:03:01 AM).
        $dateFormatString = 'g:i:s A';
        break;

      case 'fullTime': //equivalent to 'h:mm:ss a zzzz' (9:03:01 AM GMT+01:00).
        $dateFormatString = 'g:i:s A TP';
        break;

      default:
        # code...
        break;
    }

    $tempDate = date($dateFormatString, strtotime($date));
    $tempDate =  new DateTime($tempDate);
    $tempDate = $tempDate->format($dateFormatString);

    return $tempDate;
  }
}
