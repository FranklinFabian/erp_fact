<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_departamento{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Departamentos');
        $list = $CI->Ma_Departamentos->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Departamento',
            'list' => $list
        );
        $form = $CI->parser->parse('almacen/departamentos/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Departamentos');
        $details = $CI->Ma_Departamentos->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar Departamento",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'abreviatura' => $details[0]['abreviatura'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('almacen/departamentos/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
