<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Comprobantes extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    // $this->auth->check_admin_auth();
    $this->load->library('numberstowords');
    $this->breadcrumb->add('Comprobantes', base_url('cofi/comprobantes'));
  }

  # routes
  public function index() {
    $data = [
      'comprobantes' => $this->cofiModel->getComprobantes($this->EMPRESA_GESTION_ID),
      'comprobantes_tipos' => $this->cofiModel->getComprobantesTipos(),
    ];

    $content = $this->parser->parse('cofi/comprobantes/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function anulados() {
    $data = [
      'comprobantes' => $this->cofiModel->getComprobantesAnulados($this->EMPRESA_GESTION_ID),
      'comprobantes_tipos' => $this->cofiModel->getComprobantesTipos(),
    ];
    $this->breadcrumb->add('Comprobantes Anulados', '#');
    $content = $this->parser->parse('cofi/comprobantes/anulados', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function crear() {
    $data = [
      'comprobantes_tipos' => $this->cofiModel->getComprobantesTipos(),
      'cuentas_finales' => $this->cofiModel->getCuentasFinales($this->EMPRESA_GESTION_ID),
      'monedas' => $this->cofiModel->getMonedas(),
      'plantillas' => $this->cofiModel->getPlantillasByGestionEmpresa(),
    ];

    $this->breadcrumb->add('Registrar Comprobante', '#');
    $content = $this->parser->parse('cofi/comprobantes/formulario', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function editar() {
    $comprobante_id = base64_decode($_GET['id']);

    $data = [
      'comprobantes_tipos' => $this->cofiModel->getComprobantesTipos(),
      'cuentas_finales' => $this->cofiModel->getCuentasFinales($this->EMPRESA_GESTION_ID),
      'monedas' => $this->cofiModel->getMonedas(),
      'plantillas' => $this->cofiModel->getPlantillasByGestionEmpresa(),
      'comprobante_id' => $comprobante_id,
      'comprobante' => (array) $this->cofiModel->getComprobanteById($comprobante_id),
      'comprobante_data' => $this->cofiModel->getComprobanteDataByIdComprobante($comprobante_id),
    ];

    $this->breadcrumb->add('Editar Comprobante', '#');
    $content = $this->parser->parse('cofi/comprobantes/formulario', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function pdf() {
    $comprobante_id = base64_decode($_GET['id']);

    $data = [
      'comprobante' => (array) $this->cofiModel->getComprobanteById($comprobante_id),
      'comprobante_data' => $this->cofiModel->getComprobanteDataByIdComprobante($comprobante_id),
    ];

    $content = $this->parser->parse('cofi/comprobantes/reportes/comprobantePdf', $data, true);
    $this->load->library('pdf');
    $this->dompdf->loadHtml(utf8_decode($content));
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = $canvas->get_width() - 125;
    $y = 38.5;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Comprobante de " . $data['comprobante']['comprobante_tipo_nombre'] . ' Nro. ' . numero_comprobante($comprobante_id) . ".pdf", array("Attachment" => 0));
  }
  public function configuraciones() {
    $this->breadcrumb->add('Configuraciones', '#');
    $content = $this->parser->parse('cofi/comprobantes/formulario_configuraciones', [], true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function obtener_numero_comprobante($comprobante_tipo_id) {
    $comprobante_tipo = $this->cofiModel->getComprobantesTiposById($comprobante_tipo_id);
    $correlativo = get_correlativo_comprobante($comprobante_tipo_id);
    $cantidad_digitos = comprobantes_parametros('cantidad_digitos');

    echo json_encode([
      'status' => true,
      'data' => $comprobante_tipo->nombre . ' N°. ' . str_pad($correlativo, $cantidad_digitos, '0', STR_PAD_LEFT)
    ]);
    exit;
  }
  public function registrar() {
    $data = $this->input->post('data');
    $data['created_by'] = $this->session->userdata('user_id');
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['idGestionEmpresa'] = $this->EMPRESA_GESTION_ID;
    $data['correlativo'] = get_correlativo_comprobante($data['comprobante_tipo_id']);

    # REGISTRAR COMPROBANTE
    $comprobante_id = $this->cofiModel->registrarComprobante($data);

    # ACTUALIZAR CORRELATIVO COMPROBANTE
    increase_correlativo_comprobante($data['comprobante_tipo_id']);

    # GUARDANDO COMPROBANTE DATA ( lista tabla ) EN: -> 'datacomprobantes'
    $comprobante_data = $this->input->post('dataComprobante');
    foreach ($comprobante_data as $comp_data) {
      $comp_data['comprobante_id'] = $comprobante_id;
      $this->cofiModel->registrarComprobanteData($comp_data);
    }

    echo json_encode($comprobante_id);
    exit;
  }
  public function actualizar($id) {
    $data = $this->input->post('data');
    $data['updated_by'] = $this->session->userdata('user_id');
    $data['updated_at'] = date('Y-m-d H:i:s');

    # ACTUALIZAR COMPROBANTE
    $this->cofiModel->actualizarComprobanteById($data, $id);

    # ACTUALIZAR COMPROBANTE DATA
    $comprobante_data = $this->input->post('dataComprobante');
    # ELIMINAR DATOS ANTIGUOS
    $this->cofiModel->eliminarComprobanteDataByIdComprobante($id);
    # REGISTRAR COMPROBANTE DATA
    foreach ($comprobante_data as $compo_data) {
      $compo_data['comprobante_id'] = $id;
      $this->cofiModel->registrarComprobanteData($compo_data);
    }

    echo json_encode($id);
    exit;
  }
  public function anular($id) {
    $motivo = $this->input->post('motivo');
    $data['anulado'] = 1;
    $data['motivo_anulado'] = $motivo;
    $data['canceled_by'] = $this->session->userdata('user_id');
    $data['canceled_at'] = date('Y-m-d H:i:s');
    $this->cofiModel->anularComprobante($data, $id);
  }
  public function registrar_configuraciones() {
    $dataUp['cantidad_digitos'] = $_POST['cd'];
    $dataUp['numero_firmas'] = $_POST['nc'];
    $dataParamComp = json_decode($_POST['dataPC'], true);
    $i = 1;
    $names = [1 => 'uno', 2 => 'dos', 3 => 'tres', 4 => 'cuatro', 5 => 'cinco', 6 => 'seis'];
    foreach ($dataParamComp as $pc) {
      $dataUp['cargo_firma_' . $names[$i]] = $pc['cargo'];
      $dataUp['nombre_firma_' . $names[$i]] = $pc['nombre'];
      $i++;
    }
    if ($this->cofiModel->actualizarComprobantesParametrosByIdGestionEmpresa($dataUp, $this->EMPRESA_GESTION_ID))
      echo "SI";
    else echo "NO";
  }

  # local functions

}
