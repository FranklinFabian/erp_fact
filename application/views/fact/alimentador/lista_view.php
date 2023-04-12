<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Atención al consumidor</small>
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
              <h4>Alimentadores</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/alimentador/nuevo" class="btn btn-primary">Nuevo Alimentador</a>
                <a href="<?php echo base_url();?>fact/propiedad/" class="btn btn-primary">Volver Atrás</a>
               
              </div>
              
            </div>
<p></p>
<div class="content">
    
    <table id="tabla_alimentadores" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Cód. alimentador</th>
          <th>Sub estación</th>
          <th>KVA alimentador</th>
          <th>KV alimentador</th>
          <th>Consumo MT 1</th>
          <th>Consumo MT 2</th>
          <th>Consumo BT 1</th>
          <th>Consumo BT 2</th>
          <th>Cód. Localidades</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($alimentadores as $key => $value){
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['cod_alimentador']).'</td>
              <td>'.($value['subestacion']).'</td>
              <td>'.($value['kva_alimentador']).'</td>
              <td>'.($value['kv_alimentador']).'</td>
              <td>'.($value['consum_mt_1']).'</td>
              <td>'.($value['consum_mt_2']).'</td>
              <td>'.($value['consum_bt_1']).'</td>
              <td>'.($value['consum_bt_2']).'</td>
              <td>'.($value['cod_localidades']).'</td>
              <td> <a id="btn_editar" class="btn btn-purple btn-xs" href="'.base_url().'fact/alimentador/editar/'.$value['idalimentador'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="btn btn-purple btn-xs" href="javascript:eliminar('.$value['idalimentador'].')">Eliminar</button></td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function eliminar(id){
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>fact/alimentador/eliminar/"+id;
}
</script>
