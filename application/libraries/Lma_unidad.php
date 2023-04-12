<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_unidad{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Unidades');
        $list = $CI->Ma_Unidades->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Unidad',
            'list' => $list
        );
        $form = $CI->parser->parse('almacen/unidades/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Unidades');
        $details = $CI->Ma_Unidades->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar unidad',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('almacen/unidades/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
