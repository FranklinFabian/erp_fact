
<style type="text/css">
    .nav-tabs > li.active > a {
      background-color: #3B8104 !important;
      color: #fff !important;
      border-radius: 4;
    }
    .nav-tabs > li> a {
      background-color: #1C93C7 !important;
      color: #fff !important;
      border-radius: 4;
    }
     .error-input{
        border: thin solid #d9534f;
    }
</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <div class="header-title">
                <h1>Gesti&oacute;n de Interrupciones</h1>
                <small>Agregar Interrupciones</small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#"><?php echo display('odeco') ?></a></li>
                    <li class="active">Interrupciones</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        // seteando la hora actual
        date_default_timezone_set('America/La_Paz');
        ?>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo $title; ?> </h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR REGISTRO NUEVO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_interrupciones"><i class="ti-align-justify"> </i> VER LISTA DE INTERRUPCIONES</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Formulario de Nuevo Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="nro_programado" class="col-sm-2 col-form-label">Nro. Programado :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="nro_programado" id="nro_programado" type="text" value="<?php echo $get_id_interrupciones; ?>" min="0" tabindex="3" readonly="">
                                        </div>
                                        <label for="nro_diario" class="col-sm-2 col-form-label">Nro. Diario :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nro_diario" id="nro_diario" tabindex="5">
                                                <option value="">Seleccionar</option>
                                                <option value="No Corresponde">No Corresponde</option>
                                                <?php foreach ($libros as $key => $list) { ?>
                                                    <option value="<?php echo $list['NRO_DIARIO'] ?>"><?php echo $list['NRO_DIARIO'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="corte_programado" class="col-sm-2 col-form-label">Corte Programado :</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="corte_programado" id="corte_programado" tabindex="5">
                                                <option value="">Seleccionar</option>
                                                <option value="No Corresponde">No Corresponde</option>
                                                <?php foreach ($cortes as $key => $list) { ?>
                                                    <option value="<?php echo $list['NRO_PROGRAMADO'] ?>"><?php echo $list['NRO_PROGRAMADO'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_falla" class="col-sm-2 col-form-label">Tipo de Falla :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                        <select class="form-control" name="tipo_falla" id="tipo_falla" tabindex="5" aria-required="true">
                                                <option value="">Seleccionar</option>
                                                <option value="Monofasico">Monofasico</option>
                                                <option value="Bifasico">Bifasico</option>
                                                <option value="Trifasico">Trifasico</option>
                                            </select>
                                        </div>
                                        <label for="cod_alimentador" class="col-sm-2 col-form-label">C&oacute;digo Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_alimentador" id="cod_alimentador" tabindex="5" aria-required="true" required="">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_codalimentador as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_ALIMENTADOR'] ?>"><?php echo $list['COD_ALIMENTADOR'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_proteccion" id="cod_proteccion" tabindex="5" aria-required="true" required="">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_proteccion as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_PROTECCION'] ?>"><?php echo $list['COD_PROTECCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_inicial" class="col-sm-2 col-form-label">Fecha y Hora Inicial :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_inicial" id="fecha_inicial" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_inicial" id="hora_inicial" type="time" value="<?php echo date('H:i') ?>"   required="" tabindex="1">
                                        </div>
                                        <label for="fecha_final" class="col-sm-2 col-form-label">Fecha y Hora Final :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_final" id="fecha_final" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_final" id="hora_final" type="time" value="<?php echo date('H:i') ?>"   required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="origen_interrupcion" class="col-sm-2 col-form-label">Origen de la Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="origen_interrupcion" id="origen_interrupcion" tabindex="5" aria-required="true" required="" onchange="get_tipoorigen();">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_origen as $key => $list) { ?>
                                                    <option value="<?php echo $list['ORIGEN'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="" class="col-sm-2 col-form-label"> :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="cod_tipo_origen" id="cod_tipo_origen" tabindex="5" aria-required="true" required="">
                                                <!-- <option value="">Seleccionar</option>();
                                                <?php foreach ($get_codzona as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Zona'] ?>"><?php echo $list['Zona'] ?></option>
                                                <?php } ?>-->
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="causa_interrupcion" class="col-sm-2 col-form-label">Causa de la Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="causa_interrupcion" id="causa_interrupcion" tabindex="5" aria-required="true" required="" onchange="get_tipocausa();">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_causa as $key => $list) { ?>
                                                    <option value="<?php echo $list['CAUSA'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="" class="col-sm-2 col-form-label"> :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="cod_tipo_causa" id="cod_tipo_causa" tabindex="5" aria-required="true" required="">
                                                <!-- <option value="">Seleccionar</option>();
                                                <?php foreach ($get_codzona as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Zona'] ?>"><?php echo $list['Zona'] ?></option>
                                                <?php } ?>-->
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="consumidores_bt_1" class="col-sm-2 col-form-label">Consumidores BT Calidad-1 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_bt_1" id="consumidores_bt_1" type="number" placeholder="Consumidores BT 1" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_bt_2" class="col-sm-2 col-form-label">Consumidores BT Calidad-2 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_bt_2" id="consumidores_bt_2" type="number" placeholder="Consumidores BT 2" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consumidores_mt_1" class="col-sm-2 col-form-label">Consumidores MT Calidad-1 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_mt_1" id="consumidores_mt_1" type="number" placeholder="Consumidores MT 1" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_mt_2" class="col-sm-2 col-form-label">Consumidores MT Calidad-2 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_mt_2" id="consumidores_mt_2" type="number" placeholder="Consumidores MT 2" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="potencia_bt_1" class="col-sm-2 col-form-label">Potencia Interrumpida BT Calidad-1 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_bt_1" id="potencia_bt_1" type="number" placeholder="Potencia Interrumpida BT 1" min="0" tabindex="3">
                                        </div>
                                        <label for="potencia_bt_2" class="col-sm-2 col-form-label">Potencia Interrumpida BT Calidad-2 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_bt_2" id="potencia_bt_2" type="number" placeholder="Potencia Interrumpida BT 2" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="potencia_mt_1" class="col-sm-2 col-form-label">Potencia Interrumpida MT Calidad-1 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_mt_1" id="potencia_mt_1" type="number" placeholder="Potencia Interrumpida MT 1" min="0" tabindex="3">
                                        </div>
                                        <label for="potencia_mt_2" class="col-sm-2 col-form-label">Potencia Interrumpida MT Calidad-2 Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_mt_2" id="potencia_mt_2" type="number" placeholder="Potencia Interrumpida MT 2" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="motivo" class="col-sm-2 col-form-label">Motivo :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="motivo" id="motivo" rows="3" placeholder="Motivo" tabindex="4"></textarea>
                                        </div>
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="Observaci&oacute;n" tabindex="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="button" class="btn btn-default btn-block" value="Cancelar" onclick="window.history.back();" tabindex="7"/>
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Guardar Interrupciones" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
    //traer en base a Seleccion de tipo de causa 
function get_tipoorigen()
{   
    var id_origen = $('select[name="origen_interrupcion"]').val();
    var dropdown = $('#cod_tipo_origen');
    dropdown.empty();
    dropdown.append('<option selected="true" value=""> Seleccionar </option>');
    dropdown.prop('selectedIndex', 0);
    $.ajax({
        data: {id_origen: id_origen},
        url: '<?php echo base_url(); ?>odeco/get_tipo_origen',
        type: 'POST',
        dataType: 'json'
        })
    .done(function(response)
        {
            $.each(response, function(key, datos){
                dropdown.append($('<option></option>').attr('value', datos.ORIGEN_TIPO).text(datos.DESCRIPCION+' ('+datos.ORIGEN_TIPO+')'));
            });
            dropdown.append('</select>');
        })
    .fail(function(response)
        {
            //console.log('Hubo error');

        });
}
//traer en base a Seleccion de tipo de causa
function get_tipocausa()
{   
    var id_causa = $('select[name="causa_interrupcion"]').val();
    var dropdown = $('#cod_tipo_causa');
    dropdown.empty();
    dropdown.append('<option selected="true" value=""> Seleccionar</option>');
    dropdown.prop('selectedIndex', 0);
    $.ajax({
        data: {id_causa: id_causa},
        url: '<?php echo base_url(); ?>odeco/get_tipo_causa',
        type: 'POST',
        dataType: 'json'
        })
    .done(function(response)
        {
            $.each(response, function(key, datos){
                dropdown.append($('<option></option>').attr('value', datos.CAUSA_TIPO).text(datos.DESCRIPCION+' ('+datos.CAUSA_TIPO+')'));
            });
            dropdown.append('</select>');
        })
    .fail(function(response)
        {
            //console.log('Hubo error');
        });
}
//Registrar Datos en la Base de Datos
function GuardarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='nro_diario']")) || !campoVacio($("select[name='tipo_falla']")) || !campoVacio($("select[name='cod_alimentador']")) || !campoVacio($("select[name='cod_proteccion']")) || !campoVacio($("#fecha_inicial")) || !campoVacio($("#hora_inicial")) || !campoVacio($("#fecha_final")) || !campoVacio($("#hora_final")) || !campoVacio($("select[name='origen_interrupcion']"))|| !campoVacio($("select[name='causa_interrupcion']")) || !campoVacio($("select[name='cod_tipo_origen']"))|| !campoVacio($("select[name='cod_tipo_causa']"))|| !campoVacio($("#consumidores_bt_1"))|| !campoVacio($("#consumidores_bt_2"))|| !campoVacio($("#consumidores_mt_1"))|| !campoVacio($("#consumidores_mt_2"))|| !campoVacio($("#potencia_bt_1"))|| !campoVacio($("#potencia_bt_2"))|| !campoVacio($("#potencia_mt_1"))|| !campoVacio($("#potencia_mt_2")))
         correcto = false;
      if(correcto==true){
        var nro_programado = $("#nro_programado").val();
        var nro_diario = $("select[name='nro_diario']").val();
        var corte_programado = $("select[name='corte_programado']").val();
        var tipo_falla = $("select[name='tipo_falla']").val();
        var cod_alimentador = $("select[name='cod_alimentador']").val();
        var cod_proteccion = $("select[name='cod_proteccion']").val();
        var fecha_inicial = $("#fecha_inicial").val() +' ' + $("#hora_inicial").val();
        var fecha_final = $("#fecha_final").val() +' ' + $("#hora_final").val();
        var origen_interrupcion = $("select[name='origen_interrupcion']").val();
        var cod_tipo_origen = $("select[name='cod_tipo_origen']").val();
        var causa_interrupcion = $("select[name='causa_interrupcion']").val();
        var cod_tipo_causa = $("select[name='cod_tipo_causa']").val();
        var consumidores_bt_1 = $("#consumidores_bt_1").val();
        var consumidores_bt_2 = $("#consumidores_bt_2").val();
        var consumidores_mt_1 = $("#consumidores_mt_1").val();
        var consumidores_mt_2 = $("#consumidores_mt_2").val();
        var potencia_bt_1 = $("#potencia_bt_1").val();
        var potencia_bt_2 = $("#potencia_bt_2").val();
        var potencia_mt_1 = $("#potencia_mt_1").val();
        var potencia_mt_2 = $("#potencia_mt_2").val();
        var motivo = $("#motivo").val();
        var observacion = $("#observacion").val();
        var tiempo_interrupcion = CalcularTiempo(fecha_inicial, fecha_final);

        // Add record
        $.ajax({
            data: {nro_programado,nro_diario,corte_programado,tipo_falla,cod_alimentador,cod_proteccion,fecha_inicial,fecha_final,origen_interrupcion,cod_tipo_origen,causa_interrupcion,cod_tipo_causa,tiempo_interrupcion,consumidores_bt_1,consumidores_bt_2,consumidores_mt_1,consumidores_mt_2,potencia_bt_1,potencia_bt_2,potencia_mt_1,potencia_mt_2,motivo,observacion},
            url: '<?php echo base_url(); ?>odeco/registrar_interrupcion',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se registr&oacute; exitosamente el Registro',
                            text: 'El Registro fue designado con el Codigo Nro.'+response
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_interrupciones";
                        });
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al registrar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/agregar_interrupcion";
                        });
            });
    }else{
        Swal.fire({
        icon: 'error',
        title: 'Debe llenar todos los campos requeridos'
        });
    }
}
//validar campos
function campoVacio(obj)
{
    var correcto = true;
        if(obj.val()==''){
            obj.addClass("error-input");
            correcto = false;
        }else{
            obj.removeClass("error-input")
        }
    return correcto;
}

function CalcularTiempo(fecha_inicial, fecha_final){

        var fecha_hora_recepcion1 = moment(fecha_inicial, "YYY-MM-DD HH:mm");
        var fecha_hora_actual1 = moment(fecha_final, "YYY-MM-DD HH:mm");
        var diferencia = fecha_hora_actual1.diff(fecha_hora_recepcion1,'h')//diff en horas
        var minutos = diferencia*60;
        var diferencia1 = fecha_hora_actual1.diff(fecha_hora_recepcion1,'m')-minutos // diferencia minutos
        var aux = diferencia1.toString().padStart(2,'0');
        var porcentaje = Math.round((aux*100)/60);
        var tiempo_interrupcion = parseFloat(diferencia +'.'+porcentaje).toFixed(2);
        return tiempo_interrupcion;
    }
 
</script>