<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resoluciones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_resoluciones');
    return $query->result_array();
  }

  function get_resolucion($idresolucion){
    $query = $this->db->query('SELECT * FROM fact_resoluciones WHERE idresolucion=?',array($idresolucion));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_resoluciones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_resoluciones',$data);
  }
  function actualizar($idresolucion, $data)
  {
    $this->db->where('idresolucion', $idresolucion);
    $this->db->update('fact_resoluciones', $data);
  }
  function eliminar($idresolucion)
  {
    $this->db->where('idresolucion', $idresolucion);
    $this->db->delete('fact_resoluciones');
  }

}
