<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_pedidotecnico {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('almacen/pedidotecnico/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Pedidostecnicos');
        $data['test'] = 1;
        $form = $CI->parser->parse('almacen/pedidotecnico/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Pedidostecnicos');

        //Data
        $cabecera = $CI->Ma_Pedidostecnicos->retrieve_cabecera($id);

        // Catalogos

        //Array
        $data['title']                 = "Edita tu pedido";
        $data['id']                    = $cabecera[0]['id'];
        $data['fecha']                 = $cabecera[0]['fecha'];
        $data['codigo']                = $cabecera[0]['codigo'];

        $res = $CI->parser->parse('almacen/pedidotecnico/edit_form', $data, true);

        return $res;
    }



}

?>
