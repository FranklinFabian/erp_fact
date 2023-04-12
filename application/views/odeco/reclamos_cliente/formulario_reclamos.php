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
            <h1><?php echo display('generate_claim') ?></h1>
            <small><?php echo display('generate_new_claim') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active"><?php echo display('generate_claim') ?></li>
            </ol>
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
                            <h4><?php echo display('generate_claim') ?> </h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR RECLAMO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_reclamos"><i class="ti-align-justify"> </i> VER LISTA DE RECLAMOS</a></li>
                        </ul>
                    </div>
                    <!---<?php echo form_open('odeco/insert_claim', array('class' => 'form-vertical', 'id' => 'insert_claim')) ?>--->
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">DATOS DE RECLAMACI&Oacute;N</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="oficina_odeco" class="col-sm-2 col-form-label">Oficina Odeco: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="oficina_odeco" id="oficina_odeco" tabindex="5" aria-required="true">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_oficinaodeco as $key => $list) { ?>
                                                    <option value="<?php echo $list['Localidad'] ?>"><?php echo $list['Localidad'] ?></option>
                                                <?php } ?>
                                              </select>
                                        </div>
                                        <label for="nivel_calidad" class="col-sm-2 col-form-label">Nivel de Calidad: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="nivel_calidad" id="nivel_calidad" tabindex="5" required="" aria-required="true">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Calidad 1</option>
                                                <option value="2">Calidad 2</option>
                                                <option value="3">Calidad 3</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="fecha_recepcion" class="col-sm-2 col-form-label">Fecha de Recepci&oacute;n: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="fecha_recepcion" id="fecha_recepcion" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                        <label for="hora_recepcion" class="col-sm-2 col-form-label">Hora de Recepci&oacute;n: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="hora_recepcion" id="hora_recepcion" type="time" value="<?php echo date('H:i') ?>"   required="" tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="medio_recepcion" class="col-sm-2 col-form-label">Medio de Recepci&oacute;n: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="medio_recepcion" id="medio_recepcion" tabindex="5">
                                                <option value="" selected="">Seleccionar</option>
                                                <option value="PERSONAL">PERSONAL</option>
                                                <option value="TELEFONO">TELEFONO</option>
                                                <option value="CORREO ELECTRONICO">CORREO ELECTRONICO</option>
                                                <option value="CORRESPONDENCIA">CORRESPONDENCIA</option>
                                                <option value="FACSIMILE">FACSIMILE</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">IDENTIFICACI&Oacute;N DEL CONSUMIDOR (TITULAR)</legend>
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="nro_cuenta" class="col-sm-2 col-form-label">Nro. Cuenta: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="nro_cuenta" id="nro_cuenta" tabindex="5" onchange="BuscarAbonado(this);">
                                                <option value="" selected="">Seleccionar</option>
                                                <?php foreach ($get_IdAbonado as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Abonado'] ?>"><?php echo $list['Id_Abonado'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="nombre_titular" class="col-sm-2 col-form-label">Nombre de Titular: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="nombre_titular" id="nombre_titular" placeholder="Nombre de Titular" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nro_ci" class="col-sm-2 col-form-label">Nro. CI: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="nro_ci" id="nro_ci" type="text" placeholder="Nro. CI" tabindex="2"> 
                                        </div>
                                        <label for="direccion" class="col-sm-2 col-form-label">Direcci&oacute;n: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="direccion" id="direccion" type="text" placeholder="Direccion" tabindex="2"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-2 col-form-label">Telef&oacute;no: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="telefono" id="telefono" type="text" placeholder="<?php echo display('phone') ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="medidor" class="col-sm-2 col-form-label">Medidor: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="medidor" id="medidor" type="text" placeholder="Medidor" tabindex="2"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="categoria" class="col-sm-2 col-form-label">Categor&iacute;a: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="categoria" id="categoria" type="text" placeholder="Categor&iacute;a" tabindex="2"> 
                                        </div>
                                        <label for="cod_localidad" class="col-sm-2 col-form-label">Cod. Localidad: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="cod_localidad" id="cod_localidad" type="text" placeholder="Cod. Localidad" tabindex="2"> 
                                            <input name ="cod_localidad_hidden" id="cod_localidad_hidden" type="hidden"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cod_zona" class="col-sm-2 col-form-label">Cod. Zona: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="cod_zona" id="cod_zona" type="text" placeholder="Cod. Zona" tabindex="2"> 
                                            <input name ="cod_zona_hidden" id="cod_zona_hidden" type="hidden"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">IDENTIFICACI&Oacute;N DEL RECLAMANTE</legend>
                                <div class="col-md-9">
                                    <button type="button" onclick="Titular();">Titular es Reclamante</button>
                                    <div class="form-group row">
                                        <label for="nombre_reclamante" class="col-sm-2 col-form-label">Reclamante: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="nombre_reclamante" id="nombre_reclamante" placeholder="Reclamante" required />
                                        </div>
                                        <label for="nro_ci_reclamante" class="col-sm-2 col-form-label">Nro. CI: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="nro_ci_reclamante" id="nro_ci_reclamante" type="text" placeholder="Nro. CI" tabindex="2"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div><label for="nro_cuenta_reclamante" class="col-sm-2 col-form-label">Nro. Cuenta: </label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="nro_cuenta_reclamante" id="nro_cuenta_reclamante" placeholder="Nro Cuenta" required />
                                        </div>
                                        </div>
                                        <label for="direccion_reclamante" class="col-sm-2 col-form-label">Direcci&oacute;n:</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="direccion_reclamante" id="direccion_reclamante" type="text" placeholder="Direccion" tabindex="2"> 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telefono_1" class="col-sm-2 col-form-label">Telf/Cel(1): <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="telefono_1" id="telefono_1" type="text" placeholder="Telf/Cel(1)" min="0" tabindex="3">
                                        </div>
                                        <label for="telefono_2" class="col-sm-2 col-form-label">Telf/Cel(2): </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="telefono_2" id="telefono_2" type="text" placeholder="Telf/Cel(2)" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="localidad" class="col-sm-2 col-form-label">Localidad: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="localidad" id="localidad" tabindex="5" aria-required="true" required="" onchange="get_codzona();">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($get_localidades as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Localidad'] ?>"><?php echo $list['Localidad'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="cod_zona_reclamante" class="col-sm-2 col-form-label">C&oacute;digo Zona: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="cod_zona_reclamante" id="cod_zona_reclamante" tabindex="5" aria-required="true" required="">
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="medidor_reclamante" class="col-sm-2 col-form-label">Medidor: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="medidor_reclamante" id="medidor_reclamante" type="text" placeholder="Medidor" tabindex="2"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">DOMICILIO PARA IDENTIFICAR AL RECLAMANTE</legend>
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="domicilio_real" class="col-sm-2 col-form-label">Domicilio Real: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="domicilio_real" id="domicilio_real" placeholder="Domicilio Real"  />
                                        </div>
                                        <label for="domicilio_procesal" class="col-sm-2 col-form-label">Domicilio Procesal: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="domicilio_procesal" id="domicilio_procesal" type="text" placeholder="Domicilio Procesal" tabindex="2"> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="domicilio_especial" class="col-sm-2 col-form-label">Domicilio Especial: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="domicilio_especial" id="domicilio_especial" placeholder="Domicilio Especial"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">DETALLE DE LA RECLAMACI&Oacute;N Y/O DOCUMENTACI&Oacute;N PROPORCIONADA POR EL RECLAMANTE</legend>
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="fecha_evento" class="col-sm-2 col-form-label">Fecha Evento: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input type="date" tabindex="2" class="form-control" name="fecha_evento" id="fecha_evento" placeholder="Fecha Evento" required />
                                        </div>
                                        <label for="hora_evento" class="col-sm-2 col-form-label">Hora Evento: <i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="hora_evento" id="hora_evento" type="time" placeholder="Hora Evento" tabindex="2"> 
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="cod_reclamo" class="col-sm-2 col-form-label">Tipo de Reclamo: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="cod_reclamo" id="cod_reclamo" tabindex="5">
                                                <option value="" selected="">Seleccionar</option>
                                                <?php foreach ($tipo_reclamo as $key => $list) { ?>
                                                    <option value="<?php echo $list['MOTIVO'] ?>"><?php if(!empty($list['DESCRIPCION_TIPO'])){echo $list['DESCRIPCION_TIPO'].' / ';} ?><?php if(!empty($list['DESCRIPCION_CATEGORIA'])){ echo $list['DESCRIPCION_CATEGORIA'].' / ';} ?><?php echo $list['DESCRIPCION'] ?></option>
                                                <?php } ?>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="motivo" class="col-sm-2 col-form-label">Descripci&oacute;n de lo Ocurrido: <i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="motivo" id="motivo" rows="3" placeholder="Descripci&oacute;n de lo Ocurrido" tabindex="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">DESCRIPCI&Oacute;N DE EQUIPOS DA&Ntilde;ADOS </legend>
                                <div class="col-md-2">
                                    <input type="checkbox" name="descripcion_equipos" class="form-control" value="" id="descripcion_equipos" onchange="MostrarFormEquipos(this);">
                                </div>
                                <div class="col-md-9 col-md-offest-9" id="seccion_equipos">
                                    <table class="table table-hover table-striped table-responsive" id="registro_equipos">
                                        <thead>
                                            <tr>
                                              <th style="text-align: center;">Descripci&oacute;n</th>
                                              <th style="text-align: center;">Marca</th>
                                              <th style="text-align: center;">Modelo</th>
                                              <th style="text-align: center;">Serie</th>
                                              <th style="text-align: center;">A&ntilde;o</th>
                                              <th style="text-align: center;">Obervaciones</th>
                                              <th style="text-align: center;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="equipos">
                                            <tr>
                                                <td><textarea type="text" class="form-control" name="descripcion_dano" id="descripcion_dano" placeholder="Descripcion" col="" row="2" required=""></textarea></td>
                                                <td><input type="text" min="0" class="form-control col-xs-1" name="marca" id="marca" placeholder="Marca" required=""></td>   
                                                <td><input type="text" min="0" class="form-control col-xs-1" name="modelo" id="modelo" placeholder="Modelo" required=""></td>   
                                                <td><input type="text" min="0" class="form-control col-xs-1" name="serie" id="serie" placeholder="Serie" required=""></td>   
                                                <td><input type="text" min="0" class="form-control col-xs-1" name="anio" id="anio" placeholder="A&ntilde;io" required=""></td>   
                                                <td><textarea type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" col="" row="2" required=""></textarea></td>
                                                <td style="text-align: center;">
                                                    <button type="button" class="btn btn-success" id="verificar_campos" title="Validar Campos" onclick="ValidarFila(this);"><i class="fa fa-check"></i></button>
                                                    
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr id="boton_fila">
                                                <button type="button" id="anadir_fila" class="btn btn-primary" title="A&ntilde;adir Fila" onclick="AnadirFila();"><i class="fa fa-plus"></i> A&ntilde;adir Fila</button>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" id="guardar_datos" class="btn btn-primary btn-block" name="guardar_datos" value="Guardar Reclamo" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->

<!-- Manage Product End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
$(document).ready(function() { 

    /*Swal.fire({
        icon: 'info',
        html: '<p>La Oficina del consumidor ODECO, tiene como funcion principal atender eficaz y eficientemente los reclamos y deneuncias de los consumidores, cumpliendo con el decreto supremo Nro. 5665 Reglamento de la Ley de los Consumidores y Consumidoras, respondiendo todos los reclamos, en forma oportuna, cumpliendo con los plazos establecidos</p>',
        imageUrl: '<?php echo base_url();?>assets/img/prueba.png',
        imageHeight:400,
        imageWidth:800,
        imageAlt:'Custom image'
    });*/

    $('#seccion_equipos').css('display', 'none');
    $('#seccion_equipos').prop('disabled', true);
});

//Buscar datos de Cliente Titular en la base de datos
function BuscarAbonado(obj){
    //alert(obj.value);
    var Id_Abonado = obj.value;
    $.post("<?php echo base_url(); ?>Odeco/buscar_abonado", {
        Id_Abonado
    }, function (data, status) {
        var respuesta = JSON.parse(data);
        //console.log(respuesta[0].Nombres);
        $('#nombre_titular').val(respuesta[0].Nombres);
        //$('#nro_cuenta').val(respuesta[0].Id_Cliente);
        $('#nro_ci').val(respuesta[0].Nit);
        $('#telefono').val(respuesta[0].Telefono);
        $('#medidor').val(respuesta[0].Serie_Medidor);
        $('#categoria').val(respuesta[0].Categoria);
        $('#cod_localidad').val(respuesta[0].Localidad);
        $('#cod_zona').val(respuesta[0].Zona);
        $('#cod_localidad_hidden').val(respuesta[0].Id_Localidad);
        $('#cod_zona_hidden').val(respuesta[0].Id_Zona);
        $('#direccion').val('Calle '+respuesta[0].Calle+' Nro '+respuesta[0].Numero);
        $('#Id_Abonado').val(respuesta[0].Id_Abonado);
    });
}

//buscar datos del que realiza el reclamo al odeco
function Titular(){
    var nombre_titular = $("#nombre_titular").val();
    var nro_ci = $("#nro_ci").val();
    var nro_cuenta = $("#nro_cuenta").val();
    var medidor = $("#medidor").val();
    var direccion = $("#direccion").val();
    var telefono = $("#telefono").val();
    var cod_localidad = $("#cod_localidad").val();
    var categoria = $("#categoria").val();
    var cod_reclamo = $("select[name='cod_reclamo']").val();
    var motivo = $("#motivo").val();

    $('#nombre_reclamante').val(nombre_titular);
    $('#nro_ci_reclamante').val(nro_ci);
    $('#nro_cuenta_reclamante').val(nro_cuenta);
    $('#direccion_reclamante').val(direccion);
    $('#telefono_1').val(telefono);
    $('#medidor_reclamante').val(medidor);
}
//traer en base a Seleccion de Localidad el COD ZONA
function get_codzona()
{   
    var id_localidad = $('select[name="localidad"]').val();
    var dropdown = $('#cod_zona_reclamante');
    dropdown.empty();
    dropdown.append('<option selected="true" value=""> Seleccionar Cod Zona </option>');
    dropdown.prop('selectedIndex', 0);
    $.ajax({
        data: {id_localidad: id_localidad},
        url: '<?php echo base_url(); ?>Odeco/get_codzona',
        type: 'POST',
        dataType: 'json',
        success: function(response, status)
        {
            $.each(response, function(key, datos){
                dropdown.append($('<option></option>').attr('value', datos.Id_Zona).text(datos.Zona));
            });
            dropdown.append('</select>');
        },
        error: function()
        {

        }
    });
}
function MostrarFormEquipos(obj){

    if ($(obj).prop('checked') == true) 
    {
      $('#seccion_equipos').css('display', 'block');
      $('#seccion_equipos').prop('disabled', false);
      $('form #guardar_datos').prop('disabled', true);
    }else{
      $('#seccion_equipos').css('display', 'none');
      $('#seccion_equipos').prop('disabled', true);
      $('form #guardar_datos').prop('disabled', false);
    }

    $('#anadir_fila').css('display', 'none');
}
function AnadirFila(){
    $('#anadir_fila').css('display', 'none');
    $('form #guardar_datos').prop('disabled', true);
    var data = '<tr>'+
        '<td><textarea type="text" class="form-control" name="descripcion_dano" id="descripcion_dano" placeholder="Descripcion" col="" row="2" required=""></textarea></td>'+
        '<td><input type="text" min="0" class="form-control col-xs-1" name="marca" id="marca" placeholder="Marca" required=""></td>' +  
        '<td><input type="text" min="0" class="form-control col-xs-1" name="modelo" id="modelo" placeholder="Modelo" required=""></td>' +  
        '<td><input type="text" min="0" class="form-control col-xs-1" name="serie" id="serie" placeholder="Serie" required=""></td>' +  
        '<td><input type="text" min="0" class="form-control col-xs-1" name="anio" id="anio" placeholder="A&ntilde;o" required=""></td>' +  
        '<td><textarea type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones" col="" row="2" required=""></textarea></td>'+
        '<td style="text-align: center;"><button type="button" class="btn btn-success" id="verificar_campos" title="Validar Campos" onclick="ValidarFila(this);"><i class="fa fa-check"></i></button>'+
        '<button type="button" id="eliminar" class="btn btn-danger" title="Eliminar Fila" onclick="EliminarFila(this);"><i class="fa fa-minus"></i></button></td>'+
        '</tr>';
        $("#equipos").append(data);
}
function EliminarFila(obj)
{
    $(obj).closest('tr').remove();
}
function ValidarFila(obj)
{
    var validar = true;
      if(!campoVacio($(obj).closest('tr').find("#descripcion_dano")) || !campoVacio($(obj).closest('tr').find('#marca'))|| !campoVacio($(obj).closest('tr').find('#modelo'))|| !campoVacio($(obj).closest('tr').find('#serie'))|| !campoVacio($(obj).closest('tr').find('#anio')))
         validar = false;
      if(validar==true){
        $('#anadir_fila').css('display', 'block');
        $('form #guardar_datos').prop('disabled', false);
      }
}
//Registrar Datos en la Base de Datos
function GuardarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='oficina_odeco']")) || !campoVacio($("select[name='nivel_calidad']")) || !campoVacio($("#nro_cuenta")) || !campoVacio($("select[name='nombre_reclamante']"))|| !campoVacio($("select[name='nro_ci_reclamante']")) || !campoVacio($('#telefono_1'))|| !campoVacio($("select[name='localidad']"))|| !campoVacio($("select[name='cod_zona_reclamante']"))|| !campoVacio($('#domicilio_real'))|| !campoVacio($('#domicilio_procesal'))|| !campoVacio($('#domicilio_especial'))|| !campoVacio($('#fecha_evento'))|| !campoVacio($('#hora_evento'))|| !campoVacio($("select[name='cod_reclamo']"))|| !campoVacio($('#motivo')))
         correcto = false;
      if(correcto==true){
        //seccion para registro de parametros para la AE
        var nro_cuenta = $("#nro_cuenta").val();
        var nivel_calidad = $("select[name='nivel_calidad']").val();
        var fecha_recepcion = $("#fecha_recepcion").val() +' ' + $("#hora_recepcion").val();
        var cod_localidad = $("#cod_localidad_hidden").val();
        var categoria = $("#categoria").val();
        var cod_reclamo = $("select[name='cod_reclamo']").val();
        var motivo = $("#motivo").val();

        //Seccion de Registros adicionales
        var oficina_odeco = $("select[name='oficina_odeco']").val();
        var medio_recepcion = $("select[name='medio_recepcion']").val();
        var nombre_reclamante = $("#nombre_reclamante").val();
        var nro_ci_reclamante = $("#nro_ci_reclamante").val();
        var nro_cuenta_reclamante = $("#nro_cuenta_reclamante").val();
        var direccion_reclamante = $("#direccion_reclamante").val();
        var telefono_1 = $("#telefono_1").val();
        var telefono_2 = $("#telefono_2").val();
        var localidad = $("select[name='localidad']").val();
        var cod_zona_reclamante = $("select[name='cod_zona_reclamante']").val();
        var medidor_reclamante = $("#medidor_reclamante").val();
        var domicilio_real = $("#domicilio_real").val();
        var domicilio_especial = $("#domicilio_especial").val();
        var domicilio_procesal = $("#domicilio_procesal").val();
        var fecha_evento = $("#fecha_evento").val();
        var hora_evento = $("#hora_evento").val();
        //registro de equipos
        var parametros = [];
        if($('#descripcion_equipos').prop('checked') == true){
            var filas = $("#registro_equipos tbody").find("tr");
            for(i=0; i<filas.length; i++){ //Recorre las filas 1 a 1
              datos = {
                    descripcion_dano : $(filas[i]).find('td').children('#descripcion_dano').val(),
                    marca : $(filas[i]).find('td').children('#marca').val(),
                    modelo : $(filas[i]).find('td').children('#modelo').val(),
                    serie : $(filas[i]).find('td').children('#serie').val(),
                    anio : $(filas[i]).find('td').children('#anio').val(),
                    observaciones : $(filas[i]).find('td').children('#observaciones').val()
                };
              parametros.push(datos);
            }
        }
        // Add record
        $.ajax({
            data: {
            //PARA EL REISTRO ODECO PARA LA AE
            nro_cuenta,nivel_calidad,fecha_recepcion,cod_localidad,categoria,cod_reclamo,motivo,
            //REGISTROS ADICIONALES
            oficina_odeco,medio_recepcion,nombre_reclamante,nro_ci_reclamante,nro_cuenta_reclamante,direccion_reclamante,telefono_1,telefono_2,localidad,cod_zona_reclamante,medidor_reclamante,domicilio_real,domicilio_especial,domicilio_procesal,fecha_evento,hora_evento, equipos: JSON.stringify(parametros)},
            url: '<?php echo base_url(); ?>Odeco/registrar_reclamo',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                Swal.fire(
                    {
                        icon: 'success',
                        title: 'Se registr&oacute; exitosamente el reclamo',
                        text: 'El reclamo fue designado con el Codigo Nro.'+response + ' para realizar el seguimiento'
                        //type: 'success'
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco/listar_reclamos";
                    });
            })
        .fail(function(response)
            {
                Swal.fire({
                        icon: 'error',
                        title: 'Hubo Problemas al registrar el reclamo'
                        //type: 'warning'
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco";
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
};
 
</script>