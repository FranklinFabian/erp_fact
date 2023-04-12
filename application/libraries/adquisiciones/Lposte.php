<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lposte {
    public function edit_data() {
        $CI = & get_instance();

        $data['data'] = 0;

        $res = $CI->parser->parse('adquisiciones/poste/index', $data, true);
        return $res;
    }

}

?>
