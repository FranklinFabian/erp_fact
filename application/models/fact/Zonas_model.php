<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zonas_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_zonas');
    return $query->result_array();
  }

  function get_zona($idzona){
    $query = $this->db->query('SELECT * FROM fact_zonas WHERE idzona=?',array($idzona));
    return $query->row_array();
  }

  function get_zona_localidad($idlocalidad){
    $query = $this->db->query('SELECT * FROM fact_zonas WHERE idlocalidad=? ORDER BY zona',array($idlocalidad));
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_zonas" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_zonas',$data);
  }
  function actualizar($idzona, $data)
  {
    $this->db->where('idzona', $idzona);
    $this->db->update('fact_zonas', $data);
  }
  function eliminar($idzona)
  {
    $this->db->where('idzona', $idzona);
    $this->db->delete('fact_zonas');
  }

}
