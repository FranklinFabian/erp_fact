<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('module_name')) {
  function module_name() {
    return 'Contabilidad y Finanzas';
  }
}
if (!function_exists('details_selected_company')) {
  function details_selected_company($module_name = '') {
    $ci = & get_instance();

    $empresa = isset($ci->EMPRESA_GESTION['nombre']) ? $ci->EMPRESA_GESTION['nombre'] : '-';
    $gestion = isset($ci->EMPRESA_GESTION['gestion']) ? $ci->EMPRESA_GESTION['gestion'] : '-';

    return "{$module_name} | Empresa: {$empresa} | Gestión: {$gestion}";
  }
}

if (!function_exists('empresa_gestion')) {
  function empresa_gestion($param) {
    $ci = & get_instance();

    return isset($ci->EMPRESA_GESTION[$param]) ? $ci->EMPRESA_GESTION[$param] : '-';
  }
}

if (!function_exists('comprobantes_parametros')) {
  function comprobantes_parametros($param = null) {
    $ci = & get_instance();
    $comprobantes_parametros = $ci->cofiModel->getComprobantesParametros($ci->EMPRESA_GESTION_ID);
    if (!$param) {
      return $comprobantes_parametros;
    }

    return isset($comprobantes_parametros->$param) ? $comprobantes_parametros->$param : '-';
  }
}

if (!function_exists('selected_year')) {
  function selected_year() {
    $ci = & get_instance();

    return isset($ci->EMPRESA_GESTION['gestion']) ? $ci->EMPRESA_GESTION['gestion'] : '-';
  }
}

if (!function_exists('numero_comprobante')) {
  function numero_comprobante($id) {
    $ci = & get_instance();
    $comprobantes_parametros = $ci->cofiModel->getComprobantesParametros($ci->EMPRESA_GESTION_ID);

    return str_pad($id, $comprobantes_parametros->cantidad_digitos, '0', STR_PAD_LEFT);
  }
}

if (!function_exists('get_correlativo_comprobante')) {
  function get_correlativo_comprobante($comprobante_tipo_id) {
    $ci = & get_instance();
    $data = $ci->cofiModel->getComprobanteCorrelativo($comprobante_tipo_id, $ci->EMPRESA_GESTION_ID);

    if (!$data) {
      $data = [
        'comprobante_tipo_id' => $comprobante_tipo_id,
        'contador' => 1,
        'empresa_gestion_id' => $ci->EMPRESA_GESTION_ID
      ];
      $ci->cofiModel->crearComprobantesCorrelativos($data);

      return 1;
    }

    return intval($data->contador);
  }
}

if (!function_exists('increase_correlativo_comprobante')) {
  function increase_correlativo_comprobante($comprobante_tipo_id) {
    $ci = & get_instance();
    $res = $ci->cofiModel->incrementarContadorComprobantesCorrelativos($comprobante_tipo_id, $ci->EMPRESA_GESTION_ID);

    return $res;
  }
}

?>
