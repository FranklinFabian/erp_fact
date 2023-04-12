<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmcajachica_administracion {
    public function edit_data() {
        $CI = & get_instance();
        $CI->load->model('Mcajachica_Cuenta');
        $CI->load->model('Mcajachica_Solicitante');
        $data['cuentas'] = $CI->Mcajachica_Cuenta->list_cuentas();
        $data['solicitantes'] = $CI->Mcajachica_Solicitante->list_solicitantes();
    
        if ($data['cuentas'] != "") {
            array_push($data['cuentas'], array(
                    "id" => ' ',
                    "nombre" => 'Todos',
            ));
        }

        if ($data['solicitantes'] != "") {
            array_push($data['solicitantes'], array(
                "id" => ' ',
                "nombre" => 'Todos',
            ));
        }
                
        $res = $CI->parser->parse('modulo_cajachica/administracion/index', $data, true);
        return $res;
    }

}

?>
