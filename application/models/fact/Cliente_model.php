<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_cliente where 1 ORDER BY idcliente DESC LIMIT 50');
    return $query->result_array();
  }

  function get_25(){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE 1 ORDER BY idcliente DESC LIMIT 25');
    return $query->result_array();
  }

  function get_cliente($idcliente){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE idcliente=?',array($idcliente));
    return $query->row_array();
  }
  
  function get_email_cliente($idcliente){
    $query = $this->db->query('SELECT correo FROM fact_cliente WHERE idcliente=?',array($idcliente));
    return $query->row_array();
  }


  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_cliente" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function buscar_ci($ci){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE ci=?',array($ci));
    return $query->row_array();
  }

  function buscar_ci2($ci){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE ci=?',array($ci));
    return $query->result_array();
  }

  function buscar_nit($nit){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE nit=?',array($nit));
    return $query->row_array();
  }

  function buscar_completo($razon_social){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE razon_social LIKE "%'.$razon_social.'%"');
    return $query->result_array();
  }

  function buscar_abonado($razon_social){
    $query = $this->db->query('SELECT * FROM fact_cliente, fact_abonados WHERE razon_social LIKE "%'.$razon_social.'%" AND fact_abonados.idcliente=fact_cliente.idcliente ');
    return $query->result_array();
  }

  //busque app nombre
  function buscar_app_nom($apellidos, $nombres){
    $query = $this->db->query('SELECT * FROM fact_cliente, fact_abonados WHERE (razon_social LIKE "'.$apellidos.'%" AND razon_social LIKE "%'.$nombres.'%") AND fact_abonados.idcliente=fact_cliente.idcliente ');
    return $query->result_array();
  }

  //busque app nombre
  function buscar_app_nom_venta($apellidos, $nombres){
    $query = $this->db->query('SELECT * FROM fact_cliente WHERE (razon_social LIKE "'.$apellidos.'%" AND razon_social LIKE "%'.$nombres.'%") ');
    return $query->result_array();
  }

  //busque abonado
  function buscar_por_abonado($abonado){
    $query = $this->db->query('SELECT * FROM fact_cliente, fact_abonados WHERE (abonado = "'.$abonado.'") AND fact_abonados.idcliente=fact_cliente.idcliente ');
    return $query->result_array();
  }

  //busque medidor
  function buscar_por_medidor($medidor){
    $query = $this->db->query('SELECT * FROM fact_cliente, fact_abonados WHERE (medidor = "'.$medidor.'") AND fact_abonados.idcliente=fact_cliente.idcliente ');
    return $query->result_array();
  }
 

  function insertar($data)
  {
    $this->db->insert('fact_cliente',$data);
  }
  function actualizar($idcliente, $data)
  {
    $this->db->where('idcliente', $idcliente);
    $this->db->update('fact_cliente', $data);
  }
  function eliminar($idcliente)
  {
    $this->db->where('idcliente', $idcliente);
    $this->db->delete('fact_cliente');
  }
  function get_proformas($idcliente){
    $query = $this->db->query('SELECT almacen_proforma_items.id_proforma, almacen_articulo.nombre, almacen_proforma_items.cantidad, almacen_proforma_items.costo, almacen_proforma_items.total FROM fact_cliente, almacen_proforma_items, almacen_proforma, almacen_articulo WHERE (almacen_proforma.id_cliente ="'.$idcliente.'%")AND almacen_proforma.estado="P" AND almacen_proforma.id=almacen_proforma_items.id_proforma AND almacen_proforma_items.id_articulo=almacen_articulo.id AND fact_cliente.idcliente=almacen_proforma.id_cliente');
    return $query->result_array();
  }

 
}
