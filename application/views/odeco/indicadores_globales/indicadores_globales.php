
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
                <h1>Indicadores Globales - Empresas Distribuidoras</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#">Odeco</a></li>
                    <li class="active">Indicadores Globales</li>
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
                            <h4>Indicadores Globales </h4>
                        </div>
                    </div>
                    <form target="_blank" method="POST" action="<?php echo base_url(); ?>odeco/reporte_indglobal_pdf" enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Valores de Selecci&oacute;n</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="nombre_empresa" class="col-sm-2 col-form-label">Empresa: </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name ="nombre_empresa" id="nombre_empresa" type="text" value="<?php echo $nombre_empresa; ?>"tabindex="1" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="semestre" class="col-sm-2 col-form-label">Semestre: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true" required="">
                                                <option value="as" selected=""><?= date('Y-5-1') ?></option>
                                                <option value="as"><?= date('Y-5') ?>casas</option>
                                            </select>
                                            <!-- <input class="form-control" name ="fecha_reposicion" id="fecha_reposicion" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1"> -->
                                        </div>
                                        <label for="nivel_calidad" class="col-sm-2 col-form-label">Nivel Calidad: </label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nivel_calidad" id="nivel_calidad" tabindex="5" aria-required="" required="">
                                                <option value="" selected="" disabled="">Seleccionar</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Valores Complementarios</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="total_kva" class="col-sm-2 col-form-label">Total kVA Instalado: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="total_kva" id="total_kva" type="text" value="0"tabindex="1">
                                        </div>
                                        <label for="maxima_tension" class="col-sm-2 col-form-label">Máxima Tensión Distribución: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="maxima_tension" id="maxima_tension" type="text" value="0"tabindex="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="longitud_linea_bt" class="col-sm-2 col-form-label">Longitud Línea BT: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="longitud_linea_bt" id="longitud_linea_bt" type="text" value="0"tabindex="1">
                                        </div>
                                        <label for="longitud_linea_mt" class="col-sm-2 col-form-label">Longitud Línea BT: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="longitud_linea_mt" id="longitud_linea_mt" type="text" value="0"tabindex="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-8 col-form-label"></label>
                            <div class="col-sm-4">
                                <!-- <input type="submit" target="_blank" id="add-customer" class="btn btn-success btn-block" name="add-customer" value="Ver Indicador Global" onclick="Exportar(event);" tabindex="7"/> -->
                                <!-- <button target="_black" type="submit" class="btn btn-success btn-block" onclick="Exportar(event);"><span class="fa fa-file-pdf-o"></span> Ver Indicador Global <strong> (Form-ST1)</strong></button> -->
                                <button type="submit" class="btn btn-success btn-block"><span class="fa fa-file-pdf-o"></span> Ver Indicador Global <strong> (Form-ST1)</strong></button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
//Registrar Datos en la Base de Datos
function Exportar(obj){
    obj.preventDefault();
    $(obj).target = "_blank";
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='nivel_calidad']")))
         correcto = false;
      if(correcto==true){
        var nombre_empresa = $("#nombre_empresa").val();
        var nivel_calidad = $("select[name='nivel_calidad']").val();
        var semestre = $("select[name='semestre']").val();
        var total_kva = $("#total_kva").val();
        var maxima_tension = $("#maxima_tension").val();
        var longitud_linea_bt = $("#longitud_linea_bt").val();
        var longitud_linea_mt = $("#longitud_linea_mt").val();
        //window.open('about:blank','blankwindow');
        // Add record
        $.ajax({
            data: {nombre_empresa,nivel_calidad,semestre,total_kva,maxima_tension,longitud_linea_bt,longitud_linea_mt},
            url: '<?php echo base_url(); ?>odeco/reporte_indglobal_pdf',
            type: 'POST',
            dataType: 'json'
            })
        .done(function(response)
            {
                window.open($(obj).prop('<?php echo base_url(); ?>odeco/reporte_indglobal_pdf'));
                /*Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se registr&oacute; exitosamente el Registro'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones_mt";
                        });*/
                
            })
        .fail(function(response)
            {
                /*Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al registrar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/agregar_restitucion_mt";
                        });*/
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