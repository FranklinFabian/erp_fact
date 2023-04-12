<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consumidores_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_consumidores');
    return $query->result_array();
  }

  function get_consumidor($idconsumidor){
    $query = $this->db->query('SELECT * FROM fact_consumidores WHERE idconsumidor=?',array($idconsumidor));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_consumidores" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_consumidores',$data);
  }
  function actualizar($idconsumidor, $data)
  {
    $this->db->where('idconsumidor', $idconsumidor);
    $this->db->update('fact_consumidores', $data);
  }
  function eliminar($idconsumidor)
  {
    $this->db->where('idconsumidor', $idconsumidor);
    $this->db->delete('fact_consumidores');
  }

}
