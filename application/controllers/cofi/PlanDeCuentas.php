<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('Core.php');

class PlanDeCuentas extends Core
{
  public function __construct() {
    parent::__construct();

    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }

    $this->breadcrumb->add('Plan de Cuentas', base_url('cofi/planDeCuentas'));
  }

  # routes
  public function index() {
    $data = [
      'plan_cuentas' => $this->cofiModel->getCuentas($this->EMPRESA_GESTION_ID),
      'cuentas_grupos' => $this->cofiModel->getCuentasGrupos(),
      'cuentas_tipos' => $this->cofiModel->getCuentasTipos(),
      'monedas' => $this->cofiModel->getMonedas(),
    ];

    $content = $this->parser->parse('cofi/plandecuentas/index', $data, true);
    $this->template->full_admin_html_view($content);
  }

  # functions
  public function registrar() {
    $data = $this->input->post('data');
    $regex = $this->input->post('regex');

    # VERIFICAR EL FORMATO DEL CODIGO DE CUENTA
    $validation = preg_match($regex, $data['codigo_formato']);
    if (!$validation) {
      echo json_encode([
        'status' => FALSE,
        'message' => 'Verifique el formato del código de la cuenta.'
      ]);
      exit;
    }

    # VERIFICAR EL GRUPO DE LA CUENTA
    if ($data['cuenta_grupo_id'] != explode('.', $data['codigo_formato'])[0]) {
      echo json_encode([
        'status' => FALSE,
        'message' => 'No coincide el Grupo de Cuenta, verifique<br>e intente nuevamente.'
      ]);
      exit;
    }

    # VERIFICAR SI EXISTE CUENTA PADRE
    if ($data['cuenta_tipo_id'] !== '1') {
      $account_code_aux = explode('.', $data['codigo_formato']);
      array_pop($account_code_aux);
      $father_account_code = implode('.', $account_code_aux);
      $father_account = $this->cofiModel->getCuentaByCodigoFormato($father_account_code);
      if (!$father_account) {
        echo json_encode([
          'status' => FALSE,
          'message' => "No existe la cuenta padre <b>{$father_account_code}</b>, verifique<br>e intente nuevamente."
        ]);
        exit;
      }
    }

    # VERIFICAR SI EXISTE LA MISMA CUENTA
    $cuenta = $this->cofiModel->getCuentaByCodigoFormato($data['codigo_formato']);
    if ($cuenta) {
      echo json_encode([
        'status' => FALSE,
        'message' => "Ya existe una cuenta con el código <b>{$cuenta->codigo_formato}</b><br>Cuenta: <b>{$cuenta->nombre}</b>."
      ]);
      exit;
    }

    # REGISTRAR CUENTA
    $data['empresa_gestion_id'] = $this->EMPRESA_GESTION_ID;
    $response['status'] = $this->cofiModel->registrarCuenta($data);

    # ACTUALIZAR CUENTAS FINALES
    $response['update_final_accounts'] = $this->cofiModel->update_final_accounts($this->EMPRESA_GESTION_ID);

    echo json_encode($response);
    exit;
  }
  public function actualizar($id) {
    $data = $this->input->post('data');
    $res = $this->cofiModel->actualizarCuentaById($data, $id);
    echo json_encode($res);
    exit;
  }
  public function eliminar($id) {
    # VERIFICAR CUENTAS HIJAS
    $cuentas_hijas = $this->cofiModel->getCuentasHijas($id);
    if (count($cuentas_hijas) > 0) {
      echo json_encode([
        'status' => FALSE,
        'message' => 'No es posible eliminar la cuenta, esta cuenta tiene <b>' . count($cuentas_hijas) . ' cuentas</b> dependientes.'
      ]);
      exit;
    }

    # VERIFICAR MOVIMIENTOS EN COMPROBANTES
    $movimientos = $this->cofiModel->getMovimientos($id);
    if ($movimientos) {
      echo json_encode([
        'status' => FALSE,
        'message' => 'No es posible eliminar la cuenta, existen <b>comprobantes</b> registrados con esta cuenta.'
      ]);
      exit;
    }

    # VERIFICAR USO EN PLANTILLAS
    $plantillas = $this->cofiModel->getPlantillasByCuentaId($id);
    if (count($plantillas) > 0) {
      echo json_encode([
        'status' => FALSE,
        'message' => 'No es posible eliminar la cuenta, existen <b>plantillas</b> que hacen uso de esta cuenta.'
      ]);
      exit;
    }

    # ELIMINAR CUENTA
    $delete = $this->cofiModel->eliminarCuenta($id);

    # ACTUALIZAR CUENTAS FINALES
    $update = $this->cofiModel->update_final_accounts($this->EMPRESA_GESTION_ID);

    echo json_encode([
      'status' => $delete,
      'message' => 'Cuenta eliminada correctamente.',
      'update' => $update,
    ]);
    exit;
  }

  # others
  public function actualizar_cuentas_finales() {
    $res = $this->cofiModel->update_final_accounts($this->EMPRESA_GESTION_ID);
    echo json_encode($res);
    exit;
  }
  public function crear_codigo_cuenta() {
    // OLD FUNCTION
    $data['codigo'] = '22321';
    $data['cuenta_tipo_id'] = 4;

    # Funcion que genera el codigo de cuenta con formato (c/puntos)
    $paraCodigoCuenta = [1, 1, 1, 2, 1, 1, 1, 2];
    $new_cod = $data['codigo'][0];
    for ($i = 1; $i < strlen($data['codigo']); $i++) {
      #echo "sub ".$i." /".substr($codigo, $i, $paraCodigoCuenta[$i])."/<br>"; # string, start, length
      $new_cod .= "." . substr($data['codigo'], $i, $paraCodigoCuenta[$i]);
      $i += $paraCodigoCuenta[$i] - 1;
    }
    $data['codigo_formato']  = $new_cod;

    # Para el registro de comprobantes
    # debemos desactivar como cuenta final al padre, ya que tendrá un hijo (el que se está registrando)
    //$paramTipoCuenta = $this->cofiModel->getParametrosTipoCuenta($data['cuenta_tipo_id']); # ($id)
    $lonitud = 7; //$paramTipoCuenta->longitudCuentaPadre (eliminado)
    $codPadre = substr($data['codigo'], 0, $lonitud);
    $dataPadre['final'] = 0; # esta cuenta padre ya no es cuenta final

    echo json_encode($data);
    exit;
  }
}
