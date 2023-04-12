<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_pago extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mga_Pagos');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_pago');
        $content = $CI->lga_pago->add_form();
        $this->template->full_admin_html_view($content);
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_pago');
        $content = $CI->lga_pago->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lga_pago');
        $CI->load->model('Mga_Pagos');
        $content =$this->lga_pago->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mga_Pagos');
        $postData = $this->input->post();
        $data = $this->Mga_Pagos->getList($postData);
        echo json_encode($data);
    }

    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Pagos');
        $CI->load->library('pdfgenerator');

        $cliente = $CI->Mga_Pagos->reporte_ficha_cliente($id);
        $pago = $CI->Mga_Pagos->reporte_pago($id);
        $data = array(
            'cliente'  => $cliente,
            'pagos'  => $pago,
            'id' => $cliente[0]['id'],
            'fotografia' => $cliente[0]['fotografia']
        );

        $content = $this->parser->parse('gestion_asociado/pago/ficha_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('ficha_pago'.$id, array("Attachment"=>1));
    }

    //DataTables
    public function dataTable($postData=null){
        $idP = $_POST["idP"];

        $postData = $this->input->post();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value


        ## Search
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (
            codigo like '%".$searchValue."%' 
            or DATE_FORMAT(fecha, '%d-%m-%Y') like'%".$searchValue."%')";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_pago gp');
        $this->db->join('ga_suscripcion gs','gs.id = gp.id_suscripcion','left');
        $this->db->where('gp.id_suscripcion', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_pago gp');
        $this->db->join('ga_suscripcion gs','gs.id = gp.id_suscripcion','left');
        $this->db->where('gp.id_suscripcion', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('gp.*, DATE_FORMAT(gp.fecha, "%d-%m-%Y") as fecha_formato, gs.pagada pagada');
        $this->db->from('ga_pago gp');
        $this->db->join('ga_suscripcion gs','gs.id = gp.id_suscripcion','left');
        $this->db->where('gp.id_suscripcion', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_gestion_asociado_pago','delete')->access()) {
                if ($record->pagada != 1){
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
                }
            }
            /*$button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Editar "><i class="fa fa-pencil" aria-hidden="true"></i></a>';*/

            $button .=' <a href="'. base_url() .'Cga_pago/print_recibo/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title="Imprimir" target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'codigo'   =>$record->codigo,
                'fecha'   =>$record->fecha_formato,
                'importe_pagado'   =>$record->importe_pagado,
                'button'   =>$button,
            );
        }

        /*echo "<pre>";
        print_r($data);
        exit;*/

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        echo json_encode($response);
    }

    public function modal_edit(){
        $this->load->model('Mga_Pagos');
        $id = $_GET['id'];
        $type = $_GET['type'];
        if($type == 'update'){
            $data['item'] = $this->Mga_Pagos->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
            $data['costo_certificado'] = $_GET['costo'];
        }
        //echo "<pre>"; print_r($data); exit;
        $this->load->view('gestion_asociado/pago/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');
        $id_suscripcion = $this->input->post('item')['id_suscripcion'];

        //Preconfiguración de valores
        //Get current date
        $data['fecha'] = date('Y-m-d');

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('ga_pago', $data);
        }else{
            //Get current correlative
            $correlativo = $this->db->get_where("ga_correlativo",array('nombre' => 'pago'))->row_array();
            $data['codigo'] = $correlativo['formato']. str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

            $this->db->insert('ga_pago', $data);

            //Update correlative
            $correlativo['numero'] = $correlativo['numero'] + 1;
            $actualizar_correlativo = array(
                'numero' => $correlativo['numero']
            );

            $this->db->update('ga_correlativo', $actualizar_correlativo, 'nombre = "pago"');
        }

        // Generamos el codigo de socio y certificado
        //1. Preguntamos si el monto ya se pago
        $suscripcion_pagada = $this->db->get_where("ga_suscripcion",array('id' => $id_suscripcion))->row_array();
        if (!$suscripcion_pagada['pagada']){
            //2. Preguntamos si el cliente es socio
            $cliente_socio = $this->db->get_where("ga_cliente",array('id' => $suscripcion_pagada['id_cliente']))->row_array();
            if (!$cliente_socio['codigo_socio']) {
                //3. Si no es ninguno de los dos creamos un nuevo socio
                $correlativo_socio = $this->db->get_where("ga_correlativo",array('nombre' => 'socio'))->row_array();
                $socio = array(
                    'tipo_socio' => 'Nuevo',
                    'fecha_socio' => date('Y-m-d'),
                    'codigo_socio' => $correlativo_socio['formato']. str_pad($correlativo_socio['numero'], 5, '0', STR_PAD_LEFT)

                );
                $this->db->update('ga_cliente', $socio, 'id ='. $suscripcion_pagada['id_cliente']);
                //Update correlative
                $correlativo_socio['numero'] = $correlativo_socio['numero'] + 1;
                $actualizar_correlativo_socio = array(
                    'numero' => $correlativo_socio['numero']
                );
                $this->db->update('ga_correlativo', $actualizar_correlativo_socio, 'nombre = "socio"');
            }


            //4. Verificamos si la suscripcion ya fue pagada
            $valor_certificado = $this->db->get("ga_valor_certificado")->row()->monto;

            $this->db->select_sum('importe_pagado');
            $this->db->from('ga_pago');
            $this->db->where('id_suscripcion',$id_suscripcion);
            $importe_pagado = $this->db->get()->row()->importe_pagado;
            if ($valor_certificado == $importe_pagado){
                //5. Si la suscripción ya fue pagada en su totalidad
                $correlativo_certificado = $this->db->get_where("ga_correlativo",array('nombre' => 'certificado'))->row_array();
                $certificado = array(
                    'id_suscripcion' => $id_suscripcion,
                    'estado' => 'Generado',
                    'fecha' => date('Y-m-d'),
                    'codigo' => $correlativo_certificado['formato']. str_pad($correlativo_certificado['numero'], 5, '0', STR_PAD_LEFT)

                );
                $this->db->insert('ga_certificado', $certificado);
                //Update correlative
                $correlativo_certificado['numero'] = $correlativo_certificado['numero'] + 1;
                $actualizar_correlativo_certificado = array(
                    'numero' => $correlativo_certificado['numero']
                );
                $this->db->update('ga_correlativo', $actualizar_correlativo_certificado, 'nombre = "certificado"');

                //Cambiamos el estado del certificado
                $certificado_pagado = array(
                    'pagada' => 1
                );
                $this->db->update('ga_suscripcion', $certificado_pagado, 'id =' . $id_suscripcion);
            }
        }
        echo 1;
    }

    public function delete(){
        $this->db->db_debug = FALSE;
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('ga_pago');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    public function print_recibo($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Pagos');
        $CI->load->library('pdfgenerator');

        $pago = $CI->Mga_Pagos->recibo_pago($id);
        $data = array(
            'pagos'  => $pago,
            'importe_pagado'  => $pago[0]['importe_pagado'],

        );

        $content = $this->parser->parse('gestion_asociado/pago/recibo_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('recibo_pago'.$id, array("Attachment"=>1));
    }

    public function monto_pagado(){
        $id = $_GET['id'];
        $this->db->select_sum('importe_pagado');
        $this->db->from('ga_pago');
        $this->db->where('id_suscripcion',$id);
        echo $this->db->get()->row()->importe_pagado;
    }
}
