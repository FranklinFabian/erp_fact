<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requisitos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_requisitos');
    return $query->result_array();
  }

  function get_all_idservicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_requisitos WHERE idservicio=? AND estado="S"  ORDER BY idrequisito DESC', array($idservicio));
    return $query->result_array();
  }

  function get_requisito($idrequisito){
    $query = $this->db->query('SELECT * FROM fact_requisitos WHERE idrequisito=?',array($idrequisito));
    return $query->row_array();
  }

  function get_ultimo_correlativo_servicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_requisitos WHERE idservicio=? ORDER BY idrequisito DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_requisitos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_requisitos',$data);
  }
  function actualizar($idrequisito, $data)
  {
    $this->db->where('idrequisito', $idrequisito);
    $this->db->update('fact_requisitos', $data);
  }
  function eliminar($idrequisito)
  {
    $this->db->where('idrequisito', $idrequisito);
    $this->db->delete('fact_requisitos');
  }

}
