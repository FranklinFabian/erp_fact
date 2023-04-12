<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_orden_trabajo {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('almacen/orden_trabajo/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Ordenes_trabajo');
        $CI->load->model('Ma_Proveedores');
        $data['proveedores'] = $CI->Ma_Proveedores->list();
        $form = $CI->parser->parse('almacen/orden_trabajo/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Ordenes_trabajo');
        $CI->load->model('Ma_Proveedores');

        //Data
        $cabecera = $CI->Ma_Ordenes_trabajo->retrieve_cabecera($id);

        // Catalogos
        $proveedores = $CI->Ma_Proveedores->list();

        //Array
        $data['title']                 = "Edita tu orden de trabajo";
        $data['id']                    = $cabecera[0]['id'];
        $data['fecha']                 = $cabecera[0]['fecha'];
        $data['codigo']                = $cabecera[0]['codigo'];
        $data['observacion']           = $cabecera[0]['observacion'];
        $data['id_proveedor']          = $cabecera[0]['id_proveedor'];
        $data['proveedores']           = $proveedores;

        $res = $CI->parser->parse('almacen/orden_trabajo/edit_form', $data, true);

        return $res;
    }



}

?>
