<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lreporte
{
// ========== its for unit add form page load start ===========
    public function form()
    {
        $CI = &get_instance();

        $data['data'] = 0;

        $form = $CI->parser->parse('adquisiciones/reporte/form', $data, TRUE);
        return $form;
    }




}

