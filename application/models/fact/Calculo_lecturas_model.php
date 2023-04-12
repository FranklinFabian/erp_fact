<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calculo_lecturas_model extends CI_Model
{
  /**********************************************/
  /***************PARA ELECTRICIDAD*****************/  
  function get_lecturas($idperiodo, $idservicio){
    $query = $this->db->query('SELECT idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria, fact_lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion, fact_abonados.abonado 
                               FROM fact_lecturas, fact_abonados, fact_cliente 
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND fact_lecturas.estado="0"
                               ',array($idperiodo, $idservicio));
    return $query->result_array();
  }

  //cuenta el numero de abonados residenciales de un cliente
  function contar_abonados_residenciales($idcliente){
    $query = $this->db->query('SELECT COUNT(*) AS nro_abonados FROM fact_abonados WHERE (idcliente=? AND idcategoria=1)',array($idcliente));
    return $query->row_array();
  }
  
  //saca el registro de la ley1886 vigente
  function get_vigente(){
    $query = $this->db->query('SELECT idley1886 FROM fact_ley1886 WHERE vigente="1"');
    return $query->row_array();
  }
  
  //Aberigua si el abonado esta registrado y habilitado para el beneficio
  function beneficiario_ley1886($idabonado, $idley1886){
    $query = $this->db->query('SELECT idbeneficiario, fact_beneficiarios.idcliente, fact_lecturas.idabonado
                               FROM fact_lecturas, fact_beneficiarios, fact_ley1886
                               WHERE fact_lecturas.idabonado=? AND (fact_lecturas.idabonado=fact_beneficiarios.idabonado AND fact_beneficiarios.idley1886=? 
                               )',array($idabonado, $idley1886));
    return $query->row_array();
  }
  
  //Aberigua si el abonado tiene devolucion
  function get_devolucion_abonado($idabonado){
    $query = $this->db->query('SELECT fact_afectados.devuelto, fact_afectados.saldo, fact_resoluciones.estado, fact_afectados.idafectado, fact_resoluciones.idresolucion
                               FROM fact_afectados, fact_resoluciones, fact_lecturas
                               WHERE fact_lecturas.idabonado=? AND (fact_afectados.idabonado=fact_lecturas.idabonado AND fact_afectados.idresolucion=fact_resoluciones.idresolucion AND fact_resoluciones.estado="1")'
                               ,array($idabonado));
    return $query->row_array();
  }

  //saca el registro de la ley1886 vigente
  function get_socio($idabonado){
    $query = $this->db->query('SELECT fact_socios.idsocio, fact_socios.fecha FROM fact_lecturas, fact_abonados, fact_socios
                               WHERE fact_lecturas.idabonado=? AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_socios.idcliente AND fact_socios.anulado="0" ' 
                               ,array($idabonado));
    return $query->row_array();
  }
  
  //saca monto conexion de ordenes y conexion
  function get_conexion($idabonado){
    $query = $this->db->query('SELECT fact_ordenes.costo, fact_ordenes.idorden FROM fact_lecturas, fact_ordenes, fact_conexiones
                               WHERE fact_lecturas.idabonado=? AND fact_lecturas.idabonado=fact_ordenes.idabonado AND fact_ordenes.idorden=fact_conexiones.idorden AND 
                               fact_ordenes.estado="E" AND fact_conexiones.estado="E" ' 
                               ,array($idabonado));
    return $query->row_array();
  }
  
  //saca monto reposicion de cortes y reposiciones
  function get_reposicion($idabonado){
    $query = $this->db->query('SELECT fact_reposiciones.costo, fact_reposiciones.idreposicion FROM fact_lecturas, fact_cortes, fact_reposiciones
                               WHERE fact_lecturas.idabonado=? AND fact_lecturas.idabonado=fact_cortes.idabonado AND fact_cortes.idcorte=fact_reposiciones.idcorte AND 
                               fact_cortes.estado="E" AND fact_reposiciones.estado="E" '
                               ,array($idabonado));
    return $query->row_array();
  }
  
  //saca los recargos del abonado
  function get_recargo($idabonado){
    $query = $this->db->query('SELECT idrecargo, importe FROM fact_recargos WHERE idabonado=?', array($idabonado));
    return $query->result_array();
  }

  /**********************************************/
  /***************PARA MAMAR A IMPUESTOS*****************/
  function get_lecturas_unica($idperiodo, $idservicio, $idlectura){
    $query = $this->db->query('SELECT idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria,fact_ lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion, fact_abonados.abonado 
                               FROM fact_lecturas, fact_abonados, fact_cliente 
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND fact_lecturas.estado="0"
                               AND idlectura=?

                               ',array($idperiodo, $idservicio, $idlectura));
    return $query->result_array();
  }

}
