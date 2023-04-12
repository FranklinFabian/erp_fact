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
              <h4>Cambiar Empresa y/o Gestión</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-12 col-md-offset-2 col-md-5">
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <h4 class="text-center">Empresa</h4>
                    <select class="form-control" name="" id="empresa_id" style="width: 100%;">
                      <?php foreach ($empresas as $le) : ?>
                        <option value="<?php echo $le->id; ?>"><?php echo str_pad($le->id, 2, '0', STR_PAD_LEFT) . ' ' . $le->nombre; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-2">
                <div class="panel panel-primary">
                  <div class="panel-body">
                    <h4 class="text-center">Gestión</h4>
                    <select class="form-control" name="" id="empresa_gestion_id" style="width: 100%;">
                      <!-- dinámico -->
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 text-center">
                <button type="button" class="btn btn-primary btn-sm" id="btnCambiarEmpresaGestion"><i class="fa fa-check m-r-5"></i>Seleccionar</button>
                <button type="button" class="btn btn-warning btn-sm" id="btnEditarEmpresa"><i class="fa fa-pencil" aria-hidden="true"></i> Editar Empresa</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
<!-- Admin Home end -->

<!-- Editar datos empresa -->
<div class="modal fade" id="modalEditarEmpresa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="form_editar_empresa">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar Datos Empresa</h4>
          <h4 class="modal-title" id="nombre_empresa"></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <label for="nombre">Nombre</label>
              <input class="form-control" type="text" placeholder="Nombre de la empresa" id="nombre" required>
            </div>
            <div class="col-md-4">
              <label for="telefono">Telefono</label>
              <input class="form-control" type="text" placeholder="Número telefonico de la empresa" id="telefono" required>
            </div>
          </div>
          <div class="row mt-10">
            <div class="col-md-8">
              <label for="direccion">Dirección</label>
              <input type="text" class="form-control" placeholder="Dirección de la empresa" id="direccion" required>
            </div>
            <div class="col-md-4">
              <label for="ciudad">Ciudad</label>
              <input class="form-control" type="text" placeholder="Ciudad de la empresa" id="ciudad" required>
            </div>
          </div>
          <div class="row mt-10">
            <div class="col-md-6">
              <label for="nit">NIT</label>
              <input class="form-control" type="text" placeholder="NIT de la empresa" id="nit">
            </div>
            <div class="col-md-6">
              <label for="nro_patronal">No. Patronal</label>
              <input class="form-control" type="text" placeholder="N° aporte patronal de la empresa" id="nro_patronal">
            </div>
            <input type="text" id="empresa_id_editar" hidden>
          </div>
          <br />
          <div class="row">
            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Actualizar</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const empresas = <?php echo json_encode($empresas) ?>;
  const gestiones = <?php echo json_encode($gestiones) ?>;

  $('#empresa_id').on('change', function() {
    const empresa_id = $('#empresa_id').val();
    const gestiones_empresa = gestiones.filter(lg => lg.empresa_id == empresa_id);
    const gestiones_html = gestiones_empresa.map(g => `<option value="${g.id}">${g.gestion}</option>`);
    $('#empresa_gestion_id').empty().append(gestiones_html).trigger('change');
  }).change();
  $('#btnCambiarEmpresaGestion').on('click', function() {
    const empresa_id = $('#empresa_id').val();
    const empresa_gestion_id = $('#empresa_gestion_id').val();

    if (empresa_id == null) {
      return time_alert('error', 'Error!', 'Debe seleccionar una empresa.');
    }
    if (empresa_gestion_id == null) {
      return time_alert('error', 'Error!', 'Debe seleccionar una gestión.');
    }

    swloading.start();
    $.ajax({
      type: "POST",
      url: BASE_URL + 'cofi/administracion/actualizar_empresa_gestion',
      data: { empresa_gestion_id },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        time_alert('success', 'Cambio exitoso!', `Se cambió a: <b>${response.message}.</b>`, 2500)
          .then(() => window.location.reload());
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  });
  $('#btnEditarEmpresa').on('click', function() {
    const empresa_id = $('#empresa_id').val();
    const empresa = empresas.find(e => e.id == empresa_id);

    if (!empresa) {
      return time_alert('error', 'Error!', 'Debe seleccionar una empresa.');
    }

    $('#empresa_id_editar').val(empresa_id);
    $('#nombre').val(empresa.nombre);
    $('#telefono').val(empresa.telefono);
    $('#direccion').val(empresa.direccion);
    $('#ciudad').val(empresa.ciudad);
    $('#nit').val(empresa.nit);
    $('#nro_patronal').val(empresa.numero_patronal);
    $('#nombre_empresa').text(empresa.nombre);
    $('#modalEditarEmpresa').modal('show');
  });
  $('#form_editar_empresa').submit(function(e) {
    e.preventDefault();
    const empresa_id = $('#empresa_id_editar').val();
    const data_empresa = {
      ciudad: $('#ciudad').val(),
      direccion: $('#direccion').val(),
      nit: $('#nit').val(),
      numero_patronal: $('#nro_patronal').val(),
      nombre: $('#nombre').val(),
      telefono: $('#telefono').val(),
    }

    msg_confirmation('warning', '¿Está seguro?', 'Va a actualizar los datos de la empresa seleccionada.')
      .then(res => {
        if (res) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/administracion/actualizar_empresa',
            data: {
              empresa_id,
              data_empresa
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Actualizado!', 'Los datos se actualizaron correctamente.', 2500)
                .then(() => window.location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      })
  });
</script>
