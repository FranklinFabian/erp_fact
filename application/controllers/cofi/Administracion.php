<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class Administracion extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Administración', base_url('cofi/administracion'));
  }

  # routes
  public function index() {
    redirect(base_url('cofi/administracion/empresa_gestion'));
  }
  public function empresa_gestion() {
    $data = [
      'empresas' => $this->cofiModel->getEmpresas(),
      'gestiones' => $this->cofiModel->getGestionesAllEmpresas(),
    ];

    $this->breadcrumb->add('Empresa y Gestión', base_url('#'));
    $content = $this->parser->parse('cofi/administracion/empresa_gestion', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function adicionar_empresa() {
    $data = [
      'periodos_tipos' => $this->cofiModel->getPeriodosTipos(),
      'alerta' => $this->cofiModel->getPrimeraEmpresaUltimaGestion() == 0,
    ];

    $this->breadcrumb->add('Adicionar Empresa', base_url('#'));
    $content = $this->parser->parse('cofi/administracion/formulario_empresa', $data, true);
    $this->template->full_admin_html_view($content);
  }
  public function adicionar_gestion() {
    $data = [
      'empresas' => $this->cofiModel->getEmpresasUltimaGestion(),
    ];

    $this->breadcrumb->add('Adicionar Gestión', base_url('#'));
    $content = $this->parser->parse('cofi/administracion/adicionar_gestion', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function actualizar_empresa_gestion() {
    $idGestionEmpresa = $this->input->post('idGestionEmpresa');
    $this->session->set_userdata(['idGestionEmpresa' => $idGestionEmpresa]);

    $empresa_gestion = $this->cofiModel->getEmpresaGestionArray($idGestionEmpresa);
    echo json_encode([
      'status' => true,
      'message' => "{$empresa_gestion['nombreEmpresa']}, Gestión {$empresa_gestion['gestionEmpresa']}"
    ]);
    exit;
  }
  public function registrar_empresa() {
    # REGISTRAR EMPRESA
    $data = $this->input->post('empresa');
    $idEmpresa = $this->cofiModel->registrarEmpresa($data);

    # REGISTRAR GESTION
    $data_empresa_gestion['idEmpresa'] = $idEmpresa;
    $data_empresa_gestion['gestionEmpresa'] = $this->input->post('gestionEmpresa');
    $idGestionEmpresa = $this->cofiModel->registrarEmpresaGestion($data_empresa_gestion);

    # CREAR CORRELATIVOS COMPROBANTES
    $response = $this->crearCorrelativosEmpresaGestion($idGestionEmpresa);

    # CREAR COMPROBANTES PARAMETROS
    $response &= $this->crearComprobantesParametrosGestionEmpresa($idGestionEmpresa);

    # CREAR PLAN DE CUENTAS, (TEMPLATE BASE -> 0)
    $response &= $this->crearPlanDeCuentasEmpresaGestion($idGestionEmpresa, 0);

    echo json_encode([
      'status' => $response,
    ]);
    exit;
  }
  public function actualizar_empresa() {
    $empresa_id = $this->input->post('empresa_id');
    $data_empresa = $this->input->post('data_empresa');

    $response = $this->cofiModel->actualizarEmpresa($empresa_id, $data_empresa);
    echo json_decode($response);
    exit;
  }
  public function registrar_gestion() {
    # GET ULTIMA EMPRESA GESTION
    $empresa_gestion_anterior = $this->cofiModel->getUltimaEmpresaGestionByIdEmpresa($this->input->post('empresa_id'));

    # REGISTRAR GESTION
    $empresa_gestion['idEmpresa'] = $this->input->post('empresa_id');
    $empresa_gestion['gestionEmpresa'] = $this->input->post('gestion');
    $idGestionEmpresa = $this->cofiModel->registrarEmpresaGestion($empresa_gestion);

    # CREAR CORRELATIVOS COMPROBANTES
    $response = $this->crearCorrelativosEmpresaGestion($idGestionEmpresa);

    # CREAR COMPROBANTES PARAMETROS
    $response &= $this->crearComprobantesParametrosGestionEmpresa($idGestionEmpresa);

    # CREAR PLAN DE CUENTAS (COPIA DE LA GESTION ANTERIOR)
    $response &= $this->crearPlanDeCuentasEmpresaGestion($idGestionEmpresa, $empresa_gestion_anterior->idGestionEmpresa);

    echo json_encode([
      'status' => $response,
    ]);
    exit;
  }

  # local functions
  public function crearCorrelativosEmpresaGestion($idGestionEmpresa) {
    $response = true;
    $comprobantes_tipos = $this->cofiModel->getAllComprobantesTipos();

    foreach($comprobantes_tipos as $comprobante_tipo) {
      $data = [
        'comprobante_tipo_id' => $comprobante_tipo->id,
        'contador' => 1,
        'empresa_gestion_id' => $idGestionEmpresa
      ];
      $response &= boolval($this->cofiModel->crearComprobantesCorrelativos($data));
    }

    return $response;
  }
  public function crearComprobantesParametrosGestionEmpresa($idGestionEmpresa) {
    # crear parametrosComprobantea para la empresa registrada
    $paramComprobantes = $this->cofiModel->getComprobantesParametros(0); # 0 es la plantilla dafult
    $dataPC['cargo_firma_uno'] = $paramComprobantes->cargo_firma_uno;
    $dataPC['cargo_firma_dos'] = $paramComprobantes->cargo_firma_dos;
    $dataPC['cargo_firma_tres'] = $paramComprobantes->cargo_firma_tres;
    $dataPC['cargo_firma_cuatro'] = $paramComprobantes->cargo_firma_cuatro;
    $dataPC['cargo_firma_cinco'] = $paramComprobantes->cargo_firma_cinco;
    $dataPC['cargo_firma_seis'] = $paramComprobantes->cargo_firma_seis;
    $dataPC['nombre_firma_uno'] = $paramComprobantes->nombre_firma_uno;
    $dataPC['nombre_firma_dos'] = $paramComprobantes->nombre_firma_dos;
    $dataPC['nombre_firma_tres'] = $paramComprobantes->nombre_firma_tres;
    $dataPC['nombre_firma_cuatro'] = $paramComprobantes->nombre_firma_cuatro;
    $dataPC['nombre_firma_cinco'] = $paramComprobantes->nombre_firma_cinco;
    $dataPC['nombre_firma_seis'] = $paramComprobantes->nombre_firma_seis;
    $dataPC['cantidad_digitos'] = $paramComprobantes->cantidad_digitos;
    $dataPC['numero_firmas'] = $paramComprobantes->numero_firmas;
    $dataPC['idGestionEmpresa'] = $idGestionEmpresa;
    return $this->cofiModel->registrarComprobantesParametros($dataPC);
  }
  public function crearPlanDeCuentasEmpresaGestion($idGestionEmpresa, $idGestionEmpresaAnterior) {
    $planDeCuentas = $this->cofiModel->getCuentas($idGestionEmpresaAnterior);
    $response = true;
    foreach ($planDeCuentas as $pc) {
      $dataNuevoPlanCuentas['cuenta_grupo_id'] = $pc->cuenta_grupo_id;
      $dataNuevoPlanCuentas['cuenta_tipo_id'] = $pc->cuenta_tipo_id;
      $dataNuevoPlanCuentas['codigo'] = $pc->codigo;
      $dataNuevoPlanCuentas['codigo_formato'] = $pc->codigo_formato;
      $dataNuevoPlanCuentas['nombre'] = $pc->nombre;
      $dataNuevoPlanCuentas['moneda_id'] = $pc->moneda_id;
      $dataNuevoPlanCuentas['actzUFV'] = $pc->actzUFV;
      $dataNuevoPlanCuentas['final'] = $pc->final;
      $dataNuevoPlanCuentas['idGestionEmpresa'] = $idGestionEmpresa;
      $response &= $this->cofiModel->registrarCuenta($dataNuevoPlanCuentas);
    }
    $this->cofiModel->update_final_accounts($idGestionEmpresa);

    return $response;
  }
}
