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
              <h4>Propiedad</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/propiedad/nuevo" class="btn btn-primary">Nueva Propiedad</a>
                <a href="<?php echo base_url();?>fact/propiedad/" class="btn btn-primary">Volver Atrás</a>
                
              </div>
              
            </div>
<p></p>
<div class="content">
   
    <table id="tabla_propiedades" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Código</th>
          <th>Propiedad</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($propiedades as $key => $value){
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['codigo']).'</td>
              <td>'.($value['propiedad']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'fact/propiedad/editar/'.$value['idpropiedad'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="button-small pure-button button-error" href="javascript:eliminar('.$value['idpropiedad'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>fact/propiedad/eliminar/"+id;
}
</script>
