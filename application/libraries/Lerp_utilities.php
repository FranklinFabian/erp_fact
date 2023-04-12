<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lerp_utilities {

  public function convertDateToLiteral($date) {
    $date = date('Y-m-d', strtotime($date));
    list($y, $m, $d) = explode("-", $date);
    return "{$d} de " . MONTH_NAMES[$m] . " de {$y}";
  }
  public function getMonthName($number) {
    $month = str_pad($number + 1, 2, '0', STR_PAD_LEFT);
    return MONTH_NAMES[$month];
  }

}
