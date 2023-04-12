<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lestadoservicio {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/estadoservicio/index', $data, true);
        return $res;
    }

}

?>
