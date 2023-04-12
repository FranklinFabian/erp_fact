<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Plantillas') ?></small>
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
              <h4>Plantillas</h4>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12 text-center">
                <a href="<?php echo base_url('cofi/plantillas/crear') ?>" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Nueva Plantilla</a>
              </div>
            </div>
            <div class="table-responsive" style="margin-top: 10px">
              <table id="tabla_data" class="display table table-bordered table-sm table-hover text-center" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Nro.</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($plantillas as $index => $plantilla) : ?>
                    <tr>
                      <td><?php echo $index + 1; ?></td>
                      <td><?php echo $plantilla->nombre;  ?></td>
                      <td><?php echo $plantilla->descripcion;  ?></td>
                      <td>
                        <button class="btn btn-warning btn-xs" title="Ver plantilla" onclick="ver_plantilla('<?php echo $plantilla->id; ?>')"><i class="fa fa-list"></i></button>
                        <a href="<?php echo base_url('cofi/plantillas/editar/') . $plantilla->id ?>" class="btn btn-primary btn-xs" title="Editar plantilla"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <button class="btn btn-danger btn-xs" title="Eliminar plantilla" onclick="eliminar_plantilla('<?php echo $plantilla->id; ?>')"><i class="fa fa-close" aria-hidden="true"></i></button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<!-- MODAL REGISTRAR CUENTA -->
<div class="modal fade" id="modal_plantilla" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Plantilla: <span id="modal_titulo"></span> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <p><strong>Descripción: </strong><span id="plantilla_descripcion"></span></p>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-small" id="tabla_plantilla">
                <thead>
                  <tr>
                    <th width="40%">Cuenta</th>
                    <th>Tipo</th>
                    <th>Referencia</th>
                    <th>Porcentaje</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- dinámico -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const plantillas = <?php echo json_encode($plantillas); ?>;

  async function ver_plantilla(id) {
    const plantilla = plantillas.find(c => c.id == id);

    $('#modal_titulo').text(plantilla.nombre);
    $('#plantilla_descripcion').text(plantilla.descripcion);

    swloading.start();
    const plantilla_data = await $.ajax({
      type: "GET",
      url: BASE_URL + 'cofi/plantillas/get_plantilla_data_by_plantilla_id/' + id,
      dataType: "json",
      success: function (response) {
        swloading.stop();
        return response;
      },
      error: function (error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });

    const html = plantilla_data.map(pd => `
      <tr>
        <td>${pd.cuenta_codigo_formato} | ${pd.cuenta_nombre}</td>
        <td>${pd.tipo}</td>
        <td>${pd.referencia}</td>
        <td>${pd.porcentaje} %</td>
      </tr>
    `);
    $('#tabla_plantilla tbody').append(html);

    $('#modal_plantilla').modal('show');
  }

  function eliminar_plantilla(id) {
    const plantilla = plantillas.find(c => c.id == id);

    msg_confirmation('warning', '¿Está seguro?', `Va a eliminar la plantilla <b>${plantilla.nombre}</b><br>No podrá revertir los cambios.`)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/plantillas/eliminar/' + id,
            data: {
              id
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'Plantilla eliminada correctamente.', 2500)
                .then(() => window.location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  }

  $(document).ready(function() {
    $('#tabla_data').DataTable(DATA_TABLE);
  });
</script>
