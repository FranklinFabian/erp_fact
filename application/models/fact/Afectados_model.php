<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Afectados_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_afectados');
    return $query->result_array();
  }

  function get_afectado($idafectado){
    $query = $this->db->query('SELECT * FROM fact_afectados WHERE idafectado=?',array($idafectado));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_afectados" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_afectados',$data);
  }
  function actualizar($idafectado, $data)
  {
    $this->db->where('idafectado', $idafectado);
    $this->db->update('fact_afectados', $data);
  }
  function eliminar($idafectado)
  {
    $this->db->where('idafectado', $idafectado);
    $this->db->delete('fact_afectados');
  }

}
