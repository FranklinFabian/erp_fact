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
            <h1>Gesti&oacute;n de Cortes Programados</h1>
            <small>Ver/Modificar Corte Programado</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Cortes Programados</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        // seteando la hora actual
        date_default_timezone_set('America/La_Paz');
        //var_dump($get_nummedidor);
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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> VER/EDITAR CORTE PROGRAMADO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_cortes"><i class="ti-align-justify"> </i> VER LISTA DE CORTES PROGRAMADOS</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Caracter&iacute;sticas</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="nro_programado" class="col-sm-2 col-form-label">Nro. Programado :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="nro_programado" id="nro_programado" type="text" value="<?= ($data[0]['NRO_PROGRAMADO']); ?>" min="0" tabindex="3" readonly="">
                                        </div>
                                        <label for="cod_alimentador" class="col-sm-2 col-form-label">C&oacute;digo Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_alimentador" id="cod_alimentador" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_ALIMENTADOR']); ?>"><?= ($data[0]['COD_ALIMENTADOR']); ?></option>
                                                <?php foreach ($get_codalimentador as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_ALIMENTADOR'] ?>"><?php echo $list['COD_ALIMENTADOR'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_proteccion" id="cod_proteccion" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_PROTECCION']); ?>"><?= ($data[0]['COD_PROTECCION']); ?></option>
                                                <?php foreach ($get_proteccion as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_PROTECCION'] ?>"><?php echo $list['COD_PROTECCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_inicial" class="col-sm-2 col-form-label">Fecha y Hora Inicial <i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_inicial" id="fecha_inicial" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_INI'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_inicial" id="hora_inicial" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_INI'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <label for="fecha_final" class="col-sm-2 col-form-label">Fecha y Hora Final <i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_final" id="fecha_final" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_FIN'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_final" id="hora_final" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_FIN'])); ?>"  required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="origen_interrupcion" class="col-sm-2 col-form-label">Origen de la Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="origen_interrupcion" id="origen_interrupcion" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_ORIGEN']); ?>"><?= ($data[0]['DESCRIPCION_ORIGEN']); ?></option>
                                                <?php foreach ($get_origen as $key => $list) { ?>
                                                    <option value="<?php echo $list['ORIGEN'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="" class="col-sm-2 col-form-label"> :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="cod_tipo_origen" id="cod_tipo_origen" tabindex="5" aria-required="true" required="">
                                                 <option value="<?= ($data[0]['ORIGEN_TIPO']); ?>"><?= ($data[0]['DESCRIPCION_ORIGEN_TIPO']); ?> (<?= ($data[0]['ORIGEN_TIPO']); ?>)</option>();
                                                <?php foreach ($get_tipo_origen_all as $key => $list) { ?>
                                                    <option value="<?php echo $list['ORIGEN_TIPO'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="causa_interrupcion" class="col-sm-2 col-form-label">Causa de la Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="causa_interrupcion" id="causa_interrupcion" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_CAUSA']); ?>"><?= ($data[0]['DESCRIPCION_CAUSA']); ?></option>
                                                <?php foreach ($get_causa as $key => $list) { ?>
                                                    <option value="<?php echo $list['CAUSA'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="" class="col-sm-2 col-form-label"> :</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="cod_tipo_causa" id="cod_tipo_causa" tabindex="5" aria-required="true" required="">
                                                 <option value="<?= ($data[0]['CAUSA_TIPO']); ?>"><?= ($data[0]['DESCRIPCION_CAUSA_TIPO']); ?> (<?= ($data[0]['CAUSA_TIPO']); ?>)</option>();
                                                <?php foreach ($get_tipo_causa_all as $key => $list) { ?>
                                                    <option value="<?php echo $list['CAUSA_TIPO'] ?>"><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="potencia_interrumpida" class="col-sm-2 col-form-label">Potencia Interrumpida (Kva) :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="potencia_interrumpida" id="potencia_interrumpida" type="number" value="<?= ($data[0]['KVA_INTERRUMP']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_afectados" class="col-sm-2 col-form-label">Consumidores Afectados :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consumidores_afectados" id="consumidores_afectados" type="number" value="<?= ($data[0]['CONSUM_AFECTADOS']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cod_zona" class="col-sm-2 col-form-label">C&oacute;digo Zona :<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="cod_zona" id="cod_zona" readonly="" ><?= ($data[0]['COD_ZONAS']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="trabajo" class="col-sm-2 col-form-label">Trabajos a Realizarse :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="trabajo" id="trabajo" rows="3" tabindex="4"><?= ($data[0]['TRABAJO']); ?></textarea>
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
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Guardar Centro de Transformacion" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
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
<script type="text/javascript">
   
//Registrar Datos en la Base de Datos
function GuardarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
    if(!campoVacio($("select[name='cod_alimentador']")) || !campoVacio($("select[name='cod_proteccion']")) || !campoVacio($("#fecha_inicial")) || !campoVacio($("#hora_inicial")) || !campoVacio($("#fecha_final")) || !campoVacio($("#hora_final"))|| !campoVacio($("select[name='origen_interrupcion']")) || !campoVacio($("select[name='cod_tipo_origen']")) || !campoVacio($("select[name='causa_interrupcion']")) || !campoVacio($("select[name='cod_tipo_causa']")) || !campoVacio($('#consumidores_afectados')))
    correcto = false;
      if(correcto==true){
        var nro_programado_id = '<?= ($data[0]['NRO_PROGRAMADO']); ?>';
        var cod_alimentador = $("select[name='cod_alimentador']").val();
        var cod_proteccion = $("select[name='cod_proteccion']").val();
        var fecha_inicial = $("#fecha_inicial").val() +' ' + $("#hora_inicial").val();
        var fecha_final = $("#fecha_final").val() +' ' + $("#hora_final").val();
        var origen_interrupcion = $("select[name='origen_interrupcion']").val();
        var cod_tipo_origen = $("select[name='cod_tipo_origen']").val();
        var causa_interrupcion = $("select[name='causa_interrupcion']").val();
        var cod_tipo_causa = $("select[name='cod_tipo_causa']").val();
        var potencia_interrumpida = $("#potencia_interrumpida").val();
        var consumidores_afectados = $("#consumidores_afectados").val();
        var cod_zonas = $("#cod_zona").val();
        var trabajo = $("#trabajo").val();
        var tiempo_interrupcion = CalcularTiempo(fecha_inicial, fecha_final);

        console.log(cod_alimentador+' - '+ cod_proteccion+' - '+fecha_inicial+' - '+fecha_final+' - '+origen_interrupcion+' - '+cod_tipo_origen+' - '+causa_interrupcion+' - '+cod_tipo_causa+' - '+potencia_interrumpida+' - '+consumidores_afectados+' - '+tiempo_interrupcion +' - '+cod_zonas +' - '+trabajo);

        // Add record
        $.ajax({
            data: {cod_alimentador,cod_proteccion,fecha_inicial,fecha_final,origen_interrupcion,cod_tipo_origen,causa_interrupcion,cod_tipo_causa,tiempo_interrupcion,potencia_interrumpida,consumidores_afectados,cod_zonas,trabajo, nro_programado_id},
            url: '<?php echo base_url(); ?>odeco/modificar_corte',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se modific&oacute; exitosamente el Corte Programado'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_cortes";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al modificar el Corte Programado'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_cortes";
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
        var tiempo_interrupcion = parseFloat(diferencia +'.'+aux).toFixed(2);
        return tiempo_interrupcion;
    }
 
</script>