<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generar_facturas_22_model extends CI_Model
{
  function get_lecturas($idperiodo, $idservicio){
    $query = $this->db->query('SELECT idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria, fact_lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion,
                                      fact_abonados.abonado, fact_abonados.idcalle, fact_abonados.numero, fact_abonados.medidor, fact_cliente.razon_social, fact_cliente.nit, fact_cliente.ci, 
                                      fact_lecturas.imp_total, fact_lecturas.conexion, fact_lecturas.reposicion, fact_lecturas.recargo, fact_lecturas.devolucion, fact_cliente.correo
                               FROM fact_lecturas, fact_abonados, fact_cliente 
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND fact_lecturas.estado="0"
                                      AND fact_lecturas.generado IS NULL AND imp_total > 0
                               ORDER BY idlectura LIMIT '.$this->config->item('n_emision_masiva'), array($idperiodo, $idservicio));//ELIMINAR LIMIT 1
    return $query->result_array();
  }

  /////////////////para el conteo de facturas antes de enviar al sin
  function get_lecturas_periodo($idperiodo, $idservicio){
    $query = $this->db->query('SELECT idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria, fact_lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion,
                                      fact_abonados.abonado, fact_abonados.idcalle, fact_abonados.numero, fact_abonados.medidor, fact_cliente.razon_social, fact_cliente.nit, fact_cliente.ci, 
                                      fact_lecturas.imp_total, fact_lecturas.conexion, fact_lecturas.reposicion, fact_lecturas.recargo, fact_lecturas.aseo, fact_lecturas.alumbrado, fact_lecturas.afcoop, fact_lecturas.ley1886,
                                      fact_lecturas.dignidad, fact_lecturas.devolucion, fact_lecturas.desdom, fact_lecturas.desap, fact_lecturas.desau, fact_lecturas.desafcoop, fact_lecturas.desafcoop, fact_cliente.correo,
                                      fact_lecturas.generado
                                      
                               FROM fact_lecturas, fact_abonados, fact_cliente 
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND fact_lecturas.estado="0"
                                      AND fact_lecturas.generado IS NULL AND imp_total > 0
                               ORDER BY idlectura', array($idperiodo, $idservicio));//ENVIA EL TOTAL DE LAS FACTURAS CCONTADOR
    return $query->result_array();
  }
  ///////////////// con fact_factura_22
  function get_facturas_enviadas($idperiodo, $idservicio){
    $query = $this->db->query('SELECT fact_lecturas.idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria, fact_lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion,
                                      fact_abonados.abonado, fact_abonados.idcalle, fact_abonados.numero, fact_abonados.medidor, fact_cliente.razon_social, fact_cliente.nit, fact_cliente.ci, 
                                      fact_lecturas.imp_total, fact_lecturas.conexion, fact_lecturas.reposicion, fact_lecturas.recargo, fact_lecturas.aseo, fact_lecturas.alumbrado, fact_lecturas.afcoop, fact_lecturas.ley1886,
                                      fact_lecturas.dignidad, fact_lecturas.devolucion, fact_lecturas.desdom, fact_lecturas.desap, fact_lecturas.desau, fact_lecturas.desafcoop, fact_lecturas.desafcoop, fact_cliente.correo,
                                      fact_lecturas.generado, fact_factura_22.nro_fact, fact_factura_22.cuf, fact_factura_22.cufd, fact_factura_22.fecha_emision, fact_factura_22.leyenda_fact, fact_factura_22.monto_total
                                      
                               FROM fact_lecturas, fact_abonados, fact_cliente, fact_factura_22
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND 
                               fact_factura_22.idlectura=fact_lecturas.idlectura AND fact_factura_22.estado_fact="E"
                               ', array($idperiodo, $idservicio));//ENVIA EL TOTAL DE LAS FACTURAS CCONTADOR
    return $query->result_array();
  }

  ///////////////////////////////// saca unica medida para impuestos
  function get_lecturas_unica($idperiodo, $idservicio, $idlectura){
    $query = $this->db->query('SELECT idlectura, fact_lecturas.idabonado, fact_lecturas.idservicio, fact_lecturas.idcategoria, fact_lecturas.mulmed, kwh, potencia, fact_abonados.idcliente, idliberacion,
                                      fact_abonados.abonado, fact_abonados.idcalle, fact_abonados.numero, fact_abonados.medidor, fact_cliente.razon_social, fact_cliente.nit, fact_cliente.ci, 
                                      fact_lecturas.imp_total, fact_lecturas.conexion, fact_lecturas.reposicion, fact_lecturas.recargo, fact_lecturas.devolucion, fact_cliente.correo
                               FROM fact_lecturas, fact_abonados, fact_cliente 
                               WHERE (idperiodo=? AND fact_lecturas.idservicio=?) AND fact_lecturas.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente 
                               AND fact_lecturas.idlectura=?  
                               ', array($idperiodo, $idservicio, $idlectura));//ELIMINAR LIMIT 1
    return $query->result_array();
  }



}
