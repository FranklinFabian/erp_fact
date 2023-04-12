<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmcajachica_configuracion {
    public function edit_data() {
        $CI = & get_instance();
    
        $data['data'] = 0;
                
        $res = $CI->parser->parse('modulo_cajachica/configuracion/index', $data, true);
        return $res;
    }

}

?>
