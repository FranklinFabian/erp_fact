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
                            <h4><strong><?php echo "Ítems"; ?></strong></h4>
                        </div>
                    </div> <!-- Header End -->
                    <!-- Body -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" id="btn_nuevo_item" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nuevo Ítem</button>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="tabla_items" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                                        <thead>
                                            <th class="text-center">Ítem</th>
                                            <th class="text-center">Cargo</th>
                                            <th class="text-center">Básico</th>
                                            <th class="text-center">Sección</th>
                                            <th class="text-center">Servicio</th>
                                            <th class="text-center">Acciones</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_items as $di): ?>
                                                <tr>
                                                    <td style="vertical-align: middle;"><?php echo $di->id; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $di->cargo; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $di->basico; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $di->descripcion; # seccion ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $di->nombre_servicio;?></td>
                                                    <td style="vertical-align: middle;">
                                                        <button class="btn btn-primary btn-xs" onclick="editarItem('<?php echo $di->id; ?>')" title="Editar Registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
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
        <!-- Modal Registrar Nuevo Item -->
        <div class="modal fade fs-12" id="modal_nuevo_item" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="titulo_form_item"></span> Ítem
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </button>
                            <input type="hidden" id="item_id_to_update">
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_registrar_actualizar_item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="seccion">Sección</label>
                                    <select name="seccion" id="seccion" class="form-control" style="width:100%;" required>
                                        <?php foreach($data_secciones as $ds): ?>
                                            <option value="<?php echo $ds->id ?>"><?php echo $ds->descripcion; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <label class="mt-10" for="cargo">Ítem</label>
                                    <p class="form-control" id="nro_item"></p>

                                    <label class="mt-10" for="cargo">Cargo</label>
                                    <input type="text" name="cargo" id="cargo" class="form-control" required>

                                    <label class="mt-10" for="basico">Básico</label>
                                    <input type="text" name="basico" id="basico" class="form-control flotante2decimales" required>
                                </div>
                            </div>
                            <div class="mt-10 text-center">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_item"></span></button>
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
    const data_items    = <?php echo json_encode($data_items); ?>;
    let ultimo_item     = 0;
    if(data_items.length > 0)
        ultimo_item   = data_items[data_items.length - 1].id;
    const nombres_db    = ['cargo', 'basico', 'seccion'];

    /* Registrar Nuevo Empleado */
    $('#btn_nuevo_item').on('click', function () {
        // Reiniciar form
        $('#seccion').val('-1').change(); // .change() -> select2
        $('#cargo').val('');
        $('#basico').val('');
        $('#item_id_to_update').val('');
        $('.titulo_form_item').text('Registrar Nuevo');
        $('.btn_form_item').text('Registrar');
        $('#nro_item').text(parseInt(ultimo_item)+1);
        $('#modal_nuevo_item').modal('show');
    });
    /* Verificacion flotante con 2 decimales */
    $('.flotante2decimales').on('keyup change', function () {
        var regex = /^\d+(\.\d{0,2})?$/g;
        if(!regex.test(this.value)) this.value = this.value.substring(0, this.value.length-1);
    });
    /* Registrar o Actualizar Item */
    $('#form_registrar_actualizar_item').submit(function (e) {
        e.preventDefault();
        const data_form     = $('#form_registrar_actualizar_item').serializeArray();
        let data_form_send  = {};
        data_form.forEach((item) => {
            data_form_send[item.name] = item.value;
        });
        // Validar si es Registro o Actualización
        const option = $('.btn_form_item').text();
        let msj_option = '', url_option = '', id_item, msj_alerta = '';
        if(option == 'Registrar') { // Registrar
            msj_option = 'Se registrará un nuevo ítem.';
            url_option = '<?php echo base_url('rrhh/items/registrar'); ?>';
            id_item = 0;
            msj_alerta = 'Registrado';
        } else { // Actualizar
            msj_option = 'Se actualizará los datos del ítem.';
            url_option = '<?php echo base_url('rrhh/items/actualizar'); ?>';
            id_item = $('#item_id_to_update').val();
            msj_alerta = 'Actualizado';
        }
        msg_confirmation('warning', '¿Está seguro?', msj_option)
        .then((response) => {
            if(response) {
                swloading.start();
                $.ajax({
                    type: "post",
                    url: url_option,
                    data: {data_form: data_form_send, id_item: id_item},
                    dataType: "json",
                    success: function (response) {
                        swloading.stop();
                        time_alert('success', `${msj_alerta}!`, `El ítem fué ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
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
    function editarItem(id_item) {
        $('#item_id_to_update').val(id_item);
        $('.titulo_form_item').text('Editar');
        $('.btn_form_item').text('Actualizar');
        $('#nro_item').text(id_item);
        const item = data_items.find((item) => item.id === id_item);
        nombres_db.forEach((nom)=> {
            $('#'+nom).val(item[nom]).change(); // .change() -> select2
        });
        $('#modal_nuevo_item').modal('show');
    }
    $(document).ready(function () {
        $('#tabla_items').DataTable(DATA_TABLE);
    });
    </script>