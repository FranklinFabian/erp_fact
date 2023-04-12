<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Centros_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_centros');
    return $query->result_array();
  }

  function get_centro($idcentro){
    $query = $this->db->query('SELECT * FROM fact_centros WHERE idcentro=?',array($idcentro));
    return $query->row_array();
  }

  function get_centro_localidad($idlocalidad){
    $query = $this->db->query('SELECT * FROM fact_centros WHERE idlocalidad=? ORDER BY codigo',array($idlocalidad));
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_centros" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_centros',$data);
  }
  function actualizar($idcentro, $data)
  {
    $this->db->where('idcentro', $idcentro);
    $this->db->update('fact_centros', $data);
  }
  function eliminar($idcentro)
  {
    $this->db->where('idcentro', $idcentro);
    $this->db->delete('fact_centros');
  }

}
