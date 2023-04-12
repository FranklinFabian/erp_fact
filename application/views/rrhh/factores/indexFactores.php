<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo module_name() ?></h1>
            <small><?php echo details_module('Factores') ?></small>
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
                            <h4><strong><?php echo "Factores"; ?></strong></h4>
                        </div>
                    </div> <!-- Header End -->
                    <!-- Body -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" id="btn_nuevo_mes" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nuevo Mes</button>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="tabla_factores" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nro.</th>
                                                <th class="text-center">Mes</th>
                                                <th class="text-center">Rc Iva</th>
                                                <th class="text-center">Sueldo Minimo</th>
                                                <th class="text-center">Cot Actual</th>
                                                <th class="text-center">Cot Anterior</th>
                                                <th class="text-center">Bono Frontera</th>
                                                <th class="text-center">Afp Individual</th>
                                                <th class="text-center">Afp Riesgo</th>
                                                <th class="text-center">Afp Comision</th>
                                                <th class="text-center">Pat Afp</th>
                                                <th class="text-center">Pat Ans</th>
                                                <th class="text-center">Pat Fonvis</th>
                                                <th class="text-center">Club</th>
                                                <th class="text-center">Sol Laboral</th>
                                                <th class="text-center">Sol Patronal</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Refrigerio</th>
                                                <th class="text-center">Fallas Caja</th>
                                                <th class="text-center">Fallas Caja Central</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_meses as $index=>$dm): ?>
                                                <tr>
                                                    <td style="vertical-align: middle;"><?php echo ($index+1); ?></td>
                                                    <td style="vertical-align: middle;"><?php echo date('d/m/Y', strtotime($dm->mes)); ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->rc_iva; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->sueldo_minimo; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->cot_actual; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->cot_anterior; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->bono_frontera; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->afp_individual; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->afp_riesgo; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->afp_comision; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->pat_afp; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->pat_cns; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->pat_fonvis; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->club; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->sol_laboral; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->sol_patronal; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo ($dm->estado == 1)?'<span class="label label-success">Activo</span>':'<span class="label label-danger">Inactivo</span>'; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->refrigerio; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->fallas_caja; ?></td>
                                                    <td style="vertical-align: middle;"><?php echo $dm->fallas_caja_central; ?></td>
                                                    <td style="vertical-align: middle;">
                                                        <?php if($dm->estado == 1): ?>
                                                        <button class="btn btn-primary btn-xs" onclick="editarMes('<?php echo $dm->mes; ?>')" title="Editar Registro"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                        <?php endif; ?>
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
        <div class="modal fade fs-12" id="modal_nuevo_actualizar_mes" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="titulo_form_seccion"></span> Mes
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </button>
                            <input type="hidden" id="mes_to_update">
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="form_registrar_actualizar_seccion">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="dm_mes">mes</label>
                                    <input type="text" name="mes" id="dm_mes" class="form-control" required disabled>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_rc_iva">rc_iva</label>
                                    <input type="text" name="rc_iva" id="dm_rc_iva" class="form-control flotantes2decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_sueldo_minimo">sueldo_minimo</label>
                                    <input type="text" name="sueldo_minimo" id="dm_sueldo_minimo" class="form-control flotantes2decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_cot_actual">cot_actual</label>
                                    <input type="text" name="cot_actual" id="dm_cot_actual" class="form-control flotantes6decimales" required>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3">
                                    <label for="dm_cot_anterior">cot_anterior</label>
                                    <input type="text" name="cot_anterior" id="dm_cot_anterior" class="form-control flotantes6decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_bono_frontera">bono_frontera</label>
                                    <input type="text" name="bono_frontera" id="dm_bono_frontera" class="form-control flotantes2decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_afp_individual">afp_individual</label>
                                    <input type="text" name="afp_individual" id="dm_afp_individual" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_afp_riesgo">afp_riesgo</label>
                                    <input type="text" name="afp_riesgo" id="dm_afp_riesgo" class="form-control flotantes4decimales" required>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3">
                                    <label for="dm_afp_comision">afp_comision</label>
                                    <input type="text" name="afp_comision" id="dm_afp_comision" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_pat_afp">pat_afp</label>
                                    <input type="text" name="pat_afp" id="dm_pat_afp" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_pat_cns">pat_cns</label>
                                    <input type="text" name="pat_cns" id="dm_pat_cns" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_pat_fonvis">pat_fonvis</label>
                                    <input type="text" name="pat_fonvis" id="dm_pat_fonvis" class="form-control flotantes4decimales" required>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3">
                                    <label for="dm_club">club</label>
                                    <input type="text" name="club" id="dm_club" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_sol_laboral">sol_laboral</label>
                                    <input type="text" name="sol_laboral" id="dm_sol_laboral" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_sol_patronal">sol_patronal</label>
                                    <input type="text" name="sol_patronal" id="dm_sol_patronal" class="form-control flotantes4decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_refrigerio">refrigerio</label>
                                    <input type="text" name="refrigerio" id="dm_refrigerio" class="form-control flotantes2decimales" required>
                                </div>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3">
                                    <label for="dm_fallas_caja">fallas_caja</label>
                                    <input type="text" name="fallas_caja" id="dm_fallas_caja" class="form-control flotantes2decimales" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="dm_fallas_caja_central">fallas_caja_central</label>
                                    <input type="text" name="fallas_caja_central" id="dm_fallas_caja_central" class="form-control flotantes2decimales" required>
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
    /* Menu collapse */
    window.onload = function () {
        $('body').addClass("sidebar-mini sidebar-collapse");
    }
    const data_meses        = <?php echo json_encode($data_meses); ?>;
    const nombres_db        = ['mes', 'rc_iva', 'sueldo_minimo', 'cot_actual', 'cot_anterior', 'bono_frontera', 'afp_individual', 'afp_riesgo', 'afp_comision', 'pat_afp', 'pat_cns', 'pat_fonvis', 'club', 'sol_laboral', 'sol_patronal', 'refrigerio', 'fallas_caja', 'fallas_caja_central'];

    /* Registrar Nuevo Mes */
    $('#btn_nuevo_mes').on('click', function () {
        // Llenar form con los datos del ultimo mes
        const data_ultimo_mes = data_meses[0];
        nombres_db.forEach((nom)=> {
            $('#dm_'+nom).val(data_ultimo_mes[nom]);
        });
        // Fecha habilitada para crear
        const umr       = data_meses[0].mes; // ultimo_mes_registrado
        let anio_reg  = umr.split('-')[0];
        let mes_reg   = umr.split('-')[1];
        if(parseInt(mes_reg) == 12) {
            mes_reg = 1;
            anio_reg = parseInt(anio_reg)+1;
        } else {
            mes_reg = parseInt(mes_reg)+1;
        }
        const dias_reg = new Date(anio_reg, mes_reg, 0).getDate();
        // console.log(anio_reg, mes_reg, dias_reg)
        $('#dm_mes').val(`${dias_reg}/${mes_reg}/${anio_reg}`);
        // Parametros Form
        $('.titulo_form_seccion').text('Registrar Nuevo');
        $('.btn_form_seccion').text('Registrar');
        $('#modal_nuevo_actualizar_mes').modal('show');
    });
    /* Registrar o Actualizar Item */
    $('#form_registrar_actualizar_seccion').submit(function (e) { 
        e.preventDefault();
        const data_form     = $('#form_registrar_actualizar_seccion').serializeArray();
        let data_form_send  = {};
        data_form.forEach((item) => {
            data_form_send[item.name] = item.value;
        });
        data_form_send['mes'] = $('#dm_mes').val().split('/').reverse().join('-');
        // Validar si es Registro o Actualización
        const option = $('.btn_form_seccion').text();
        let msj_option = '', url_option = '', id_seccion, msj_alerta = '';
        if(option == 'Registrar') { // Registrar
            msj_option      = 'No podrá revertir los cambios.';
            url_option      = '<?php echo base_url('rrhh/factores/registrar'); ?>';
            id_mes          = 0;
            msj_alerta      = 'Registrado';
            mes_desactivar  = data_meses[0].mes;
        } else { // Actualizar
            msj_option      = 'Se actualizará los datos del mes.';
            url_option      = '<?php echo base_url('rrhh/factores/actualizar'); ?>';
            id_mes          = $('#mes_to_update').val();
            msj_alerta      = 'Actualizado';
            mes_desactivar  = 0;
        }
        msg_confirmation('warning', '¿Está seguro?', msj_option)
            .then((response) => {
                if(response) {
                    swloading.start();
                    $.ajax({
                        type: "post",
                        url: url_option,
                        data: {data_form: data_form_send, mes: id_mes, mes_de: mes_desactivar},
                        dataType: "json",
                        success: function (response) {
                            swloading.stop();
                            time_alert('success', `${msj_alerta}!`, `El mes fué ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
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
    function editarMes(mes) {
        // Data Update Modal
        const mes_edit = data_meses.find((m) => m.mes === mes);
        nombres_db.forEach((nom)=> {
            $('#dm_'+nom).val(mes_edit[nom]);
        });
        $('#dm_mes').val(mes.split('-').reverse().join('/'));
        // Parametros Modal
        $('#mes_to_update').val(mes);
        $('.titulo_form_seccion').text('Editar');
        $('.btn_form_seccion').text('Actualizar');
        $('#modal_nuevo_actualizar_mes').modal('show');
    }
    $(document).ready(function () {
        $('#tabla_factores').DataTable(DATA_TABLE);
    });
    </script>