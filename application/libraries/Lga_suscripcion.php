<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_suscripcion {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('gestion_asociado/suscripcion/lista',$data,true);
        return $list;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Mga_Clientes');
        $cliente = $CI->Mga_Suscripciones->reporte_ficha_cliente($id);
        $data = $cliente[0];
        $res = $CI->parser->parse('gestion_asociado/suscripcion/edit_form', $data, true);

        return $res;
    }



}

?>
