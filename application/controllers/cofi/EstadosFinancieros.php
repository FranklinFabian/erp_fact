<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class EstadosFinancieros extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Estados Financieros', base_url('cofi/estadosFinancieros'));
  }

  # routes
  public function index() {
    $data = [
      'cuentas_tipos' => $this->cofiModel->getCuentasTipos(),
    ];

    $content = $this->parser->parse('cofi/estadosFinancieros/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  # -- Balance sumas y saldos
  public function balance_sumas_saldos_pdf() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataBalanceSumasSaldos = $this->cofiModel->getDataBalanceSumasSaldos($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/balanceSumasSaldos.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = 28;
    $y = $canvas->get_height() - 33;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Balance de Sumas y Saldos - del " . $fechaInicial . " al " . $fechaFinal . " - generado el " . date('d-m-Y H:i:s') . ".pdf", array("Attachment" => 0));
  }
  public function balance_sumas_saldos_excel() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataBalanceSumasSaldos = $this->cofiModel->getDataBalanceSumasSaldos($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/balanceSumasSaldos.php');
    $tipo       = 'excel';
    $extension  = '.xls';
    $nombreExt  = 'Balance de Sumas y Saldo - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . $extension;
    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=$nombreExt");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo utf8_decode($html);
  }
  # -- Balance general
  public function balance_general_pdf() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataBalanceGeneral = $this->cofiModel->getDataBalanceGeneral($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/balanceGeneral.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = 28;
    $y = $canvas->get_height() - 33;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Balance General - del " . $fechaInicial . " al " . $fechaFinal . " - generado el " . date('d-m-Y H:i:s') . ".pdf", array("Attachment" => 0));
  }
  public function balance_general_excel() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataBalanceGeneral = $this->cofiModel->getDataBalanceGeneral($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/balanceGeneral.php');
    # header para exportar en excel
    $tipo       = 'excel';
    $extension  = '.xls';
    $nombreExt  = 'Balance General - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . $extension;
    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=$nombreExt");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo utf8_decode($html);
  }
  # -- Estado de resultados
  public function estado_resultados_pdf() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataEstadoResultados = $this->cofiModel->getDataEstadoResultados($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/estadoResultados.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $canvas = $this->dompdf->get_canvas();
    $x = 28;
    $y = $canvas->get_height() - 33;
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";
    $font = null;
    $size = 9.5;
    $color = array(0, 0, 0);
    $word_space = 0.0;
    $char_space = 0.0;
    $angle = 0.0;
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    $this->dompdf->stream("Estado de Resultados - del " . $fechaInicial . " al " . $fechaFinal . " - generado el " . date('d-m-Y H:i:s') . ".pdf", array("Attachment" => 0));
  }
  public function estado_resultados_excel() {
    list($fei, $fef, $nc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $dataEstadoResultados = $this->cofiModel->getDataEstadoResultados($fei, $fef, $nc, $this->EMPRESA_GESTION_ID);
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/estadoResultados.php');
    $tipo       = 'excel';
    $extension  = '.xls';
    $nombreExt  = 'Estado de Resultados - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . $extension;
    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=$nombreExt");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo utf8_decode($html);
  }

  # **** Estados de Cuentas ****
  public function estado_cuentas() {
    $data = [
      'listaCuentasGE' => $this->cofiModel->getCuentas($this->EMPRESA_GESTION_ID),
    ];

    $this->breadcrumb->add('Estado de Cuentas', '#');
    $content = $this->parser->parse('cofi/estadosFinancieros/estado_cuentas/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function estado_cuentas_pdf(){
    list($fei, $fef, $idc, $tpm) = explode('/', base64_decode($_GET['dt']));
    $data_cuenta        = $this->cofiModel->getCuentaById($idc);
    $dataEstadoCuentas  = $this->cofiModel->getDataEstadoCuentas($fei, $fef, $idc, $this->EMPRESA_GESTION_ID);
    $cantEspaciosCuenta = $this->cofiModel->getCuentaTipoById(4)->longitud;
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fei);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fef);
    include('./application/views/cofi/estadosFinancieros/reportes/estadoCuentas.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml(utf8_decode($html));
    $this->dompdf->setPaper('letter'); # tamño carta vertical
    $this->dompdf->render();
    $this->dompdf->stream("Estado de la cuenta " . $data_cuenta->nombre . "(" . $data_cuenta->codigo_formato . ")" . ".pdf", array("Attachment" => 0));
  }

  # **** Balance General y Estado de Resultados Comparativos ****
  public function balance_gral_estado_res_comp() {
    $data = [
      'cuentas_tipos' => $this->cofiModel->getCuentasTipos(),
    ];

    $this->breadcrumb->add('Balance Gral. y Estados de Resultados Comparativos', '#');
    $content = $this->parser->parse('cofi/estadosFinancieros/balance_gral_estado_res_comp/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function balance_gral_estado_res_comp_pdf() {
    list($niCta, $tpm, $tpBal, $mesBal, $gestion) = explode('/', base64_decode($_GET['dt']));
    $dataBalanceGralEstadoResComp = $this->cofiModel->getBalanceGralEstadoResComp($niCta, $tpm, $tpBal, $mesBal, $gestion);
    $listaGruposCuentas = $this->cofiModel->getCuentasGrupos();
    $hastaMes = strtoupper(MONTH_NAMES[str_pad($mesBal, 2, '0', STR_PAD_LEFT)]);
    #print_r($dataBalanceGralEstadoResComp);
    #echo $dataBalanceGralEstadoResComp[1][1]->nombre;
    #$dataCuentaForm     = $this->cofiModel->getCuentaById($idc);
    #$cantEspaciosCuenta = $this->cofiModel->getCuentaTipoById(4)->longitud;
    #$fechaInicial       = $this->lerp_utilities->convertDateToLiteral($fei);
    #$fechaFinal         = $this->lerp_utilities->convertDateToLiteral($fef);

    include('./application/views/cofi/estadosFinancieros/reportes/balanceGralEstResComp.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml(utf8_decode($html));
    $this->dompdf->setPaper('legal', 'landscape'); # tamño oficio y horizontal
    $this->dompdf->render();
    $this->dompdf->stream("finiquito.pdf", array("Attachment" => 0));
  }

  # functions
  public function verificar_estado_cuentas() {
    $fechaIni = $this->input->post('fechaIni');
    $fechaFin = $this->input->post('fechaFin');
    $cuenta_id = $this->input->post('cuenta_id');
    $tpMoneda = $this->input->post('tpMoneda');
    # Verificando si existe información de los datos proporcionados
    if ($this->cofiModel->verificarRegistrosCuentaById($fechaIni, $fechaFin, $cuenta_id, $this->EMPRESA_GESTION_ID)) {
      $mGET = '?dt=' . base64_encode($fechaIni . '/' . $fechaFin . '/' . $cuenta_id . '/' . $tpMoneda);
      echo base_url('cofi/estadosFinancieros/estado_cuentas_pdf/') . $mGET;
    } else {
      echo "NO"; # caso cuando no existen registros de la cuenta seleccionada
    }
  }

  # local functions

}
