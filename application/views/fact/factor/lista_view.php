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
              <h4>Factores</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/factor/nuevo" class="btn btn-primary">Nuevo Factor</a>
                <a href="<?php echo base_url();?>fact/facturacion/" class="btn btn-primary">Volver Atrás</a>
              </div>
              
            </div>
<p></p>
<div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong>Factores</strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
                            <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                    <thead>
                      <th class="text-center">Factor</th>
                      <th class="text-center">Periodo</th>
                      <th class="text-center">Re20</th>
                      <th class="text-center">Re100</th>
                      <th class="text-center">ReAde</th>
                      <th class="text-center">Ge20</th>
                      <th class="text-center">Ge100</th>
                      <th class="text-center">GeAde</th>
                      <th class="text-center">I150</th>
                      <th class="text-center">I1Ade</th>
                      <th class="text-center">I2Ade</th>
                      <th class="text-center">I2Dem</th>
                      <th class="text-center">Ta Ade</th>
                      <th class="text-center">Ba 020</th>
                      <th class="text-center">Ba 100</th>
                      <th class="text-center">Ba Ade</th>
                      <th class="text-center">Sc 020</th>
                      <th class="text-center">Sc 100</th>
                      <th class="text-center">Sc Ade</th>
                      <th class="text-center">Aseo</th>
                      <th class="text-center">Alumbrado</th>
                      <th class="text-center">Dignidad</th>
                      <th class="text-center">Ley 1886</th>
                      <th class="text-center">Tv_ts</th>
                      <th class="text-center">Tv_tp</th>
                      <th class="text-center">Tv_c1</th>
                      <th class="text-center">Tv_c1_adi</th>
                      <th class="text-center">Tv_c2</th>
                      <th class="text-center">Tv_c2_adi</th>
                      <th class="text-center">Tv_c3</th>
                      <th class="text-center">Tv_c3_adi</th>
                      <th class="text-center">Usuario</th>

                      <th class="text-center">Editar</th>
                      <th class="text-center">Eliminar</th>


                    </thead>
                    <tbody>
                      <?php 
                      
                      foreach ($factores as $key => $value){
                        $periodo = $this->periodos_model->get_periodo($value['idperiodo']); 
                        echo '
                        <tr>
              <td style="vertical-align: middle;">'.($value['idfactor']).'</td>
              <td style="vertical-align: middle;">'.($periodo['emision']).'</td>
              <td style="vertical-align: middle;">'.number_format($value['re_020'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['re_100'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['re_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ge_020'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ge_100'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ge_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['i1_050'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['i1_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['i2_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['i2_dem'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ta_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ba_020'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ba_100'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ba_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['sc_020'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['sc_100'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['sc_ade'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['aseo'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['alumbrado'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['dignidad'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['ley1886'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_ts'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_tp'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c1'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c1_adi'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c2'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c2_adi'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c3'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.number_format($value['tv_c3_adi'],2,',','.').'</td>
              <td style="vertical-align: middle;">'.$value['usuario'].'</td>

              <td style="vertical-align: middle;"> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'fact/factor/editar/'.$value['idfactor'].'">Editar</button></td>
              <td style="vertical-align: middle;"> <a id="btn_eliminar" class="button-small pure-button button-error" href="javascript:eliminar('.$value['idfactor'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>fact/factor/eliminar/"+id;
}
</script>
