
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Facturacion y Cobranzas</small>
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
              <h4>Venta de Material</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/venta" class="btn btn-primary">Nueva Venta</a>
                

              </div>
            </div>
<p></p><!-- Quitar nivel 2 -->
<div class="content">
    
    
    <h2 class="content-head is-center">PROFORMA</h2>
<p></p>
    
<div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong>Orden De Venta</strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
                            <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                    <thead>
                      <th class="text-center">Nro.</th>
                      <th class="text-center">Id Proforma</th>
                      <th class="text-center">Articulo</th>
                      <th class="text-center">Cantidad</th>
                      <th class="text-center">Precio Untario</th>
                      <th class="text-center">Total</th>
                      </thead>
                    <tbody>
                      <?php 
                      $i=1;
                      $precio_total=0;
                      foreach ($almacen_proforma_items as $key => $value){ 
                       $precio_total=$precio_total+$value['total'];
                        echo '
                        <tr>
                          <td style="vertical-align: middle;">'.$i++.'</td>
                          <td style="vertical-align: middle;">'.($value['id_proforma']).'</td>
                          <td style="vertical-align: middle;">'.($value['nombre']).'</td>
                          <td style="vertical-align: middle;">'.($value['cantidad']).'</td>
                          <td style="vertical-align: middle;">'.number_format($value['costo'], 2, ',', '.').'</td>
                          <td style="vertical-align: middle;">'.number_format($value['total'], 2, ',', '.').'</td>
                          </tr>
                        ';
                      } 
                      echo '<tr><td colspan=5 style="text-align:center; font-weight:bold; color:#000;">TOTAL A COBRAR:</td><td style="text-align:center; font-weight:bold; color:#000;">'.number_format(($precio_total), 2, ',', '.').'</td></tr>'  
                      ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <p>
            <table width="100%" style="border: hidden; margin:0; padding:0">
                <tr>                    
                                      
                <td>
                        <label for="tipo_emision">TIPO DE EMISIÓN:</label><br>
                        <select name="tipo_emision" id="tipo_emision">
                            <option value="1">EN LINEA</option>
                            <option value="2">FUERA DE LINEA</option>
                        </select>

                    </td>

                    <td width="10%"><button id="btn_confirmar_orden" onclick="confirmar_orden(total);" class="pure-button button-success">Cobrar</button></td>
                    <td width="10%"><div class="pure-controls">
                            <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div></td>
                </tr>
            </table>
                    </p>
          </div> <!-- Body End -->
        </div>
      </div>
    </div>



<script>




</script>