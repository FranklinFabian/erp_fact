<?php
class Leyenda_factura_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_leyenda_factura WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_leyenda_factura WHERE 1 ORDER BY nro_leyenda_factura DESC ');
    return $query->result_array();
  }
  
  function get_leyenda_factura($id_leyenda_factura)
  {
    $query = $this->db->query('SELECT * FROM fact_leyenda_factura WHERE id_leyenda_factura=?', array($id_leyenda_factura));
    return $query->row_array();
  }

  function buscar_codigo_leyenda_factura($codigo_actividad, $descripcion_leyenda )
  {
    $query = $this->db->query('SELECT * FROM fact_leyenda_factura WHERE codigo_actividad =? AND descripcion_leyenda=?', array($codigo_actividad, $descripcion_leyenda));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_leyenda_factura" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_leyenda_factura',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_leyenda_factura', $id);
    $this->db->update('fact_leyenda_factura', $data);
  }

  function eliminar($id_leyenda_factura){
    $this->db->where('id_leyenda_factura', $id_leyenda_factura);
    $this->db->delete('fact_leyenda_factura');
  }

}//fin class
