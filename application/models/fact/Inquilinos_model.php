<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquilinos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_inquilinos');
    return $query->result_array();
  }

  function get_inquilino($idinquilino){
    $query = $this->db->query('SELECT * FROM fact_inquilinos WHERE idinquilino=?',array($idinquilino));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_inquilinos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_inquilinos',$data);
  }
  function actualizar($idinquilino, $data)
  {
    $this->db->where('idinquilino', $idinquilino);
    $this->db->update('fact_inquilinos', $data);
  }
  function eliminar($idinquilino)
  {
    $this->db->where('idinquilino', $idinquilino);
    $this->db->delete('fact_inquilinos');
  }

}
