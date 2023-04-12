<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_proforma {
    /*
     * * Retrieve  Quize List From DB
     */
    public function list()
    {
        $CI =& get_instance();
        $CI->load->model('Ma_Proformas');
        $CI->load->model('Web_settings');
        $data['total']    = $CI->Ma_Proformas->count();
        $list = $CI->parser->parse('almacen/proforma/lista',$data,true);
        return $list;
    }

    //Add Form
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Articulos');
        $CI->load->model('Ma_Proveedores');
        $CI->load->model('fact/Cliente');

        $articulos = $CI->Ma_Articulos->list();
       // $proveedores = $CI->Ma_Proveedores->list();
        $clientes = $CI->Cliente->clientes();

        $data = array(
            'title'        => "Añadir Proforma",
            'articulos'=> $articulos,
            //'proveedores'=> $proveedores,
            'clientes'=> $clientes

        );
        $form = $CI->parser->parse('almacen/proforma/add_form', $data, true);
        return $form;
    }

    //Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Proformas');
        $CI->load->model('Ma_Articulos');
        $CI->load->model('fact/Cliente');
//        $CI->load->model('Ma_Proveedores');

        //Data
        $cabecera_cotizacion = $CI->Ma_Proformas->retrieve_proforma($id);
        $cotizacion = $CI->Ma_Proformas->retrieve_proforma_items($id);

        // Catalogos
        $articulos = $CI->Ma_Articulos->list();
        $clientes = $CI->Cliente->clientes();

        //Array
        $data['title']                 = 'Editar proforma';
        $data['id']                    = $cabecera_cotizacion[0]['id'];
        $data['fecha']                 = $cabecera_cotizacion[0]['fecha'];
        $data['codigo']                = $cabecera_cotizacion[0]['codigo'];
        $data['id_cliente']            = $cabecera_cotizacion[0]['id_cliente'];

        $data['articulos']             = $articulos;
        $data['clientes']             = $clientes;
        $data['cabecera_cotizacion']   = $cabecera_cotizacion;
        $data['cotizaciones']          = $cotizacion;
        $res = $CI->parser->parse('almacen/proforma/edit_form', $data, true);
        //print_r($data);exit();
        return $res;
    }



}

?>
