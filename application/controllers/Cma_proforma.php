<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_proforma extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Proformas');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_proforma');
        $content = $CI->lma_proforma->add_form();
        $this->template->full_admin_html_view($content);
    }


    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_proforma');
        $this->load->model('Ma_Fact_cliente');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'proforma'))->row_array();
        $correlativo_formateado = $correlativo['formato'] . str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cliente = $this->input->post("id_cliente[]");
        $cliente = $cliente[0];
      //  print_r($cliente);exit();
        $cabecera_proforma = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha,
            'id_cliente' => $cliente,
            'estado' => 'P'
        );

        $this->db->insert('almacen_proforma', $cabecera_proforma);
        $id_cabecera_cotizacion = $this->db->insert_id();

        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $actualizar_correlativo, 'nombre = "proforma"');

        //$id_proveedor = $this->input->post('id_proveedor');

        $id_cliente = $this->input->post('id_cliente');
        $id_articulo = $this->input->post('id_articulo');
        $costo = $this->input->post('costo');
        $cantidad = $this->input->post('cantidad');
        $total = $this->input->post('total');

        // Vueltas
        $vueltas = count($this->input->post('id_articulo'));

        for ($i = 0; $i < $vueltas; $i++) {
            //$id_clientes = $id_cliente[$i];
            $id_articulos = $id_articulo[$i];
            // $id_proveedores = $id_proveedor[$i];
            $costos = $costo[$i];
            $cantidades = $cantidad[$i];
            $totales = $total[$i];

            $proforma = array(
                'id_proforma'    => $id_cabecera_cotizacion,
                // 'id_proveedor'    => $id_proveedores,
                //'id_cliente'    => $id_clientes,
                'id_articulo'    => $id_articulos,
                'costo' => $costos,
                'cantidad' => $cantidades,
                'total' => $totales
            );

            $this->db->insert('almacen_proforma_items', $proforma);
        }


        if (isset($_POST['add'])) {
            redirect(base_url('Cma_proforma/administrar'));
            exit;
        } elseif (isset($_POST['add-another'])) {
            redirect(base_url('Cma_proforma'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_proforma');
        $content = $CI->lma_proforma->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Proformas');

        $id = $this->input->post('id');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera_proforma = array(
            'fecha'    => $fecha,
        );

        $this->db->update('almacen_proforma', $cabecera_proforma, "id =". $id);

        //Proforma

        $this->db->delete('almacen_proforma_items', array('id_proforma' => $id));

        //$id_proveedor = $this->input->post('id_proveedor');
        $id_cliente = $this->input->post('id_cliente');
        $id_articulo = $this->input->post('id_articulo');
        $costo = $this->input->post('costo');
        $cantidad = $this->input->post('cantidad');
        $total = $this->input->post('total');

        // Vueltas
        $vueltas = count($this->input->post('id_articulo'));

        for ($i = 0; $i < $vueltas; $i++) {
           // $id_proveedores = $id_proveedor[$i];
            //$id_clientes = $id_cliente[$i];
            $id_articulos = $id_articulo[$i];
            $costos = $costo[$i];
            $cantidades = $cantidad[$i];
            $totales = $total[$i];

            $proforma = array(
                'id_proforma'    => $id,
                //'id_proveedor'    => $id_proveedores,
               // 'id_cliente'    => $id_clientes,
                'id_articulo'    => $id_articulos,
                'costo' => $costos,
                'cantidad' => $cantidades,
                'total' => $totales
            );

            $this->db->insert('almacen_proforma_items', $proforma);
        }

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_proforma/administrar'));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lma_proforma');
        $CI->load->model('Ma_proformas');
        $content =$this->lma_proforma->list();

        $this->template->full_admin_html_view($content);
    }

    // DataTables
    public function dataList(){
        // GET data
        $this->load->model('Ma_Proformas');
        $postData = $this->input->post();
        $data = $this->Ma_Proformas->getList($postData);
        echo json_encode($data);
    }

    // Delete
    public function delete($id) {
        $CI = & get_instance();
        $this->auth->check_admin_auth();
        $CI->load->model('Ma_Proformas');
        $CI->Ma_Proformas->delete($id);
        redirect(base_url('Cma_proforma/administrar'));
    }

    // Print

    public function print_proforma($id) {
        $CI = & get_instance();
        $CI->load->model('Ma_Proformas');

        // Cargar la librería TCPDF
        $CI->load->library('tcpdf');

        // Obtener los datos de la cabecera
        $cabecera = $CI->Ma_Proformas->retrieve_print_proforma($id);
        $cuerpo = $CI->Ma_Proformas->retrieve_print_proforma_items($id);

        $data = array(
            'cabecera' => $cabecera,
            'detalles' => $cuerpo,
        );

        $content = $CI->parser->parse('almacen/proforma/cotizacion_pdf', $data, true);

// Configurar las opciones de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Almacen Proforma ' . $id);
        $pdf->SetSubject('Almacen Proforma ' . $id);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

// Limpiar cualquier contenido previo
        ob_clean();

// Agregar el contenido al PDF
        $pdf->writeHTML($content, true, false, true, false, '');

// Generar el PDF y descargarlo
        $pdf->Output('almacen_proforma_' . $id . '.pdf', 'D');
    }


    //Cotizaciones Individuales

    public function print_proforma_individual($id_cotizacion, $id_proveedor){
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





    public function json_form($id){
        $CI = & get_instance();
        $us = $this->auth->check_admin_auth();
        $CI->load->model('Ma_Proformas');
        $items = $CI->Ma_Proformas->lista_items($id);
        //print_r($items);exit();
        $totaldetails = [];
        $amount =0;
        $idcliente = '';
        $idusuario = '';
        for ($i = 0; $i < count($items); $i++) {
            $details = array(
                "sin_activity_code" => 351000,
                "sin_product_code"=> 99100,
                "description"=>$items[$i]['nombre'],
                "quantity"=>  $items[$i]['cantidad'],
                "sin_measure_unit_code"=> 47,
                "unit_price"=> $items[$i]['costo'],
                "discount"=> 0,
                "subtotal"=>$items[$i]['total']
            );
            $totaldetails[] = $details ;
            $amount += $items[$i]['total'];
            $idcliente = $items[$i]['id_cliente'];
            $idusuario = $items[$i]['id_usuario'];
        }
        //print_r($idcliente);exit();
        $cliente = $CI->Ma_Proformas->lista_cliente($idcliente);
        $usuario = $CI->Ma_Proformas->lista_usuario($idusuario);
        //print_r($cliente);exit();


        $product = ($details);

        $details = (array($product,$product));

        $invoices = array (
            "date_of_issue"=> str_replace(' ', 'T', date('Y-m-d H:i:s.v')),

            "sin_identity_document_type_code"=> "1",
            "business_name"=> $cliente[0]['razon_social'],
            "document_number"=> $cliente[0]['ci'],
            "complement"=> $cliente[0]['complemento'],
            "client_code"=>$cliente[0]['ci'],
            "email"=> $cliente[0]['correo'],
            "address"=> "this is my home address",

            "sin_payment_method_code"=> 1,
            "card_number"=> null,
            "sin_currency_type_code"=> 1,
            "exchange_rate"=> 1,

            "total_amount"=> $amount,
            "total_amount_iva"=> $amount,
            "total_amount_currency"=>$amount,

            "additional_discount"=> 0,
            "gift_card_amount"=> 0,
            "exception_code"=> null,
            "user"=> $usuario[0]['first_name'],

            "details"=>$totaldetails,
        );
        $invoices_array = array($invoices);
        $json = array (
            "sin_sector_document_type_code"=>  1,
            "invoices"=> $invoices_array,
        );
        echo json_encode($json);

        $data = json_encode($json);
        $url = "https://facturacion.progreso-cgroup.com/api/invoices/online?point_of_sale_id=1";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecución de la petición y obtención de la respuesta
        $response = curl_exec($ch);

// Cierre de la conexión curl
        curl_close($ch);

// Imprimir la respuesta recibida
        echo $response;

    }



}
