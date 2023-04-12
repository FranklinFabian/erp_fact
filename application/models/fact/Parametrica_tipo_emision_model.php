<?php
class Parametrica_tipo_emision_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_emision WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_emision WHERE 1 ORDER BY nro_parametrica_tipo_emision DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_tipo_emision($id_parametrica_tipo_emision)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_emision WHERE id_parametrica_tipo_emision=?', array($id_parametrica_tipo_emision));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_tipo_emision($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_emision WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_tipo_emision" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_tipo_emision',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_tipo_emision', $id);
    $this->db->update('fact_parametrica_tipo_emision', $data);
  }

  function eliminar($id_parametrica_tipo_emision){
    $this->db->where('id_parametrica_tipo_emision', $id_parametrica_tipo_emision);
    $this->db->delete('fact_parametrica_tipo_emision');
  }

}//fin class
