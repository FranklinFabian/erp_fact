<?php
class Punto_venta_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE 1 ORDER BY nro_punto_venta DESC ');
    return $query->result_array();
  }
  
  function get_all_habilitados()
  {
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE estado="1" ORDER BY nit_ci' );
    return $query->result_array();
  }

  function get_punto_venta($id_punto_venta)
  {
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE id_punto_venta=?', array($id_punto_venta));
    return $query->row_array();
  }

  function get_ultimo_punto_venta()
  {
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE 1 ORDER BY id_punto_venta DESC LIMIT 1');
    return $query->row_array();
  }

  function get_punto_venta_prod_unid($id_punto_venta)
  {
    $query = $this->db->query('SELECT * FROM fact_punto_venta, fact_producto, fact_unidad_medida
                                        WHERE fact_punto_venta.id_producto=fact_producto.id_producto AND
                                        fact_producto.id_unidad_medida=fact_unidad_medida.id_unidad_medida AND
                                        fact_punto_venta.id_punto_venta=?', array($id_punto_venta));
    return $query->row_array();
  }

  function get_razon_social($razon_social)
  {
    $query = $this->db->query('SELECT * FROM fact_punto_venta WHERE razon_social=?',array($razon_social));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_punto_venta" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_punto_venta',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_punto_venta', $id);
    $this->db->update('fact_punto_venta', $data);
  }

  function eliminar($id_punto_venta){
    $this->db->where('id_punto_venta', $id_punto_venta);
    $this->db->delete('fact_punto_venta');
  }

}//fin class
