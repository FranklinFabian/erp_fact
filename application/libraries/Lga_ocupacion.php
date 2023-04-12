<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_ocupacion{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Ocupaciones');
        $list = $CI->Mga_Ocupaciones->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Ocupación',
            'list' => $list
        );
        $form = $CI->parser->parse('gestion_asociado/ocupaciones/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Ocupaciones');
        $details = $CI->Mga_Ocupaciones->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar ocupacion",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('gestion_asociado/ocupaciones/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
