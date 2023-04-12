
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
                <h1>Formulario - Dias Feriados</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#">Odeco</a></li>
                    <li class="active">Dias Feriados</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Dias Feriados </h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR REGISTRO NUEVO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_feriados"><i class="ti-align-justify"> </i> VER LISTA DE DIAS FERIADOS DEL AÑO</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                                <div class="col-md-9 col-md-offset-2">
                                    <div class="form-group ">
                                        <label for="descripcion" class="col-sm-2 col-form-label">Descripcion de Dia Feriado:</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="descripcion" id="descripcion" type="text" required="" tabindex="1" placeholder="Describa el dia feriado">
                                        </div>
                                        <label for="fecha" class="col-sm-2 col-form-label">Fecha Feriado:</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" name ="fecha" id="fecha" type="date" value="<?php echo date('Y-m-d') ?>"  required="" tabindex="1">
                                        </div>
                                    </div>
                                </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="button" class="btn btn-default btn-block" value="Cancelar" onclick="window.history.back();" tabindex="7"/>
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" id="add-customer" class="btn btn-success btn-block" name="add-customer" value="Guardar Registro" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
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
      if(!campoVacio($("#descripcion")) || !campoVacio($("#fecha")))
         correcto = false;
      if(correcto==true){
        var descripcion = $("#descripcion").val();
        var fecha = $("#fecha").val();

        // Add record
        $.ajax({
            data: {descripcion,fecha},
            url: '<?php echo base_url(); ?>odeco/registrar_feriado',
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
                            window.location.href ="<?php echo base_url(); ?>odeco/listar_feriados";
                        });
                
            })
        .fail(function(response)
            {
                Swal.fire({
                            icon: 'error',
                            title: 'Hubo Problemas al registrar el Registro'
                        }).then(function (){
                            //type: 'warning'
                            window.location.href ="<?php echo base_url(); ?>odeco/agregar_feriado";
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