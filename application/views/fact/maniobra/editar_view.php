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
              <h4>Editar Elementos de Maniobra</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
               <a href="<?php echo base_url();?>fact/maniobra/lista/" class="btn btn-primary">Volver Atrás</a>
                
              </div>
              
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    
    
      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>fact/maniobra/actualizar/<?php echo $maniobra['idmaniobra']?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
                        
          <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="tipo_proteccion">Tipo protección:</label>
                <input id="tipo_proteccion" name="tipo_proteccion" type="text" placeholder="Ej. tipo proteccion" value="<?php echo $maniobra['tipo_proteccion'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="estado">Estado:</label>
                <input id="estado" name="estado" type="text" placeholder="Ej. 1" value="<?php echo $maniobra['estado'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="kva_proteccion">kva protección:</label>
                <input id="kva_proteccion" name="kva_proteccion" type="number" placeholder="Ej. 1" value="<?php echo $maniobra['kva_proteccion'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="kv_proteccion">kv protección:</label>
                <input id="kv_proteccion" name="kv_proteccion" type="number" placeholder="Ej. 1" value="<?php echo $maniobra['kv_proteccion'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_mt_1">Consumo MT 1:</label>
                <input id="consum_mt_1" name="consum_mt_1" type="number" placeholder="Ej. 2" value="<?php echo $maniobra['consum_mt_1'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_mt_2">Consumo MT 2:</label>
                <input id="consum_mt_2" name="consum_mt_2" type="number" placeholder="Ej. 2" value="<?php echo $maniobra['consum_mt_2'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_bt_1">Consumo BT 1:</label>
                <input id="consum_bt_1" name="consum_bt_1" type="number" placeholder="Ej. 3" value="<?php echo $maniobra['consum_bt_1'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_bt_2">Consumo BT 2:</label>
                <input id="consum_bt_2" name="consum_bt_2" type="number" placeholder="Ej. 3" value="<?php echo $maniobra['consum_bt_2'];?>" required>
              </div>            
            </div></p>
          </div>

          <div class="pure-g">
          <p><div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="proteccion_sup">Protección Sup.:</label>
                <input style="width: 60%;" id="proteccion_sup" name="proteccion_sup" type="text" placeholder="Ej. Protección sup." value="<?php echo $maniobra['proteccion_sup'];?>" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="direccion">Dirección:</label>
                <input style="width: 60%;" id="direccion" name="direccion" type="text" placeholder="Ej. Dirección" value="<?php echo $maniobra['direccion'];?>" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="idzona">Zona:</label>
                <?php
                  foreach ($zonas as $key => $value) {
                    $data[$value['idzona']] = $value['zona'];
                  }
                  echo form_dropdown('idzona', $data,$maniobra['idzona']);
                ?>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-control-group">
                <label for="idalimentador">Alimentador:</label>
                <?php
                  foreach ($alimentadores as $key => $value) {
                    $data2[$value['idalimentador']] = $value['cod_alimentador'].' - '.$value['subestacion'];
                  }
                  echo form_dropdown('idalimentador', $data2,$maniobra['idalimentador']);
                ?>
              </div>            
            </div></p>
            
          </div>

          <div class="pure-g">
          <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div></p>
            <p> <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
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
      
      var url = BASE_URL+"fact/maniobra/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"fact/maniobra/lista";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
