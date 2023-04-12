<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Atención al consumidor</h1>
      <small>Administración</small>
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
              <h4>Administración</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/admin/empresa" class="btn btn-primary">Institución/configuración</a>
                <a href="<?php echo base_url();?>fact/admin/" class="btn btn-primary">Volver Atrás</a>
              </div>
            </div>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<br>
  <div class="content">
    <h2>EDITAR INFORMACIÓN DE LA INSTITUCIÓN</h2>
    <p></p>

    

    <form method="post" class="pure-form pure-form-stacked" id="form_empresa" data-parsley-validate>
      <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
      <div class="pure-g">
      <p> <div class="pure-u-1 pure-u-md-1-4">
          <label for="logo_linea1">Logo línea título:</label>
          <input id="logo_linea1" name="logo_linea1" type="text" value="<?php echo $empresa['logo_linea1'];?>">
        </div></p>
        <p><div class="pure-u-1 pure-u-md-1-4">
          <label for="logo_linea2">Logo línea sub título:</label>
          <input id="logo_linea2" name="logo_linea2" type="text" value="<?php echo $empresa['logo_linea2'];?>">
        </div></p>
        <p> <div class="pure-u-1 pure-u-md-1-4">
          <label for="direccion">Dirección:</label>
          <input id="direccion" name="direccion" type="text" value="<?php echo $empresa['direccion'];?>">
        </div></p>
        <p><div class="pure-u-1 pure-u-md-1-4">
          <label for="telefono">Teléfonos:</label>
          <input id="telefono" name="telefono" type="text" value="<?php echo $empresa['telefono'];?>">
        </div></p>
        <p><div class="pure-u-1 pure-u-md-1-4">
          <label for="whatsapp">Whatsapp:</label>
          <input id="whatsapp" name="whatsapp" type="text" value="<?php echo $empresa['whatsapp'];?>">
        </div></p>
        <p><div class="pure-u-1 pure-u-md-1-4">
          <label for="pie_impresion">Pie impresion:</label>
          <input id="pie_impresion" name="pie_impresion" type="text" value="<?php echo $empresa['pie_impresion'];?>">
        </div></p>


        </div>
        
        <div class="pure-g">
        <p> <div class="pure-u-1 pure-u-md-1-4">
          <label for="pie_impresion">Actualizar:</label>
          <button id="btn_guardar" class="pure-button button-success" type="submit">Actualizar</button>
        </div></p>

        </div>
        
      </div>
      
      
    </form>
  </div>

<script>
$('#form_empresa').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"fact/admin/actualizar_empresa/<?php echo $empresa['id_configuracion'];?>";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_empresa').serialize(),
        success: function(data)
        {
          if(data=='ok'){
            alert("Los datos se actualizaron correctamente.");
            location.href=BASE_URL+"fact/admin/empresa";
          }
          else alert("Ocurrio un error inesperado");
        }
      });
    }//fin if
  return false;
});
</script>
