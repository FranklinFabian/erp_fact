<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procesos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_procesos');
    return $query->result_array();
  }

  function get_procesos($idproceso){
    $query = $this->db->query('SELECT * FROM fact_procesos WHERE idproceso=?',array($idproceso));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_procesos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_procesos',$data);
  }
  function actualizar($idproceso, $data)
  {
    $this->db->where('idproceso', $idproceso);
    $this->db->update('fact_procesos', $data);
  }
  function eliminar($idproceso)
  {
    $this->db->where('idproceso', $idproceso);
    $this->db->delete('fact_procesos');
  }

}
