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
                <a href="<?php echo base_url();?>fact/venta/envio_fuera_linea" class="btn btn-primary">Finalizar Fuera de Linea</a>
                   
              </div>
            </div>
<p></p>

<div class="content">
<h2 class="content-head is-center">Venta</h2>
    <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-4"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>venta" id="btn_nuevo" class="pure-button button-secondary" style="width: 100%">Nueva venta</a></p></div>
        <div class="pure-u-1 pure-u-md-1-4"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>venta/lista_ventas/<?php echo date('Y-m-d');?>" id="btn_nuevo" class="pure-button button-secondary" style="width: 100%">Ventas del día</a></p></div>      
    </div>
  <br>
  <hr>

  <div style="text-align:center">
    <h2 class="content-head is-center">ERROR VENTA CRÉDITO</h2>
      <p>
        A ocurrido un ERROR CLIENTE, vuelva a intentarlo.<br>
        Probablemente el cliente no se encuentre registrado en su base de datos de CLIENTES.
      </p>

  </div>
</div>
