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
            <h4>Periodos</h4>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <a href="<?php echo base_url();?>fact/lectura" class="btn btn-primary">Seleccionar Circuito</a>
              <a href="<?php echo base_url();?>fact/periodo/lista" class="btn btn-primary">Ver Periodo</a>
              <a href="<?php echo base_url();?>fact/periodo/nuevo" class="btn btn-primary">Nuevo Periodo</a>
            </div>
            
          </div>
<p></p>
  <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong>Periodos</strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
                            <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                    <thead>
                    <th class="text-center">Id periodo</th>
          <th class="text-center">Emisión</th>
          <th class="text-center">Activado</th>
          <th class="text-center">Vencimiento</th>
          <th class="text-center">Próxima medición</th>
          <th class="text-center">Estatus</th>
          <th class="text-center">fecstatus</th>
          <th class="text-center">Editar</th>
          <th class="text-center">Eliminar</th> 
                    </thead>
                    <tbody>
                      <?php 
                      
                      foreach ($periodos as $key => $value){
                        
                        echo '
                        <tr>
              
              <td style="vertical-align: middle;">'.($value['idperiodo']).'</td>
              <td style="vertical-align: middle;">'.($value['emision']).'</td>
              <td style="vertical-align: middle;">'.($value['idproceso']).'</td>
              <td style="vertical-align: middle;">'.($value['vencimiento']).'</td>
              <td style="vertical-align: middle;">'.($value['semision']).'</td>
              <td style="vertical-align: middle;">'.($value['estatus']).'</td>
              <td style="vertical-align: middle;">'.($value['fecstatus']).'</td>
              <td style="vertical-align: middle;"> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'fact/periodo/editar/'.$value['idperiodo'].'">Editar</button></td>
              <td style="vertical-align: middle;"> <a id="btn_eliminar" class="button-small pure-button button-error" href="javascript:eliminar('.$value['idperiodo'].')">Eliminar</button></td>
            </tr>
                        ';
                      } 
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> <!-- Body End -->
        </div>
      </div>
    </div>

<script>
function eliminar(id){
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>fact/periodo/eliminar/"+id;
}
</script>
