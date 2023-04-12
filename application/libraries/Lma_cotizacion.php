<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_cotizacion {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $CI->load->model('Ma_Cotizaciones');
        $CI->load->model('Web_settings');
        $data['total']    = $CI->Ma_Cotizaciones->count();
        $list = $CI->parser->parse('almacen/cotizacion/lista',$data,true);
        return $list;
    }

    //Add Form
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Articulos');
        $CI->load->model('Ma_Proveedores');

        $articulos = $CI->Ma_Articulos->list();
        $proveedores = $CI->Ma_Proveedores->list();

        $data = array(
            'title'        => "Añadir Cotización",
            'articulos'=> $articulos,
            'proveedores'=> $proveedores

        );
        $form = $CI->parser->parse('almacen/cotizacion/add_form', $data, true);
        return $form;
    }

    //Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Cotizaciones');
        $CI->load->model('Ma_Articulos');
        $CI->load->model('Ma_Proveedores');

        //Data
        $cabecera_cotizacion = $CI->Ma_Cotizaciones->retrieve_cabecera_cotizacion($id);
        $cotizacion = $CI->Ma_Cotizaciones->retrieve_cotizacion($id);

        // Catalogos
        $articulos = $CI->Ma_Articulos->list();
        $proveedores = $CI->Ma_Proveedores->list();

        //Array
        $data['title']                 = 'Editar cotización';
        $data['id']                    = $cabecera_cotizacion[0]['id'];
        $data['fecha']                 = $cabecera_cotizacion[0]['fecha'];
        $data['codigo']                = $cabecera_cotizacion[0]['codigo'];
        $data['articulos']             = $articulos;
        $data['proveedores']           = $proveedores;
        $data['cabecera_cotizacion']   = $cabecera_cotizacion;
        $data['cotizaciones']          = $cotizacion;

        $res = $CI->parser->parse('almacen/cotizacion/edit_form', $data, true);

        return $res;
    }



}

?>
