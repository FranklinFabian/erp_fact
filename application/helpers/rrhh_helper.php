<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('module_name')) {
  function module_name() {
    return 'Recursos Humanos';
  }
}
if (!function_exists('details_module')) {
  function details_module($module_name = '') {
    return "{$module_name}";
  }
}

?>
