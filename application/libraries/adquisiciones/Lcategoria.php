<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lcategoria {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/categoria/index', $data, true);
        return $res;
    }

}

?>
