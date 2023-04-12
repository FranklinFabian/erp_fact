<!-- Datos generales del cliente-->

            <div class="panel-title">
              <h4><strong>Datos Del Cliente:</strong></h4>
            </div>   
           
<div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:10px;">
  <div class="pure-u-1 pure-u-md-1-3">
    <strong>Cliente:</strong> <?php echo $cliente['ci'];?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
    <strong>Télefono:</strong> <?php echo $cliente['telefono'];?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
    <strong>NIT:</strong> <?php echo $cliente['nit'];?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
    <strong>Razón Social:</strong> <?php echo $cliente['razon_social'];?>
  
  </div>
</div>
<!-- Fin Datos generales del cliente-->

            <div class="panel-title">
              <h4><strong>Datos Del Abonado:</strong></h4>
            </div>  
<div  style="background-color: #fff; padding:.5em; margin-top:.5em; border-radius:10px;">
  <form method="post" class="pure-form pure-form-stacked" id="form_buscar" data-parsley-validate>
    <fieldset>
      <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-5">
          <div class="pure-control-group">
            <label for="idabonado">Abonados:</label>
            <?php              
              foreach ($abonados as $key => $value){
                $servicio = $this->servicios_model->get_servicio($value['idservicio']);
                $data[$value['idabonado']] = 'idabonado:'.$value['idabonado'].' - '.$servicio['descripcion'];
              }
              $js_servicio = 'id="idabonado" '; 
              echo form_dropdown('idabonado', $data, $abonado['idabonado'], $js_servicio);
            ?>
          </div>            
        </div>
        
        <!--<div class="pure-u-1 pure-u-md-1-5">
          <div class="pure-control-group">
            <label for="idabonado">Abonado: <?php echo $abonado['idcliente'];?> servicio: <?php echo $abonado['idservicio'];?></label>
            <?php
              // $abonados = $this->abonados_model->get_abonos_cliente_servicio($abonado['idcliente'], $abonado['idservicio']);

              // foreach ($abonados as $key2 => $value2)
              //   $data_abonos[$value2['idabonado']] = $value2['idabonado'].' - '.$value2['abonado'];
              // $js_abonos = 'id="idabonado"'; 
              // echo form_dropdown('idabonado', $data_abonos, $abonado['idabonado'], $js_abonos);
            ?>
          </div>            
        </div>-->
      </div>
      <br>
      <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-5">
          <div class="pure-control-group">
            <strong>Circuito:</strong>  
              <?php
                  $circuito=$this->centros_model->get_centro($abonado['idcentro']);
                  echo $circuito['codigo'].' - '.$circuito['centro'];
              ?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
              <strong>Dirección:</strong>  
              <?php
                  $direccion=$this->calles_model->get_all_all($abonado['idcalle']);
                  echo $direccion['localidad'].' / '.$direccion['zona'].' / '.$direccion['calle'];
              ?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<strong>Categoria:</strong>  
              <?php
                  $categoria=$this->categorias_model->get_categorias($abonado['idcategoria']);
                  echo $categoria['categoria'];
              ?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<strong>Estado:</strong>  
              <?php
                  $estado=$this->estados_model->get_estado($abonado['idestado']);
                  echo $estado['estado'];
              ?>
    &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
<strong>Medidor:</strong>  
              <?php
                  echo $abonado['medidor'];
              ?>
          </div>            
        </div>
        
      </div>
    </fieldset>
  </form>    
</div>

<div class="panel-title">
              <h4><strong>Kardex De Usuario:</strong></h4>
            </div> 
  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
   
  <caption>KARDEX - <?php echo $abonado['idabonado']?></caption>
  
    <thead>
      <tr>
        <th>Nro.</th>
        <th>Emisión</th>
        <th>Lectura</th>
        <th>Consumo</th>
        <th>Servicios</th>
        <th>Otros</th>
        <th>Total</th>
        <th>Suma</th>
        <th>Pagar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $total = 0;
      foreach ($lecturas as $key => $value){
        $periodo=$this->periodos_model->get_periodo($value['idperiodo']);
        $sub_total = $value['imp_total']+$value['conexion']+$value['reposicion']+$value['recargo']+$value['aseo']+$value['alumbrado']+$value['afcoop']-$value['ley1886']-$value['dignidad']-$value['devolucion']-$value['desdom']-$value['desap']-$value['desau']-$value['desafcoop'];
        $total+=$sub_total;
        echo '
          <tr>
            <td><a href="'.base_url().'fact/cobranza/impresion_factura/'.$value['idlectura'].'" target="_blank" title="Reimpresión factura">'.($value['idlectura']).'<a></td>
            <td>'.substr(($periodo['emision']),3).'</td>
            <td>'.($value['indice']).'</td>
            <td>'.($value['kwh']).'</td>
            <td>'.($value['conexion']+$value['reposicion']).'</td>
            <td>'.($value['recargo']+$value['aseo']+$value['alumbrado']+$value['afcoop']).'</td>
            <td style="text-align:right; font-weight:bold">'.(number_format($sub_total,2,',','.')).'</td>
            <td style="text-align:right; font-weight:bold">'.(number_format($total,2,',','.')).'</td>
            <td style="text-align:center;"> <a id="btn_pagar_'.$value['idlectura'].'" class="button-small pure-button button-success" href="javascript:pagar_lectura('.$value['idlectura'].')">Pagar</button></td>
          </tr>
        ';
      }
      ?>
    </tbody>
  </table>

  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
  <caption> RESUMEN<?php //echo 'idcliente:'.$abonado['idcliente'];?></caption>
    <thead>
      <tr>
        <th style="background:#ffcc88;">Cliente</th>
        <th style="background:#ffcc88;">Servicio</th>
        <th style="background:#ffcc88;">Nro.</th>
        <th style="background:#ffcc88;">Importe</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
        $abonos_elect = $this->abonados_model->get_abonos_cliente_servicio($cliente['idcliente'], 1);
        $abonos_cable = $this->abonados_model->get_abonos_cliente_servicio($cliente['idcliente'], 2);

        //calcula el total de deudas de abonos electricos del cliente
        $total_elect = 0;
        $contador_elect = 0;
        foreach ($abonos_elect as $key0 => $value0) {
          $lecturas_elect = $this->lecturas_model->get_lecturas_abonado_servicio($value0['idabonado'], 1);
          foreach ($lecturas_elect as $key => $value){
            $sub_total_elect = $value['imp_total']+$value['conexion']+$value['reposicion']+$value['recargo']+$value['aseo']+$value['alumbrado']+$value['afcoop']-$value['ley1886']-$value['dignidad']-$value['devolucion']-$value['desdom']-$value['desap']-$value['desau']-$value['desafcoop'];
            $total_elect+=$sub_total_elect;
          }
          $contador_elect++;
          //echo $total_elect.'<br>';      
        }

        // Borrar cose
        //calcula el total de deudas de abonos cable del cliente
        $total_cable = 0;
        $contador_cable = 0;
        foreach ($abonos_cable as $key0 => $value0) {
          $lecturas_cable = $this->lecturas_model->get_lecturas_abonado_servicio($value0['idabonado'], 2);
          foreach ($lecturas_cable as $key => $value){
            $sub_total_cable = $value['imp_total']+$value['conexion']+$value['reposicion']+$value['recargo']+$value['aseo']+$value['alumbrado']+$value['afcoop']-$value['ley1886']-$value['dignidad']-$value['devolucion']-$value['desdom']-$value['desap']-$value['desau']-$value['desafcoop'];
            $total_cable+=$sub_total_cable;
          }
          $contador_cable++;
          //echo $total_cable.'<br>';      
        }
      
        //Impresion en tabla
        $servcios_contratados = $this->abonados_model->get_servicios_contratados_cliente($cliente['idcliente']);
        
        if(count($servcios_contratados)>1){
          echo '<tr><td>'.($cliente['ci']).'</td><td>ENERGIA ELECTRICA</td><td>'.$contador_elect.'</td><td style="text-align:right; font-weight:bold">'.number_format($total_elect, 2, ',', '.').'</td></tr>';
          echo '<tr><td>'.($cliente['ci']).'</td><td>TV CABLE</td><td>'.$contador_cable.'</td><td style="text-align:right; font-weight:bold">'.number_format($total_cable, 2, ',', '.').'</td></tr>';
          echo '<tr><td colspan=3 style="text-align:center; font-weight:bold; color:#000;">TOTAL</td><td style="text-align:right; font-weight:bold; color:#000;">'.number_format(($total_elect+$total_cable), 2, ',', '.').'</td></tr>';
        }else{
          echo '<tr><td>'.($cliente['ci']).'</td><td>ENERGIA ELECTRICA</td><td>'.$contador_elect.'</td><td style="text-align:right; font-weight:bold">'.number_format($total_elect, 2, ',', '.').'</td></tr>';
          echo '<tr><td colspan=3 style="text-align:center; font-weight:bold; color:#000;">TOTAL</td><td style="text-align:right; font-weight:bold; color:#000;">'.number_format(($total_elect), 2, ',', '.').'</td></tr>';
        }
      ?>
    </tbody>
  </table>  
<script>
	$("#idabonado").change(function(){
      cargar_kardex($('#idabonado').val());
  });

  function pagar_lectura(idlectura){
    var url = BASE_URL+"fact/cobranza/pagar_lectura/";      
      $.ajax({
        type: "GET",
        url: url,
        data: {'idlectura': idlectura},
        success: function(data){
          //console.log(data);
          if(data=='ok'){
            window.open(BASE_URL+'fact/cobranza/impresion_factura/'+idlectura,'_blank');
            ocultar_boton(idlectura);
          }
          else if(data=='err')
            alert("No puedes pagar existen periodos anteriores.");
          else 
            alert("Factura ya cobrada");
        }
      });

  }

  function ocultar_boton(idlectura){
    $("#btn_pagar_"+idlectura).fadeOut(0);
  }
</script>