<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_administracion {
    public function edit_data() {
        $CI = & get_instance();
        $CI->load->model('Mactivos_Cuenta');
        $CI->load->model('Mactivos_Ubicacion');
        $data['cuentas'] = $CI->Mactivos_Cuenta->list_cuentas();
        $data['ubicaciones'] = $CI->Mactivos_Ubicacion->list_ubicaciones();

        array_push($data['cuentas'], array(
            "id" => ' ',
            "nombre" => 'Todos',
        ));

        $res = $CI->parser->parse('modulo_activos/administracion/index', $data, true);
        return $res;
    }

}

?>
