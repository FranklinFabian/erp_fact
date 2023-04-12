<?php
class Parametrica_tipo_metodo_pago_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_metodo_pago WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_metodo_pago WHERE 1 ORDER BY nro_parametrica_tipo_metodo_pago DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_tipo_metodo_pago($id_parametrica_tipo_metodo_pago)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_metodo_pago WHERE id_parametrica_tipo_metodo_pago=?', array($id_parametrica_tipo_metodo_pago));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_tipo_metodo_pago($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_metodo_pago WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_tipo_metodo_pago" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_tipo_metodo_pago',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_tipo_metodo_pago', $id);
    $this->db->update('fact_parametrica_tipo_metodo_pago', $data);
  }

  function eliminar($id_parametrica_tipo_metodo_pago){
    $this->db->where('id_parametrica_tipo_metodo_pago', $id_parametrica_tipo_metodo_pago);
    $this->db->delete('fact_parametrica_tipo_metodo_pago');
  }

}//fin class
