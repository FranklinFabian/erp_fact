<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_responsable{
    public function edit_data() {
        $CI = & get_instance();
        $data['data'] = 0;
        $res = $CI->parser->parse('modulo_activos/responsable/index', $data, true);
        return $res;
    }
}

?>
