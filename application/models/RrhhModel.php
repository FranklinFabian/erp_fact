<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class RrhhModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('lcustomer');
        $this->load->library('Smsgateway');
        $this->load->library('session');
        $this->load->model('Customers');
        $this->auth->check_admin_auth();
    }
    # ******************************************************************************************
    # **************************************** EMPLEADOS ***************************************
    # ******************************************************************************************
    public function getEmpleados() {
        $this->db->select('e.*, ei.cargo as nombre_item, ei.basico, es.servicio, es.descripcion as nombre_seccion, CONCAT(e.paterno, " ", e.materno, " ", e.nombre1, " ", e.nombre2) as nombre_empleado,');
        $this->db->join('rrhh_empleado_item ei', 'ei.id = e.item');
        $this->db->join('rrhh_empleado_seccion es', 'es.id = ei.seccion');
        $this->db->order_by('e.paterno', 'ASC');
        return $this->db->get('rrhh_empleado e')->result();
    }
    public function getEmpleado($empleado) {
        #$this->db->select('l.*, CAST(l.modalidadContrato as UNSIGNED) as modalidadContratoNumero');
        $this->db->select('e.*, ei.cargo as nombre_item, ei.basico');
        $this->db->where('e.empleado', $empleado);
        $this->db->join('rrhh_empleado_item ei', 'ei.id = e.item');
        $this->db->order_by('e.paterno', 'ASC');
        $res = $this->db->get('rrhh_empleado e');
        if ($res->num_rows() > 0)
            return $res->row();
        return [];
    }
    function get_enum_values($table, $field) {
        $type = $this->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row(0)->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }
    public function getItems() {
        $this->db->select('i.*, es.descripcion, es.servicio, ss.Servicio as nombre_servicio');
        $this->db->join('rrhh_empleado_seccion es', 'es.id = i.seccion');
        $this->db->join('sis_servicios ss', 'ss.Id_Servicio = es.servicio');
        return $this->db->get('rrhh_empleado_item i')->result();
    }
    public function crearNuevoUsuario($data){
        $this->db->insert('rrhh_empleado', $data);
        return $this->db->insert_id();      # devuelve el id del registro creado
    }
    public function deleteEmpleadoById($id){
        $this->db->where('id', $id);
        return $this->db->delete('rrhh_empleado');
    }
    public function updateEmpleado($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado', $data);
    }
    public function getFamiliaresByEmpleado($empleado) {
        $this->db->select('f.*');
        $this->db->where('f.empleado', $empleado); # nro de documento
        $res = $this->db->get('rrhh_empleado_familia f');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevoFamiliarEmpleado($data){
        $this->db->insert('rrhh_empleado_familia', $data);
        return $this->db->insert_id();      # devuelve el id del registro creado
    }
    public function updateFamiliarEmpleado($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_familia', $data);
    }
    public function deleteFamiliarEmpleadoById($id){
        $this->db->where('id', $id);
        return $this->db->delete('rrhh_empleado_familia');
    }
    # ------------------------------------------- ITEMS ------------------------------------------
    function getSecciones() {
        $this->db->select('s.*, ss.Servicio as nombre_servicio');
        $this->db->join('sis_servicios ss', 'ss.Id_Servicio = s.servicio');
        return $this->db->get('rrhh_empleado_seccion s')->result();
    }
    public function crearNuevoItem($data){
        $this->db->insert('rrhh_empleado_item', $data);
        return $this->db->insert_id();      # devuelve el id del registro creado
    }
    public function updateItem($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_item', $data);
    }
    # ----------------------------------------- SERVICIOS -----------------------------------------
    public function getSisServicios() {
        return $this->db->get('sis_servicios')->result();
    }
    public function crearNuevaSeccion($data){
        $this->db->insert('rrhh_empleado_seccion', $data);
        return $this->db->insert_id();      # devuelve el id del registro creado
    }
    public function updateSeccion($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_seccion', $data);
    }
    # ----------------------------------------- ASISTENCIA ----------------------------------------
    public function getMesHabilidato() {
        $this->db->select('m.*');
        $this->db->where('m.estado', '1');
        $res = $this->db->get('rrhh_empleado_mes m');
        if ($res->num_rows() > 0) {
            $r = array();
            $r[0] = ($res->row());
            return $r;
        } return [];
    }
    public function registrarAsistenciaDiaMesEmpleado($data) {
        $this->db->select('ead.*');
        $this->db->where('ead.empleado', $data['empleado']);
        $this->db->where('ead.fecha', $data['fecha']);
        $res = $this->db->get('rrhh_empleado_asistencia_dia ead');
        if ($res->num_rows() <= 0) {
            $this->db->insert('rrhh_empleado_asistencia_dia', $data);
            return $this->db->insert_id();      # devuelve el id del registro creado
        } return 0;
    }
    public function updateAsistencia($nro_ci_emp, $fecha, $data_asistencia) {
        $this->db->where('empleado', $nro_ci_emp);
        $this->db->where('fecha', $fecha);
        return $this->db->update('rrhh_empleado_asistencia_dia', $data_asistencia);
    }
    public function getAsistenciaMesEmpleado($nro_ci_empleado, $mes_asistencia) {
        $this->db->select('ad.*, c.descripcion');
        $this->db->join('rrhh_empleado_control c', 'c.control = ad.control', 'left');
        $this->db->where('ad.empleado', $nro_ci_empleado);
        $this->db->where('ad.mes', $mes_asistencia);
        $this->db->order_by('ad.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_asistencia_dia ad');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getDataAsistenciaByRangoFechas($empleado, $fecha_ini, $fecha_fin) {
        $this->db->select('ad.*, c.descripcion');
        $this->db->join('rrhh_empleado_control c', 'c.control = ad.control', 'left');
        $this->db->where('ad.empleado', $empleado);
        $this->db->where('ad.fecha >=', $fecha_ini);
        $this->db->where('ad.fecha <=', $fecha_fin);
        $this->db->order_by('ad.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_asistencia_dia ad');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getDataAsistenciaByControlAndRangoFechas($control, $empleado, $fecha_ini, $fecha_fin) {
        $this->db->select('ad.*, c.descripcion');
        $this->db->join('rrhh_empleado_control c', 'c.control = ad.control', 'left');
        $this->db->where('ad.empleado', $empleado);
        $this->db->where('ad.fecha >=', $fecha_ini);
        $this->db->where('ad.fecha <=', $fecha_fin);
        $this->db->where('ad.control', $control);
        $this->db->order_by('ad.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_asistencia_dia ad');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getDataAsistenciaLicenciasVacacionesByRangoFechas($empleado, $fecha_ini, $fecha_fin) {
        $this->db->select('ad.*, c.descripcion');
        $this->db->join('rrhh_empleado_control c', 'c.control = ad.control', 'left');
        $this->db->where('ad.empleado', $empleado);
        $this->db->where('ad.fecha >=', $fecha_ini);
        $this->db->where('ad.fecha <=', $fecha_fin);
        $this->db->where('(ad.control="VA" or ad.control="L1" or ad.control="L2")');
        $this->db->order_by('ad.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_asistencia_dia ad');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    # ------------------------------------------ VACACIONES -----------------------------------------
    public function getVacacionById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        return $this->db->get('rrhh_empleado_vacaciones')->row();
    }
    public function getDataVacacionesEmpleado($empleado) {
        $this->db->select('*');
        $this->db->where('empleado', $empleado);
        return $this->db->get('rrhh_empleado_vacaciones')->result();
    }
    public function getVacacionesRangoFechaEmpleado($empleado, $vacacion, $fecha_ini, $fecha_fin) {
        $this->db->select('*');
        $this->db->where('empleado', $empleado);
        $this->db->where('fecha>=', $fecha_ini);
        $this->db->where('fecha<=', $fecha_fin);
        $this->db->where('control', $vacacion); # Vacaciones
        return $this->db->get('rrhh_empleado_asistencia_dia')->result();
    }
    public function registrarVacacionRegistroEmpleado($data) {
        $this->db->insert('rrhh_empleado_vacaciones', $data);
        return $this->db->insert_id();
    }
    public function actualizarVacacionRegistroEmpleado($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_vacaciones', $data);
    }
    public function inactivarVacacionRegistroEmpleadoActivo($empleado, $data) {
        $this->db->where('empleado', $empleado);
        $this->db->where('estado', 1);
        return $this->db->update('rrhh_empleado_vacaciones', $data);
    }
    # --------------------------------------- REGISTRO MENSUAL --------------------------------------
    # -----------------------------------------------------------------------------------------------

    # ------------------------------------------ ANTICIPOS ------------------------------------------
    public function getAllMeses() {
        $this->db->select('m.*');
        $this->db->order_by('m.mes', 'desc');
        return $this->db->get('rrhh_empleado_mes m')->result();
    }
    # ---- Modulos Formato 1 -> Anticipos, Form 101, Fondo Rotativo, Sindicato
    public function getRegistrosMensualesByTablaRangoFechas($nombre_Tabla,  $fecha_ini, $fecha_fin) {
        $this->db->select('rm.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('rm.mes >=', $fecha_ini);
        $this->db->where('rm.mes <=', $fecha_fin);
        $this->db->order_by('e.paterno', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado = rm.empleado');
        $res = $this->db->get($nombre_Tabla.' rm');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevoRegistroMensual($nombre_tabla, $data) {
        return $this->db->insert($nombre_tabla, $data);
    }
    public function updateRegistroMensual($nombre_tabla, $empleado, $mes, $data){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        return $this->db->update($nombre_tabla, $data);
    }
    public function deleteRegistroMensual($nombre_tabla, $empleado, $mes){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        return $this->db->delete($nombre_tabla);
    }
    # ----------------------------------------- HORAS EXTRAS ----------------------------------------
    public function getHorasExtrasTotalesByMes($mes) {
        $this->db->select('he.*');
        $this->db->where('he.mes', $mes);
        $this->db->order_by('he.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_horas_extras he');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getRegistrosResumenHorasExtrasByMes($mes) {
        $data_empleados = $this->getEmpleados();
        $data_horas_extras = [];
        $data_horas_extras_totales_mes   = []; # result

        $this->db->select('he.*');
        $this->db->where('he.mes', $mes);
        $this->db->order_by('he.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_horas_extras he');
        if ($res->num_rows() > 0)
            $data_horas_extras = $res->result();

        foreach($data_empleados as $emp) {
            $sum_sencillas = 0; $sum_dobles = 0; $sum_nocturnas = 0; $sum_recargo = 0; $sum_total_horas_extras = 0; $sw = false;
            foreach($data_horas_extras as $he) {
                if($he->empleado == $emp->empleado) {
                    $sw             = true;
                    $sum_sencillas  += floatval($he->sencillas);
                    $sum_dobles     += floatval($he->dobles);
                    $sum_nocturnas  += floatval($he->nocturnas);
                    $sum_recargo    += floatval($he->nocturnas)*0.3; # 30% del las hrs nocturnas
                    $sum_total_horas_extras += floatval($he->dobles) + floatval($he->nocturnas)*0.3;
                }
            }
            if($sw){
                $data_aux                       = [];
                $data_aux                       = (array) $emp;
                $data_aux['total_sencillas']    = round($sum_sencillas, 2, PHP_ROUND_HALF_DOWN);
                $data_aux['total_dobles']       = round($sum_dobles, 2, PHP_ROUND_HALF_DOWN);
                $data_aux['total_nocturnas']    = round($sum_nocturnas, 2, PHP_ROUND_HALF_DOWN);
                $data_aux['total_recargo']      = round($sum_recargo, 2, PHP_ROUND_HALF_DOWN);
                $data_aux['total_hrs_extras']   = round($sum_total_horas_extras, 2, PHP_ROUND_HALF_DOWN);
                array_push($data_horas_extras_totales_mes, $data_aux);
            }
        }
        return $data_horas_extras_totales_mes;
    }
    public function getHorasExtrasEmpleadoByMes($empleado, $mes) {
        $this->db->select('he.*');
        $this->db->where('he.empleado', $empleado);
        $this->db->where('he.mes', $mes);
        $this->db->order_by('he.fecha', 'asc');
        $res = $this->db->get('rrhh_empleado_horas_extras he');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getRegistrosHorasExtrasByRangoFechas($empleado,  $fecha_ini, $fecha_fin) {
        $this->db->select('he.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('he.mes >=', $fecha_ini);
        $this->db->where('he.mes <=', $fecha_fin);
        $this->db->where('he.empleado', $empleado);
        $this->db->order_by('he.fecha', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado = he.empleado');
        $res = $this->db->get('rrhh_empleado_horas_extras he');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevasHorasExtras($data) {
        return $this->db->insert('rrhh_empleado_horas_extras', $data);
    }
    public function updateHorasExtras($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_horas_extras', $data);
    }
    public function deleteHorasExtras($id_hora_extra){
        $this->db->where('id', $id_hora_extra);
        return $this->db->delete('rrhh_empleado_horas_extras');
    }
    # ------------------------------------------ SUPLENCIAS -----------------------------------------
    public function getSuplenciasByMes($fecha_ini, $fecha_fin) {
        $this->db->select('s.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('s.mes >=', $fecha_ini);
        $this->db->where('s.mes <=', $fecha_fin);
        $this->db->order_by('e.paterno', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado = s.empleado');
        $res = $this->db->get('rrhh_empleado_suplencia s');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevaSuplencia($data) {
        return $this->db->insert('rrhh_empleado_suplencia', $data);
    }
    public function updateSuplencia($empleado, $mes, $item, $data){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        $this->db->where('item', $item);
        return $this->db->update('rrhh_empleado_suplencia', $data);
    }
    public function deleteSuplencia($empleado, $mes, $item){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        $this->db->where('item', $item);
        return $this->db->delete('rrhh_empleado_suplencia');
    }
    # ------------------------------------------ SANCIONES -----------------------------------------
    public function getSancionesByMes($fecha_ini, $fecha_fin) {
        $this->db->select('s.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('s.mes >=', $fecha_ini);
        $this->db->where('s.mes <=', $fecha_fin);
        $this->db->order_by('e.paterno', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado = s.empleado');
        $res = $this->db->get('rrhh_empleado_sancion s');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevaSancion($data) {
        return $this->db->insert('rrhh_empleado_sancion', $data);
    }
    public function updateSancion($empleado, $mes, $data){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        return $this->db->update('rrhh_empleado_sancion', $data);
    }
    public function deleteSancion($empleado, $mes){
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes);
        return $this->db->delete('rrhh_empleado_sancion');
    }
    public function getSancionesByRangoFechas($fecha_ini, $fecha_fin) {
        $this->db->select('rm.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('rm.mes >=', $fecha_ini);
        $this->db->where('rm.mes <=', $fecha_fin);
        $this->db->order_by('e.paterno', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado = rm.empleado');
        $res = $this->db->get('rrhh_empleado_sancion rm');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }

    # -------------------------------------------- CONTROL ------------------------------------------
    public function getControles() {
        return $this->db->get('rrhh_empleado_control c')->result();
    }
    public function getControl($control) {
        $this->db->where('control', $control);
        return $this->db->get('rrhh_empleado_control')->row();
    }
    public function registrarControl($data){
        $this->db->insert('rrhh_empleado_control', $data);
        return $this->db->insert_id();
    }
    public function actualizarControl($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('rrhh_empleado_control', $data);
    }
    # ------------------------------------------- FACTORES ------------------------------------------
    function getMeses() {
        $this->db->select('m.*');
        # $this->db->join('rrhh_empleado_seccion es', 'es.id = i.seccion'); # con servicios
        $this->db->order_by('m.mes', 'desc');
        $res = $this->db->get('rrhh_empleado_mes m');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function crearNuevoMes($data){
        return $this->db->insert('rrhh_empleado_mes', $data);
    }
    public function updateMes($mes, $data){
        $this->db->where('mes', $mes);
        return $this->db->update('rrhh_empleado_mes', $data);
    }
    # ------------------------------------------- CALCULOS ------------------------------------------
    public function getAllMesesAnio($anio) {
        $this->db->select('m.*');
        $this->db->where('m.mes >= ', $anio.'-01-01');
        $this->db->order_by('m.mes', 'asc');
        $res = $this->db->get('rrhh_empleado_mes m');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getSuplenciasByMesEmpleado($fecha_ini, $fecha_fin, $empleado) {
        $this->db->select('s.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('e.empleado', $empleado);
        $this->db->where('s.mes >=', $fecha_ini);
        $this->db->where('s.mes <=', $fecha_fin);
        $this->db->join('rrhh_empleado e', 'e.empleado = s.empleado');
        $res = $this->db->get('rrhh_empleado_suplencia s');
        if ($res->num_rows() > 0)
            return $res->result();
        return [];
    }
    public function getHaberBasicoByItem($item) {
        $this->db->select('i.*');
        $this->db->where('i.id', $item);
        $res = $this->db->get('rrhh_empleado_item i');
        if ($res->num_rows() > 0)
            return $res->row();
        return [];
    }
    public function getPorcentajeBonoAntiguedad($anios){
        $this->db->select('ba.*');
        $this->db->where('ba.anio_inicio <=', $anios); # que este dentro del rango de asignacion de bono de antiguedad
        $this->db->where('ba.anio_final >', $anios);
        $res = $this->db->get('rrhh_empleado_bono_antiguedad ba');
        if ($res->num_rows() > 0)
            return $res->row(); # devuelve el caso de bono de antiguedad que corresponde
        else
            return false;
    }
    public function getParametrosMes($mes) {
        $this->db->select('m.*');
        $this->db->where('m.mes', $mes);
        $res = $this->db->get('rrhh_empleado_mes m');
        if ($res->num_rows() > 0)
            return $res->row();
        return [];
    }
    public function getSancionesEmpleadoMes($fecha_ini, $fecha_fin, $empleado) {
        $this->db->select('s.*, e.paterno, e.materno, e.nombre1, e.nombre2');
        $this->db->where('e.empleado', $empleado);
        $this->db->where('s.mes >=', $fecha_ini);
        $this->db->where('s.mes <=', $fecha_fin);
        $this->db->join('rrhh_empleado e', 'e.empleado = s.empleado');
        $res = $this->db->get('rrhh_empleado_sancion s');
        if ($res->num_rows() > 0)
            return $res->row(); # Solo hay un registro por mes
        return [];
    }
    public function getFondoRotativoEmpleadoMes($mes_planilla, $empleado) {
        $this->db->select('fr.*');
        $this->db->where('fr.empleado', $empleado);
        $this->db->where('fr.mes', $mes_planilla);
        $res = $this->db->get('rrhh_empleado_fondo_rotativo fr');
        if ($res->num_rows() > 0)
            return $res->row(); # Solo hay un registro por mes
        return [];
    }
    public function getAnticipoEmpleadoMes($mes_planilla, $empleado) {
        $this->db->select('a.*');
        $this->db->where('a.empleado', $empleado);
        $this->db->where('a.mes', $mes_planilla);
        $res = $this->db->get('rrhh_empleado_anticipos a');
        if ($res->num_rows() > 0)
            return $res->row(); # Solo hay un registro por mes
        return [];
    }
    public function getForm101EmpleadoMes($mes_planilla, $empleado) {
        $this->db->select('f.*');
        $this->db->where('f.empleado', $empleado);
        $this->db->where('f.mes', $mes_planilla);
        $res = $this->db->get('rrhh_empleado_form101 f');
        if ($res->num_rows() > 0)
            return $res->row(); # Solo hay un registro por mes
        return [];
    }
    # Registrar Cálculos
    public function existeCalculosPlanillaSalarialEmpleado($empleado, $mes_planilla) {
        $this->db->select('id');
        $this->db->from('rrhh_empleado_sueldo');
        $this->db->where('empleado', $empleado);
        $this->db->where('mes', $mes_planilla);
        return $this->db->get()->row();
    }
    public function registrarCalculosPlanillaSalarialEmpleado($data) {
        $this->db->insert('rrhh_empleado_sueldo', $data);
        return $this->db->insert_id(); # devuelve el id del registro creado
    }
    public function actualizarCalculosPlanillaSalarialEmpleado($id_sueldo, $data) {
        $this->db->where('id', $id_sueldo);
        return $this->db->update('rrhh_empleado_sueldo', $data);
    }
    # PLANILAS - Planilla Salarial
    public function getDataPlanillaSalarialByServicioByMes($servicio, $mes) {
        $this->db->select('s.*, es.id as seccion_empleado, e.item, CONCAT(e.paterno, " ", e.materno, " ", e.nombre1, " ", e.nombre2) as nombre_empleado, ei.cargo, e.empleado as cid_empleado, e.fecha_ingreso');
        $this->db->where('s.mes', $mes);
        $this->db->join('rrhh_empleado e', 'e.empleado=s.empleado', 'left');
        $this->db->join('rrhh_empleado_item ei', 'ei.id=e.item', 'left');
        $this->db->join('rrhh_empleado_seccion es', 'es.id=ei.seccion', 'left');
        $this->db->where('es.servicio', $servicio);
        $this->db->order_by('e.item', 'asc');
        return $this->db->get('rrhh_empleado_sueldo s')->result();
    }
    function getSeccionesByServicio($servicio) {
        $this->db->select('s.*');
        $this->db->where('s.servicio', $servicio);
        return $this->db->get('rrhh_empleado_seccion s')->result();
    }
    # Planilla Incremento Salarial
    public function getMesesIncremetoSalarialByGestion($gestion) {
        $this->db->distinct();
        $this->db->select('is.mes');
        $this->db->where('is.mes >=', $gestion.'-01-31');
        $this->db->where('is.mes <=', $gestion.'-12-31');
        return $this->db->get('rrhh_empleado_incremento is')->result();
    }
    public function getDataIncrementoSalarialByGestion($gestion) {
        $this->db->select('is.*, CONCAT(e.paterno, " ", e.materno, " ", e.nombre1, " ", e.nombre2) as nombre_empleado, e.nacionalidad, e.fecha_nacimiento, ei.cargo, e.fecha_ingreso, es.servicio, ei.seccion, e.item, e.clasificacion_laboral, e.contrato, e.horas_pagadas');
        $this->db->where('is.mes >=', $gestion.'-01-31');
        $this->db->where('is.mes <=', $gestion.'-12-31');
        $this->db->order_by('is.empleado', 'asc');
        $this->db->order_by('is.mes', 'asc');
        $this->db->join('rrhh_empleado e', 'e.empleado=is.empleado', 'left');
        $this->db->join('rrhh_empleado_item ei', 'ei.id=e.item', 'left');
        $this->db->join('rrhh_empleado_seccion es', 'es.id=ei.seccion', 'left');
        return $this->db->get('rrhh_empleado_incremento is')->result();
    }
    public function getDataSalarioByMesIniMesFin($mes_ini, $mes_fin) {
        $this->db->select('s.*');
        $this->db->where('s.mes >=', $mes_ini);
        $this->db->where('s.mes <=', $mes_fin);
        #$this->db->order_by('is.empleado', 'asc');
        #$this->db->order_by('is.mes', 'asc');
        return $this->db->get('rrhh_empleado_sueldo s')->result();
    }
    # Planilla de Asistencia
    public function getEmpleadosAsistenciaByMes($fecha_ini, $fecha_fin) {
        $this->db->distinct();
        $this->db->select('ea.empleado, CONCAT(e.paterno, " ", e.materno, " ", e.nombre1, " ", e.nombre2) as nombre_empleado');
        $this->db->where('ea.fecha >=', $fecha_ini);
        $this->db->where('ea.fecha <=', $fecha_fin);
        $this->db->join('rrhh_empleado e', 'e.empleado=ea.empleado', 'left');
        $this->db->order_by('e.paterno', 'asc');
        $this->db->order_by('e.materno', 'asc');
        return $this->db->get('rrhh_empleado_asistencia_dia ea')->result();
    }
    public function getDataAsistenciaByMes($fecha_ini, $fecha_fin) {
        $this->db->select('ea.*');
        $this->db->where('ea.fecha >=', $fecha_ini);
        $this->db->where('ea.fecha <=', $fecha_fin);
        $this->db->join('rrhh_empleado e', 'e.empleado=ea.empleado', 'left');
        $this->db->order_by('ea.fecha', 'asc');
        return $this->db->get('rrhh_empleado_asistencia_dia ea')->result();
    }
    # Planilla de Horas Extras
    # se toma 
    # Reporte atención cajeros
    public function getEmpleadosCajerosByFechass($fecha_ini, $fecha_fin) {
        $this->db->distinct();
        $this->db->select('a.usuario, CONCAT(u.last_name, " ", u.first_name) as nombre_usuario');
        $this->db->where('a.fecha >=', $fecha_ini.' 00:00:00');
        $this->db->where('a.fecha <=', $fecha_fin.' 23:59:59');
        $this->db->join('users u', 'u.user_id=a.usuario', 'left');
        $this->db->order_by('u.last_name', 'asc');
        $this->db->order_by('u.first_name', 'asc');
        return $this->db->get('caco_arqueo a')->result();
    }
    public function getDataReporteCajerosByFechas($fecha_ini, $fecha_fin) {
        $this->db->select('a.*');
        $this->db->where('a.fecha >=', $fecha_ini.' 00:00:00');
        $this->db->where('a.fecha <=', $fecha_fin.' 23:59:59');
        return $this->db->get('caco_arqueo a')->result();
    }
    # Archivo para el banco
    public function getDataArchivoBancoByMes($mes) {
        $this->db->select('e.cuenta, s.liquido_pagable');
        $this->db->where('s.mes', $mes);
        $this->db->join('rrhh_empleado e', 'e.empleado=s.empleado', 'left');
        $this->db->order_by('e.paterno', 'asc');
        $this->db->order_by('e.materno', 'asc');
        return $this->db->get('rrhh_empleado_sueldo s')->result();
    }

    public function get_company_information() {
        return $this->db->get('company_information')->row();
    }
}