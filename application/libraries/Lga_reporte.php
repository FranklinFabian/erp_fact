<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_reporte
{
// ========== its for unit add form page load start ===========
    public function add_form_reporte_cliente()
    {
        $CI = &get_instance();

        $data = array(
            'title' => 'Reportes',
        );

        $form = $CI->parser->parse('gestion_asociado/reporte/form_reporte_cliente', $data, TRUE);
        return $form;
    }

}

