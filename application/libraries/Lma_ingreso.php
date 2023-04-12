<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_ingreso {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('almacen/ingreso/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Proveedores');
        $CI->load->model('Ma_Ordenes_compra');
        $data['proveedores'] = $CI->Ma_Proveedores->list();
        $data['ordenes_compra'] = $CI->Ma_Ordenes_compra->list_dropdown();
        $form = $CI->parser->parse('almacen/ingreso/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Ingresos');
        $CI->load->model('Ma_Proveedores');
        $CI->load->model('Ma_Ordenes_compra');

        //Data
        $cabecera = $CI->Ma_Ingresos->retrieve_cabecera_ingreso($id);
        $ingreso = $CI->Ma_Ingresos->retrieve_ingreso($id);

        // Catalogos
        $proveedores = $CI->Ma_Proveedores->list();
        $ordenes_compra = $CI->Ma_Ordenes_compra->list_dropdown();


        //Array
        $data['title']                 = "Edita tu ingreso";
        $data['id']                    = $cabecera[0]['id'];
        $data['fecha']                 = $cabecera[0]['fecha'];
        $data['codigo']                = $cabecera[0]['codigo'];
        $data['glosa']                 = $cabecera[0]['glosa'];
        $data['id_proveedor']          = $cabecera[0]['id_proveedor'];
        $data['id_orden']              = $cabecera[0]['id_orden'];
        $data['proveedores']           = $proveedores;
        $data['ordenes_compra']           = $ordenes_compra;
        $data['cabecera_ingreso']      = $cabecera;
        $data['ingresos'] = $ingreso;

        $res = $CI->parser->parse('almacen/ingreso/edit_form', $data, true);

        return $res;
    }



}

?>
