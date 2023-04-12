
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
                <h1>Formulario - Cronograma de Instalacion de Equipos</h1>
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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR REGISTRO NUEVO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_cronogramas"><i class="ti-align-justify"> </i> VER LISTA DE CRONOGRAMA DE INSTALACION DE EQUIPOS</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Seleccion Manual</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="campana" class="col-sm-2 col-form-label">Campa&ntilde;a :</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="campana" id="campana" tabindex="5">
                                                <option value="">Seleccionar</option>
                                                <option value="Baja Tension">Baja Tension</option>
                                                <option value="Media Tension">Media Tension</option>
                                                <option value="Centro de Transformacion">Centro de Transformacion</option>
                                                <option value="Desequilibrio de Tensiones">Desequilibrio de Tensiones</option>
                                            </select>
                                        </div>
                                        <label for="mes" class="col-sm-2 col-form-label">Mes :</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="mes" id="mes" tabindex="5">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($meses as $key => $mes) { ?>
                                                    <option value="<?php echo $key; ?>"><?php echo $mes; ?> (<?php if($key <= '10'){ echo ($anio_actual+1); }else{ echo $anio_actual; }  ?>, <?php echo $semestre_actual; ?>)</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tipo_punto" class="col-sm-2 col-form-label">Tipo Punto:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="tipo_punto" id="tipo_punto" tabindex="5" aria-required="true" required="">
                                                <option value="">Seleccionar</option>
                                                <option value="Basico">B&aacute;sico</option>
                                                <option value="Reclamo">Reclamo</option>
                                                <option value="Alternativo">Alternativo</option>
                                            </select>
                                        </div>
                                        <label for="tipo_medicion" class="col-sm-2 col-form-label">Tipo de Medicion:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="tipo_medicion" id="tipo_medicion" tabindex="5" aria-required="true" required="" onchange="GenerarCodAE();">
                                                <option value="">Seleccionar</option>
                                                <option value="Medicion">Medicion</option>
                                                <option value="Nueva Medicion">Nueva Medicion</option>
                                                <option value="Remedicion">Remedicion</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">C&oacute;digo AE y NRO. ID</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="codigo_ae" class="col-sm-2 col-form-label">Codigo AE: <i class="text-danger">*</i></label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="codigo_ae" id="codigo_ae" tabindex="5">
                                            </select>
                                        </div>
                                        <label for="nro_id" class="col-sm-2 col-form-label">Nro. ID (Nro.Cuenta BT): <i class="text-danger">*</i></label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="nro_id" id="nro_id" tabindex="5">
                                                <option value="" selected="">Seleccionar</option>
                                                <?php foreach ($get_IdAbonado as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Abonado'] ?>"><?php echo $list['Id_Abonado'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Cronograma de Instalacion y Retiro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="fecha_instalacion" class="col-sm-2 col-form-label">Fecha y Hora Instalacion:</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_instalacion" id="fecha_instalacion" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_instalacion" id="hora_instalacion" type="time" value="<?php echo date('H:i') ?>"   required="" tabindex="1">
                                        </div>
                                        <label for="fecha_retiro" class="col-sm-2 col-form-label">Fecha y Hora Retiro:</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="fecha_retiro" id="fecha_retiro" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="hora_retiro" id="hora_retiro" type="time" value="<?php echo date('H:i') ?>"   required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n:<i class="text-danger">*</i></label>
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
      if(!campoVacio($("select[name='codigo_ae']")) || !campoVacio($("select[name='nro_id']"))|| !campoVacio($("#fecha_instalacion")) || !campoVacio($("#hora_instalacion")) || !campoVacio($("#fecha_retiro")) || !campoVacio($("#hora_retiro")) || !campoVacio($("#observacion")))
         correcto = false;
      if(correcto==true){
        var campana = $("select[name='campana']").val();
        var mes = $("select[name='mes']").val();
        var tipo_punto = $("select[name='tipo_punto']").val();
        var tipo_medicion = $("select[name='tipo_medicion']").val();
        var codigo_ae = $("select[name='codigo_ae']").val();
        var nro_id = $("select[name='nro_id']").val();
        var fecha_instalacion = $("#fecha_instalacion").val() +' ' + $("#hora_instalacion").val();
        var fecha_retiro = $("#fecha_retiro").val() +' ' + $("#hora_retiro").val();
        var observacion = $("#observacion").val();

        // Add record
        $.ajax({
            data: {campana,mes,tipo_punto,tipo_medicion, codigo_ae, nro_id, fecha_instalacion, fecha_retiro,observacion},
            url: '<?php echo base_url(); ?>odeco/registrar_cronograma',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se registr&oacute; exitosamente el Registro'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_cronogramas";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al registrar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/agregar_cronograma";
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
function GenerarCodAE()
{
    var campana = $("select[name='campana']").val(); var campana1 = campana.substring(-1,1);
    var mes = $("select[name='mes']").val(); var mes1 = mes.substring(-1,2);
    var tipo_punto = $("select[name='tipo_punto']").val(); var tipo_punto1 = tipo_punto.substring(-1,1);
    var tipo_medicion = $("select[name='tipo_medicion']").val(); var tipo_medicion1 = tipo_medicion.substring(-1,1);
    
    //console.log(campana + '- ' + mes + '- ' +tipo_punto + '- ' +tipo_medicion);
    //console.log(campana1 + '- ' + mes1 + '- ' +tipo_punto1 + '- ' +tipo_medicion1);
    var dropdown = $('#codigo_ae');
    dropdown.empty();
    dropdown.append('<option selected="true" value=""> Seleccionar </option>');
    dropdown.prop('selectedIndex', 0);
    var prefijo_empresa = '<?php echo $prefijo_empresa; ?>';
    var mes2 = parseInt(mes1);
    //var mes3 = '';
    if(mes2==9){ mes2 = 'O'}
        if(mes2==11){ mes2 = 'N'}
            if(mes2==12){ mes2 = 'D'}
    var text = $("#mes option:selected").text(); var aux = text.split('(');
    var anio = aux[1].substring(3,4);
    //console.log(anio);
    
    if(tipo_medicion1=='M'){ 
        var codigo_ae = prefijo_empresa+campana1+tipo_punto1+anio+mes2+1;
        dropdown.append($('<option></option>').attr('value', codigo_ae).text(codigo_ae));
    }
    //dropdown.append('</select>');
}
</script>