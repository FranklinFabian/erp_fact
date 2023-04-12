<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Empleados extends Core
{
  public function __construct()
  {
    parent::__construct();
    $this->breadcrumb->add('Empleados', base_url('rrhh/empleados'));
  }

  # routes
  public function index()
  {
    $data = [
      'empleados' => $this->rrhhModel->getEmpleados(),
      'servicios' => $this->rrhhModel->getSisServicios(), // ! it isn't necesary
      'items' => $this->rrhhModel->getItems(),

      'enum_ci_extencion' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'ci_extension'), # tabla, columna
      'enum_documento' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'documento'), # tabla, columna
      'enum_estado_civil' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'estado_civil'), # tabla, columna
      'enum_caja_salud' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'caja_salud'), # tabla, columna
      'enum_afp_aporta' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'afp_aporta'), # tabla, columna
      'enum_clasificacion_laboral' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'clasificacion_laboral'), # tabla, columna
      'enum_tipo_contrato' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'tipo_contrato'), # tabla, columna
      'enum_contrato' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'contrato'), # tabla, columna
      'enum_subsidio' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'subsidio'), # tabla, columna
      'enum_motivo_retiro' => $this->rrhhModel->get_enum_values('rrhh_empleado', 'motivo_retiro'), # tabla, columna
    ];

    $content = $this->parser->parse('rrhh/empleados/index', $data, true);
    $this->template->full_admin_html_view($content);
  }
  // ? TODO: NO IMPLEMENTADO
  public function kardex_sueldos()
  {
    $id_empleado = base64_decode($_GET['data']);

    # Data reporte
    include('./application/views/rrhh/empleados/reportes/kardexSueldosEmpleadoPdf.php'); # incluye - '$html'
    $this->load->library('pdf');                    # Load pdf library
    $this->dompdf->loadHtml(utf8_decode($html));    # Load HTML content
    $this->dompdf->setPaper('letter');              # tamaño carta vertical setPaper('letter', 'landscape'); # carta horizontal
    $this->dompdf->render();                        # Render the HTML as PDF
    # paginar pdf generado - add the header
    $canvas = $this->dompdf->get_canvas();
    # datos para paginar el pdf generado
    $x = $canvas->get_width() - 125;         # posición eje x ($canvas->get_width() el borde maximo de la pag)
    $y = $canvas->get_height() - 50;         # posición eje y
    $text = "Página:       {PAGE_NUM} de {PAGE_COUNT}";   # texto a mostrar
    $font = null;                   # $fontMetrics->get_font("helvetica", "bold");
    $size = 9.5;                   # tamaño de las letras
    $color = array(0, 0, 0);               # color del texto (negro)
    $word_space = 0.0;                # separacion entre palabras
    $char_space = 0.0;                # separacion entre caracteres
    $angle = 0.0;                   # angulo de orientacion del texto
    # the same call as in my previous example
    $canvas->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    # Output the generated PDF (1 = download and 0 = preview)
    $this->dompdf->stream("reporte nombre.pdf", array("Attachment" => 0));
  }
  public function hoja_filiacion()
  {
    $empleado_id = base64_decode($this->input->get('id'));
    $data_empleado = $this->rrhhModel->getEmpleado($empleado_id);
    include('./application/views/rrhh/empleados/reportes/hojaFiliacionEmpleadoPdf.php');
    $this->load->library('pdf');
    $this->dompdf->loadHtml($html);
    $this->dompdf->setPaper('letter');
    $this->dompdf->render();
    $this->dompdf->stream("Hoja filiación empleado.pdf", array("Attachment" => 0));
  }

  # functions
  public function registrar()
  {
    $data = $this->input->post('data_form');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $data['id'] = $this->rrhhModel->crearNuevoUsuario($data);

    echo json_encode($data);
    exit;
  }
  public function actualizar()
  {
    $empleado_id = $this->input->post('empleado_id');

    $data = $this->input->post('data_form');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateEmpleado($empleado_id, $data);

    echo json_encode($data);
    exit;
  }
  public function eliminar()
  {
    $empleado_id = $this->input->post('empleado_id');
    $this->rrhhModel->deleteEmpleadoById($empleado_id);
  }
  public function get_familiares()
  {
    $empleado = $_POST['emp']; # nro de documento = 'empleado'
    $data = $this->rrhhModel->getFamiliaresByEmpleado($empleado);
    echo json_encode($data);
    exit;
  }
  public function registrar_familiar()
  {
    $data = $this->input->post('data');
    $data['creadoPor'] = $this->session->userdata('user_id');
    $data['creadoEn'] = date('Y-m-d H:i:s');
    $data['id'] = $this->rrhhModel->crearNuevoFamiliarEmpleado($data);
    echo json_encode($data);
    exit;
  }
  public function actualizar_familiar()
  {
    $familiar_id = $this->input->post('familiar_id');
    $data = $this->input->post('data');
    $data['actualizadoPor'] = $this->session->userdata('user_id');
    $data['actualizadoEn'] = date('Y-m-d H:i:s');
    $this->rrhhModel->updateFamiliarEmpleado($familiar_id, $data);
    echo json_encode($data);
    exit;
  }
  public function eliminar_familiar()
  {
    $familiar_id = $this->input->post('familiar_id');
    $this->rrhhModel->deleteFamiliarEmpleadoById($familiar_id);
  }
}
