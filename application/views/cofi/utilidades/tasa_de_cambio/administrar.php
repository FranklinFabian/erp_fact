<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Utilidades') ?></small>
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
              <h4>Tasas de Cambio</h4>
              <?php echo MONTH_NAMES[$month] . ' ' . $year; ?>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12 text-center">
                <button class="btn btn-success" id="btn_importar_datos"><i class="fa fa-file-excel-o"></i> Importar Datos</button>
                <a href="<?= base_url('cofi/utilidades/tasa_de_cambio') ?>" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Regresar</a>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-md-8 col-md-offset-2">
                <table id="tablaTasasDeCambio" class="table table-striped table-bordered table-main">
                  <thead>
                    <tr>
                      <th>Nro.</th>
                      <th>Fecha</th>
                      <th>TC BS/US$</th>
                      <th>TC BS/UFV</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for ($i = 1; $i <= $numero_dias_mes; $i++) :
                        $fechaGen = date('Y-m-d', strtotime($year . '-' . $month . '-' . $i));
                        $fechaMostrar = date('d/m/Y', strtotime($year . '-' . $month . '-' . $i));
                        $tasa_index = array_search($fechaGen,  array_column($tasas_cambio, 'fecha'));
                    ?>
                        <tr>
                          <td class="center"><?php echo $i; ?></td>
                          <td class="center"><?php echo $fechaMostrar; ?></td>
                          <td class="center"><?php echo $tasa_index === FALSE ? 's/d':$tasas_cambio[$tasa_index]->tcBsUS; ?></td>
                          <td class="center"><?php echo $tasa_index === FALSE ? 's/d':$tasas_cambio[$tasa_index]->tcBsUFV; ?></td>
                          <td class="center">
                            <?php if($tasa_index === FALSE): ?>
                              <button onclick="registrar_valor('<?php echo $fechaGen; ?>');" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Registrar</button>
                            <?php else: ?>
                              <button onclick="actualizar_valor('<?php echo $tasas_cambio[$tasa_index]->tcBsUS; ?> ','<?php echo $tasas_cambio[$tasa_index]->tcBsUFV; ?> ', '<?php echo $fechaGen; ?>')" class="btn btn-primary btn-sm"> <i class="fa fa-pencil"></i> Editar</button>
                            <?php endif;?>
                          </td>
                        </tr>
                    <?php
                      endfor;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<!-- MODAL IMPORTAR DATOS -->
<div class="modal fade" id="modalImportarDatos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title" id="myModalLabel">Importar Tasas de Cambio <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></h4>
        <a target="_blank" href="<?= base_url()?>uploads/tasas_cambio/formato_tasas_de_cambio_cofi.xlsx">Descargar modelo</a>
      </div>
      <div class="modal-body">
        <form action="#" id="form_subir_leer_datos">
          <div class="row">
            <div class="col-md-9">
              <label for="importar_datos_archivo">Seleccione el archivo</label>
              <input type="text" id="importar_datos_direccion_archivo" hidden>
              <input type="file" name="importar_datos_archivo" id="importar_datos_archivo" class="form-control" accept=".xls,.xlsx" required>
            </div>
            <div class="col-md-3">
              <label for="">&nbsp;</label>
              <button class="btn btn-info btn-block"><i class="fa fa-file-text-o"></i> Leer archivo</button>
            </div>
          </div>
          <br>
        </form>
        <div id="data_importar_archivo">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-striped table-small" id="tabla_data_importar_archivo">
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Bs -> US$</th>
                    <th>Bs -> UFV</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- dinamico -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" id="btn_importar_datos_to_db"><i class="fa fa-check"></i> Importar Datos</button>
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  async function registrar_valor(fecha) {
    const fecha_mostrar = convertYmdTodmY(fecha);
    const { value: valorUS } = await Swal.fire({
      title: 'Ingrese el TC BS/US$ del ' + fecha_mostrar,
      text: 'El separador decimal es el punto "."',
      input: 'text',
      inputPlaceholder: "Ingrese TC BS/US$",
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Siguiente',
      cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      inputValidator: (value) => {
        value = parseFloat(value);
        if (!value) {
          return 'Debes ingresar un valor num\351rico!';
        }
      }
    })
    if (!valorUS) {
      return;
    }

    const {
      value: valorUFV
    } = await Swal.fire({
      title: 'Ingrese el TC BS/UFV del ' + fecha_mostrar,
      text: 'El separador decimal es el punto "."',
      input: 'text',
      inputPlaceholder: "Ingrese TC BS/UFV",
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Registrar',
      cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      inputValidator: (value) => {
        value = parseFloat(value);
        if (!value) {
          return 'Debes ingresar un valor num\351rico!';
        }
      }
    })
    if (valorUS && valorUFV) {
      var valUS = parseFloat(valorUS).toFixed(6);
      var valUFV = parseFloat(valorUFV).toFixed(6);
      Swal.fire({
        title: 'Est\341 seguro?',
        html: "TC BS/US$ = " + valUS + " y <br>TC BS/UFV = " + valUFV,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Si, Registrar',
        cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      }).then((result) => {
        if (result.value) {
          const data = {
            fecha: fecha,
            tcBsUS: valUS,
            tcBsUFV: valUFV,
          };

          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/utilidades/registrar_tasa_de_cambio',
            data: { data },
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Registrado!', 'Los valores de Tasa de Cambio fueron registrados correctamente.', 2000)
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
  }
  async function actualizar_valor(tcBUS, tcBUFV, fecha) {
    const fecha_mostrar = convertYmdTodmY(fecha);
    const { value: valorBSUS } = await Swal.fire({
      title: 'Actualizando Tasa de Cambio ( BS/US$ ) del ' + fecha_mostrar,
      text: 'El separador decimal es el punto "."',
      input: 'text',
      inputValue: tcBUS.trim(),
      inputPlaceholder: "Ingrese Tasa de Cambio BS/US$",
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Siguiente',
      cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      inputValidator: (value) => {
        value = parseFloat(value);
        if (!value) {
          return 'Debes ingresar un valor num\351rico!';
        }
      }
    })
    if (!valorBSUS) {
      return;
    }
    const {
      value: valorBSUFV
    } = await Swal.fire({
      title: 'Actualizando Tasa de Cambio ( BS/UFV ) del ' + fecha_mostrar,
      text: 'El separador decimal es el punto "."',
      input: 'text',
      inputValue: tcBUFV.trim(),
      inputPlaceholder: "Ingrese Tasa de Cambio BS/US$",
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Actualizar',
      cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      inputValidator: (value) => {
        value = parseFloat(value);
        if (!value) {
          return 'Debes ingresar un valor num\351rico!';
        }
      }
    })
    if (valorBSUS && valorBSUFV) {
      var valUS = parseFloat(valorBSUS).toFixed(6);
      var valUFV = parseFloat(valorBSUFV).toFixed(6);
      Swal.fire({
        title: 'Est\341 seguro?',
        html: "TC BS/US$ = " + valUS + " y <br>TC BS/UFV = " + valUFV,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Si, Actualizar',
        cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      }).then((result) => {
        if (result.value) {
          const data = {
            tcBsUS: valUS,
            tcBsUFV: valUFV,
          };
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/utilidades/actualizar_tasa_de_cambio/' + fecha,
            data: { data },
            success: function(data) {
              swloading.stop();
              time_alert('success', 'Actualizado!', 'Los valores de Tasa de Cambio fueron actualizados correctamente.', 2000)
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
  }

  $('#btn_importar_datos').on('click', function () {
    $('#modalImportarDatos').modal('show');
    $('#data_importar_archivo').hide();
  });
  $('#form_subir_leer_datos').submit(async function (e) {
    e.preventDefault();
    const nombre_archivo  = ('<?php echo MONTH_NAMES[$month] . '_' . $year ?>').toLowerCase();
    const formData        = new FormData();
    const files           = $('#importar_datos_archivo')[0].files[0];
    formData.append('file', files);

    swloading.start();
    const res = await $.ajax({
      url: BASE_URL + 'cofi/utilidades/subir_leer_datos_archivo_tasa_cambio/' + nombre_archivo,
      type: 'post',
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        swloading.stop();
        return response;
      }
    });
    if(res.estado == 0) {
      time_alert('error', 'Error al subir el archivo.', 'No se pudo subir el archivo.', 1500)
      return;
    }
    const mes_anio = '<?= $month.'/'.$year ?>';
    const data = res.data;
    let data_tabla = '';
    $('#tabla_data_importar_archivo tbody').empty();
    data.forEach((item) => {
      data_tabla +=`
        <tr>
          <td>${item.dia}/${mes_anio}</td>
          <td>${item.bs_us}</td>
          <td>${item.bs_ufv}</td>
          <td>
            <button class="btn btn-danger btn-xs eliminar_fila" title="Eliminar registro"><i class="fa fa-times"></i></button>
          </td>
        </tr>
      `;
    });
    $('#tabla_data_importar_archivo tbody').append(data_tabla);
    $('#data_importar_archivo').show();
    $('#tabla_data_importar_archivo').on('click', '.eliminar_fila', function() {
      $(this).parents('tr').detach();
    });
  });
  $('#btn_importar_datos_to_db').on('click', function () {
    let data_importar = [];
    // Verificar que haya por lo menos un dato en la tabla
    $('#tabla_data_importar_archivo > tbody tr').each(function() {
      const data_tasa_cambio = {
        fecha: $(this).find('td').eq(0).text().split('/').reverse().join('-'),
        tcBsUS: $(this).find('td').eq(1).text(),
        tcBsUFV: $(this).find('td').eq(2).text(),
      }
      data_importar.push(data_tasa_cambio);
    });
    if(data_importar.length == 0) {
      time_alert('error', 'No hay datos!', 'No hay datos para importar.', 2000)
      return;
    }
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.<br>(Si existen datos registrados estos serán actualizados)')
    .then((res) => {
      if(res) {
        swloading.start();
        $.ajax({
          type: "post",
          url: BASE_URL + 'cofi/utilidades/importar_datos_tasas_cambio',
          data: {data_importar},
          dataType: "json",
          success: function (response) {
            swloading.stop();
            time_alert('success', 'Datos importados!', 'Los datos se importaron correctamente', 3000)
            .then(() => window.location.reload())
          },
          error: function(error) {
            swloading.stop();
            ok_alert_error(error);
          }
        });
      }
    })
  });

  $(document).ready(function() {
    $('#tablaTasasDeCambio').DataTable(DATA_TABLE);
  });
</script>
