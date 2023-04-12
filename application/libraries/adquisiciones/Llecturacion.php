<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Llecturacion {
    /*
     * * Retrieve  Quize List From DB
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('adquisiciones/lecturacion/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Ma_Ordenes_compra');
        $CI->load->model('Ma_Proveedores');
        $data['proveedores'] = $CI->Ma_Proveedores->list();
        $form = $CI->parser->parse('almacen/orden_compra/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Lecturacion');
        /*$CI->load->model('Ma_Proveedores');*/

        //Data
        $cabecera = $CI->Lecturacion->retrieve_cabecera($id);

        // Catalogos
     //   $proveedores = $CI->Ma_Proveedores->list();

        //Array
        $data['title']                 = "ERP | Progreso Consuting Group S.R.L.";
        $data['id']                    = $cabecera[0]['id'];
        $data['cid']                 = $cabecera[0]['cid'];
        $data['razon_social']                = $cabecera[0]['razon_social'];
        $data['medidor']           = $cabecera[0]['medidor'];
        $data['lectura']           = $cabecera[0]['lectura'];
        $data['multiplicador']           = $cabecera[0]['multiplicador'];
        $data['categoria']           = $cabecera[0]['categoria'];
        $data['numero_doc']           = $cabecera[0]['numero_doc'];
        $data['direccion']           = $cabecera[0]['direccion'];
        //$data['id_proveedor']          = $cabecera[0]['id_proveedor'];
       // $data['proveedores']           = $proveedores;

        $res = $CI->parser->parse('adquisiciones/lecturacion/edit_form', $data, true);

        return $res;
    }



}

?>
