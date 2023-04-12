
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
                <h1>Indicadores</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#">Odeco</a></li>
                    <li class="active">Indicadores</li>
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
                            <h4>Indicadores </h4>
                        </div>
                    </div>
                    <form method="POST" action="#" enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="semestre" id="semestre" type="text" value="<?php echo '77'; ?>"tabindex="1" readonly>
                                        </div>
                                        <label for="semestre" class="col-sm-2 col-form-label text-right">Cambiar Semestre: </label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true" required="">
                                                <option value="12" selected=""><?= date('Y-5-1') ?></option>
                                                <option value="22"><?= date('Y-5') ?>casas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio_basico" class="col-sm-4 col-form-label text-right"> PRECIO BASICO DE ENERGIA (Bs/kWh): </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="precio_basico" id="precio_basico" type="number" placeholder="" required="" tabindex="1">
                                        </div>
                                        <!-- <div class="col-sm-4">
                                            <button type="submit" class="btn btn-success btn-small"> Guardar </button>
                                        </div> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="tarifa_promedio" class="col-sm-4 col-form-label text-right">  TARIFA PROMEDIO CAT. RESIDENCIAL (Bs/kWh): </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="tarifa_promedio" id="tarifa_promedio" type="number" placeholder="" required="" tabindex="1">
                                        </div>
                                        <!-- <div class="col-sm-4">
                                            <button type="submit" class="btn btn-success btn-small"> Guardar </button>
                                        </div> -->

                                        <div class="col-sm-4 pull-right">
                                            <button type="submit" class="btn btn-success btn-small btn-block" onclick="Setear(event);"> Guardar </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    </form>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="indices" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nivel Calidad</th>
                                        <th class="text-center">Formulario 1 (SC1) </th>
                                        <th class="text-center">Formulario 2 (SC2) </th>
                                        <th class="text-center">Formulario 3 (SC3) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
//Registrar Datos en la Base de Datos
function Setear(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("#precio_basico")) || !campoVacio($("#tarifa_promedio")))
         correcto = false;
      if(correcto==true)
      {
        var semestre = $('#semestre').val();
        var precio_basico = $("#precio_basico").val();
        var tarifa_promedio = $("#tarifa_promedio").val();
        $('#indices tbody tr').remove();
        var data = '<tr><td class="text-center">1</td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_reclamos/'+semestre+'/1/'+precio_basico+'">SC1 (Nivel Calidad 1)</a></td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_facturacion/'+semestre+'/1">SC2 (Nivel Calidad 1)</a></td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_atencion_consumidor/'+semestre+'/1/'+tarifa_promedio+'">SC3 (Nivel Calidad 1)</a></td>'+
                    '</tr><tr><td class="text-center">2</td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_reclamos/'+semestre+'/2/'+precio_basico+'">SC1 (Nivel Calidad 2)</a></td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_facturacion/'+semestre+'/2">SC2 (Nivel Calidad 2)</a></td>'+
                    '<td class="text-center"><a target="_blank" href="<?php echo base_url(); ?>odeco/indice_atencion_consumidor/'+semestre+'/2/'+tarifa_promedio+'">SC3 (Nivel Calidad 2)</a></td>'+
                    '</tr>';
            $('#indices tbody').prepend(data);
    }else{
        Swal.fire({
        icon: 'error',
        title: 'Debe llenar todos los campos'
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