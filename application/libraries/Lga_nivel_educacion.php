<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_nivel_educacion{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Niveles_educacion');
        $list = $CI->Mga_Niveles_educacion->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Niveles de educación',
            'list' => $list
        );
        $form = $CI->parser->parse('gestion_asociado/niveles_educacion/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Niveles_educacion');
        $details = $CI->Mga_Niveles_educacion->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar niveles de educación",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('gestion_asociado/niveles_educacion/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
