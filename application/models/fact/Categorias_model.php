<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_categorias');
    return $query->result_array();
  }

  function get_categorias($idcategoria){
    $query = $this->db->query('SELECT * FROM fact_categorias WHERE idcategoria=?',array($idcategoria));
    return $query->row_array();
  }

  function get_categorias_servicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_categorias WHERE idservicio=?',array($idservicio));
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_categorias" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_categorias',$data);
  }
  function actualizar($idcategoria, $data)
  {
    $this->db->where('idcategoria', $idcategoria);
    $this->db->update('fact_categorias', $data);
  }
  function eliminar($idcategoria)
  {
    $this->db->where('idcategoria', $idcategoria);
    $this->db->delete('fact_categorias');
  }

}
