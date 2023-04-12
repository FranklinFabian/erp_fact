<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_grupo{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Grupos');
        $CI->load->model('Ma_Almacenes');
        $list = $CI->Ma_Grupos->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Grupo',
            'list' => $list
        );
        $data['almacenes'] = $CI->Ma_Almacenes->dropdown();
        $form = $CI->parser->parse('almacen/grupos/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Grupos');
        $details = $CI->Ma_Grupos->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar grupo',
            'id'   => $details[0]['id'],
            'id_almacen'   => $details[0]['id_almacen'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('almacen/grupos/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
