<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_cotizacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Cotizaciones');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_cotizacion');
        $content = $CI->lma_cotizacion->add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insertar
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_cotizacion');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'cotizacion'))->row_array();
        $correlativo_formateado = $correlativo['formato'] . str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera_cotizacion = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha
        );

        $this->db->insert('almacen_cabecera_cotizacion', $cabecera_cotizacion);
        $id_cabecera_cotizacion = $this->db->insert_id();

        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $actualizar_correlativo, 'nombre = "cotizacion"');

        $id_proveedor = $this->input->post('id_proveedor');
        $id_articulo = $this->input->post('id_articulo');
        $costo = $this->input->post('costo');
        $cantidad = $this->input->post('cantidad');

        // Vueltas
        $vueltas = count($this->input->post('id_articulo'));

        for ($i = 0; $i < $vueltas; $i++) {
            $id_articulos = $id_articulo[$i];
            $id_proveedores = $id_proveedor[$i];
            $costos = $costo[$i];
            $cantidades = $cantidad[$i];

            $cotizacion = array(
                'id_cabecera_cotizacion'    => $id_cabecera_cotizacion,
                'id_proveedor'    => $id_proveedores,
                'id_articulo'    => $id_articulos,
                'costo' => $costos,
                'cantidad' => $cantidades
            );

            $this->db->insert('almacen_cotizacion', $cotizacion);
        }


        if (isset($_POST['add'])) {
            redirect(base_url('Cma_cotizacion/administrar'));
            exit;
        } elseif (isset($_POST['add-another'])) {
            redirect(base_url('Cma_cotizacion'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_cotizacion');
        $content = $CI->lma_cotizacion->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Cotizaciones');

        $id = $this->input->post('id');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera_cotizacion = array(
            'fecha'    => $fecha,
        );

        $this->db->update('almacen_cabecera_cotizacion', $cabecera_cotizacion, "id =". $id);

        //Cotización

        $this->db->delete('almacen_cotizacion', array('id_cabecera_cotizacion' => $id));

        $id_proveedor = $this->input->post('id_proveedor');
        $id_articulo = $this->input->post('id_articulo');
        $costo = $this->input->post('costo');
        $cantidad = $this->input->post('cantidad');

        // Vueltas
        $vueltas = count($this->input->post('id_articulo'));

        for ($i = 0; $i < $vueltas; $i++) {
            $id_proveedores = $id_proveedor[$i];
            $id_articulos = $id_articulo[$i];
            $costos = $costo[$i];
            $cantidades = $cantidad[$i];

            $cotizacion = array(
                'id_cabecera_cotizacion'    => $id,
                'id_proveedor'    => $id_proveedores,
                'id_articulo'    => $id_articulos,
                'costo' => $costos,
                'cantidad' => $cantidades
            );

            $this->db->insert('almacen_cotizacion', $cotizacion);
        }

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_cotizacion/administrar'));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lma_cotizacion');
        $CI->load->model('Ma_Cotizaciones');
        $content =$this->lma_cotizacion->list();

        $this->template->full_admin_html_view($content);
    }

    // DataTables
    public function dataList(){
        // GET data
        $this->load->model('Ma_Cotizaciones');
        $postData = $this->input->post();
        $data = $this->Ma_Cotizaciones->getList($postData);
        echo json_encode($data);
    }

    // Delete
    public function delete($id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Ma_Cotizaciones');
        $CI->Ma_Cotizaciones->delete($id);
        redirect(base_url('Cma_cotizacion/administrar'));
    }

    // Print
    public function print_cotizacion($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Cotizaciones');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Ma_Cotizaciones->cabecera_proforma($id);
        $cotizacion = $CI->Ma_Cotizaciones->proforma($id);
        $proveedores = $CI->Ma_Cotizaciones->proveedores($id);
        $proveedores_totales = $CI->Ma_Cotizaciones->proveedores_totales($id);
        $costos = $CI->Ma_Cotizaciones->costos($id);

        /*echo "<pre>";
        print_r($proveedores);
        exit;*/

        $data = array(
            'title'         => 'Cotización',
            'cabecera'  => $cabecera,
            'proveedores'  => $proveedores,
            'proveedores_totales'  => $proveedores_totales,
            'costos'  => $costos,
            'cotizaciones'  => $cotizacion,
            'n' => 1
        );
        /*echo "<pre>";
        print_r($data); exit;*/

        $content = $this->parser->parse('almacen/cotizacion/cotizacion_pdf', $data, true);
        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->set_paper('letter', 'landscape');
        $dompdf->render();
        $dompdf->stream('almacen_cotizacion_'.$id, array("Attachment"=>1));
    }

    //Cotizaciones Individuales

    public function print_cotizacion_individual($id_cotizacion, $id_proveedor){
        $CI = & get_instance();
        $CI->load->model('Ma_Cotizaciones');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Ma_Cotizaciones->cabecera_cotizacion($id_cotizacion, $id_proveedor);
        $cuerpo = $CI->Ma_Cotizaciones->cuerpo_cotizacion($id_cotizacion, $id_proveedor);

        $data = array(
            'cabecera'  => $cabecera,
            'cuerpos'  => $cuerpo
        );

        $content = $this->parser->parse('almacen/cotizacion/cotizacion_individual_pdf', $data, true);
        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->set_paper('letter', 'portrait');
        $dompdf->render();
        $dompdf->stream('almacen_cotizacion_'.$id_cotizacion.'_'.$id_proveedor, array("Attachment"=>1));
    }

}
