<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_depreciar extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mactivos_Depreciar');
        $this->load->library('lmactivos_depreciar');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }


    public function index() {
        $content = $this->lmactivos_depreciar->add_form();
        $this->template->full_admin_html_view($content);
    }

    public function depreciar(){
        // Obtenemos todos los activos.
        $lista_activos = $this->Mactivos_Depreciar->lista_activos();
        if($lista_activos){
            foreach ($lista_activos as $lista){
                // Obtenemos la lista de Ufvs a portir de una fecha especifica.
                $ufvs = $this->Mactivos_Depreciar->lista_ufv($lista->fecha_depreciacion);
                $valor_inicial = $lista->valor_actualizado;
                $ufv_inicial = $lista->ufv_inicial;
                $depreciacion_acumulada = $lista->depreciacion_acumulada;
                $fechainicial = new DateTime($lista->fecha_depreciacion);
                $fechainicial = $fechainicial->sub(new DateInterval('P1D'));
                $valor_neto = $lista->valor_neto;
                $vida_util = $lista->vida_util;
                foreach ($ufvs as $ufv){
                    if ($valor_neto > 1){
                        $ufv_final = $ufv->valor;
                        $fechafinal = new DateTime($ufv->fecha);
                        $diferencia = $fechainicial->diff($fechafinal);
                        $meses_usados = ( $diferencia->y * 12 ) + $diferencia->m;
                        $data['id_activo'] = $lista->id;
                        $data['fecha'] = $ufv->fecha;
                        $data['valor_inicial'] = $valor_inicial;
                        $data['id_ufv'] = $ufv->id;
                        $data['factor'] = ($ufv_final/$ufv_inicial) - 1;
                        $data['incremento_actualizacion'] = $valor_inicial * $data['factor'];
                        $data['valor_actualizado'] = $valor_inicial + $data['incremento_actualizacion'];
                        $data['depreciacion_acumulada'] = $depreciacion_acumulada;
                        $data['aitb_depreciacion_acumulada'] = $data['depreciacion_acumulada'] * $data['factor'];
                        $data['depreciacion_ejercicio'] = (($data['valor_actualizado'] * $lista->coeficiente_depreciacion)/12) * $meses_usados;
                        $data['depreciacion_acumulada_actualizada'] = $data['depreciacion_acumulada'] + $data['aitb_depreciacion_acumulada'] + $data['depreciacion_ejercicio'];
                        if ($data['valor_actualizado'] - $data['depreciacion_acumulada_actualizada'] > 1){
                            $data['valor_neto'] = $data['valor_actualizado'] - $data['depreciacion_acumulada_actualizada'];
                        }else{
                            $data['valor_neto'] = 1;
                        }
                        $data['meses_vida_util'] = $vida_util - $meses_usados;
                        $this->db->insert('activos_depreciacion', $data);

                        //Actualización de Variables del Bucle
                        $valor_inicial = $data['valor_actualizado'];
                        $ufv_inicial = $ufv_final;
                        $depreciacion_acumulada = $data['depreciacion_acumulada_actualizada'];
                        $fechainicial = $fechafinal;
                        $valor_neto = $data['valor_neto'];
                        $vida_util = $data['meses_vida_util'];
                    }
                }

                //Actualización Valores de los Activos Tabla Principal
                $valores_actualizados = array(
                    'valor_actualizado'    => $data['valor_actualizado'],
                    'ufv_inicial'    => $ufv_inicial,
                    'depreciacion_acumulada' => $depreciacion_acumulada,
                    'fecha_depreciacion' => $fechafinal->format('Y-m-d'),
                    'valor_neto' => $valor_neto,
                    'vida_util' => $vida_util
                );

                $this->db->update('activos_registro', $valores_actualizados, "id =". $lista->id);

            }

            $res['msg']= "Depreciación Realizada con Éxito";
            $res['code']= 1;

        }else{

            $res['msg']= "No hay Items Para Depreciar";
            $res['code']= 0;

        }

        echo json_encode($res);

    }

    public function kardex_general_pdf(){
        $CI = & get_instance();
        $CI->load->model('Ma_Reportes');
        $this->load->model('Ma_Cuentas_contables');
        $this->load->model('Ma_Cuentas_auxiliares');
        $CI->load->library('pdfgenerator');

        //Conversiones de fecha
        $date_inicio = new DateTime($this->input->post('fec_inicio'));
        $fecha_inicio = $date_inicio->format('Y-m-d');

        $date_fin = new DateTime($this->input->post('fec_fin'));
        $fecha_fin = $date_fin->format('Y-m-d');

        $tipo = $this->input->post('tipo');

        $detalle = $CI->Ma_Reportes->kardex_general($fecha_inicio, $fecha_fin, $tipo);

        $resumen = $CI->Ma_Reportes->resumen_kardex_general($fecha_inicio, $fecha_fin, $tipo);

        if (!$detalle){
            $cuentas = false;
        }else{
            /* Generacion de array de cuentas contables */
            foreach ($detalle as $data){
                $cuenta_contable[] = $data['id_cuenta_contable'];
            }
            $cuenta_contable_filtrada = $this->Ma_Cuentas_contables->list_filtrada( array_unique($cuenta_contable));

            /* Generacion de array de cuentas auxiliares */

            $contador = 0;
            foreach ( $cuenta_contable_filtrada as $contable) {
                foreach ($detalle as $auxiliar) {
                    if ($contable['id'] == $auxiliar['id_cuenta_contable'] ){
                        $cuentas[$contador]['id'] = $auxiliar['id_cuenta_contable'];
                        $cuentas[$contador]['codigo'] = $contable['codigo'];
                        $cuentas[$contador]['nombre'] = $auxiliar['cuenta_contable'];
                        $cuentas[$contador]['cuenta_auxiliar'][] = $auxiliar['id_cuenta_auxiliar'];
                    }
                }

                $cuentas[$contador]['cuenta_auxiliar'] = $this->Ma_Cuentas_auxiliares->list_filtrada( array_unique($cuentas[$contador]['cuenta_auxiliar']) );
                $contador++;
            }
        }


        /*echo "<pre>";
        var_dump($cuentas);
        exit;*/

        $data = array(
            'detalles'  => $detalle,
            'cuentas'  => $cuentas,
            'resumenes'  => $resumen,
            'fecha_inicio' => $this->input->post('fec_inicio'),
            'fecha_fin' => $this->input->post('fec_fin')
        );

        /*echo "<pre>";
        var_dump($cuentas);
        exit;*/


        $content = $this->parser->parse('almacen/reporte/kardex_general_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('kardex_general_' . date('d/m/Y'), array("Attachment"=>1));

    }







}
