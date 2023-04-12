<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_ufv{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Ufv');
        $list = $CI->Mactivos_Ufv->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Ufv',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/ufv/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Ufv');
        $details = $CI->Mactivos_Ufv->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Ufv',
            'id'   => $details[0]['id'],
            'fecha' => $details[0]['fecha'],
            'valor' => $details[0]['valor'],
        );
        $editShow = $CI->parser->parse('modulo_activos/ufv/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
