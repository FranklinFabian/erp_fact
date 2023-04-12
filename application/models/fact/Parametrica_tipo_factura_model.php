<?php
class Parametrica_tipo_factura_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_factura WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_factura WHERE 1 ORDER BY nro_parametrica_tipo_factura DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_tipo_factura($id_parametrica_tipo_factura)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_factura WHERE id_parametrica_tipo_factura=?', array($id_parametrica_tipo_factura));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_tipo_factura($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_tipo_factura WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_tipo_factura" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_tipo_factura',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_tipo_factura', $id);
    $this->db->update('fact_parametrica_tipo_factura', $data);
  }

  function eliminar($id_parametrica_tipo_factura){
    $this->db->where('id_parametrica_tipo_factura', $id_parametrica_tipo_factura);
    $this->db->delete('fact_parametrica_tipo_factura');
  }

}//fin class
