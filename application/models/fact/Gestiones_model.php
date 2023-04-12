<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gestiones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_gestiones');
    return $query->result_array();
  }

  function get_gestion($idgestion){
    $query = $this->db->query('SELECT * FROM fact_gestiones WHERE idgestion=?',array($idgestion));
    return $query->row_array();
  }

  function get_by_idservicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_gestiones WHERE idservicio=?',array($idservicio));
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_gestiones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_gestiones',$data);
  }
  function actualizar($idgestion, $data)
  {
    $this->db->where('idgestion', $idgestion);
    $this->db->update('fact_gestiones', $data);
  }
  function eliminar($idgestion)
  {
    $this->db->where('idgestion', $idgestion);
    $this->db->delete('fact_gestiones');
  }

}
