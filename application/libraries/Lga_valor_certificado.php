<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_valor_certificado{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mga_Valores_certificado');
        $list = $CI->Mga_Valores_certificado->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Valor certificado',
            'list' => $list
        );
        $form = $CI->parser->parse('gestion_asociado/valores_certificado/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Valores_certificado');
        $details = $CI->Mga_Valores_certificado->retrieve_editdata($id);
        $data = array(
            'title'     => "Editar valor certificado",
            'id'   => $details[0]['id'],
            'monto' => $details[0]['monto']
        );
        $editShow = $CI->parser->parse('gestion_asociado/valores_certificado/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
