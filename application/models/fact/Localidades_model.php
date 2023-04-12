<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localidades_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_localidades');
    return $query->result_array();
  }

  function get_all_asc(){
    $query = $this->db->query('SELECT * FROM fact_localidades ORDER BY localidad');
    return $query->result_array();
  }

  function get_localidades($idlocalidades){
    $query = $this->db->query('SELECT * FROM fact_localidades WHERE idlocalidad=?',array($idlocalidades));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_localidades" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_localidades',$data);
  }
  function actualizar($idlocalidades, $data)
  {
    $this->db->where('idlocalidad', $idlocalidades);
    $this->db->update('fact_localidades', $data);
  }
  function eliminar($idlocalidades)
  {
    $this->db->where('idlocalidad', $idlocalidades);
    $this->db->delete('fact_localidades');
  }

}
