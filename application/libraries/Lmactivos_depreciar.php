<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_depreciar
{
    public function add_form()
    {
        $CI = &get_instance();
        $CI->load->model('Mactivos_Depreciar');

        $data = array(
            'title' => 'Depreciar',
        );
        $form = $CI->parser->parse('modulo_activos/depreciar/index', $data, TRUE);
        return $form;
    }

}

