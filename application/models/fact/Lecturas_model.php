<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lecturas_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_lecturas');
    return $query->result_array();
  }

  function get_lectura($idlectura){
    $query = $this->db->query('SELECT * FROM fact_lecturas WHERE idlectura=?',array($idlectura));
    return $query->row_array();
  }

  function get_ultima_lectura_abonado($idabonado){
    $query = $this->db->query('SELECT * FROM fact_lecturas WHERE idabonado=? ORDER BY idlectura DESC',array($idabonado));
    return $query->row_array();
  }

  function buscar_abonado_periodo($idabonado, $idperiodo){
    $query = $this->db->query('SELECT * FROM fact_lecturas WHERE idabonado=? AND idperiodo=?',array($idabonado, $idperiodo));
    return $query->row_array();
  }

  function get_lecturas_abonado($idabonado){//sacar las columnas necesarias
    $query = $this->db->query('SELECT idperiodo, estado FROM fact_lecturas WHERE idabonado=? AND estado="0" ORDER BY idperiodo',array($idabonado));
    return $query->result_array();
  }

  function get_lecturas_abonado_5($idabonado, $idperiodo){//sacar las columnas necesarias
    $query = $this->db->query('SELECT idperiodo, indice, kwh, estimado, estado FROM fact_lecturas WHERE idabonado=? AND idperiodo <> ? ORDER BY idperiodo DESC LIMIT 6',array($idabonado, $idperiodo));
    return $query->result_array();
  }

  function get_lectura_anterior($idabonado, $idperiodo){
    $query = $this->db->query('SELECT idperiodo, indice, kwh, estimado, estado FROM fact_lecturas WHERE idabonado=? AND idperiodo <> ? ORDER BY idperiodo DESC  LIMIT 1',array($idabonado, $idperiodo));
    return $query->row_array();
  }

  function get_lecturas_abonado_servicio($idabonado, $idservicio){
    $query = $this->db->query('SELECT * FROM fact_lecturas WHERE idabonado=? AND idservicio=? AND estado="0"',array($idabonado, $idservicio));
    return $query->result_array();
  }

  function contar_meses_deuda($idabonado){
    $query = $this->db->query('SELECT COUNT(*) AS `meses` FROM fact_lecturas WHERE idabonado=? AND (estado="0" OR estado IS NULL) ',array($idabonado));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_lecturas" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_lecturas',$data);
  }
  function actualizar($idlectura, $data)
  {
    $this->db->where('idlectura', $idlectura);
    $this->db->update('fact_lecturas', $data);
  }
  function eliminar($idlectura)
  {
    $this->db->where('idlectura', $idlectura);
    $this->db->delete('fact_lecturas');
  }

}
