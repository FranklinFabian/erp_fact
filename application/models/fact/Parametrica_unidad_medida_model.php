<?php
class Parametrica_unidad_medida_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_unidad_medida WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_unidad_medida WHERE 1 ORDER BY nro_parametrica_unidad_medida DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_unidad_medida($id_parametrica_unidad_medida)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_unidad_medida WHERE id_parametrica_unidad_medida=?', array($id_parametrica_unidad_medida));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_unidad_medida($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_unidad_medida WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_unidad_medida" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_unidad_medida',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_unidad_medida', $id);
    $this->db->update('fact_parametrica_unidad_medida', $data);
  }

  function eliminar($id_parametrica_unidad_medida){
    $this->db->where('id_parametrica_unidad_medida', $id_parametrica_unidad_medida);
    $this->db->delete('fact_parametrica_unidad_medida');
  }

}//fin class
