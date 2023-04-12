<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Administración') ?></small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

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
              <h4>Adicionar Empresa</h4>
            </div>
          </div>
          <div class="panel-body">
            <form action="#" id="formulario">
              <div class="row">
                <div class="col-12 col-md-8">
                  <div class="panel panel-primary">
                    <div class="panel-body text-center">
                      <h4>Datos de la empresa</h4>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-8">
                          <label for="nombre">Nombre</label>
                          <input class="form-control" type="text" placeholder="Nombre de la empresa" id="nombre" minlength="3" required>
                        </div>
                        <div class="col-md-4">
                          <label for="telefono">Telefono</label>
                          <input class="form-control" type="text" placeholder="Número telefonico de la empresa" id="telefono">
                        </div>
                      </div>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-8">
                          <label for="direccion">Dirección</label>
                          <input type="text" class="form-control" placeholder="Dirección de la empresa" id="direccion">
                        </div>
                        <div class="col-md-4">
                          <label for="ciudad">Ciudad</label>
                          <input class="form-control" type="text" placeholder="Ciudad de la empresa" id="ciudad">
                        </div>
                      </div>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                          <label for="nit">NIT</label>
                          <input class="form-control" type="text" placeholder="NIT de la empresa" id="nit">
                        </div>
                        <div class="col-md-6">
                          <label for="numero_patronal">No. Patronal</label>
                          <input class="form-control" type="text" placeholder="N° aporte patronal de la empresa" id="numero_patronal">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="panel panel-primary">
                    <div class="panel-body">
                      <h4 class="text-center">Año y Periodo</h4>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                          <label for="gestion">Año</label>
                          <input class="form-control" type="number" value="<?php echo date('Y'); ?>" placeholder="Ingrese gestión de inicio..." id="gestion" step="1" min="2000" max="2100" required>
                        </div>
                      </div>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-md-12">
                          <label for="periodo_tipo_id">Periodo</label>
                          <select class="form-control dont-select-me" name="periodo_tipo_id" id="periodo_tipo_id" required>
                            <?php foreach ($periodos_tipos as $pt) : ?>
                              <option value="<?php echo $pt->id; ?>"><?php echo $pt->inicio . ' - ' . $pt->fin; ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-12 text-right">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Registrar</button>
                  <a href="<?php echo base_url('cofi/administracion'); ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Cancelar</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
<!-- Admin Home end -->

<script>
  const alerta = Boolean('<?php echo $alerta ?>');

  $('#formulario').submit(function (e) {
    e.preventDefault();
    const empresa = {
      nombre: $('#nombre').val().toUpperCase(),
      telefono: $('#telefono').val(),
      direccion: $('#direccion').val(),
      ciudad: $('#ciudad').val(),
      nit: $('#nit').val(),
      numero_patronal: $('#numero_patronal').val(),
      periodo_tipo_id: $('#periodo_tipo_id').val(),
    }
    const gestion = $('#gestion').val();

    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/administracion/registrar_empresa',
            data: { empresa, gestion },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              if (response.status) {
                return time_alert('success', 'Registrado!', 'La Empresa fué registrada correctamente.', 2500)
                  .then(() => window.location = BASE_URL + 'cofi/administracion');
              }
              ok_alert_error();
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });

  $(document).ready(function() {
    if (alerta) {
      ok_alert('warning', 'Debe registrar un empresa.', 'No hay empresas registradas.');
    }
  });
</script>
