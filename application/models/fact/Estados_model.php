<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estados_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_estados');
    return $query->result_array();
  }

  function get_estado($idestado){
    $query = $this->db->query('SELECT * FROM fact_estados WHERE idestado=?',array($idestado));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_estados" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_estados',$data);
  }
  function actualizar($idestado, $data)
  {
    $this->db->where('idestado', $idestado);
    $this->db->update('fact_estados', $data);
  }
  function eliminar($idestado)
  {
    $this->db->where('idestado', $idestado);
    $this->db->delete('fact_estados');
  }

}
