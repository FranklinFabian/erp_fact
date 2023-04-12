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
              <h4>Controles</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
              
                <a href="<?php echo base_url();?>fact/facturacion/" class="btn btn-primary">Volver Atrás</a>
                </div>
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
              <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>fact/control/actualizar/<?php echo $control['idcontrol']?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
                        
          <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="control">Control:</label>
                <input id="control" name="control" type="text" placeholder="Ej. Mi control" value="<?php echo $control['control']?>"required>
              </div>            
            </div>
            </p>
          </div>

          <div class="pure-g">
          <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Actualizar:</label>
                <button type="submit" class="pure-button button-success">Actualizar</button>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div></p>
          </div>

        </fieldset>
      </form>
    </div>