<?php
class Parametrica_motivo_anulacion_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_motivo_anulacion WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_motivo_anulacion WHERE 1 ORDER BY nro_parametrica_motivo_anulacion DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_motivo_anulacion($id_parametrica_motivo_anulacion)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_motivo_anulacion WHERE id_parametrica_motivo_anulacion=?', array($id_parametrica_motivo_anulacion));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_motivo_anulacion($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_motivo_anulacion WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_motivo_anulacion" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_motivo_anulacion',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_motivo_anulacion', $id);
    $this->db->update('fact_parametrica_motivo_anulacion', $data);
  }

  function eliminar($id_parametrica_motivo_anulacion){
    $this->db->where('id_parametrica_motivo_anulacion', $id_parametrica_motivo_anulacion);
    $this->db->delete('fact_parametrica_motivo_anulacion');
  }

}//fin class
