<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo module_name() ?></h1>
            <small><?php echo details_module('Ítems') ?></small>
            <?php echo $this->breadcrumb->render() ?>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Alert Message -->
        <?php $message = $this->session->userdata('message');
        if (isset($message)){ ?>
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
                            <h4><strong><?php echo "Secciones"; ?></strong></h4>
                        </div>
                    </div> <!-- Header End -->
                    <!-- Body -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" id="btn_nueva_seccion" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nueva Sección</button>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="tabla_secciones" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                                        <thead>
                                            <th class="text-center">Sección</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Servicio</th>
                                            <th class="text-center">Acciones</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_secciones as $ds): ?>
                                                <tr>
                                                    <td style="vertical-align: middle;"><?php echo $ds->id; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $ds->descripcion; # seccion ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $ds->nombre_servicio;?></td>
                                                    <td style="vertical-align: middle;">
                                                        <button class="btn btn-primary btn-xs" onclick="editarSeccion('<?php echo $ds->id; ?>')" title="Editar Registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Body End -->
                </div>
            </div>
        </div>
        <!-- Modal Registrar Nueva Sección -->
        <div class="modal fade fs-12" id="modal_nueva_actualizar_seccion" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="titulo_form_seccion"></span> Sección
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </button>
                            <input type="hidden" id="seccion_id_to_update">
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_registrar_actualizar_seccion">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Sección</label>
                                    <p class="form-control" id="nro_seccion"></p>

                                    <label class="mt-10" for="descripcion">Descripción Sección</label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>

                                    <label class="mt-10" for="servicio">Servicio</label>
                                    <select name="servicio" id="servicio" class="form-control" style="width:100%;" required>
                                        <?php foreach($data_servicios as $ds): ?>
                                            <option value="<?= $ds->Id_Servicio; ?>"><?= $ds->Servicio; ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
    </section> <!-- /.content -->

</div> <!-- /.content-wrapper -->

<script type="text/javascript">
    const data_secciones    = <?php echo json_encode($data_secciones); ?>;
    let ultima_seccion      = 0;
    if(data_secciones.length > 0)
        ultima_seccion = data_secciones[data_secciones.length - 1].id;
    const nombres_db        = ['descripcion', 'servicio']; // para select2

    /* Registrar Nueva Sección */
    $('#btn_nueva_seccion').on('click', function () {
        // Reiniciar form
        $('#servicio').val('1').change(); // .change() -> select2
        $('#descripcion').val('');
        $('#seccion_id_to_update').val('');
        $('.titulo_form_seccion').text('Registrar Nueva');
        $('.btn_form_seccion').text('Registrar');
        $('#nro_seccion').text(parseInt(ultima_seccion)+1);
        $('#modal_nueva_actualizar_seccion').modal('show');
    });
    /* Verificacion flotante con 2 decimales */
    $('.flotante2decimales').on('keyup change', function () {
        var regex = /^\d+(\.\d{0,2})?$/g;
        if(!regex.test(this.value)) this.value = this.value.substring(0, this.value.length-1);
    });
    /* Registrar o Actualizar Item */
    $('#form_registrar_actualizar_seccion').submit(function (e) {
        e.preventDefault();
        const data_form     = $('#form_registrar_actualizar_seccion').serializeArray();
        let data_form_send  = {};
        data_form.forEach((item) => {
            data_form_send[item.name] = item.value;
        });
        // Validar si es Registro o Actualización
        const option = $('.btn_form_seccion').text();
        let msj_option = '', url_option = '', id_seccion, msj_alerta = '';
        if(option == 'Registrar') { // Registrar
            msj_option = 'Se registrará una nueva sección.';
            url_option = '<?php echo base_url('rrhh/secciones/registrar'); ?>';
            id_seccion = 0;
            msj_alerta = 'Registrada';
        } else { // Actualizar
            msj_option = 'Se actualizará los datos de la sección.';
            url_option = '<?php echo base_url('rrhh/secciones/actualizar'); ?>';
            id_seccion = $('#seccion_id_to_update').val();
            msj_alerta = 'Actualizada';
        }
        msg_confirmation('warning', '¿Está seguro?', msj_option)
        .then((response) => {
            if(response) {
                swloading.start();
                $.ajax({
                    type: "post",
                    url: url_option,
                    data: {data_form: data_form_send, id_seccion: id_seccion},
                    dataType: "json",
                    success: function (response) {
                        swloading.stop();
                        time_alert('success', `${msj_alerta}!`, `La Sección fué ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
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
    function editarSeccion(id_seccion) {
        $('#seccion_id_to_update').val(id_seccion);
        $('.titulo_form_seccion').text('Editar');
        $('.btn_form_seccion').text('Actualizar');
        $('#nro_seccion').text(id_seccion);
        const seccion = data_secciones.find((secc) => secc.id === id_seccion);
        nombres_db.forEach((nom)=> {
            $('#'+nom).val(seccion[nom]).change(); // .change() -> select2
        });
        $('#modal_nueva_actualizar_seccion').modal('show');
    }
    $(document).ready(function () {
        $('#tabla_secciones').DataTable(DATA_TABLE);
    });
    </script>