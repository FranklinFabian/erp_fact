<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_reporte
{
// ========== its for unit add form page load start ===========
    public function add_form_inventario_fisico()
    {
        $CI = &get_instance();
        $CI->load->model('Ma_Reportes');

        $data = array(
            'title' => 'Reportes',
        );
        $form = $CI->parser->parse('almacen/reporte/add_form_inventario_fisico', $data, TRUE);
        return $form;
    }

    public function add_form_kardex_general()
    {
        $CI = &get_instance();
        $CI->load->model('Ma_Reportes');

        $data = array(
            'title' => 'Reportes',
        );

        $data['tipo'][0]['id'] = 'Ingreso';
        $data['tipo'][0]['nombre'] = 'Ingreso';
        $data['tipo'][1]['id'] = 'Egreso';
        $data['tipo'][1]['nombre'] = 'Egreso';

        $form = $CI->parser->parse('almacen/reporte/add_form_kardex_general', $data, TRUE);
        return $form;
    }

    public function add_form_salida_almacen()
    {
        $CI = &get_instance();
        $CI->load->model('Ma_Reportes');

        $data = array(
            'title' => 'Reportes',
        );

        $form = $CI->parser->parse('almacen/reporte/add_form_salida_almacen', $data, TRUE);
        return $form;
    }


}

