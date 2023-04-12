<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_certificado {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('gestion_asociado/certificado/lista',$data,true);
        return $list;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Mga_Certificados');
        $certificado = $CI->Mga_Certificados->vista_cliente($id);
        $data = $certificado[0];
        $res = $CI->parser->parse('gestion_asociado/certificado/edit_form', $data, true);

        return $res;
    }



}

?>
