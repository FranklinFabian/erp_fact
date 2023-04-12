<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_almacen{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Almacenes');
        $list = $CI->Ma_Almacenes->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Almacen',
            'list' => $list
        );
        $form = $CI->parser->parse('almacen/almacenes/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Almacenes');
        $details = $CI->Ma_Almacenes->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar almacen',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('almacen/almacenes/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
