<?php
class Factura_22_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE 1 ORDER BY nro_factura_22 DESC ');
    return $query->result_array();
  }
  
  function get_fact_idcliente($idcliente)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE idcliente=? ORDER BY fecha_emision DESC', array($idcliente));
    return $query->result_array();
  }

  function get_factura_lectura($idlectura)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE idlectura=?', array($idlectura));
    return $query->row_array();
  }

  function get_factura_cuf($cuf)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE cuf=?', array($cuf));
    return $query->row_array();
  }


  function get_factura_22($id_factura_22)
  {
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE id_factura_22=?', array($id_factura_22));
    return $query->row_array();
  }

  function get_factura_22_by_id_orden($id_orden){
    $query = $this->db->query('SELECT * FROM fact_factura_22 WHERE id_orden=?', array($id_orden));
    return $query->row_array();
  }

  function get_punto_venta($id_punto_venta){
    $query = $this->db->query('SELECT * FROM fact_factura_22
                                WHERE estado_fact = "E" AND
                                      id_punto_venta = ?
                              ', array($id_punto_venta));
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_factura_22" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_factura_22',$data);
  }

  function actualizar_cuf($cuf, $data)
  {
    $this->db->where('cuf', $cuf);
    $this->db->update('fact_factura_22', $data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_factura_22', $id);
    $this->db->update('fact_factura_22', $data);
  }

  function eliminar($id_factura_22){
    $this->db->where('id_factura_22', $id_factura_22);
    $this->db->delete('fact_factura_22');
  }

}//fin class
