<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cortes_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_cortes');
    return $query->result_array();
  }

  function get_corte($idcorte){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idcorte=?',array($idcorte));
    return $query->row_array();
  }

  function get_cortes($idabonado){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idabonado=?',array($idabonado));
    return $query->result_array();
  }

  function get_lista_impresion($idservicio){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? AND impreso=0',array($idservicio));
    return $query->result_array();
  }

  function get_listas_cortes($idservicio){
    $query = $this->db->query('SELECT DISTINCT lista FROM fact_cortes WHERE idservicio=? AND lista <> 0 order by lista desc',array($idservicio));
    return $query->result_array();
  }

  function get_fila_lista($idservicio, $lista){
    $query = $this->db->query('SELECT idcorte, fecha, idabonado FROM fact_cortes WHERE idservicio=? AND lista=?',array($idservicio, $lista));
    return $query->row_array();
  }

  function get_cortes_s($idservicio){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? AND estado="S" AND (fentrega IS NULL) AND (devuelto IS NULL)  AND (fdevuelto IS NULL) ORDER BY fecha DESC',array($idservicio));
    return $query->result_array();
  }

  function get_cortes_gestion($idgestion=null, $idservicio=null){
    if(is_null($idgestion)){
      $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? AND pentrega IS NULL', array($idservicio));
      return $query->result_array();
    }else{
      return 0;
    }

  }

  function get_cortes_by_servicio_lista($idservicio, $lista){
    $query = $this->db->query('SELECT fact_abonados.idabonado, fact_abonados.abonado, fact_cliente.razon_social, fact_cortes.numero, fact_postes.poste, fact_abonados.medidor, fact_cortes.meses, fact_abonados.idposte,
                                      idcalle
                                FROM fact_cortes, fact_abonados, fact_cliente, fact_postes
                                WHERE fact_cortes.idservicio=? AND lista=? AND (fact_cortes.idabonado=fact_abonados.idabonado AND fact_abonados.idcliente=fact_cliente.idcliente AND
                                fact_abonados.idposte=fact_postes.idposte)
                                ',array($idservicio, $lista));
    return $query->result_array();
  }

  //para cortes
  function get_cortes_para_procesar($idservicio){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? AND estado="S" AND entregado IS NOT NULL ORDER BY numero DESC',array($idservicio));
    return $query->result_array();
  }

  function get_cortes_gestion_para_devolucion($idservicio=null){
      $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? AND fdevuelto IS NULL AND pentrega IS NOT NULL', array($idservicio));
      return $query->result_array();
  }

  function get_orden($idcorte){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idcorte=?',array($idcorte));
    return $query->row_array();
  }

  function get_ultima_fila($idservicio){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idservicio=? ORDER BY idcorte DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function get_ultima_lista($idservicio){
    $query = $this->db->query('SELECT fact_cortes.idcorte, lista, fact_cortes.idservicio, idcentro 
                                  FROM fact_cortes, fact_abonados
                                  WHERE fact_cortes.idservicio=? AND (lista <> 0) AND (fact_cortes.idabonado=fact_abonados.idabonado) ORDER BY lista DESC',array($idservicio));
    return $query->row_array();
  }

  function get_costo($idcorte){
    $query = $this->db->query('SELECT * FROM fact_cortes WHERE idcorte=?',array($idcorte));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_cortes" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_cortes',$data);
  }
  function actualizar($idcorte, $data)
  {
    $this->db->where('idcorte', $idcorte);
    $this->db->update('fact_cortes', $data);
  }
  function eliminar($idcorte)
  {
    $this->db->where('idcorte', $idcorte);
    $this->db->delete('fact_cortes');
  }

}
