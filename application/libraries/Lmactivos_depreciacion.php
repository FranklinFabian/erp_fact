<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_depreciacion{
    public function edit_data() {
        $CI = & get_instance();
        $CI->load->model('Mactivos_Administracion');
        $data['activos'] = $CI->Mactivos_Administracion->list_activos();

        array_push($data['activos'], array(
            "id" => ' ',
            "codigo_activo" => 'Todos',
        ));

        $res = $CI->parser->parse('modulo_activos/depreciacion/index', $data, true);
        return $res;
    }
}

?>
