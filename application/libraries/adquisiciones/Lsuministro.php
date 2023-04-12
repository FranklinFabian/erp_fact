<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lsuministro {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/suministro/index', $data, true);
        return $res;
    }

}

?>
