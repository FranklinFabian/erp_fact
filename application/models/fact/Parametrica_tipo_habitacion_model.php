<?php
class Parametrica_tipo_habitacion_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_habitacion WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_habitacion WHERE 1 ORDER BY nro_parametrica_tipo_habitacion DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_tipo_habitacion($id_parametrica_tipo_habitacion)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_habitacion WHERE id_parametrica_tipo_habitacion=?', array($id_parametrica_tipo_habitacion));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_tipo_habitacion($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_habitacion WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_tipo_habitacion" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_tipo_habitacion',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_tipo_habitacion', $id);
    $this->db->update('fact_parametrica_tipo_habitacion', $data);
  }

  function eliminar($id_parametrica_tipo_habitacion){
    $this->db->where('id_parametrica_tipo_habitacion', $id_parametrica_tipo_habitacion);
    $this->db->delete('fact_parametrica_tipo_habitacion');
  }

}//fin class
