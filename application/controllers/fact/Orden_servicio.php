<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden_servicio extends CI_Controller{

  public function lista(){
    if(isLogin()){      
      $data['main_content'] = 'orden_servicio/lista_view';
      $data['title'] = 'Lista de orden_servicios';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function buscar_cliente(){//cliente abonado
    if(isLogin()){
      $razon_social = trim(mb_strtoupper($this->input->post('razon_social')));
      $resultado = array();
      if(($razon_social==''))
        $resultado = null; //echo 'Debe indroducir algún criterio de busqueda';
      else
        $resultado = $this->cliente_model->buscar_abonado($razon_social);
      $salida='';
      $i=1;
      if(!is_null($resultado)){
        $salida.= '
        <table style="margin-top:-1em">
          <caption>RESULTADOS DE LA BUSQUEDA</caption>
          <thead>
            <tr>
              <th>Nro.</th>
              <th>Cliente</th>
              <th>Razón Social abonado</th>
              <th>NIT</th>
              <th>Nacimiento</th>
              <th>Telefono</th>
              <th>Servicio</th>
              <th>Solicitudes</th>
            </tr>
          </thead>
          <tbody>';
          foreach ($resultado as $key => $value) {
            $servicio=$this->servicios_model->get_servicio($value['idservicio']);
            $salida.='
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['ci']).'</td>
              <td>'.($value['razon_social']).'</td>
              <td>'.($value['nit']).'</td>
              <td>'.($value['nacimiento']).'</td>
              <td>'.($value['telefono']).'</td>
              <td>'.$servicio['descripcion'].'</td>
              <td> <a id="btn_editar" class="button-small pure-button pure-button-primary" href="'.base_url().'orden_servicio/listar_ordenes_servicio/'.$value['idabonado'].'/'.$value['idservicio'].'">Ver solicitudes</button></td>
            </tr>            
            ';
          }
          $salida.='</tbody>
        </table>        
        ';
        echo $salida;
      }else{
        echo 'Debe indroducir algún criterio de busqueda';
      }
    }
    else
      redirect(base_url());
  }

  public function listar_ordenes_servicio($idabonado, $idservicio){
    
    if(isLogin()){
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $data['idservicio'] = $idservicio;
      $data['idabonado'] = $idabonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $ordenes_cliente = $this->ordenes_model->get_ordenes($idabonado);
      if(!is_null($ordenes_cliente))
        $data['ordenes'] = $ordenes_cliente;

      $data['main_content'] = 'orden_servicio/listar_ordenes_servicio_view';
      $data['title'] = 'Lista de orden_servicios por cliente';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function listar_cortes_reposiciones($idabonado, $idservicio){
    
    if(isLogin()){
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $data['idservicio'] = $idservicio;
      $data['idabonado'] = $idabonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $cortes_cliente = $this->cortes_model->get_cortes($idabonado);
      if(!is_null($cortes_cliente))
        $data['cortes'] = $cortes_cliente;

      $data['main_content'] = 'orden_servicio/listar_cortes_reposiciones_view';
      $data['title'] = 'Lista de orden_servicios por cliente';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo($idabonado, $idservicio){
    if(isLogin()){
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $data['idservicio'] = $idservicio;
      $data['idabonado'] = $idabonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $data['gestiones'] = $this->gestiones_model->get_by_idservicio($idservicio);
      $data['categorias'] = $this->categorias_model->get_categorias_servicio($idservicio);
      $data['abonado'] = $this->abonados_model->get_abonado($idabonado);
      
      $data['main_content'] = 'orden_servicio/nuevo_view';
      $data['title'] = 'Nueva orden_servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isLogin())
    {
      $ultima_fila = $this->ordenes_model->get_ultima_fila($this->input->post('idservicio'));
      if(is_null($ultima_fila))
        $numero = 1;
      else 
        $numero = $ultima_fila['numero'] + 1;
      
      $data['numero'] = $numero;
      $data['idabonado'] = $this->input->post('idabonado');
      $data['idgestion'] = $this->input->post('idgestion');
      $data['idservicio'] = $this->input->post('idservicio');
      $data['fecha'] = date('Y-m-d H:i:s');
      $costo = $this->costos_model->get_costo_by_idgestion($this->input->post('idgestion'));
      $data['costo'] = $costo['importe'];
      $data['nota'] = strtoupper($this->input->post('nota'));
      $data['solicitante'] = strtoupper($this->input->post('solicitante'));
      $data['estado'] = 'S';
      if(($this->input->post('idgestion')==11) || ($this->input->post('idgestion')==5))
        $data['ncategoria']=$this->input->post('ncategoria');
      if(($this->input->post('idgestion')==13) || ($this->input->post('idgestion')==7))
        $data['ncliente']=$this->input->post('ncliente');
      if($this->input->post('idgestion')==6){
        //actualizar abonado OJO NO SERA CUANDO EL TECNICO ACTUALICE REALMENTE LOS PUNTOS?
        $abonado = $this->abonados_model->get_abonado($this->input->post('idabonado'));
        $data_abonado['cantidad']=(int)($abonado['cantidad'] + $this->input->post('cantidad'));
        $this->abonados_model->actualizar($this->input->post('idabonado'), $data_abonado);
      }
      
      $data['usuario'] = $this->session->userdata('id_empleado');
      // var_dump($data); 1.000.000
     $this->ordenes_model->insertar($data);
     echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function imprimir_orden($idorden){
    if(isLogin()){
      $orden = $this->ordenes_model->get_orden($idorden);
      $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $centro = $this->centros_model->get_centro($abonado['idcentro']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $servicio = $this->gestiones_model->get_gestion($orden['idgestion']);
      $costo = $this->costos_model->get_costo_by_idgestion($servicio['idgestion']);

      $data['orden'] = $orden;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['centro'] = $centro;
      $data['poste'] = $poste;
      $data['categoria'] = $categoria;
      $data['direccion'] = $direccion;
      $data['servicio'] = $servicio;
      $data['costo'] = $costo;
      $data['ncategoria'] = $this->categorias_model->get_categorias($orden['ncategoria']);;
      $data['ncliente'] = $this->cliente_model->get_cliente($orden['ncliente']);;
      
      $data['title'] = 'Impresión orden';
      //actualizando impreso en 1
      $data_orden['impreso']=1;
      $this->ordenes_model->actualizar($idorden, $data_orden);

      //Segun el tipo de orden imprimimos correspondiente solicitud
      $idgestion = $orden['idgestion'];
      //var_dump($orden);
      switch ($idgestion) {
        //servicios cable
        case '1': $this->load->view('orden_servicio/imprimir_gestion_tv_nueva_conexion_view', $data);break;
        case '2': $this->load->view('orden_servicio/imprimir_gestion_tv_corte_servicio_view', $data);break;
        case '5': $this->load->view('orden_servicio/imprimir_gestion_tv_cambio_categoria_view', $data);break;
        case '7': $this->load->view('orden_servicio/imprimir_gestion_tv_cambio_nombre_view', $data);break;

        //Servicios electricos
        case '9' :$this->load->view('orden_servicio/imprimir_gestion_nueva_conexion_view', $data);break;
        case '10':$this->load->view('orden_servicio/imprimir_gestion_tramite_elt_view', $data);break;
        case '11':$this->load->view('orden_servicio/imprimir_gestion_cambio_categoria_view', $data);break;
        case '12':$this->load->view('orden_servicio/imprimir_gestion_traslado_view', $data);break;
        case '13':$this->load->view('orden_servicio/imprimir_gestion_cambio_nombre_view', $data);break;
        case '15':$this->load->view('orden_servicio/imprimir_gestion_orden_view', $data);break;
        case '16':$this->load->view('orden_servicio/imprimir_gestion_cambio_medidor_view', $data);break;
        case '17':$this->load->view('orden_servicio/imprimir_gestion_cambio_cuchilla_view', $data);break;
      }
      
    }
    else
      redirect(base_url());
  }

  public function buscar_ci($ci){
    $resultado = $this->cliente_model->buscar_ci2($ci);// buscar_ci2 por si hay duplicados
    
    $salida='<table style="margin-top:.2em; margin-bottom:-.2em;">';
    foreach ($resultado as $key => $value) {
      $edad = calculaAnios(($value['nacimiento']), date('d/m/Y'));
      $arr_edad = explode(',',$edad);
      
      $salida.= '
        <tr>
          <td>'.$value['idcliente'].'</td>
          <td>'.$value['razon_social'].'</td>
          <td>'.($value['nacimiento']).'</td>';
      
        $salida.='<td><button type="button" onclick="establecer_id_cliente('.$value['idcliente'].');">agregar</button></td>';
      
      $salida.='</tr>'; 
    }
    $salida.='</table>';

    if(empty($resultado))
      echo '<p style="color: #DE9D00; font-weight:bold;">EL CI ingresado no ese encuntra registrado.</p>';
    else 
      echo $salida;
  }

  //PARA LISTAS
  public function lista_impresion(){
    if(isLogin()){
      $ordenes = $this->ordenes_model->get_lista_impresion(1);
      //var_dump($ordenes);
      $data['ordenes'] = $ordenes;
      $data['main_content'] = 'orden_servicio/lista_impresion_view';
      $data['title'] = 'Lista impresión';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

  public function lista_impresion_cable(){
    if(isLogin()){
      $data['ordenes']=$this->ordenes_model->get_lista_impresion(2);
      $this->load->view('orden_servicio/lista_impresion_cable_view', $data);
    }
    else
      redirect(base_url());
  }

  
  public function procesar_ordenes($idservicio){
    if(isLogin()){
      $ordenes = $this->ordenes_model->get_ordenes_s($idservicio);
      $data['ordenes'] = $ordenes;
      $data['idservicio'] = $idservicio;
      $data['main_content'] = 'orden_servicio/procesar_ordenes_view';
      $data['title'] = 'Asignar ordenes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  
  public function procesar($idorden){
    if(isLogin()){
      $orden = $this->ordenes_model->get_orden($idorden);
      $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $centro = $this->centros_model->get_centro($poste['idcentro']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $estado = $this->estados_model->get_estado($abonado['idestado']);
      $gestion = $this->gestiones_model->get_gestion($orden['idgestion']);
      $empleados = $this->empleados_model->get_all_vigente();

      $data['orden'] = $orden;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['poste'] = $poste;
      $data['centro'] = $centro;
      $data['direccion'] = $direccion;
      $data['categoria'] = $categoria;
      $data['estado'] = $estado;
      $data['gestion'] = $gestion;
      $data['empleados'] = $empleados;
      $data['main_content'] = 'orden_servicio/procesar_view';
      $data['title'] = 'Procesar orden';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function ejecutar($idorden){
    if(isLogin()){
      $orden = $this->ordenes_model->get_orden($idorden);
      //var_dump($orden);
      $data_orden['estado'] = 'E';
      $data_orden['fecha_final'] = $this->input->post('fecha_fin').' '.$this->input->post('hora_fin').':00';
      $data_orden['tiempo_tramite'] = $this->input->post('tiempo_tram_dias');
      $empleado = $this->empleados_model->get_empleado($this->input->post('idempleado'));
      $data_orden['empleado'] = $empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->ordenes_model->actualizar($idorden, $data_orden);
      if($orden['idgestion']==11){
        $data_abonado['idcategoria']=$orden['ncategoria'];
        $this->abonados_model->actualizar($orden['idabonado'], $data_abonado);
      }elseif($orden['idgestion']==13){
        $data_abonado['idcliente']=$orden['ncliente'];
        $this->abonados_model->actualizar($orden['idabonado'], $data_abonado);
      }
      
      redirect(base_url().'orden_servicio/procesar_ordenes/'.$orden['idservicio']);
    }
    else
      redirect(base_url());
  }

  /////////////////////////////////NUEVAS CONEXIONES
  public function cargar_poste_centro($idcentro){
    $html='<select name="idposte" id="idposte" onchange="" required="required">';
    $html.='<option value="">Seleccione</option>';
    $postes = $this->postes_model->get_poste_centro($idcentro);
    foreach ($postes as $key => $value)
      $html.='<option value="'.$value['idposte'].'">'.$value['poste'].'</option>';
    $html.='</select>';
    echo $html;
  }//fin funcion para ajax

  public function procesar_ordenes_nueva_conexion($idservicio){
    if(isLogin()){
      $ordenes = $this->conexiones_model->get_conexiones_servicio($idservicio);
      $data['idservicio'] = $idservicio;
      $data['ordenes'] = $ordenes;
      $data['main_content'] = 'orden_servicio/procesar_ordenes_nueva_conexion_view';
      $data['title'] = 'Asignar ordenes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  
  public function procesar_nueva_conexion($idservicio, $idconexion){
    if(isLogin()){
      $conexion = $this->conexiones_model->get_conexion($idconexion);
      $orden = $this->ordenes_model->get_orden($conexion['idorden']);
      $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);

      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $centro = $this->centros_model->get_centro($poste['idcentro']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $estado = $this->estados_model->get_estado($abonado['idestado']);
      $gestion = $this->gestiones_model->get_gestion($orden['idgestion']);
      $empleados = $this->empleados_model->get_all_vigente();

      $data['orden'] = $orden;
      $data['abonado'] = $abonado;
      $data['conexion'] = $conexion;
      $data['cliente'] = $cliente;      
      $data['poste'] = $poste;
      $data['centro'] = $centro;
      $data['direccion'] = $direccion;
      $data['categoria'] = $categoria;
      $data['estado'] = $estado;
      $data['gestion'] = $gestion;
      $data['idservicio'] = $idservicio;
      $data['empleados'] = $empleados;
      $data['main_content'] = 'orden_servicio/procesar_nueva_conexion_view';
      $data['title'] = 'Procesar Conexión';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function ejecutar_nueva_conexion($idconexion){
    if(isLogin()){
      $conexion = $this->conexiones_model->get_conexion($idconexion);
      $orden = $this->ordenes_model->get_orden($conexion['idorden']);
      $abonado = $this->abonados_model->get_abonado($orden['idabonado']);
      $data_conexion['estado'] = 'E';
      $data_conexion['fecha_final'] = $this->input->post('fecha_fin').' '.$this->input->post('hora_fin').':00';
      $data_conexion['tiempo_tramite'] = $this->input->post('tiempo_tram_dias');
      $empleado = $this->empleados_model->get_empleado($this->input->post('idempleado'));
      $data_conexion['empleado'] = $empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->conexiones_model->actualizar($idconexion, $data_conexion);

      //para actualizar datos del abonado
      $data_abo['idcentro']=$this->input->post('idcentro');
      $data_abo['idposte']=$this->input->post('idposte');
      $data_abo['idcalle']=$this->input->post('idcalle');
      $data_abo['idestado']=2;
      $data_abo['fechainsta']=$this->input->post('fecha_fin');
      $data_abo['medidor']=trim(strtoupper($this->input->post('medidor')));
      $data_abo['indiceinicial']=strtoupper($this->input->post('indiceinicial'));

      //si es conexion nueva evitar que el numero de medidor se repita
      $medidor_ducplicado = $this->abonados_model->buscar_medidor(trim(strtoupper($this->input->post('medidor'))));
      if((!is_null($medidor_ducplicado)) && ($abonado['idservicio']) && $orden['idgestion']=='9')
        redirect(base_url().'orden_servicio/error_medidor');
      
      if($orden['idgestion']=='16'){
        $ultima_lectura = $this->lecturas_model->get_ultima_lectura_abonado($abonado['idabonado']);
        if(!is_null($ultima_lectura)){
          $data_lectura['indice']=$this->input->post('indiceinicial');
          $this->lecturas_model->actualizar($ultima_lectura['idlectura'], $data_lectura);
        }
      }
      
      $this->abonados_model->actualizar($abonado['idabonado'], $data_abo);
      
      if($conexion['idservicio']==1)
        redirect(base_url().'orden_servicio/procesar_ordenes_nueva_conexion/1');
      else 
        redirect(base_url().'orden_servicio/procesar_ordenes_nueva_conexion/2');

    }
    else
      redirect(base_url());
  }///////////////////fin nuevas conexiones

  //PARA LISTAS
  public function asignar_ordenes(){
    if(isLogin()){
      $ordenes = $this->ordenes_model->get_ordenes_sin_nombre();
      $data['ordenes'] = $ordenes;
      $data['main_content'] = 'orden_servicio/asignar_ordenes_view';
      $data['title'] = 'Asignar ordenes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

  //PARA ERROR MEDIDOR
  public function error_medidor(){
    if(isLogin()){
      $data['main_content'] = 'orden_servicio/error_medidor_view';
      $data['title'] = 'Error medidor';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

  ///////////////////////// PARA CORTES
  public function nuevo_corte($idabonado, $idservicio){
    if(isLogin()){
      $abonado = $this->abonados_model->get_abonado($idabonado);
      $data['idservicio'] = $idservicio;
      $data['idabonado'] = $idabonado;
      $data['cliente'] = $this->cliente_model->get_cliente($abonado['idcliente']);
      $data['abonado'] = $this->abonados_model->get_abonado($idabonado);
      
      $data['main_content'] = 'orden_servicio/nuevo_corte_view';
      $data['title'] = 'Nuevo corte de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin nuevo_corte

  public function crear_corte(){
    if(isLogin())
    {
      $ultima_fila = $this->cortes_model->get_ultima_fila($this->input->post('idservicio'));
      if(is_null($ultima_fila))
        $numero = 1;
      else 
        $numero = $ultima_fila['numero'] + 1;
      
      $data['numero'] = $numero;
      $data['idabonado'] = $this->input->post('idabonado');
      $data['idservicio'] = $this->input->post('idservicio');
      $data['fecha'] = date('Y-m-d H:i:s');
      $data['lista'] = 0;
      $data['meses'] = 0;
      $data['pagado'] = 0;
      $data['estado'] = 'S';
      $data['nota'] = strtoupper($this->input->post('nota'));
      
      $data['solicitante'] = strtoupper($this->input->post('solicitante'));
      
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->cortes_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function imprimir_corte($idcorte){
    if(isLogin()){
      $corte = $this->cortes_model->get_corte($idcorte);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $centro = $this->centros_model->get_centro($abonado['idcentro']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      
      $data['corte'] = $corte;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['centro'] = $centro;
      $data['poste'] = $poste;
      $data['categoria'] = $categoria;
      $data['direccion'] = $direccion;
      
      $data['title'] = 'Impresión corte';
      $this->load->view('orden_servicio/imprimir_corte_view', $data);
    }
    else
      redirect(base_url());
  }//fin impresion corte

  public function procesar_cortes($idservicio){
    if(isLogin()){
      $cortes = $this->cortes_model->get_cortes_para_procesar($idservicio);
      $data['idservicio'] = $idservicio;
      $data['cortes'] = $cortes;
      $data['main_content'] = 'orden_servicio/procesar_cortes_view';
      $data['title'] = 'Asignar cortes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function procesar_el_corte($idservicio, $idcorte){
    if(isLogin()){
      $corte = $this->cortes_model->get_corte($idcorte);
      //$orden = $this->ordenes_model->get_orden($corte['idorden']);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);

      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $centro = $this->centros_model->get_centro($poste['idcentro']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $estado = $this->estados_model->get_estado($abonado['idestado']);
      
      $empleados = $this->empleados_model->get_all_vigente();

      $data['abonado'] = $abonado;
      $data['corte'] = $corte;
      $data['cliente'] = $cliente;      
      $data['poste'] = $poste;
      $data['centro'] = $centro;
      $data['direccion'] = $direccion;
      $data['categoria'] = $categoria;
      $data['estado'] = $estado;
      $data['idservicio'] = $idservicio;
      $data['empleados'] = $empleados;
      $data['main_content'] = 'orden_servicio/procesar_el_corte_view';
      $data['title'] = 'Procesar Conexión';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function ejecutar_corte($idcorte){
    if(isLogin()){
      
      $corte = $this->cortes_model->get_corte($idcorte);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);

      if($abonado['idestado'] == 2){///solo se ejecuta el cambio si es que el estado es NORMAL
        $data_corte['estado'] = 'E';
        $data_corte['fecha_final'] = $this->input->post('fecha_fin').' '.$this->input->post('hora_fin').':00';
        $data_corte['tiempo_tramite'] = $this->input->post('tiempo_tram_dias');
        $empleado = $this->empleados_model->get_empleado($this->input->post('idempleado'));
        $data_corte['empleado'] = $empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
        if($corte['idservicio']==1)
          $data_corte['lectura'] = $this->input->post('lectura');

        $this->cortes_model->actualizar($idcorte, $data_corte);
  
        //para actualizar datos del abonado
        $data_abo['idestado']=3;
        $data_abo['fechacorte']=$data_corte['fecha_final'];
        $this->abonados_model->actualizar($abonado['idabonado'], $data_abo);
        
        if($corte['idservicio']==1)
          redirect(base_url().'orden_servicio/procesar_cortes/1');
        else 
          redirect(base_url().'orden_servicio/procesar_cortes/2');
  
      }else// el estado es distito a 2
        redirect(base_url().'orden_servicio/error_corte');//error validacion

    }//fin if login
    else
      redirect(base_url());
  }//fin funcion  
  
  public function error_corte(){
    if(isLogin()){
      $data['main_content'] = 'orden_servicio/error_corte_view';
      $data['title'] = 'Error corte';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

  /////////////////REPOSICIONES
  public function reponer_corte($idcorte){
    if(isLogin()){
      $corte = $this->cortes_model->get_corte($idcorte);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $centro = $this->centros_model->get_centro($poste['idcentro']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $estado = $this->estados_model->get_estado($abonado['idestado']);
      
      $empleados = $this->empleados_model->get_all_vigente();

      $data['corte'] = $corte;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['poste'] = $poste;
      $data['centro'] = $centro;
      $data['direccion'] = $direccion;
      $data['categoria'] = $categoria;
      $data['estado'] = $estado;
      $data['empleados'] = $empleados;
      $data['main_content'] = 'orden_servicio/reponer_corte_view';
      $data['title'] = 'Reposición';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear_reposicion(){
    if(isLogin()){

      $idservicio = $this->input->post('idservicio');
      $idcorte = $this->input->post('idcorte');

      $ultima_fila = $this->reposiciones_model->get_ultima_fila($idservicio);
      if(is_null($ultima_fila))
        $numero = 1;
      else 
        $numero = $ultima_fila['numero'] + 1;

      $data_repo['idcorte'] = $idcorte;
      $data_repo['numero'] = $numero;
      $data_repo['idservicio'] = $idservicio;
      $data_repo['fecha_pago'] = date('Y-m-d h:i:s');
      $data_repo['estado'] = 'S';
      $data_repo['solicitante'] = mb_strtoupper(trim($this->input->post('solicitante')));
      $data_repo['ci'] = mb_strtoupper(trim($this->input->post('ci')));
      $data_repo['telefono'] = mb_strtoupper(trim($this->input->post('telefono')));
      
      $periodo_activo = $this->periodos_model->get_ultimo();
      $costo = $this->costos_model->get_costo_repo($periodo_activo['idperiodo'], 3);// enviamos el periodo y idgestion (3 = reposicion)
      if(is_null($costo))
        redirect(base_url().'orden_servicio/error_costo/');
      else{
        $data_repo['costo'] = (float)$costo['importe'];
        $data_repo['usuario'] = $this->session->userdata('usuario');
        $this->reposiciones_model->insertar($data_repo);
        $corte = $this->cortes_model->get_corte($idcorte);
        redirect(base_url().'orden_servicio/listar_cortes_reposiciones/'.$corte['idabonado'].'/'.$idservicio);//($idabonado, $idservicio)
      }
    }
    else
      redirect(base_url());
  }

  //PARA ERROR COSTO
  public function error_costo(){
    if(isLogin()){
      $data['main_content'] = 'orden_servicio/error_costo_view';
      $data['title'] = 'Error costo';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function imprimir_form_rep($idcorte){
    if(isLogin()){
      $corte = $this->cortes_model->get_corte($idcorte);
      $reposicion = $this->reposiciones_model->get_rep_by_idcorte($idcorte);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
      $centro = $this->centros_model->get_centro($abonado['idcentro']);
      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      
      $data['corte'] = $corte;
      $data['reposicion'] = $reposicion;
      $data['abonado'] = $abonado;
      $data['cliente'] = $cliente;
      $data['centro'] = $centro;
      $data['poste'] = $poste;
      $data['categoria'] = $categoria;
      $data['direccion'] = $direccion;
      $data['title'] = 'Impresión reposición servicio';

      $this->load->view('orden_servicio/imprimir_form_rep_view', $data);
    }
    else
      redirect(base_url());
  }
  //////////////////////////////REPOSICIONES
  public function procesar_reposiciones($idservicio){
    if(isLogin()){
      $reposiciones = $this->reposiciones_model->get_reposiciones_para_procesar($idservicio);
      $data['idservicio'] = $idservicio;
      $data['reposiciones'] = $reposiciones;
      $data['main_content'] = 'orden_servicio/procesar_reposiciones_view';
      $data['title'] = 'Asignar reposiciones';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function procesar_la_reposicion($idservicio, $idreposicion){
    if(isLogin()){
      $reposicion = $this->reposiciones_model->get_reposicion($idreposicion);
      $corte = $this->cortes_model->get_corte($reposicion['idcorte']);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);
      $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);

      $poste = $this->postes_model->get_poste($abonado['idposte']);
      $centro = $this->centros_model->get_centro($poste['idcentro']);
      $direccion = $this->calles_model->get_all_all($abonado['idcalle']);
      $categoria = $this->categorias_model->get_categorias($abonado['idcategoria']);
      $estado = $this->estados_model->get_estado($abonado['idestado']);
      
      $empleados = $this->empleados_model->get_all_vigente();

      $data['abonado'] = $abonado;
      $data['corte'] = $corte;
      $data['reposicion'] = $reposicion;
      $data['cliente'] = $cliente;      
      $data['poste'] = $poste;
      $data['centro'] = $centro;
      $data['direccion'] = $direccion;
      $data['categoria'] = $categoria;
      $data['estado'] = $estado;
      $data['idservicio'] = $idservicio;
      $data['empleados'] = $empleados;
      $data['main_content'] = 'orden_servicio/procesar_la_reposicion_view';
      $data['title'] = 'Procesar Conexión';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function ejecutar_reposicion($idreposicion){
    if(isLogin()){
      
      $reposicion = $this->reposiciones_model->get_reposicion($idreposicion);
      $corte = $this->cortes_model->get_corte($reposicion['idcorte']);
      $abonado = $this->abonados_model->get_abonado($corte['idabonado']);

      if($abonado['idestado'] != 2){///solo se ejecuta el cambio si es que el estado es NORMAL
        $data_repos['estado'] = 'E';
        $data_repos['fecha_repos'] = $this->input->post('fecha_repos').' '.$this->input->post('hora_repos').':00';
        $data_repos['tiempo_tramite'] = $this->input->post('tiempo_tram_dias');
        $data_repos['lectura_rep'] = $this->input->post('lectura');
        $empleado = $this->empleados_model->get_empleado($this->input->post('idempleado'));
        $data_repos['empleado'] = $empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
        $this->reposiciones_model->actualizar($idreposicion, $data_repos);
  
        //para actualizar datos del abonado
        $data_abo['idestado']=2;
        $data_abo['fecharepos']=$data_repos['fecha_repos'];
        $this->abonados_model->actualizar($abonado['idabonado'], $data_abo);
        
        if($corte['idservicio']==1)
          redirect(base_url().'orden_servicio/procesar_reposiciones/1');
        else 
          redirect(base_url().'orden_servicio/procesar_reposiciones/2');
  
      }else// el estado es distito != 2
        redirect(base_url().'orden_servicio/error_reposicion');//error validacion

    }//fin if login
    else
      redirect(base_url());
  }//fin funcion  

  public function error_reposicion(){
    if(isLogin()){
      $data['main_content'] = 'orden_servicio/error_reposicion_view';
      $data['title'] = 'Error reposicion';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());

  }

}//fin class
