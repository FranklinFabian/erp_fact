<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Planillas extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Planillas', base_url('rrhh/planillas'));
  }

  # routes
  public function index()
  {
    $data = [
      'data_meses' => $this->rrhhModel->getAllMeses(),
      'data_empleados' => $this->rrhhModel->getEmpleados(),
      'data_servicios' => $this->rrhhModel->getSisServicios()
    ];

    $content = $this->parser->parse('rrhh/planillas/indexPlanillas', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions

  // PLANILLA SALARIAL
  public function planilla_salarial_excel()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    echo $servicio . ' ' . $mes . '<br>';
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    print_r($empleados_servicio_mes);
  }
  public function planilla_salarial_pdf()
  {
    $serivicio_mes_base_64  = $this->input->get('data');
    list($servicio, $mes)   = explode('+', base64_decode($serivicio_mes_base_64));
    $data_secciones         = $this->rrhhModel->getSeccionesByServicio($servicio);
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    $nombre_servicio        = $this->getNombreServicio($servicio);
    include('./application/views/rrhh/planillas/reportes/planillaSalarialPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla de Sueldos y Salarios - " . $nombre_servicio . " - " . $mes_anio . ".pdf", array("Attachment" => 0));
  }

  // PLANILLA TRIBUTARIA
  public function planilla_tributaria_excel()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    echo $servicio . ' ' . $mes . '<br>';
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    print_r($empleados_servicio_mes);
    die;
  }
  public function planilla_tributaria_pdf()
  {
    $serivicio_mes_base_64  = $this->input->get('data');
    list($servicio, $mes)   = explode('+', base64_decode($serivicio_mes_base_64));
    $data_secciones         = $this->rrhhModel->getSeccionesByServicio($servicio);
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    $nombre_servicio        = $this->getNombreServicio($servicio);
    include('./application/views/rrhh/planillas/reportes/planillaTributariaPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla Tributaria - " . $nombre_servicio . " - " . $mes_anio . ".pdf", array("Attachment" => 0));
  }

  // PLANILLA APORTES PATRONALES
  public function planilla_aportes_patronales_excel()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    echo $servicio . ' ' . $mes . '<br>';
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    print_r($empleados_servicio_mes);
    die;
  }
  public function planilla_aportes_patronales_pdf()
  {
    $serivicio_mes_base_64  = $this->input->get('data');
    list($servicio, $mes)   = explode('+', base64_decode($serivicio_mes_base_64));
    $data_secciones         = $this->rrhhModel->getSeccionesByServicio($servicio);
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    $nombre_servicio        = $this->getNombreServicio($servicio);
    include('./application/views/rrhh/planillas/reportes/planillaAportesPatronalesPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla Aportes Patronales - " . $nombre_servicio . " - " . $mes_anio . ".pdf", array("Attachment" => 0));
  }

  // ? TODO: PLANILLA AGUINALDOS

  // ? TODO: PLANILLA INCREMENTO SALARIAL
  public function verificar_existe_incremento_salarial()
  {
    $gestion = $this->input->post('gestion');
    $res = $this->rrhhModel->getMesesIncremetoSalarialByGestion($gestion);
    echo json_encode($res);
    exit;
  }
  public function planilla_incremento_salarial_excel()
  {
    $gestion_base_64            = $this->input->get('data');
    $gestion                    = base64_decode($gestion_base_64);
    $meses_incremento_salarial  = $this->rrhhModel->getMesesIncremetoSalarialByGestion($gestion);
    $mes_ini    = $meses_incremento_salarial[0]->mes;
    $mes_fin    = $meses_incremento_salarial[count($meses_incremento_salarial) - 1]->mes;

    $data_incremento_salarial   = $this->rrhhModel->getDataIncrementoSalarialByGestion($gestion);
    $data_salario               = $this->rrhhModel->getDataSalarioByMesIniMesFin($mes_ini, $mes_fin);

    $data['gestion']                    = $gestion;
    $data['data_salario']               = $data_salario;
    $data['data_incremento_salarial']   = $data_incremento_salarial;
    $this->load->view('rrhh/planillas/reportes/planillaIncrementoSalarialExcel', $data);
  }

  // PLANILLA DE ASISTENCIA
  public function planilla_asistencia_pdf()
  {
    $mes_base_64 = $this->input->get('data');
    $mes = base64_decode($mes_base_64);
    list($a, $m, $d) = explode('-', $mes);
    $empleados_asistencia = $this->rrhhModel->getEmpleadosAsistenciaByMes($a . '-' . $m . '-01', $mes);
    $data_asistencia = $this->rrhhModel->getDataAsistenciaByMes($a . '-' . $m . '-01', $mes);
    $mes_anio = MONTH_NAMES[$m] . '/' . $a;
    $mes_anio_nombre = MONTH_NAMES[$m] . '-' . $a;
    $titulo     = 'REPORTE ASISTENCIA EMPLEADOS';
    include('./application/views/rrhh/planillas/reportes/planillaAsistenciaPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla de Asistencia - " . $mes_anio_nombre . ".pdf", array("Attachment" => 0));
  }

  // PLANILLA HORAS EXTRAS
  public function planilla_horas_extras_pdf()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    list($a, $m, $d) = explode('-', $mes);
    $data_horas_extras = $this->rrhhModel->getRegistrosResumenHorasExtrasByMes($mes);
    $titulo = 'REPORTE HORAS EXTRAS';
    $nombre_servicio = $this->getNombreServicio($servicio);
    $mes_anio = MONTH_NAMES[$m] . '/' . $a;
    $mes_anio_nombre = MONTH_NAMES[$m] . '-' . $a;
    include('./application/views/rrhh/planillas/reportes/planillaHorasExtrasPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla Horas Extras - " . $nombre_servicio . " - " . $mes_anio_nombre . ".pdf", array("Attachment" => 0));
  }

  // ? TODO: REPORTE CAJEROS
  // ! TODO: CACO module isn't mine
  public function reporte_cajeros_pdf()
  {
    $mes_base_64            = $this->input->get('data');
    $mes                    = base64_decode($mes_base_64);
    list($a, $m, $d)        = explode('-', $mes);
    $empleados_cajeros      = $this->rrhhModel->getEmpleadosCajerosByFechass($a . '-' . $m . '-01', $mes);
    $data_atencion_cajeros  = $this->rrhhModel->getDataReporteCajerosByFechas($a . '-' . $m . '-01', $mes);
    $titulo                 = 'REPORTE ATENCION CAJEROS';
    $mes_anio               = MONTH_NAMES[$m] . '/' . $a;
    $mes_anio_nombre        = MONTH_NAMES[$m] . '-' . $a;
    include('./application/views/rrhh/planillas/reportes/reporteAtencionCajeros.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal', 'landscape');
    $this->dompdf->render();
    $this->dompdf->stream("Reporte Atención Cajeros - " . $mes_anio_nombre . ".pdf", array("Attachment" => 0));
  }

  // ARCHIVO PARA BANCO
  public function archivo_banco()
  {
    $mes_base_64 = $this->input->get('data');
    $mes = base64_decode($mes_base_64);
    list($a, $m, $d) = explode('-', $mes);
    $data['mes_anio'] = MONTH_NAMES[$m] . '-' . $a;
    $data['nombre_mes'] = MONTH_NAMES[$m];
    $data['emp_liq_pag_mes'] = $this->rrhhModel->getDataArchivoBancoByMes($mes);
    $this->load->view('rrhh/planillas/reportes/archivoBancoTxt', $data);
  }

  // ? TODO: REPORTE CONTABLE
  public function reporte_contable_pdf()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    list($a, $m, $d) = explode('-', $mes);
    $data_repo_contable = [];
    $titulo = 'REPORTE SUELDOS Y SALARIOS';
    $nombre_servicio = $this->getNombreServicio($servicio);
    $mes_anio = MONTH_NAMES[$m] . '/' . $a;
    $mes_anio_nombre = MONTH_NAMES[$m] . '-' . $a;
    include('./application/views/rrhh/planillas/reportes/reporteContablePdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml(utf8_decode($html));
    $this->dompdf->setPaper('legal');
    $this->dompdf->render();
    $this->dompdf->stream("Reporte Contable - " . $nombre_servicio . " - " . $mes_anio_nombre . ".pdf", array("Attachment" => 0));
  }

  // COSTO POR HORA
  public function planilla_costo_por_hora_pdf()
  {
    $serivicio_mes_base_64 = $this->input->get('data');
    list($servicio, $mes) = explode('+', base64_decode($serivicio_mes_base_64));
    list($a, $m, $d) = explode('-', $mes);
    $data_secciones = $this->rrhhModel->getSeccionesByServicio($servicio);
    $empleados_servicio_mes = $this->rrhhModel->getDataPlanillaSalarialByServicioByMes($servicio, $mes);
    $titulo = 'PLANILLA DE COSTOS SUELDOS Y SALARIOS';
    $nombre_servicio = $this->getNombreServicio($servicio);
    $mes_anio = MONTH_NAMES[$m] . '/' . $a;
    $mes_anio_nombre = MONTH_NAMES[$m] . '-' . $a;
    include('./application/views/rrhh/planillas/reportes/planillaCostoPorHoraPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('legal');
    $this->dompdf->render();
    $this->dompdf->stream("Planilla Costos por Hora - " . $nombre_servicio . " - " . $mes_anio_nombre . ".pdf", array("Attachment" => 0));
  }

  private function getNombreServicio($servicio_id)
  {
    $data_servicios = $this->rrhhModel->getSisServicios();
    $this->servicio_id = $servicio_id;
    $servicio_reporte = array_filter($data_servicios, function ($s) {
      return $s->Id_Servicio == $this->servicio_id;
    });
    $servicio_reporte = reset($servicio_reporte);
    return $servicio_reporte->Servicio;
  }
}
