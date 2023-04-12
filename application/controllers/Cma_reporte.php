<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_reporte extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Reportes');
        $this->load->library('lma_reporte');
    }


    public function inventario_fisico() {
        $content = $this->lma_reporte->add_form_inventario_fisico();
        $this->template->full_admin_html_view($content);
    }

    public function kardex_general() {
        $content = $this->lma_reporte->add_form_kardex_general();
        $this->template->full_admin_html_view($content);
    }

    public function salida_almacen() {
        $content = $this->lma_reporte->add_form_salida_almacen();
        $this->template->full_admin_html_view($content);
    }


    public function inventario_fisico_pdf(){
        $CI = & get_instance();
        $CI->load->model('Ma_Reportes');
        $this->load->model('Ma_Grupos');
        $CI->load->library('pdfgenerator');

        //Conversiones de fecha
        /*$date_inicio = new DateTime($this->input->post('fec_inicio'));
        $fecha_inicio = $date_inicio->format('Y-m-d');

        $date_fin = new DateTime($this->input->post('fec_fin'));
        $fecha_fin = $date_fin->format('Y-m-d');*/


        $detalles = $CI->Ma_Reportes->inventario_fisico();
        $grupos = $CI->Ma_Grupos->list();

        $data = array(
            'detalles'  => $detalles,
            'grupos'  => $grupos
        );

        /*echo "<pre>";
        print_r($data); exit;*/

        $content = $this->parser->parse('almacen/reporte/inventario_fisico_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('inventario_fisico_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

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
        $pdf->stream('kardex_general_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

    }

    public function salida_almacen_pdf(){
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

        $detalle = $CI->Ma_Reportes->salida_almacen($fecha_inicio, $fecha_fin);

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

        $data = array(
            'detalles'  => $detalle,
            'cuentas'  => $cuentas,
            'fecha_inicio' => $this->input->post('fec_inicio'),
            'fecha_fin' => $this->input->post('fec_fin')
        );

        $content = $this->parser->parse('almacen/reporte/salida_almacen_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('salida_almacen_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));
    }





}
