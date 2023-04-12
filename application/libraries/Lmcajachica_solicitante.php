<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmcajachica_solicitante {
    public function edit_data() {
        $CI = & get_instance();
    
        $data['data'] = 0;
                
        $res = $CI->parser->parse('modulo_cajachica/solicitante/index', $data, true);
        return $res;
    }

}

?>
