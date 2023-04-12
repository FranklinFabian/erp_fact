<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adquisicion_producto_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM adquisicion_producto');
    return $query->result_array();
  }
    
  function get_id_adquisicion($id_adquisicion_producto)
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto WHERE id_adquisicion_producto=?', array($id_adquisicion_producto));
    return $query->row_array();
  }
  
  function get_nro_adquisicion($id_producto)
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto, nro_adquisicion WHERE adquisicion_producto.id_nro_adquisicion=nro_adquisicion.id_nro_adquisicion
                              AND adquisicion_producto.cantidad_existente_adquisicion > 0 AND adquisicion_producto.id_producto=?', array($id_producto));
    return $query->result_array();
  }

  function get_cantidad_existente_adquisicion_producto_por_id($id_producto)
  {
    $query = $this->db->query('SELECT SUM(cantidad_existente_adquisicion) AS `cantidad_existente_adquisicion` FROM adquisicion_producto WHERE 
                              cantidad_existente_adquisicion > 0 AND id_producto=?', array($id_producto));
    return $query->row_array();
  }
  function contar_filas($id_producto)
  {
    $query = $this->db->query('SELECT COUNT(*) AS `filas` FROM adquisicion_producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }
  
  function ultimoID($id_producto)
  {
    $query = $this->db->query('SELECT MAX(`id_adquisicion_producto`) AS `ultimoID` FROM adquisicion_producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }

  function ultimo_nro_adquisicion($tipo, $id_producto )
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto WHERE tipo=? AND id_producto=? ORDER BY id_adquisicion_producto DESC LIMIT 1', array($tipo, $id_producto));
    return $query->row_array();
  }

  function ultimo_nro_adquisicion_by_id_prod($id_producto )
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto WHERE id_producto=? ORDER BY id_adquisicion_producto DESC LIMIT 1', array($id_producto));
    return $query->row_array();
  }

  function get_ingresos($id_producto)
  {
    $query = $this->db->query('SELECT fecha_adquisicion, adquisicion_producto.id_adquisicion_producto, adquisicion_producto.id_nro_adquisicion, cantidad_ingreso, cantidad_existente_adquisicion, precio_adquisicion, saldo_valorado, saldo_fisico
                               FROM adquisicion_producto, nro_adquisicion WHERE (adquisicion_producto.id_nro_adquisicion = nro_adquisicion.id_nro_adquisicion) AND (cantidad_existente_adquisicion > 0 AND id_producto=?)
                               ORDER BY fecha_adquisicion ASC', 
                               array($id_producto));
    return $query->result_array();
  }
  // de otro modelo
  function get_all_id_salida($id_salida)
  {
    $query = $this->db->query('SELECT * FROM salida, adquisicion_producto, producto, unidad_medida WHERE 
                              adquisicion_producto.id_salida=salida.id_salida AND
                              producto.id_unidad_medida=unidad_medida.id_unidad_medida AND
                              
                              adquisicion_producto.id_producto=producto.id_producto AND
                              salida.id_salida=?',array($id_salida));
    return $query->result_array();
  }


  // estas 2 en duda
  function suma_existentes($id_producto)
  {
    $query = $this->db->query('SELECT SUM(`cantidad_existente_adquisicion`) AS `suma_existente_adquisicion` FROM adquisicion_producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }
  
  function suma_saldo_valorado($id_producto)
  {
    $query = $this->db->query('SELECT SUM(`saldo_valorado`) AS `suma_saldo_valorado` FROM adquisicion_producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }
  
  function get_adquisicion_producto($id_adquisicion_producto)
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto WHERE id_adquisicion_producto=?', array($id_adquisicion_producto));
    return $query->row_array();
  }

  function get_all_id_nro_adquisicion($id_nro_adquisicion)
  {
    $query = $this->db->query('SELECT * FROM adquisicion_producto, producto, apertura_programatica
                               WHERE adquisicion_producto.id_producto=producto.id_producto AND
                               adquisicion_producto.id_apertura_programatica = apertura_programatica.id_apertura_programatica AND
                               adquisicion_producto.id_nro_adquisicion=?', array($id_nro_adquisicion));
    return $query->result_array();
  }

  function get_all_prod()
  {
    $query = $this->db->query('SELECT * FROM nro_adquisicion, adquisicion_producto, producto WHERE nro_adquisicion.id_nro_adquisicion=adquisicion_producto.id_nro_adquisicion AND adquisicion_producto.id_producto=producto.id_producto ORDER BY adquisicion_producto.id_adquisicion_producto DESC');
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="adquisicion_producto" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('adquisicion_producto',$data);
  }
  function actualizar($id_adquisicion_producto, $data)
  {
    $this->db->where('id_adquisicion_producto', $id_adquisicion_producto);
    $this->db->update('adquisicion_producto', $data);
  }
  function eliminar($id_adquisicion_producto)
  {
    $this->db->where('id_adquisicion_producto', $id_adquisicion_producto);
    $this->db->delete('adquisicion_producto');
  }

}
