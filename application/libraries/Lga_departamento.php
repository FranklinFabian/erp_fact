<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_departamento{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Departamentos');
        $list = $CI->Mga_Departamentos->list();
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
        $form = $CI->parser->parse('gestion_asociado/departamentos/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Departamentos');
        $details = $CI->Mga_Departamentos->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar departamento",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('gestion_asociado/departamentos/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
