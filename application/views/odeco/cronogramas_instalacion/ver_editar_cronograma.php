
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
                <h1>Formulario Edicion - Cronograma de Instalacion de Equipos</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#">Odeco</a></li>
                    <li class="active">Cronograma de Instalacion de Equipos</li>
                </ol>
            </div>
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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> EDITAR CRONOGRAMA</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_cronogramas"><i class="ti-align-justify"> </i> VER LISTA DE CRONOGRAMA DE INSTALACION DE EQUIPOS</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Caracter&iacute;sticas</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="codigo_ae" class="col-sm-2 col-form-label">Codigo AE: </label>
                                        <div class="col-sm-3">
                                            <input class="form-control" name ="codigo_ae" id="codigo_ae" type="text" value="<?= ($data[0]['CODIGO_AE']); ?>" min="0" tabindex="3" readonly>
                                        </div>
                                        <label for="nro_id" class="col-sm-2 col-form-label">Nro. ID (Nro.Cuenta BT): </label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="nro_id" id="nro_id" tabindex="5">
                                                <option value="<?= ($data[0]['NRO_ID']); ?>" selected=""><?= ($data[0]['NRO_ID']); ?></option>
                                                <?php foreach ($get_IdAbonado as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Abonado'] ?>"><?php echo $list['Id_Abonado'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="fecha_instalacion" class="col-sm-2 col-form-label">Fecha y Hora Instalacion:</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_instalacion" id="fecha_instalacion" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_INST'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_instalacion" id="hora_instalacion" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_INST'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <label for="fecha_retiro" class="col-sm-2 col-form-label">Fecha y Hora Retiro:</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_retiro" id="fecha_retiro" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_RET'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_retiro" id="hora_retiro" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_RET'])); ?>"  required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n:<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3"  tabindex="4"><?= ($data[0]['OBSERVACION']); ?></textarea>
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
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Modificar Registro" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url() ?>assets/js/moment.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
//Registrar Datos en la Base de Datos
function GuardarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='nro_id']"))|| !campoVacio($("#fecha_instalacion")) || !campoVacio($("#hora_instalacion")) || !campoVacio($("#fecha_retiro")) || !campoVacio($("#hora_retiro")) || !campoVacio($("#observacion")))
         correcto = false;
      if(correcto==true){
        var codigo_ae = $("#codigo_ae").val();
        var nro_id = $("select[name='nro_id']").val();
        var fecha_instalacion = $("#fecha_instalacion").val() +' ' + $("#hora_instalacion").val();
        var fecha_retiro = $("#fecha_retiro").val() +' ' + $("#hora_retiro").val();
        var observacion = $("#observacion").val();
        // Add record
        $.ajax({
            data: {codigo_ae, nro_id, fecha_instalacion, fecha_retiro,observacion},
            url: '<?php echo base_url(); ?>odeco/modificar_cronograma',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se modific&oacute; exitosamente el Registro'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_cronogramas";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al modificar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_cronogramas";
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
</script>