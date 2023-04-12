<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Periodos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_periodos');
    return $query->result_array();
  }

  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_periodos WHERE 1 ORDER BY idperiodo DESC');
    return $query->result_array();
  }

  function get_periodo($idperiodo){
    $query = $this->db->query('SELECT * FROM fact_periodos WHERE idperiodo=?',array($idperiodo));
    return $query->row_array();
  }

  function get_ultimo(){
    $query = $this->db->query('SELECT * FROM fact_periodos WHERE idproceso=1');
    return $query->row_array();
  }

  function get_activo(){
    $query = $this->db->query('SELECT * FROM fact_periodos WHERE idproceso=1');
    return $query->row_array();
  }

  function actualizar_idproceso(){
    $query = $this->db->query('UPDATE `fact_periodos` SET `idproceso`=3 WHERE 1');
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_periodos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_periodos',$data);
  }
  function actualizar($idperiodo, $data)
  {
    $this->db->where('idperiodo', $idperiodo);
    $this->db->update('fact_periodos', $data);
  }
  function eliminar($idperiodo)
  {
    $this->db->where('idperiodo', $idperiodo);
    $this->db->delete('fact_periodos');
  }

}
