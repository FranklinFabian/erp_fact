<?php
class Facturas_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_facturas WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_facturas WHERE 1 ORDER BY nro_facturas DESC ');
    return $query->result_array();
  }
  
  function get_factura($idfactura)
  {
    $query = $this->db->query('SELECT * FROM fact_facturas WHERE idfactura=?', array($idfactura));
    return $query->row_array();
  }

  function get_factura_lectura($idlectura)
  {
    $query = $this->db->query('SELECT * FROM fact_facturas WHERE idlectura=?', array($idlectura));
    return $query->row_array();
  }

  function get_facturas_by_id_orden($id_orden){
    $query = $this->db->query('SELECT * FROM fact_facturas WHERE id_orden=?', array($id_orden));
    return $query->row_array();
  }

  function get_punto_venta($id_punto_venta){
    $query = $this->db->query('SELECT * FROM fact_facturas
                                WHERE estado_fact = "E" AND
                                      id_punto_venta = ?
                              ', array($id_punto_venta));
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_facturas" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_facturas',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('idfactura', $id);
    $this->db->update('fact_facturas', $data);
  }

  function eliminar($idfactura){
    $this->db->where('idfactura', $idfactura);
    $this->db->delete('fact_facturas');
  }

}//fin class
