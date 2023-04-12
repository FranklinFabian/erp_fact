<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Llocalidad {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/localidad/index', $data, true);
        return $res;
    }

}

?>
