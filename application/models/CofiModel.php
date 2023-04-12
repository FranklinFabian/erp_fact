<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CofiModel extends CI_Model {
    protected $codigo_cuenta = '';
    protected $longitud_cuenta = '';

    public function __construct() {
        parent::__construct();
    }

    public function getPrimeraEmpresaUltimaGestion() {
        $this->db->select('*');
        $this->db->order_by('empresa_id', 'ASC');
        $this->db->order_by('gestion', 'DESC');
        $res = $this->db->get('cofi_empresas_gestiones')->row();
        return isset($res->id) ? $res->id : 0;
    }

    # ------------------------------------------------------------------------------------------
    # ------------------------------------ PLAN DE CUENTAS -------------------------------------
    # ------------------------------------------------------------------------------------------
    public function getCuentas($empresa_gestion_id) {
        $this->db->select('c.*, t.nombre as cuenta_tipo_nombre, t.sangria as cuenta_tipo_sangria, g.nombre as cuenta_grupo_nombre, m.codigo as moneda_codigo');
        $this->db->from('cofi_cuentas c');
        $this->db->join("cofi_cuentas_tipos t", "t.id = c.cuenta_tipo_id");
        $this->db->join("cofi_cuentas_grupos g", "g.id = c.cuenta_grupo_id");
        $this->db->join("cofi_monedas m", "m.id = c.moneda_id");
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->order_by('c.codigo', 'asc');
        return $this->db->get()->result();
    }
    public function getCuentasFinales($empresa_gestion_id) {
        $this->db->select('c.*, t.nombre as cuenta_tipo_nombre, t.sangria as cuenta_tipo_sangria, g.nombre as cuenta_grupo_nombre, m.codigo as moneda_codigo');
        $this->db->from('cofi_cuentas c');
        $this->db->join("cofi_cuentas_tipos t", "t.id = c.cuenta_tipo_id");
        $this->db->join("cofi_cuentas_grupos g", "g.id = c.cuenta_grupo_id");
        $this->db->join("cofi_monedas m", "m.id = c.moneda_id");
        $this->db->where("c.final", 1);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->order_by('c.codigo', 'asc');
        return $this->db->get()->result();
    }
    public function getCuentaById($id) {
        $this->db->select('*');
        $this->db->from('cofi_cuentas');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    public function getCuentaByCodigoFormato($codigo_formato) {
        $this->db->select('*');
        $this->db->where('codigo_formato', $codigo_formato);
        $this->db->where('empresa_gestion_id', $this->session->userdata('empresa_gestion_id'));
        return $this->db->get('cofi_cuentas')->row();
    }
    public function getCuentaByCodigo($codigo) {
        $this->db->select('c.*, tc.sangria as cuenta_tipo_sangria');
        $this->db->from('cofi_cuentas as c');
        $this->db->where('c.codigo', $codigo);
        $this->db->where('c.empresa_gestion_id', $this->session->userdata('empresa_gestion_id'));
        $this->db->join('cofi_cuentas_tipos as tc', 'tc.id = c.cuenta_tipo_id');
        return $this->db->get()->row();
    }
    public function getCuentasGrupos() {
        $this->db->select('*');
        $this->db->from('cofi_cuentas_grupos');
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result();
    }
    public function getCuentasTipos() {
        $this->db->select('*');
        $this->db->from('cofi_cuentas_tipos');
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result();
    }
    public function getMonedas() {
        $this->db->select('*');
        $this->db->from('cofi_monedas');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }
    public function registrarCuenta($data) {
        return $this->db->insert('cofi_cuentas', $data);
    }
    public function actualizarCuentaById($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('cofi_cuentas', $data);
    }
    public function getCuentasHijas($cuenta_id) {
        $cuenta = $this->getCuentaById($cuenta_id);
        $this->db->select('*');
        $this->db->from('cofi_cuentas');
        $this->db->like('codigo', $cuenta->codigo, 'after');
        $this->db->where('empresa_gestion_id', $cuenta->empresa_gestion_id);
        $this->db->where('id !=', $cuenta_id);
        return $this->db->get()->result();
    }
    public function getMovimientos($cuenta_id) {
        $this->db->select('*');
        $this->db->from('cofi_comprobantes_data');
        $this->db->where('cuenta_id', $cuenta_id);
        return $this->db->get()->result();
    }
    public function eliminarCuenta($cuenta_id) {
        $this->db->where('id', $cuenta_id);
        return $this->db->delete('cofi_cuentas');
    }
    public function getCuentaTipoById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        return $this->db->get('cofi_cuentas_tipos')->row();
    }
    public function update_final_accounts($empresa_gestion_id) {
        $query = "SELECT COFI_UPDATE_FINAL_ACCOUNTS({$empresa_gestion_id})";
        return $this->db->query($query)->row();
    }

    # ------------------------------------------------------------------------------------------
    # -------------------------------------- COMPROBANTES --------------------------------------
    # ------------------------------------------------------------------------------------------
    public function getComprobantes($empresa_gestion_id) {
        $this->db->select('c.*, tc.nombre as comprobante_tipo_nombre');
        $this->db->where('c.anulado', 0);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->join('cofi_comprobantes_tipos as tc', 'tc.id = c.comprobante_tipo_id');
        $this->db->order_by('c.id', 'asc');
        return $this->db->get('cofi_comprobantes as c')->result();;
    }
    public function getComprobantesAnulados($empresa_gestion_id) {
        $this->db->select('c.*, tc.nombre as comprobante_tipo_nombre');
        $this->db->where('c.anulado', 1);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->join('cofi_comprobantes_tipos as tc', 'tc.id = c.comprobante_tipo_id');
        $this->db->order_by('c.id', 'asc');
        return $this->db->get('cofi_comprobantes as c')->result();
    }
    public function getComprobanteById($id) {
        $this->db->select('c.*, tc.nombre as comprobante_tipo_nombre');
        $this->db->where('c.id', $id);
        $this->db->join('cofi_comprobantes_tipos as tc', 'tc.id = c.comprobante_tipo_id');
        return $this->db->get('cofi_comprobantes as c')->row();
    }
    public function getComprobanteDataByIdComprobante($comprobante_id) {
        $this->db->select('dc.*, c.*, cu.*, cu.nombre as cuenta_nombre, cu.codigo as cuenta_codigo, cu.codigo_formato as cuenta_codigo_formato');
        $this->db->join('cofi_comprobantes as c', 'c.id = dc.comprobante_id');
        $this->db->join('cofi_cuentas as cu', 'cu.id = dc.cuenta_id');
        $this->db->where('dc.comprobante_id', $comprobante_id);
        return $this->db->get('cofi_comprobantes_data dc')->result();
    }
    public function getAllComprobantesTipos() {
        $this->db->select('*');
        $this->db->from('cofi_comprobantes_tipos');
        return $this->db->get()->result();
    }
    public function getComprobantesTipos() {
        $this->db->select('*');
        $this->db->from('cofi_comprobantes_tipos');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }
    public function getComprobantesTiposById($id) {
        $this->db->select('*');
        $this->db->from('cofi_comprobantes_tipos');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    public function registrarComprobante($data) {
        $this->db->insert('cofi_comprobantes', $data);
        return $this->db->insert_id();
    }
    public function actualizarComprobanteById($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('cofi_comprobantes', $data);
    }
    public function eliminarComprobanteDataByIdComprobante($comprobante_id) {
        $this->db->where('comprobante_id', $comprobante_id);
        return $this->db->delete('cofi_comprobantes_data');
    }
    public function registrarComprobanteData($data) {
        $this->db->insert('cofi_comprobantes_data', $data);
        return $this->db->insert_id();
    }
    public function anularComprobante($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('cofi_comprobantes', $data);
    }
    public function getComprobanteCorrelativo($comprobante_tipo_id, $empresa_gestion_id) {
        $this->db->select('*');
        $this->db->from('cofi_comprobantes_correlativos');
        $this->db->where('comprobante_tipo_id', $comprobante_tipo_id);
        $this->db->where('empresa_gestion_id', $empresa_gestion_id);
        return $this->db->get()->row();
    }
    public function crearComprobantesCorrelativos($data) {
        $this->db->insert('cofi_comprobantes_correlativos', $data);
        return $this->db->insert_id();
    }
    public function incrementarContadorComprobantesCorrelativos($comprobante_tipo_id, $empresa_gestion_id) {
        $this->db->set('contador', 'contador+1', FALSE);
        $this->db->where('comprobante_tipo_id', $comprobante_tipo_id);
        $this->db->where('empresa_gestion_id', $empresa_gestion_id);
        return $this->db->update('cofi_comprobantes_correlativos');
    }
    public function getComprobantesParametros($empresa_gestion_id) {
        $this->db->select('*');
        $this->db->where('empresa_gestion_id', $empresa_gestion_id);
        return $this->db->get('cofi_comprobantes_parametros')->row();
    }
    public function registrarComprobantesParametros($data) {
        return $this->db->insert('cofi_comprobantes_parametros', $data);
    }
    public function actualizarComprobantesParametrosByIdGestionEmpresa($data, $empresa_gestion_id) {
        $this->db->where('empresa_gestion_id', $empresa_gestion_id);
        return $this->db->update('cofi_comprobantes_parametros', $data);
    }

    # ------------------------------------------------------------------------------------------
    # ----------------------------------------- LIBROS -----------------------------------------
    # ------------------------------------------------------------------------------------------
    #-- Libro Diario
    public function getComprobantesLibroDiario($tipoComp, $feinif2, $fefinf2, $empresa_gestion_id){
        $this->db->select('c.*, tc.nombre as comprobante_tipo_nombre');
        $this->db->join('cofi_comprobantes_tipos as tc', 'tc.id = c.comprobante_tipo_id');
        $this->db->where('c.fecha >=', $feinif2);
        $this->db->where('c.fecha <=', $fefinf2);
        if($tipoComp != '*') $this->db->where('c.comprobante_tipo_id', $tipoComp); # *, significa todos los tipos
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);  # solo los de la empresa y gestion seleccionados
        $this->db->where('c.anulado', 0);                # NO ANULADO
        $this->db->order_by('c.fecha', 'asc');
        return $this->db->get('cofi_comprobantes c')->result();
    }
    #-- Libro Mayor
    public function getCuentasLibroMayor($codIni, $codFin, $empresa_gestion_id){
        $this->db->select('c.*');
        $this->db->where('c.codigo >=', $codIni);
        $this->db->where('c.codigo <=', $codFin);
        $this->db->where('c.final', 1); # Solo las cuentas finales
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->order_by('c.codigo', 'asc');
        return $this->db->get('cofi_cuentas c')->result();
    }
    public function getDataCuentaLibroMayorByIdCuentaAndFechas($cuenta_id, $feini, $feFin){
        $this->db->select('c.*, dc.*, tc.nombre as comprobante_tipo_nombre');
        $this->db->join('cofi_comprobantes_data as dc', 'dc.comprobante_id = c.id');
        $this->db->join('cofi_comprobantes_tipos as tc', 'tc.id = c.comprobante_tipo_id');
        $this->db->where('c.fecha >=', $feini);
        $this->db->where('c.fecha <=', $feFin);
        $this->db->where('c.anulado', 0); # NO ANULADO
        $this->db->where('dc.cuenta_id', $cuenta_id);
        $this->db->order_by('c.fecha', 'asc');
        return $this->db->get('cofi_comprobantes as c')->result();
    }
    # ------------------------------------------------------------------------------------------
    # --------------------------------------- UTILIDADES ---------------------------------------
    # ------------------------------------------------------------------------------------------
    public function getTasasDeCambioByAnioMes($anio_mes) {
        $this->db->select('*');
        $this->db->like('fecha', $anio_mes, 'after');
        return $this->db->get('cofi_tasas_cambio')->result();
    }
    public function registrarTasaCambio($data) {
        $this->db->insert('cofi_tasas_cambio', $data);
        return $this->db->insert_id();
    }
    public function actualizarTasaCambio($fecha, $data) {
        $this->db->where('fecha', $fecha);
        return $this->db->update('cofi_tasas_cambio', $data);
    }
    public function verificarTasaCambio($fecha) {
        $this->db->select('*');
        $this->db->from('cofi_tasas_cambio');
        $this->db->where('fecha', $fecha);
        return $this->db->get()->row();
    }

    # ------------------------------------------------------------------------------------------
    # ----------------------------------- ESTADOS FINANCIEROS ----------------------------------
    # ------------------------------------------------------------------------------------------

    function getDataBalanceSumasSaldos($fechaini, $fechafin, $nivel_cuenta, $empresa_gestion_id, $unique=false) {
        $pn5 = $this->getCuentaTipoById(5); # parametros cuenta nivel 5
        $pn4 = $this->getCuentaTipoById(4); # parametros cuenta nivel 4
        $pn3 = $this->getCuentaTipoById(3); # parametros cuenta nivel 3
        $pn2 = $this->getCuentaTipoById(2); # parametros cuenta nivel 2
        $pn1 = $this->getCuentaTipoById(1); # parametros cuenta nivel 1

        # lista de todas las cuentasX de los comprobantes de los datos proporcionados
        $this->db->select('cta.codigo as cuenta_codigo, dc.debeBs, dc.haberBs, dc.debeUS, dc.haberUS, dc.debeUFV, dc.haberUFV');
        $this->db->join('cofi_comprobantes c', 'c.id = dc.comprobante_id');
        $this->db->join('cofi_cuentas cta', 'cta.id = dc.cuenta_id');
        $this->db->where('c.fecha >=', $fechaini);
        $this->db->where('c.fecha <=', $fechafin);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->where('c.anulado', 0); # NO ANULADO (NO ELIMINADO)
        $this->db->order_by('cta.codigo', 'asc');
        $data_cuentas = $this->db->get('cofi_comprobantes_data dc')->result();

        # Obtener cuentas, titulos, rubros, grupos
        $nivel5 = [];
        $nivel4 = [];
        $nivel3 = [];
        $nivel2 = [];
        $nivel1 = [];
        # Obtener cuentas de nivel, n5, n4, n3, n2 y n1
        foreach($data_cuentas as $dc){
            if($unique) {  # cumplir longitud cod cuenta segun nivel
                if(strlen(substr($dc->cuenta_codigo, 0, $pn5->longitud)) == $pn5->longitud)
                    $nivel5[]   = substr($dc->cuenta_codigo, 0, $pn5->longitud);
                if(strlen(substr($dc->cuenta_codigo, 0, $pn4->longitud)) == $pn4->longitud)
                    $nivel4[]   = substr($dc->cuenta_codigo, 0, $pn4->longitud);
                if(strlen(substr($dc->cuenta_codigo, 0, $pn3->longitud)) == $pn3->longitud)
                    $nivel3[]   = substr($dc->cuenta_codigo, 0, $pn3->longitud);
                if(strlen(substr($dc->cuenta_codigo, 0, $pn2->longitud)) == $pn2->longitud)
                    $nivel2[]   = substr($dc->cuenta_codigo, 0, $pn2->longitud);
                if(strlen(substr($dc->cuenta_codigo, 0, $pn1->longitud)) == $pn1->longitud)
                    $nivel1[]   = substr($dc->cuenta_codigo, 0, $pn1->longitud);
            } else {
                $nivel5[]   = substr($dc->cuenta_codigo, 0, $pn5->longitud);
                $nivel4[]   = substr($dc->cuenta_codigo, 0, $pn4->longitud);
                $nivel3[]   = substr($dc->cuenta_codigo, 0, $pn3->longitud);
                $nivel2[]   = substr($dc->cuenta_codigo, 0, $pn2->longitud);
                $nivel1[]   = substr($dc->cuenta_codigo, 0, $pn1->longitud);
            }
        }
        $nivel5 = array_unique($nivel5);    # Se eliminan los datos repetidos
        $nivel4 = array_unique($nivel4);    # Se eliminan los datos repetidos
        $nivel3 = array_unique($nivel3);    # Se eliminan los datos repetidos
        $nivel2 = array_unique($nivel2);    # Se eliminan los datos repetidos
        $nivel1 = array_unique($nivel1);    # Se eliminan los datos repetidos

        # GENERAR DATOS ORDENADOS DE ACUERDO AL NIVEL SELECCIONADO
        $response = [];
        $cantidadEspacios = 0;
        if($nivel_cuenta == 5) { # caso de las cuentas nivel 5
            $dataTipoCuenta     = $nivel5;
            $cantidadEspacios   = $pn5->longitud;
        } else if($nivel_cuenta == 4) { # caso de las cuentas nivel 4
            $dataTipoCuenta     = $nivel4;
            $cantidadEspacios   = $pn4->longitud;
        } else if($nivel_cuenta == 3) { # caso de las cuentas nivel 3
            $dataTipoCuenta     = $nivel3;
            $cantidadEspacios   = $pn3->longitud;
        } else if($nivel_cuenta == 2) { # caso de las cuentas nivel 2
            $dataTipoCuenta     = $nivel2;
            $cantidadEspacios   = $pn2->longitud;
        } else if($nivel_cuenta == 1) { # caso de las cuentas nivel 1
            $dataTipoCuenta     = $nivel1;
            $cantidadEspacios   = $pn1->longitud;
        }
        foreach($dataTipoCuenta as $dtc) {
            $db=0; $hb=0; $dd=0; $hd=0;
            $this->codigo_cuenta = $dtc;
            $this->longitud_cuenta = $cantidadEspacios;
            $data_cuentas_nivel = array_filter($data_cuentas, function($c) {
                return substr($c->cuenta_codigo, 0, $this->longitud_cuenta) == $this->codigo_cuenta;
            });
            foreach($data_cuentas_nivel as $dcn) {
                # sumas
                $db += $dcn->debeBs;
                $hb += $dcn->haberBs;
                $dd += $dcn->debeUS;
                $hd += $dcn->haberUS;
            }
            $data_cuenta = $this->getCuentaByCodigo($dtc);
            $aux['cuenta_codigo']        = $dtc;
            $aux['codigoCuentaOrdenar'] = $dtc.'-';
            $aux['cuenta_nombre']        = $data_cuenta->nombre;
            $aux['cuenta_tipo_sangria']   = $data_cuenta->cuenta_tipo_sangria;
            $aux['cantidadAsientos']    = count($data_cuentas_nivel);
            $aux['debeBs']      = $db;
            $aux['haberBs']     = $hb;
            $aux['debeUS']      = $dd;
            $aux['haberUS']     = $hd;

            # saldos
            if(($db-$hb)==0) {
                $deudorBs     = 0;
                $acreedorBs   = 0;
                $deudorUS     = 0;
                $acreedorUS   = 0;
            } else if(($db-$hb)>0) {
                $deudorBs     = $db-$hb;
                $acreedorBs   = 0;
                $deudorUS     = $dd-$hd;
                $acreedorUS   = 0;
            } else {
                $deudorBs     = 0;
                $acreedorBs   = $hb-$db;
                $deudorUS     = 0;
                $acreedorUS   = $hd-$dd;
            }
            $aux['deudorBs']   = $deudorBs;
            $aux['acreedorBs'] = $acreedorBs;
            $aux['deudorUS']   = $deudorUS;
            $aux['acreedorUS'] = $acreedorUS;

            $response[] = (object) $aux;
        }
        return $response;
    }
    function getDataBalanceGeneral($fechaini, $fechafin, $nivel_cuenta, $empresa_gestion_id) {
        $data = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 1, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
        $monto_total = [];
        $monto_total['1']['bs'] = 0; $monto_total['1']['us'] = 0;
        $monto_total['2']['bs'] = 0; $monto_total['2']['us'] = 0;
        $monto_total['3']['bs'] = 0; $monto_total['3']['us'] = 0;
        foreach($data as $d) {
            if($d->cuenta_codigo == '1') {
                $monto_total[$d->cuenta_codigo]['bs'] = $d->deudorBs - $d->acreedorBs;
                $monto_total[$d->cuenta_codigo]['us'] = $d->deudorUS - $d->acreedorUS;
            } else {
                $monto_total[$d->cuenta_codigo]['bs'] = $d->acreedorBs - $d->deudorBs;
                $monto_total[$d->cuenta_codigo]['us'] = $d->acreedorUS - $d->deudorUS;
            }
        }
        if($nivel_cuenta > 1) {
            $data2 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 2, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data2);
        }
        if($nivel_cuenta > 2) {
            $data3 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 3, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data3);
        }
        if($nivel_cuenta > 3) {
            $data4 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 4, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data4);
        }
        if($nivel_cuenta > 4) {
            $data5 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 5, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data5);
        }
        # Para ordenar las cuentas, según código
        usort($data, function($a, $b) {
            return $a->codigoCuentaOrdenar <=> $b->codigoCuentaOrdenar;
        });
        # ACTIVOS
        $data_activos = array_filter($data, function($d) {
            return (substr($d->cuenta_codigo, 0, 1) == '1');
        });

        # PASIVOS Y PATRIMONIO
        $data_pasivos_patrimonios = array_filter($data, function($cpp) {
            return (substr($cpp->cuenta_codigo, 0, 1) == '2' || substr($cpp->cuenta_codigo, 0, 1) == '3');
        });

        $response['data_activos'] = $data_activos;
        $response['data_pasivos_patrimonios'] = $data_pasivos_patrimonios;
        $response['total_activos_bs'] = $monto_total['1']['bs'];
        $response['total_activos_us'] = $monto_total['1']['us'];
        $response['total_pasivos_patrimonios_bs'] = $monto_total['2']['bs'] + $monto_total['3']['bs'];
        $response['total_pasivos_patrimonios_us'] = $monto_total['2']['us'] + $monto_total['3']['us'];

        return $response;
    }
    function getDataEstadoResultados($fechaini, $fechafin, $nivel_cuenta, $empresa_gestion_id) {
        $data = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 1, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
        $monto_total = [];
        $monto_total['4']['bs'] = 0; $monto_total['4']['us'] = 0;
        $monto_total['5']['bs'] = 0; $monto_total['5']['us'] = 0;
        foreach($data as $d) {
            if($d->cuenta_codigo == '4') {
                $monto_total[$d->cuenta_codigo]['bs'] = $d->acreedorBs - $d->deudorBs;
                $monto_total[$d->cuenta_codigo]['us'] = $d->acreedorUS - $d->deudorUS;
            } else if($d->cuenta_codigo == '5') {
                $monto_total[$d->cuenta_codigo]['bs'] = $d->deudorBs - $d->acreedorBs;
                $monto_total[$d->cuenta_codigo]['us'] = $d->deudorUS - $d->acreedorUS;
            }
        }
        if($nivel_cuenta > 1) {
            $data2 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 2, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data2);
        }
        if($nivel_cuenta > 2) {
            $data3 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 3, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data3);
        }
        if($nivel_cuenta > 3) {
            $data4 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 4, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data4);
        }
        if($nivel_cuenta > 4) {
            $data5 = $this->getDataBalanceSumasSaldos($fechaini, $fechafin, 5, $empresa_gestion_id, true); # cumplir longitud cod cuenta segun nivel
            $data = array_merge($data, $data5);
        }
        # Para ordenar las cuentas, según código
        usort($data, function($a, $b) {
            return $a->codigoCuentaOrdenar <=> $b->codigoCuentaOrdenar;
        });
        # INGRESOS
        $data_ingresos = array_filter($data, function($d) {
            return (substr($d->cuenta_codigo, 0, 1) == '4');
        });

        # EGRESOS
        $data_egresos = array_filter($data, function($cpp) {
            return (substr($cpp->cuenta_codigo, 0, 1) == '5');
        });

        $response['data_ingresos'] = $data_ingresos;
        $response['data_egresos'] = $data_egresos;
        $response['total_ingresos_bs'] = $monto_total['4']['bs'];
        $response['total_ingresos_us'] = $monto_total['4']['us'];
        $response['total_egresos_bs'] = $monto_total['5']['bs'];
        $response['total_egresos_us'] = $monto_total['5']['us'];

        return $response;
    }

    function generarDataBalanceGeneral($nivel1, $nivel2, $nivel3, $nivel4, $nivel5, $fechaini, $fechafin, $nivel_cuenta) { # TODO: ESTA FUNCIÓN SE DEBE SUSTITUIR
        # parametros de los tipos de cuentas
        $pn5  = $this->getCuentaTipoById(5);
        $pn4  = $this->getCuentaTipoById(4);
        $pn3  = $this->getCuentaTipoById(3);
        $pn2  = $this->getCuentaTipoById(2);
        $pn1  = $this->getCuentaTipoById(1);

        $data = [];
        foreach($nivel1 as $g){
            $data_cuenta = $this->getCuentaByCodigo($g); # codigo
            $obj['cuenta_codigo']        = $g;
            $obj['cuenta_nombre']        = $data_cuenta->nombre;
            $obj['cantCerosTipCuenta']  = $pn1->longitud;
            $obj['cuenta_tipo_sangria']   = $data_cuenta->cuenta_tipo_sangria;
            list($obj['montoBs'], $obj['montoUS']) = $this->getBalanceGeneralMontoBsUS($g, $fechaini, $fechafin, $pn1->longitud); # [0] : bolivianos y [1] : dólares

            $data[] = (object)$obj;
            if(($nivel_cuenta == 2)||($nivel_cuenta == 3)||($nivel_cuenta == 4)||(($nivel_cuenta == 5))){
                foreach($nivel2 as $r){
                    $rg = substr($r, 0, $pn1->longitud); # se filtra para obtener solo el digito del grupo
                    if($g == $rg){
                        $data_cuenta_r = $this->getCuentaByCodigo($r);
                        $obj['cuenta_codigo']        = $r;
                        $obj['cuenta_nombre']        = $data_cuenta_r->nombre;
                        $obj['cantCerosTipCuenta']  = $pn2->longitud;
                        $obj['cuenta_tipo_sangria']   = $data_cuenta_r->cuenta_tipo_sangria;
                        list($obj['montoBs'], $obj['montoUS']) = $this->getBalanceGeneralMontoBsUS($r, $fechaini, $fechafin, $pn2->longitud); # [0] : bolivianos y [1] : dólares
                        $data[] = (object)$obj;
                        #echo "rubro ".$r.'<br>';
                        if(($nivel_cuenta == 3)||($nivel_cuenta == 4)||(($nivel_cuenta == 5))){
                            foreach($nivel3 as $t){
                                $trg = substr($t, 0, $pn2->longitud); # se filtra para obtener solo el digito de rubro
                                if($r == $trg){
                                    $data_cuenta_t = $this->getCuentaByCodigo($t);
                                    $obj['cuenta_codigo']        = $t;
                                    $obj['cuenta_nombre']        = $data_cuenta_t->nombre;
                                    $obj['cantCerosTipCuenta']  = $pn3->longitud;
                                    $obj['cuenta_tipo_sangria']   = $data_cuenta_t->cuenta_tipo_sangria;
                                    list($obj['montoBs'], $obj['montoUS']) = $this->getBalanceGeneralMontoBsUS($t, $fechaini, $fechafin, $pn3->longitud); # [0] : bolivianos y [1] : dólares
                                    $data[] = (object)$obj;
                                    #echo "titulo ".$t.'<br>';
                                    if(($nivel_cuenta == 4)||(($nivel_cuenta == 5))){
                                        foreach($nivel4 as $c){
                                            $ctrg = substr($c, 0, $pn3->longitud); # se filtra para obtener solo el digito de titulo
                                            if($t == $ctrg){
                                                $data_cuenta_c = $this->getCuentaByCodigo($c);
                                                $obj['cuenta_codigo']        = $c;
                                                $obj['cuenta_nombre']        = $data_cuenta_c->nombre;
                                                $obj['cantCerosTipCuenta']  = $pn4->longitud;
                                                $obj['cuenta_tipo_sangria']   = $data_cuenta_c->cuenta_tipo_sangria;
                                                list($obj['montoBs'], $obj['montoUS']) = $this->getBalanceGeneralMontoBsUS($c, $fechaini, $fechafin, $pn4->longitud); # [0] : bolivianos y [1] : dólares
                                                $data[] = (object)$obj;
                                                #echo "cuenta ".$c.'<br>';
                                                if($nivel_cuenta == 5){
                                                    foreach($nivel5 as $s){
                                                        $sctrg = substr($s, 0, $pn4->longitud); # se filtra para obtener solo el digito de cuenta
                                                        if($c == $sctrg){
                                                            $data_cuenta_s = $this->getCuentaByCodigo($s);
                                                            $obj['cuenta_codigo']        = $s;
                                                            $obj['cuenta_nombre']        = $data_cuenta_s->nombre;
                                                            $obj['cantCerosTipCuenta']  = $pn5->longitud;
                                                            $obj['cuenta_tipo_sangria']   = $data_cuenta_s->cuenta_tipo_sangria;
                                                            list($obj['montoBs'], $obj['montoUS']) = $this->getBalanceGeneralMontoBsUS($s, $fechaini, $fechafin, 10); # [0] : bolivianos y [1] : dólares
                                                            $data[] = (object)$obj;
                                                            #echo 'sub-cuenta '.$s.'<br>';
                                                        }
                                                    } # nivel5
                                                }
                                            }
                                        } # nivel4
                                    }
                                }
                            } # nivel3
                        }
                    }
                } # nivel2
            }
        } # nivel1
        return $data;
    }
    function getBalanceGeneralMontoBsUS($cuenta_codigo, $fechaIni, $fechaFin, $caracteresCodigo){
        # Obtencion de todos los datos
        $this->db->select('dc.debeBs, dc.haberBs, dc.debeUS, dc.haberUS, cc.codigo as cuenta_codigo');
        $this->db->join('cofi_comprobantes as c', 'c.id = dc.comprobante_id');
        $this->db->join('cofi_cuentas cc', 'cc.id = dc.cuenta_id');
        $this->db->where('c.fecha >=', $fechaIni);
        $this->db->where('c.fecha <=', $fechaFin);
        $this->db->where('c.empresa_gestion_id', $this->session->userdata('empresa_gestion_id')); # datos según empresa&gestión
        $data = $this->db->get('cofi_comprobantes_data as dc')->result();
        $a1 = 0;
        $a2 = 0;
        $a3 = 0;
        $a4 = 0;
        foreach($data as $r){
            if($cuenta_codigo == substr($r->cuenta_codigo, 0, $caracteresCodigo)){
                $a1 += $r->debeBs;
                $a2 += $r->haberBs;
                $a3 += $r->debeUS;
                $a4 += $r->haberUS;
            }
        }
        return [$a1-$a2, $a3-$a4]; # [0]: Bolivianos, [1]: Dólares
    }
    function getDataEstadoCuentas($fechaini, $fechafin, $idcuenta, $empresa_gestion_id){
        $codigoCuentaForm   = $this->getCuentaById($idcuenta)->codigo;
        # parametros de los tipos de cuentas
        $pn4                 = $this->getCuentaTipoById(4);
        # Obtencion de todos los datos
        $this->db->select('c.*, cta.*, dc.*, cta.codigo as cuenta_codigo, cta.nombre as cuenta_nombre');
        $this->db->from('cofi_comprobantes as c');
        $this->db->where('c.fecha >=', $fechaini);
        $this->db->where('c.fecha <=', $fechafin);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->where('c.anulado', '0'); # COMPROBANTES NO ANULADOS
        $this->db->join('cofi_comprobantes_data as dc', 'dc.comprobante_id = c.id');
        $this->db->join('cofi_cuentas as cta', 'cta.id = dc.cuenta_id');
        $this->db->order_by('cta.codigo', 'asc');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $data = false;
            # GENERAR DATOS ORDENADOS PARA EL ESTADO DE CUENTA
            foreach($res->result() as $r)
                if((substr($r->cuenta_codigo, 0, $pn4->longitud)) == $codigoCuentaForm)
                    $subCuentas[]   = substr($r->cuenta_codigo, 0, 10);

            $subCuentas  = array_unique($subCuentas); # Se eliminan los datos repetidos
            foreach($subCuentas as $sc){
                $adb=0;$ahb=0;$add=0;$ahd=0;
                foreach($res->result() as $r){
                    if($sc == $r->cuenta_codigo){
                        $nomCuenta = $r->cuenta_nombre;
                        $adb += $r->debeBs;
                        $ahb += $r->haberBs;
                        $add += $r->debeUS;
                        $ahd += $r->haberUS;
                    }
                }
                $obj['cuenta_codigo']    = $sc;
                $obj['cuenta_nombre']    = $nomCuenta;
                # Data en Bolivianos y Dólares
                $obj['debeBs']      = $adb;
                $obj['haberBs']     = $ahb;
                $obj['debeUS']      = $add;
                $obj['haberUS']     = $ahd;
                if($adb > $ahb){
                    $obj['deudorBs']    = $adb - $ahb;
                    $obj['acreedorBs']  = 0;
                    $obj['deudorUS']    = $add - $ahd;
                    $obj['acreedorUS']  = 0;
                }else{
                    $obj['deudorBs']    = 0;
                    $obj['acreedorBs']  = $ahb - $adb;
                    $obj['deudorUS']    = 0;
                    $obj['acreedorUS']  = $ahd - $add;
                }
                $data[] = (object)$obj;
            }
            return $data;
        } else {
            return false;
        }
    }
    function verificarRegistrosCuentaById($fechaini, $fechafin, $idcuenta, $empresa_gestion_id){
        # parametros de los tipos de cuentas
        $pn4             = $this->getCuentaTipoById(4);
        # Obtencion de todos los datos
        $this->db->select('cta.codigo as cuenta_codigo');
        $this->db->from('cofi_comprobantes as c');
        $this->db->where('c.fecha >=', $fechaini);
        $this->db->where('c.fecha <=', $fechafin);
        $this->db->where('c.empresa_gestion_id', $empresa_gestion_id);
        $this->db->where('c.anulado', '0'); # COMPROBANTES NO ANULADOS
        $this->db->join('cofi_comprobantes_data as dc', 'dc.comprobante_id = c.id');
        $this->db->join('cofi_cuentas as cta', 'cta.id = dc.cuenta_id');
        $res = $this->db->get();
        if($res->num_rows() > 0){
            $data_cuenta = $this->getCuentaById($idcuenta);
            foreach($res->result() as $r){
                if(substr($r->cuenta_codigo, 0, $pn4->longitud) == $data_cuenta->codigo)
                    return true;
            }
            return false;
        }
        return false;
    }
    function getBalanceGralEstadoResComp($niCta, $tpMon, $tpBal, $mesBal, $gestion){
        $anio = $gestion;
        # obtenemos la lista de todas las cuentas que intervienen en el rango seleccionado
        # será desde el 01/01/XXXX hasta '$fechaFin'
        $fechaIni = "2020-01-01";
        $fechaFin = $anio.'-'.$mesBal.'-'.cal_days_in_month(CAL_GREGORIAN, $mesBal, $anio); // (CG, mes, año)
        # parametros de los tipos de cuentas
        $pn4  = $this->getCuentaTipoById(4);
        $pn3  = $this->getCuentaTipoById(3);
        $pn2  = $this->getCuentaTipoById(2);
        $pn1  = $this->getCuentaTipoById(1);

        # lista de todas las sub cuentas disponibles de los datos proporcionados
        $this->db->select('cta.codigo as cuenta_codigo');
        $this->db->from('cofi_comprobantes as c');
        $this->db->where('c.fecha >=', $fechaIni);
        $this->db->where('c.fecha <=', $fechaFin);
        $this->db->join('cofi_comprobantes_data as dc', 'dc.comprobante_id = c.id');
        $this->db->join('cofi_cuentas as cta', 'cta.id = dc.cuenta_id');
        $this->db->order_by('cta.codigo', 'asc');
        $res    = $this->db->get();
        if($res->num_rows() > 0){
            $subcuentasG  = array_unique($res->result(), SORT_REGULAR);
            # Obtener cuentas, titulos, rubros, grupos
            foreach($subcuentasG as $sc){
                $subCuentas[]   = substr($sc->cuenta_codigo, 0, 10);
                $cuentas[]      = substr($sc->cuenta_codigo, 0, $pn4->longitud);
                $titulos[]      = substr($sc->cuenta_codigo, 0, $pn3->longitud);
                $rubros[]       = substr($sc->cuenta_codigo, 0, $pn2->longitud);
                $grupos[]       = substr($sc->cuenta_codigo, 0, $pn1->longitud);
            }
            $cuentas  = array_unique($cuentas); # Se eliminan los datos repetidos
            $titulos  = array_unique($titulos); # Se eliminan los datos repetidos
            $rubros   = array_unique($rubros);  # Se eliminan los datos repetidos
            $grupos   = array_unique($grupos);  # Se eliminan los datos repetidos

            for($i=1;$i<=$mesBal;$i++){
                $fechaini = $anio.'-'.$i.'-01';
                $fechafin = $anio.'-'.$i.'-'.cal_days_in_month(CAL_GREGORIAN, $i, $anio); // (CG, mes, año)
                $data[$i] = $this->generarDataBalanceGeneral($grupos, $rubros, $titulos, $cuentas, $subCuentas, $fechaini, $fechafin, $niCta);
            }
            # en '$data' esta la información de todos los meses
            #print_r($data[1]); # primer mes
            #echo "<br><br>";
            return $data;

        }else{
            return false;
        }
    }

    # ------------------------------------------------------------------------------------------
    # -------------------------------------- ADMINISTRACIÓN ------------------------------------
    # ------------------------------------------------------------------------------------------
    public function getEmpresas() {
        $this->db->select('*');
        return $this->db->get('cofi_empresas')->result();
    }
    public function getPeriodosTipos() {
        $this->db->select('*');
        $this->db->from('cofi_periodos_tipos');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }
    public function getGestionesAllEmpresas() {
        $this->db->select('*');
        return $this->db->get('cofi_empresas_gestiones')->result();
    }
    public function registrarEmpresa($data) {
        $this->db->insert('cofi_empresas', $data);
        return $this->db->insert_id();
    }
    public function actualizarEmpresa($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('cofi_empresas', $data);
    }
    public function registrarEmpresaGestion($data) {
        $this->db->insert('cofi_empresas_gestiones', $data);
        return $this->db->insert_id();
    }
    public function getEmpresaGestionArray($empresa_gestion_id) {
        $this->db->select('ge.*, e.*');
        $this->db->where('ge.id', $empresa_gestion_id);
        $this->db->join('cofi_empresas as e', 'e.id = ge.empresa_id');
        return (array) $this->db->get('cofi_empresas_gestiones as ge')->row();
    }
    public function getEmpresasUltimaGestion() {
        $this->db->select('e.id, e.nombre, MAX(ge.gestion) as ultimaGestion');
        $this->db->join('cofi_empresas_gestiones ge', 'ge.empresa_id=e.id', 'left');
        $this->db->group_by('e.id, e.nombre');
        return $this->db->get('cofi_empresas e')->result();
    }
    public function getUltimaEmpresaGestionByIdEmpresa($empresa_id) {
        $this->db->select('*');
        $this->db->from('cofi_empresas_gestiones');
        $this->db->where('empresa_id', $empresa_id);
        return $this->db->get()->last_row();
    }

    # ------------------------------------------------------------------------------------------
    # ------------------------------------ GENERIC FUNCTIONS------------------------------------
    # ------------------------------------------------------------------------------------------
    public function insert($tabla, $data) {
        $this->db->insert($tabla, $data);
        return $this->db->insert_id();
    }
    public function updateById($tabla, $data, $id) {
        $this->db->where('id', $id);
        return $this->db->update($tabla, $data);
    }
    public function deleteByCustomAttribute($tabla, $atribute, $value) {
        $this->db->where($atribute, $value);
        return $this->db->delete($tabla);
    }
    public function getPlantillasByGestionEmpresa() {
        $this->db->select('*');
        $this->db->where('empresa_gestion_id', $this->session->userdata('empresa_gestion_id'));
        return $this->db->get('cofi_plantillas')->result();
    }
    public function getPlantillaById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        return $this->db->get('cofi_plantillas')->row();
    }
    public function getPlantillaDataByPlantillaId($plantilla_id) {
        $this->db->select('pd.*, c.nombre as cuenta_nombre, c.codigo_formato as cuenta_codigo_formato');
        $this->db->join('cofi_cuentas c', 'c.id=pd.cuenta_id', 'left');
        $this->db->where('pd.plantilla_id', $plantilla_id);
        return $this->db->get('cofi_plantillas_data as pd')->result();
    }
    public function getPlantillasByCuentaId($cuenta_id) {
        $this->db->select('p.*');
        $this->db->join('cofi_plantillas_data pd', 'pd.plantilla_id = p.id', 'left');
        $this->db->where('pd.cuenta_id', $cuenta_id);
        return $this->db->get('cofi_plantillas p')->result();
    }
}
