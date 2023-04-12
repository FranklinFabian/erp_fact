<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Control') ?></small>
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
    <?php
      $this->session->unset_userdata('error_message');
    } ?>
    <div class="row">
      <div class="col-sm-12">
      </div>
    </div>

    <!--Add Invoice -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong><?php echo "Control"; ?></strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12 text-center">
                <div class="btn-group btn-group-sm">
                  <button type="button" onclick="nuevo_control()" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nuevo Control</button>
                  <!-- <button type="button" class="btn btn-primary btn_" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ver Notas</button> -->
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_controles" class="table table-hover table-bordered table-main">
                    <thead>
                      <th>Sección</th>
                      <th>Descripción</th>
                      <th>Servicio</th>
                      <th>Acciones</th>
                    </thead>
                    <tbody>
                      <?php foreach ($controles as $control) : ?>
                        <tr>
                          <td><?php echo $control->id; ?></td>
                          <td><?php echo $control->control; ?></td>
                          <td><?php echo $control->descripcion; ?></td>
                          <td>
                            <button class="btn btn-primary btn-xs" onclick="editar_control('<?php echo $control->id; ?>')" title="Editar Registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
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
      </div>
    </div>

    <!-- Modal Registrar Control -->
    <div class="modal fade fs-12" id="modal_administrar_control" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="titulo_form_seccion"></span> Control
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_actualizar_control">
              <div class="row">
                <div class="col-sm-12">
                  <label for="c_codigo_control">Código Control</label>
                  <input type="text" name="control" id="c_codigo_control" class="form-control" minlength="2" maxlength="2" required>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <label class="mt-10" for="c_descripcion">Descripción</label>
                  <input type="text" name="descripcion" id="c_descripcion" class="form-control" required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_seccion"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div> <!-- /.content-wrapper -->

<script>
  const controles = <?php echo json_encode($controles); ?>;
  let registro_id = false;

  const nuevo_control = () => {
    registro_id = false;
    $('#form_registrar_actualizar_control')[0].reset();
    $('#c_codigo_control').attr('disabled', false);

    $('.titulo_form_seccion').text('Registrar');
    $('.btn_form_seccion').text('Registrar');
    $('#modal_administrar_control').modal('show');
  }

  const editar_control = (control_id) => {
    registro_id = control_id;

    const control = controles.find(item => item.id === control_id);
    $('#c_codigo_control').val(control.control);
    $('#c_descripcion').val(control.descripcion);

    $('#c_codigo_control').attr('disabled', true);
    $('.titulo_form_seccion').text('Editar');
    $('.btn_form_seccion').text('Actualizar');
    $('#modal_administrar_control').modal('show');
  }

  $('#form_registrar_actualizar_control').submit(function(e) {
    e.preventDefault();
    const form = {
      control: $('#c_codigo_control').val().toUpperCase(),
      descripcion: $('#c_descripcion').val().toUpperCase()
    };

    // Check the control code -> It must be unique
    const verificar = controles.find(element => element.control === form.control);
    if (verificar && !registro_id) {
      return time_alert('error', 'Error código de control.', `El código de control <b>${form.control}</b> ya se encuentra en uso.<br>Ingrese otro, este debe ser único.`);
    }

    msg_confirmation('warning', '¿Está seguro?', registro_id ? 'Va a actualizar los datos del control.' : 'Va a registrar un nuevo control.<br>No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: BASE_URL + 'rrhh/control/' + ( registro_id ? 'actualizar' : 'registrar'),
            data: { form, control_id: registro_id },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Correcto!', `El control fué ${registro_id ? 'actualizado' : 'registrado'} correctamente.`)
                .then(() => location.reload());
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
    $('#tabla_controles').DataTable(DATA_TABLE);
  });
  $('#modal_administrar_control').on('shown.bs.modal', function(e) {
    $('#c_codigo_control').focus();
  })
</script>
