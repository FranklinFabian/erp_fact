<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_egreso {
    /*
     * * Retrieve  Quize List From DB
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('almacen/egreso/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Egresos');
        $data['var']    = 0;
        $data['pedidos'] = $CI->Ma_Egresos->list_pedidos();
        $form = $CI->parser->parse('almacen/egreso/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Egresos');
        $CI->load->model('Ma_Proveedores');

        //Data
        $cabecera = $CI->Ma_Egresos->retrieve_cabecera_egreso($id);
        $egreso = $CI->Ma_Egresos->retrieve_egreso($id);

        $data['pedidos'] = $CI->Ma_Egresos->list_pedidos();
        //Array
        $data['title']                 = "Edita tu egreso";
        $data['id']                    = $cabecera[0]['id'];
        $data['fecha']                 = $cabecera[0]['fecha'];
        $data['codigo']                = $cabecera[0]['codigo'];
        $data['glosa']                 = $cabecera[0]['glosa'];
        $data['solicitante']           = $cabecera[0]['solicitante'];
        $data['id_proveedor']          = $cabecera[0]['id_proveedor'];
        $data['id_pedido']          = $cabecera[0]['id_pedido'];
        $data['cabecera_egreso']      = $cabecera;
        $data['egresos'] = $egreso;

        $res = $CI->parser->parse('almacen/egreso/edit_form', $data, true);

        return $res;
    }



}

?>
