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
              <h4>Postes</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/poste/nuevo" class="btn btn-primary">Nuevo Poste</a>
                <a href="<?php echo base_url();?>fact/propiedad/" class="btn btn-primary">Volver Atrás</a>
                
              </div>
              
            </div>
<p></p>
<div class="content">
   
    <table id="tabla_postes" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Poste</th>
          <th>Distancia</th>
          <th>Unidad</th>
          <th>Centro</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($postes as $key => $value){
          $centro = $this->centros_model->get_centro($value['idcentro']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['poste']).'</td>
              <td>'.($value['distancia']).'</td>
              <td>'.($value['unidades']).'</td>
              <td>'.($centro['centro']).'</td>
              <td> <a id="btn_editar" class="btn btn-purple btn-xs" href="'.base_url().'fact/poste/editar/'.$value['idposte'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="btn btn-purple btn-xs" href="javascript:eliminar('.$value['idposte'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>fact/poste/eliminar/"+id;
}
</script>
