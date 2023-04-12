<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_estado_civil{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Estados_civiles');
        $list = $CI->Mga_Estados_civiles->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Estado civil',
            'list' => $list
        );
        $form = $CI->parser->parse('gestion_asociado/estados_civiles/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Estados_civiles');
        $details = $CI->Mga_Estados_civiles->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar estado civil",
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('gestion_asociado/estados_civiles/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
