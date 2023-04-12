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
              <h4>Registro Cliente Nuevo</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
              <a href="<?php echo base_url();?>fact/cliente/" class="btn btn-primary">Volver Atras</a>
 
              </div>
              
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
          <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="razon_social">Razón Social:</label>
                <input id="razon_social" name="razon_social" type="text" placeholder="Ej. Paraiso LTDA" required autofocus>
              </div>
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="email">Email:</label>
                <input id="correo" name="correo" type="email" placeholder="Ej. juan_perez@gmail.com">
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="direccion">Dirección:</label>
                <input id="direccion" name="direccion" type="text" placeholder="Ej. Calle a esq. b" required>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nacimiento">Fecha de nacimiento:</label>
                <input id="nacimiento" name="nacimiento" type="date" placeholder="" required>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="telefono">Télefono:</label>
                <input id="telefono" name="telefono" type="text" placeholder="76112345 22212345" required>
              </div>
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ci">CI:</label>
                <input id="ci" name="ci" type="text" placeholder="Ej. 3123456" required>
              </div>
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cex">CEX:</label>
                <input id="cex" name="cex" type="text" placeholder="Ej. j-312345-6">
              </div>
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="pas">PASAPORTE:</label>
                <input id="pas" name="pas" type="text" placeholder="Ej. ZAB0000676">
              </div>
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="od">OTRO:</label>
                <input id="od" name="od" type="text" placeholder="Ej. K-21000022-1-1">
              </div>
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nit">NIT:</label>
                <input id="nit" name="nit" type="number" placeholder="Ej. 1234567015">
              </div>
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tipo_doc_fact">DOC. PARA FACTURA:</label>
                <?php
                  foreach ($tipos_doc_iden as $key => $value)
                    $data_tipo_doc[$value['codigo_clasificador']] = $value['descripcion'];
                  echo form_dropdown('tipo_doc_fact', $data_tipo_doc);
                ?>
              </div>
            </div></p>

          </div>

          <p><div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Crear nuevo:</label>
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
      
      var url = BASE_URL+"fact/cliente/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        { 
          if(data=='ok')
            location.href=BASE_URL+"fact/cliente";
          else
            alert('Ocurrio un error, vuelva a intentarlo.');
        }
      });
    }//fin if
  return false;
});
</script>
