<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items_orden_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_items_orden');
    return $query->result_array();
  }
  function get_items_orden($id_items_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_items_orden WHERE id_items_orden=?',array($id_items_orden));
    return $query->row_array();
  }
  function get_items($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_items_orden WHERE id_orden=?',array($id_orden));
    return $query->result_array();
  }

  function get_item_prod_id_orden($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_items_orden, fact_producto
                                WHERE (fact_items_orden.id_producto=fact_producto.id_producto) AND 
                                id_orden=?
                                ',array($id_orden));
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_items_orden" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_items_orden',$data);
  }
  function actualizar($id_items_orden, $data){
    $this->db->where('id_items_orden', $id_items_orden);
    $this->db->update('fact_items_orden', $data);
  }

  function actualizar_cant_salida($id_orden, $idProducto, $data){
    $this->db->where('id_orden', $id_orden);
    $this->db->where('id_producto', $idProducto);
    $this->db->update('fact_items_orden', $data);
  }

  function eliminar($id_items_orden)
  {
    $this->db->where('id_items_orden', $id_items_orden);
    $this->db->delete('fact_items_orden');
  }
  function buscar($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_items_orden WHERE id_orden=?', array($id_orden));
    $resultado = $query->result_array();
    if(count($resultado)==0)
      return false;
    else
      return true;
  }

  /* actualizar precio_venta parche*/
  function actualizar_precio_venta($id_producto, $data){
    $this->db->where('id_producto', $id_producto);
    $this->db->update('fact_items_orden', $data);
  }


}
