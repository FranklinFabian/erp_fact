<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Facturación Y Cobranzas</small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Alert Message -->
    <?php $message = $this->session->userdata('message');
    if (isset($message)) { ?>
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $message ?>
      </div>
    <?php $this->session->unset_userdata('message');
    }
    $error_message = $this->session->userdata('error_message');
    if (isset($error_message)) { ?>
      <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $error_message ?>
      </div>
    <?php $this->session->unset_userdata('error_message');
    }
    ?>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="panel-title">
              <h4>Facturas Del Usuario</h4>
            </div>
          </div>
          <div class="panel-body">
          <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/gestion_factura/" class="btn btn-primary">Volver a Consultar</a>
                
                
              </div>
            </div>
<p></p>
<div class="content">
    
    <p><strong>CLIENTE:</strong> <a target="_blank" href="<?php echo base_url()?>cliente/editar/<?php echo $cliente['idcliente']?>"><?php echo $cliente['razon_social'];?></a></p>
    <!-- SERVICIOS BASICOS-->
    <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <caption>Servicios Básicos</caption>
      <thead>
        <tr>
          <th width=10%>Sector</th>
          <th width=10%>Fecha emisión</th>
          <th width=7%>Nro. Factura</th>
          <th>CUF</th>
          <th width=7%>Monto total</th>
          <th width=5%>Imprimir</th>
          <th width=5%>Correo</th>
          <th width=5%>Anular</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($facturas_13 as $key => $value){
          echo '
            <tr>
              <td>Consumo electrico</td>
              <td>'.($value['fecha_emision']).'</td>
              <td>'.($value['nro_fact']).'</td>
              <td>'.($value['cuf']).'</td>
              <td>'.number_format($value['monto_total'],2,',','.').'</td>';
              if($value['estado_fact']=='E'){
                echo '
                <td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/impresion_factura/'.$value['idlectura'].'/13">Imprimir</button></td>';
                if(!is_null($cliente['correo']) && ($cliente['correo']!=''))
                  echo '<td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/enviar_factura/'.$value['idlectura'].'/13">Enviar</button></td>';
                else echo '<td></td>';
                  echo '<td style="align:center"> <a id="btn_eliminar" class="button-small pure-button button-error" href="'.base_url().'fact/gestion_factura/anular/'.$value['idlectura'].'/13">Anular</button></td>
                </tr>';
              }elseif($value['estado_fact']=='A'){
                echo '<td colspan=3 style="text-align:center">ANULADO</td>';
              }else
                echo '<td colspan=3 style="text-align:center">PENDIENTE</td>';
        }// fin foreach
        ?>
      </tbody>
    </table><!-- FIN SERVICIOS BASICOS-->

    <!-- TV CABLE-->
    <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
    <caption>Telecomunicaciones</caption>
      <thead>
        <tr>
          <th width=10%>Sector</th>
          <th width=10%>Fecha emisión</th>
          <th width=7%>Nro. Factura</th>
          <th>CUF</th>
          <th width=7%>Monto total</th>
          <th width=5%>Imprimir</th>
          <th width=5%>Correo</th>
          <th width=5%>Anular</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($facturas_22 as $key => $value){
          echo '
            <tr>
              <td>Telecomunicaciones</td>
              <td>'.($value['fecha_emision']).'</td>
              <td>'.($value['nro_fact']).'</td>
              <td>'.($value['cuf']).'</td>
              <td>'.number_format($value['monto_total'],2,',','.').'</td>';
              if($value['estado_fact']=='E'){
                echo '
                <td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/impresion_factura/'.$value['idlectura'].'/22">Imprimir</button></td>';
                if(!is_null($cliente['correo']) && ($cliente['correo']!=''))
                  echo '<td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/enviar_factura/'.$value['idlectura'].'/22">Enviar</button></td>';
                else echo '<td></td>';
                  echo '<td style="align:center"> <a id="btn_eliminar" class="button-small pure-button button-error" href="'.base_url().'fact/gestion_factura/anular/'.$value['idlectura'].'/22">Anular</button></td>
                </tr>';
              }elseif($value['estado_fact']=='A'){
                echo '<td colspan=3 style="text-align:center">ANULADO</td>';
              }else
                echo '<td colspan=3 style="text-align:center">PENDIENTE</td>';
        }// fin foreach
        ?>
      </tbody>
    </table><!-- FIN TV CABLE-->

    <!-- COMPRA VENTA-->
    <table wid="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
    <caption>Compra y venta</caption>
      <thead>
        <tr>
          <th width=10%>Sector</th>
          <th width=10%>Fecha emisión</th>
          <th width=7%>Nro. Factura</th>
          <th>CUF</th>
          <th width=7%>Monto total</th>
          <th width=5%>Imprimir</th>
          <th width=5%>Correo</th>
          <th width=5%>Anular</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($facturas as $key => $value){
          echo '
            <tr>
              <td>Compra venta</td>
              <td>'.($value['fecha_emision']).'</td>
              <td>'.($value['nro_fact']).'</td>
              <td>'.($value['cuf']).'</td>
              <td>'.number_format($value['monto_total'],2,',','.').'</td>';
              if($value['estado_fact']=='E'){
                echo '
                <td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/impresion_factura/'.$value['id_factura'].'/1">Imprimir</button></td>';
                if(!is_null($cliente['correo']) && ($cliente['correo']!=''))
                  echo '<td style="align:center"> <a id="btn_editar" class="button-small pure-button pure-button-primary" target="_blank" href="'.base_url().'fact/gestion_factura/enviar_factura/'.$value['id_factura'].'/1">Enviar</button></td>';
                else echo '<td></td>';
                  echo '<td style="align:center"> <a id="btn_eliminar" class="button-small pure-button button-error" href="'.base_url().'fact/gestion_factura/anular/'.$value['id_factura'].'/1">Anular</button></td>
                </tr>';
              }elseif($value['estado_fact']=='A'){
                echo '<td colspan=3 style="text-align:center">ANULADO</td>';
              }else
                echo '<td colspan=3 style="text-align:center">PENDIENTE</td>';
        }// fin foreach
        ?>
      </tbody>
    </table><!-- FIN COMPRA VENTA-->

  </div>

<script>
</script>
