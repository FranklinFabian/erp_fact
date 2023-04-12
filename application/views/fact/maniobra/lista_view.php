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
              <h4>Elementos de Maniobra</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/maniobra/nuevo" class="btn btn-primary">Nuevo Elemento de Maniobra</a>
                <a href="<?php echo base_url();?>fact/propiedad/" class="btn btn-primary">Volver Atrás</a>
                
              </div>
              
            </div>
<p></p>
<div class="content">
    
    <table id="tabla_maniobras" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Tipo protección</th>
          <th>Estado</th>
          <th>KVA protección</th>
          <th>KV protección</th>
          <th>Consumo MT 1</th>
          <th>Consumo MT 2</th>
          <th>Consumo BT 1</th>
          <th>Consumo BT 2</th>
          <th>Protección Sup.</th>
          <th>Dirección</th>
          <th>Alimentador</th>
          <th>Zona</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($maniobras as $key => $value){
          $alimentador = $this->alimentadores_model->get_alimentador($value['idalimentador']);
          $zona = $this->zonas_model->get_zona($value['idzona']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['tipo_proteccion']).'</td>
              <td>'.($value['estado']).'</td>
              <td>'.($value['kva_proteccion']).'</td>
              <td>'.($value['kv_proteccion']).'</td>
              <td>'.($value['consum_mt_1']).'</td>
              <td>'.($value['consum_mt_2']).'</td>
              <td>'.($value['consum_bt_1']).'</td>
              <td>'.($value['consum_bt_2']).'</td>
              <td>'.($value['proteccion_sup']).'</td>
              <td>'.($value['direccion']).'</td>
              <td>'.($alimentador['cod_alimentador'].'-'.$alimentador['subestacion']).'</td>
              <td>'.($zona['zona']).'</td>
              <td> <a id="btn_editar" class="btn btn-purple btn-xs" href="'.base_url().'fact/maniobra/editar/'.$value['idmaniobra'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="btn btn-purple btn-xs" href="javascript:eliminar('.$value['idmaniobra'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>fact/maniobra/eliminar/"+id;
}
</script>
