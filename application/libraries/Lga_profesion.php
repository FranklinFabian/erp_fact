<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_profesion{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Profesiones');
        $list = $CI->Mga_Profesiones->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Profesión',
            'list' => $list
        );
        $form = $CI->parser->parse('gestion_asociado/profesiones/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Profesiones');
        $details = $CI->Mga_Profesiones->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar profesión",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('gestion_asociado/profesiones/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
