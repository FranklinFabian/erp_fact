<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Libros extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Libros', base_url('cofi/libros'));
  }

  # routes
  public function index() {
    redirect(base_url('cofi/libros/diario'));
  }
  public function diario() {
    $data = [
      'monedas' => $this->cofiModel->getMonedas(),
      'listaTipoComprobantes' => $this->cofiModel->getComprobantesTipos(),
    ];

    $this->breadcrumb->add('Libro Diario', '#');
    $content = $this->parser->parse('cofi/libros/diario/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function diario_pdf() {
    list($fechaIni, $fechaFin, $comprobante_tipo_id, $tipoMoneda) = explode('/', base64_decode($_GET['dt']));
    list($comprobantesLibroDiario, $fechaInicial, $fechaFinal) = $this->calcularDataLibroDiario($fechaIni, $fechaFin, $comprobante_tipo_id);
    include('./application/views/cofi/libros/reportes/libroDiario.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    if ($tipoMoneda != 6) $this->dompdf->setPaper('letter');
    else $this->dompdf->setPaper('letter', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream('Libro Diario - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . '.pdf', array("Attachment" => 0));
  }
  public function diario_excel() {
    list($fechaIni, $fechaFin, $comprobante_tipo_id, $tipoMoneda) = explode('/', base64_decode($_GET['dt']));
    list($comprobantesLibroDiario, $fechaInicial, $fechaFinal) = $this->calcularDataLibroDiario($fechaIni, $fechaFin, $comprobante_tipo_id);
    include('./application/views/cofi/libros/reportes/libroDiario.php');
    $tipo       = 'excel';
    $extension  = '.xls';
    $nombreExt  = 'Libro Diario - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . $extension;
    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=$nombreExt");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $html;
  }

  public function mayor() {
    $data = [
      'monedas' => $this->cofiModel->getMonedas(),
      'listaCuentasFinalesGE' => $this->cofiModel->getCuentasFinales($this->EMPRESA_GESTION_ID),
    ];

    $this->breadcrumb->add('Libro Mayor', '#');
    $content = $this->parser->parse('cofi/libros/mayor/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function mayor_pdf(){
    list($codCuentaDesde, $codCuentaHasta, $fechaIni, $fechaFin, $tipoMoneda) = explode('/', base64_decode($_GET['dt']));
    list($dataCuentasLibroMayor, $fechaInicial, $fechaFinal) = $this->calcularDataLibroMayor($codCuentaDesde, $codCuentaHasta, $fechaIni, $fechaFin, $tipoMoneda);
    include('./application/views/cofi/libros/reportes/libroMayor.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml(utf8_decode($html));
    if ($tipoMoneda == 6) $this->dompdf->setPaper('legal', 'landscape');
    else $this->dompdf->setPaper('letter', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Libro Mayor - desde " . $codCuentaDesde . " hasta - " . $codCuentaHasta . " - del " . $fechaInicial . " al " . $fechaFinal . " - generado el " . date('d-m-Y H:i:s') . ".pdf", array("Attachment" => 0));
  }
  public function mayor_excel() {
    list($codCuentaDesde, $codCuentaHasta, $fechaIni, $fechaFin, $tipoMoneda) = explode('/', base64_decode($_GET['dt']));
    list($dataCuentasLibroMayor, $fechaInicial, $fechaFinal) = $this->calcularDataLibroMayor($codCuentaDesde, $codCuentaHasta, $fechaIni, $fechaFin, $tipoMoneda);
    include('./application/views/cofi/libros/reportes/libroMayor.php');
    $tipo       = 'excel';
    $extension  = '.xls';
    $nombreExt  = 'Libro Mayor - ' . $codCuentaDesde . ' - del ' . $fechaInicial . ' al ' . $fechaFinal . ' - generado el ' . date('d-m-Y H:i:s') . $extension;
    header("Content-type: application/vnd.ms-$tipo");
    header("Content-Disposition: attachment; filename=$nombreExt");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $html;
  }


  # functions


  # local functions
  # -- Libro Diario
  public function calcularDataLibroDiario($fechaIni, $fechaFin, $comprobante_tipo_id) {
    $comprobantesLibroDiario = $this->cofiModel->getComprobantesLibroDiario($comprobante_tipo_id, $fechaIni, $fechaFin, $this->EMPRESA_GESTION_ID);
    foreach ($comprobantesLibroDiario as $cld) {
      $cld->dataComprobanteLibroDiario = $this->cofiModel->getComprobanteDataByIdComprobante($cld->id);
    }
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fechaIni);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fechaFin);

    return [$comprobantesLibroDiario, $fechaInicial, $fechaFinal];
  }
  # -- Libro Mayor
  public function calcularDataLibroMayor($codCuentaDesde, $codCuentaHasta, $fechaIni, $fechaFin, $tipoMoneda) {
    $dataCuentasLibroMayor = $this->cofiModel->getCuentasLibroMayor($codCuentaDesde, $codCuentaHasta, $this->EMPRESA_GESTION_ID);
    foreach ($dataCuentasLibroMayor as $clm) {
      $clm->dataCuentaLibroMayor = $this->cofiModel->getDataCuentaLibroMayorByIdCuentaAndFechas($clm->id, $fechaIni, $fechaFin);
    }
    $fechaInicial = $this->lerp_utilities->convertDateToLiteral($fechaIni);
    $fechaFinal = $this->lerp_utilities->convertDateToLiteral($fechaFin);

    return [$dataCuentasLibroMayor, $fechaInicial, $fechaFinal];
  }


  // TODO! PENDING
  # -- Libro de Ventas IVA
  public function libroVentasIva()
  {
    # Verificar inicio de sesion
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

    $data = [];
    $content = $this->parser->parse('cofi/libros/indexLibroVentasIva', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function llamarGenerarLibroVentasIva()
  {
    $mesPeriodoFiscal   = $_POST['mpf'];
    $sucursal           = $_POST['s'];
    $tipoReporte        = $_POST['tr'];
    # Envio de varaible por el metodo GET
    $mGET = '?dt=' . base64_encode($mesPeriodoFiscal . '/' . $sucursal);
    if ($tipoReporte == "PDF") // PDF
      echo base_url('cofi/generarLibroVentasIvaPDF/') . $mGET;
    else // EXCEL
      echo base_url('cofi/generarLibroVentasIvaExcel/') . $mGET;
  }
  public function generarLibroVentasIvaPDF()
  {
    list($mesPeriodoFiscal, $sucursal)  = explode('/', base64_decode($_GET['dt']));

    if ($mesPeriodoFiscal <= 9) $mesPeriodoFiscal = '0' . $mesPeriodoFiscal;
    $periodoFiscal  = $mesPeriodoFiscal . "/" . selected_year();
    $razonSocial    = "EJEMPLO De razOn Social";
    $numeroNIT      = "1234500345";
    $numeroFolio    = "104";
    $nroSucursal    = "1";
    $direccion      = "av. perez Calle los andes nro 245";
    $ciResponsable      = "8546122";
    $nombreResponsable  = "PAOLA ROBERTA CHIRI ochoa";

    #$html <- include - Se incluye el diseño del reporte desde las vistas
    include('./application/views/cofi/libros/reportes/libroVentasIvaPdf.php'); # incluye - '$html'
    // Load pdf library
    $this->load->library('pdf');
    // Load HTML content
    $this->dompdf->loadHtml(utf8_decode($html));
    // (Optional) Setup the paper size and orientation
    $this->dompdf->setPaper('letter', 'landscape'); # tamaño carta horizontal
    // Render the HTML as PDF
    $this->dompdf->render();
    // Output the generated PDF (1 = download and 0 = preview)
    $this->dompdf->stream("finiquito.pdf", array("Attachment" => 0));
  }
  public function generarLibroVentasIvaExcel()
  { # llama a la funcion prefacturaConsolidadaMensualExcel()
    # Recuperamos los datos enviados en la URL
    list($mesPeriodoFiscal, $sucursal)  = explode('/', base64_decode($_GET['dt']));

    if ($mesPeriodoFiscal <= 9) $mesPeriodoFiscal = '0' . $mesPeriodoFiscal;
    $data['periodoFiscal']          = $mesPeriodoFiscal . "/" . selected_year();
    $data['razonSocial']            = "EJEMPLO De razOn Social";
    $data['numeroNIT']              = "1234500345";
    $data['numeroFolio']            = "104";
    $data['nroSucursal']            = "1";
    $data['direccion']              = "av. perez Calle los andes nro 245";
    $data['ciResponsable']          = "8546122";
    $data['nombreResponsable']      = "PAOLA ROBERTA CHIRI ochoa";

    $data['dataLibroVentasIva']     = null; // enviar data del libro de venta
    $this->load->view('cofi/libros/reportes/libroVentasIvaExcel', $data);
  }
  # -- Libro de Compras IVA
  public function libroComprasIva()
  {
    # Verificar inicio de sesion
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

    $data = [];
    $content = $this->parser->parse('cofi/libros/indexLibroComprasIva', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function llamarGenerarLibroComprasIva()
  {
    $mesPeriodoFiscal   = $_POST['mpf'];
    $sucursal           = $_POST['s'];
    $tipoReporte        = $_POST['tr'];
    # Envio de varaible por el metodo GET
    $mGET = '?dt=' . base64_encode($mesPeriodoFiscal . '/' . $sucursal);
    if ($tipoReporte == "PDF") // PDF
      echo base_url('cofi/generarLibroComprasIvaPDF/') . $mGET;
    else // EXCEL
      echo base_url('cofi/generarLibroComprasIvaExcel/') . $mGET;
  }
  public function generarLibroComprasIvaPDF()
  {
    list($mesPeriodoFiscal, $sucursal)  = explode('/', base64_decode($_GET['dt']));

    if ($mesPeriodoFiscal <= 9) $mesPeriodoFiscal = '0' . $mesPeriodoFiscal;
    $periodoFiscal  = $mesPeriodoFiscal . "/" . selected_year();
    $razonSocial    = "EJEMPLO De razOn Social";
    $numeroNIT      = "1234500345";
    $numeroFolio    = "104";
    $nroSucursal    = "1";
    $direccion      = "av. perez Calle los andes nro 245";

    $ciResponsable      = "8546122";
    $nombreResponsable  = "PAOLA ROBERTA CHIRI ochoa";

    #$html <- include - Se incluye el diseño del reporte desde las vistas
    include('./application/views/cofi/libros/reportes/libroComprasIvaPdf.php'); # incluye - '$html'
    // Load pdf library
    $this->load->library('pdf');
    // Load HTML content
    $this->dompdf->loadHtml(utf8_decode($html));
    // (Optional) Setup the paper size and orientation
    $this->dompdf->setPaper('letter', 'landscape'); # tamaño carta horizontal
    // Render the HTML as PDF
    $this->dompdf->render();
    // Output the generated PDF (1 = download and 0 = preview)
    $this->dompdf->stream("finiquito.pdf", array("Attachment" => 0));
  }
  public function generarLibroComprasIvaExcel()
  { # llama a la funcion prefacturaConsolidadaMensualExcel()
    # Recuperamos los datos enviados en la URL
    list($mesPeriodoFiscal, $sucursal)  = explode('/', base64_decode($_GET['dt']));

    if ($mesPeriodoFiscal <= 9) $mesPeriodoFiscal = '0' . $mesPeriodoFiscal;
    $data['periodoFiscal']          = $mesPeriodoFiscal . "/" . selected_year();
    $data['razonSocial']            = "EJEMPLO De razOn Social";
    $data['numeroNIT']              = "1234500345";
    $data['numeroFolio']            = "104";
    $data['nroSucursal']            = "1";
    $data['direccion']              = "av. perez Calle los andes nro 245";
    $data['ciResponsable']          = "8546122";
    $data['nombreResponsable']      = "PAOLA ROBERTA CHIRI ochoa";

    $data['dataLibroComprasIva']    = null; // enviar data del libro de compras
    $this->load->view('cofi/libros/reportes/libroComprasIvaExcel', $data);
  }
}
