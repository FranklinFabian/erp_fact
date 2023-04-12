<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuis_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_cuis WHERE 1 ORDER BY nombre_cuis');
    return $query->result_array();
  }

  function get_cuis($id_cuis){
    $query = $this->db->query('SELECT * FROM fact_cuis WHERE id_cuis=?',array($id_cuis));
    return $query->row_array();
  }

  function get_cuis_id_punto_venta($id_punto_venta){
    $query = $this->db->query('SELECT * FROM fact_cuis WHERE id_punto_venta=?',array($id_punto_venta));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_cuis" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_cuis',$data);
  }
  function actualizar($id_cuis, $data)
  {
    $this->db->where('id_cuis', $id_cuis);
    $this->db->update('fact_cuis', $data);
  }
  function eliminar($id_cuis)
  {
    $this->db->where('id_cuis', $id_cuis);
    $this->db->delete('fact_cuis');
  }
  function buscar_id_cuis($id_cuis)
  {
    $query = $this->db->query('SELECT * FROM fact_cuis WHERE id_cuis=?', array($id_cuis));
    $resultado = $query->result_array();
    if(count($resultado)==0)
    return false;
          else
    return true;
  }

}
