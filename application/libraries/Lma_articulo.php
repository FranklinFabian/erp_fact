<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_articulo{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Articulos');
        $CI->load->model('Ma_Almacenes');
        $CI->load->model('Ma_Unidades');
        //$CI->load->model('Ma_Grupos');
        $list = $CI->Ma_Articulos->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Articulo',
            'list' => $list
        );

        $data['almacenes'] = $CI->Ma_Almacenes->dropdown();
        $data['unidades'] = $CI->Ma_Unidades->dropdown();
        //$data['grupos'] = $CI->Ma_Grupos->dropdown();
        $form = $CI->parser->parse('almacen/articulos/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Articulos');
        $CI->load->model('Ma_Almacenes');
        $CI->load->model('Ma_Unidades');
        //$CI->load->model('Ma_Grupos');
        $details = $CI->Ma_Articulos->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Articulo',
            'id'   => $details[0]['id'],
            'id_unidad'   => $details[0]['id_unidad'],
            'id_grupo'   => $details[0]['id_grupo'],
            'nombre' => $details[0]['nombre'],
            'stock_minimo' => $details[0]['stock_minimo'],
            'monto_minimo' => $details[0]['monto_minimo'],
            'monto_maximo' => $details[0]['monto_maximo'],
            'descripcion'    => $details[0]['descripcion'],
        );

        $data['almacenes'] = $CI->Ma_Almacenes->dropdown();
        $data['unidades'] = $CI->Ma_Unidades->dropdown();
//        $data['grupos'] = $CI->Ma_Grupos->dropdown();
        $editShow = $CI->parser->parse('almacen/articulos/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
