<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Propiedades_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_propiedades');
    return $query->result_array();
  }

  function get_propiedades($idpropied){
    $query = $this->db->query('SELECT * FROM fact_propiedades WHERE idpropiedad=?',array($idpropied));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_propiedades" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_propiedades',$data);
  }
  function actualizar($idpropied, $data)
  {
    $this->db->where('idpropiedad', $idpropied);
    $this->db->update('fact_propiedades', $data);
  }
  function eliminar($idpropied)
  {
    $this->db->where('idpropiedad', $idpropied);
    $this->db->delete('fact_propiedades');
  }

}
