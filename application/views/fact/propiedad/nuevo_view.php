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
              <h4>Nueva Propiedad</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/propiedad/lista" class="btn btn-primary">Volver Atrás</a>
                
              </div>
              
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
  
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
          <p> <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo">Código:</label>
                <input id="codigo" name="codigo" type="text" placeholder="Ej. T-2121" autofocus required>
              </div>            
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="propiedad">Propiedad:</label>
                <input id="propiedad" name="propiedad" type="text" placeholder="Ej. Mi propiedad" required>
              </div>            
            </div></p>

          </div>

          <div class="pure-g">
          <p> <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div></p>
          </div>

        </fieldset>
      </form>
    </div>
<script>

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"fact/propiedad/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"fact/propiedad/lista";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
