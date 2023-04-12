<?php
class Factura_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_factura WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_factura WHERE 1 ORDER BY nro_factura DESC ');
    return $query->result_array();
  }
  
  function get_factura($id_factura)
  {
    $query = $this->db->query('SELECT * FROM fact_factura WHERE id_factura=?', array($id_factura));
    return $query->row_array();
  }

  function get_factura_by_id_orden($id_orden){
    $query = $this->db->query('SELECT * FROM fact_factura WHERE id_orden=?', array($id_orden));
    return $query->row_array();
  }

  function get_factura_cuf($cuf)
  {
    $query = $this->db->query('SELECT * FROM fact_factura WHERE cuf=?', array($cuf));
    return $query->row_array();
  }

  function get_factura_offline()
  {
    $query = $this->db->query('SELECT * FROM fact_factura WHERE tipo_emision="2" AND estado_fact="P" ');
    return $query->result_array();
  }

  function get_fact_idcliente($idcliente)
  {
    $query = $this->db->query('SELECT * FROM fact_factura WHERE idcliente=? ORDER BY fecha_emision DESC', array($idcliente));
    return $query->result_array();
  }

  function get_punto_venta($id_punto_venta){
    $query = $this->db->query('SELECT * FROM fact_factura
                                WHERE estado_fact = "E" AND
                                      id_punto_venta = ?
                              ', array($id_punto_venta));
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_factura" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_factura',$data);
  }

  function actualizar_cuf($cuf, $data)
  {
    $this->db->where('cuf', $cuf);
    $this->db->update('fact_factura', $data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_factura', $id);
    $this->db->update('fact_factura', $data);
  }

  function eliminar($id_factura){
    $this->db->where('id_factura', $id_factura);
    $this->db->delete('fact_factura');
  }

}//fin class
