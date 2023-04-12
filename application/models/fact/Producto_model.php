<?php
class Producto_model extends CI_Model{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_producto WHERE 1 ORDER BY nombre_producto');
    return $query->result_array();
  }
  function get_all_habilitados()
  {
    $query = $this->db->query('SELECT * FROM fact_producto WHERE estado_producto="1" ORDER BY nombre_producto' );
    return $query->result_array();
  }
  function get_all_habilitados_unidad()
  {
    $query = $this->db->query('SELECT * FROM fact_producto, fact_unidad_medida WHERE 
                                        estado_producto="1" AND
                                        fact_producto.id_unidad_medida=fact_unidad_medida.id_unidad_medida
                                        ORDER BY nombre_producto' );
    return $query->result_array();
  }

  function get_producto($id_producto)
  {
    $query = $this->db->query('SELECT * FROM fact_producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }
  function get_producto_unidad_medida($id_producto)
  {
    $query = $this->db->query('SELECT * FROM fact_producto, fact_unidad_medida WHERE (fact_producto.id_unidad_medida=fact_unidad_medida.id_unidad_medida) AND id_producto=?', array($id_producto));
    return $query->row_array();
  }


  function get_nombre_producto($nombre_producto)
  {
    $query = $this->db->query('SELECT * FROM fact_producto WHERE nombre_producto=?',array($nombre_producto));
    return $query->row_array();
  }
  function get_nombre_codBarras($codBarras)
  {
    $query = $this->db->query('SELECT * FROM fact_producto WHERE cod_producto=?',array($codBarras));
    return $query->row_array();
  }
  function get_all_all()
  {
    $query = $this->db->query('SELECT * FROM fact_producto
                               WHERE estado_producto=1
                               ORDER BY fact_producto.nombre_producto
                              ');
    return $query->result_array();
  }
  function get_all_nro_ad()
  {
    $query = $this->db->query('SELECT * FROM fact_producto, fact_adquisicion_producto
                               WHERE fact_adquisicion_producto.id_producto=fact_producto.id_producto
                               AND fact_producto.estado_producto=1 
                               AND fact_adquisicion_producto.id_nro_adquisicion=1
                               ORDER BY fact_producto.nombre_producto
                               ');
    return $query->result_array();
  }

  /*
 
  function get_prod_plus($id_producto)
  {
    $query = $this->db->query('SELECT * FROM producto WHERE id_producto=?', array($id_producto));
    return $query->row_array();
  }
  */
  function get_prod_mov($id_producto)
  {
    $query = $this->db->query('SELECT id_adquisicion_producto, tipo 
                                FROM fact_producto, fact_adquisicion_producto WHERE
                                fact_producto.id_producto=fact_adquisicion_producto.id_producto AND
                                fact_producto.id_producto=?
                              ', array($id_producto));
    return $query->result_array();
  }

  function get_json2()// para ingreso de material
  {
    $salida = '';
    $query = $this->db->query('SELECT * FROM fact_producto WHERE estado_producto = 1');
    $res = $query->result_array();
    foreach ($res as $key => $value)
    {
        $salida.= '"'.$value['nombre_producto'].'",';
    }
    return $salida;
  }
  
  function get_json3()//PARA LA SOLICITUD DE MATERIAL
  {
    $salida = '';
    
    $query = $this->db->query('SELECT fact_producto.id_producto, fact_adquisicion_producto.id_adquisicion_producto, nombre_producto, cantidad_existente_adquisicion FROM fact_producto, fact_adquisicion_producto
                                WHERE fact_producto.id_producto=fact_adquisicion_producto.id_producto AND
                                fact_adquisicion_producto.cantidad_existente_adquisicion > 0 AND 
                                      estado_producto = 1');
    return $query->result_array();
  }

  //
  function suma_existentes($id_producto){
    $query = $this->db->query('SELECT SUM(cantidad_existente_adquisicion) as suma_stock 
                                FROM `fact_adquisicion_producto`
                                WHERE `id_producto` = ?', array($id_producto));
    return $query->row_array();
  }

  function insertar($data)
  {
    $this->db->insert('fact_producto',$data);
  }
  function actualizar($id, $data)
  {
    $this->db->where('id_producto', $id);
    $this->db->update('fact_producto', $data);
  }

  function eliminar($id_producto){
    $this->db->where('id_producto', $id_producto);
    $this->db->delete('fact_producto');
  }

  function verificar_nombre($nombre_producto){
    $query = $this->db->query('SELECT * FROM fact_producto WHERE nombre_producto=?', array($nombre_producto));
    $res = $query->row_array();
    
    if(is_null($res))// es null, el producto no existe
      return true;
    else
      return false;
  }

  function extraer_menos($nombre_producto){
    $query = $this->db->query('SELECT * FROM `fact_producto`
                                WHERE `nombre_producto` NOT IN 
                                (SELECT nombre_producto FROM `fact_producto` WHERE `nombre_producto`=?)', array($nombre_producto));
    return $query->result_array();
  }


  function total_paginados($por_pagina,$segmento) 
  {
    $consulta = $this->db->get('fact_producto',$por_pagina, $segmento);
    return $consulta->result_array();
  }  
}//fin class
