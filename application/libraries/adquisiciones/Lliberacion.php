<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lliberacion {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/liberacion/index', $data, true);
        return $res;
    }

}

?>
