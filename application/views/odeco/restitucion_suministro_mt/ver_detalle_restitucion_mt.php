
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
                <h1>Gesti&oacute;n de Restituci&oacute;n de Suministros MT</h1>
                <small>Ver/Modificar Restituci&oacute;n de Suministros MT</small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#"><?php echo display('odeco') ?></a></li>
                    <li class="active">Restituci&oacute;n de Suministros MT</li>
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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> VER/MODIFICAR REGISTRO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_restituciones"><i class="ti-align-justify"> </i> VER LISTA DE INTERRUPCIONES MT</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Formulario de Nuevo Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="nro_interrupcion" class="col-sm-2 col-form-label">Nro. Interrupci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nro_interrupcion" id="nro_interrupcion" tabindex="5">
                                                <option value="<?= ($data[0]['NRO_INTERRUPCION']); ?>"><?= ($data[0]['NRO_INTERRUPCION']); ?></option>
                                                <?php foreach ($get_interrupciones as $key => $list) { ?>
                                                    <option value="<?php echo $list['NRO_INTERRUPCION'] ?>"><?php echo $list['NRO_INTERRUPCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="nro_restitucion" class="col-sm-2 col-form-label">Nro. Restituci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nro_restitucion" id="nro_restitucion" tabindex="5">
                                                <option value="<?= ($data[0]['NRO_REPOSICION']); ?>"><?= ($data[0]['NRO_REPOSICION']); ?></option>
                                                <?php foreach ($get_restituciones as $key => $list) { ?>
                                                    <option value="<?php echo $list['NRO_REPOSICION'] ?>"><?php echo $list['NRO_REPOSICION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="nro_cuenta" class="col-sm-2 col-form-label">Nro. Cuenta :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nro_cuenta" id="nro_cuenta" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['NRO_CUENTA']); ?>"><?= ($data[0]['NRO_CUENTA']); ?></option>
                                                <?php foreach ($get_abonado as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Abonado'] ?>"><?php echo $list['Id_Abonado'] ?> - (<?php echo $list['Nombres'] ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha_reposicion" class="col-sm-2 col-form-label">Fecha y Hora Reposici&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_reposicion" id="fecha_reposicion" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_REPOS'])); ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_reposicion" id="hora_reposicion" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_REPOS'])); ?>"   required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3" tabindex="4"><?= ($data[0]['OBSERVACION']); ?></textarea>
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
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Guardar Restitucion de Suministro" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
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
      if(!campoVacio($("select[name='nro_interrupcion']")) || !campoVacio($("select[name='nro_restitucion']"))|| !campoVacio($("select[name='nro_cuenta']")) || !campoVacio($("#fecha_reposicion")) || !campoVacio($("#hora_reposicion")) || !campoVacio($("#observacion")))
         correcto = false;
      if(correcto==true){
        var nro_interrupcion = $("#nro_interrupcion").val();
        var nro_restitucion = $("select[name='nro_restitucion']").val();
        var nro_cuenta = $("select[name='nro_cuenta']").val();
        var fecha_reposicion = $("#fecha_reposicion").val() +' ' + $("#hora_reposicion").val();
        var observacion = $("#observacion").val();

        // Add record
        $.ajax({
            data: {nro_interrupcion,nro_restitucion,nro_cuenta,fecha_reposicion,observacion},
            url: '<?php echo base_url(); ?>odeco/modificar_restitucion_mt',
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
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones_mt";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al modificar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/agregar_restitucion_mt";
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