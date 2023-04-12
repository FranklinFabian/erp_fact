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
              <h4>informacion Abonados</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
              
              <p><a href="<?php echo base_url();?>fact/abonado/lista" class="btn btn-primary">Abonados</a>
               <a href="<?php echo base_url();?>fact/categorias/lista" class="btn btn-primary">Categorias</a>
               <a href="<?php echo base_url();?>fact/cosnumidor/lista" class="btn btn-primary">Consumidores</a>
               <a href="<?php echo base_url();?>fact/cliente/" class="btn btn-primary">Clientes</a>
               <a href="<?php echo base_url();?>fact/estado/lista" class="btn btn-primary">Estados</a>
               </p>
               <p>
               <a href="<?php echo base_url();?>fact/liberacion/lista" class="btn btn-primary">Liberaciones</a>
               <a href="<?php echo base_url();?>fact/medicion/lista" class="btn btn-primary">Mediciones</a>
               <a href="<?php echo base_url();?>fact/requisito/lista" class="btn btn-primary">Requisitos</a>
               <a href="<?php echo base_url();?>fact/servicio/lista" class="btn btn-primary">Servicios</a>
               <a href="<?php echo base_url();?>fact/suministro/lista" class="btn btn-primary">Suministros</a>
  </p>
              </div>
              
            </div>

