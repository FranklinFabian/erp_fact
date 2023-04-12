<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lecturas_observadas_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_lecturas_observadas');
    return $query->result_array();
  }

  function get_lecturas_observadas($idlecturas_observadas){
    $query = $this->db->query('SELECT * FROM fact_lecturas_observadas WHERE idlecturas_observadas=?',array($idlecturas_observadas));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_lecturas_observadas" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_lecturas_observadas',$data);
  }
  function actualizar($idlecturas_observadas, $data)
  {
    $this->db->where('idlecturas_observadas', $idlecturas_observadas);
    $this->db->update('fact_lecturas_observadas', $data);
  }
  function eliminar($idlecturas_observadas)
  {
    $this->db->where('idlecturas_observadas', $idlecturas_observadas);
    $this->db->delete('fact_lecturas_observadas');
  }

}
