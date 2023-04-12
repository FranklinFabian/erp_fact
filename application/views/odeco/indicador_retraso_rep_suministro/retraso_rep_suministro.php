
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
                <h1>Retraso en la Rep. Suministro</h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                    <li><a href="#">Odeco</a></li>
                    <li class="active">Retraso en la Rep. Suministro</li>
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
                            <h4>Retraso en la Rep. Suministro </h4>
                        </div>
                    </div>
                    <form method="POST" action="#" enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="semestre" id="semestre" type="text" value="<?php echo $semestre_actual[0]['Sigla']; ?>"tabindex="1" readonly>
                                        </div>
                                        <label for="cambiar_semestre" class="col-sm-2 col-form-label text-right">Cambiar Semestre: </label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="cambiar_semestre" id="cambiar_semestre" tabindex="5" aria-required="true" required="" onchange="Semestre(this);">
                                                <option value="">Seleccionar</option>
                                                <?php foreach ($listar_semestres as $list) { ?>
                                                <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="precio_basico" class="col-sm-4 col-form-label text-right"> Consumidores Afectados: </label>
                                        <div class="col-sm-4" id="calidad_1">
                                            <a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/<?php echo $semestre_actual[0]['Sigla']; ?>/1"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 1</strong></a>
                                        </div>
                                        <div class="col-sm-4" id="calidad_2">
                                            <a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/<?php echo $semestre_actual[0]['Sigla']; ?>/2"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 2</strong></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">

function Semestre(obj)
{
    var cambiar_semestre = $("select[name='cambiar_semestre']").val();
    $('#semestre').val(cambiar_semestre);
    $('#calidad_1 a').remove();
    $('#calidad_2 a').remove();
    var sethref = '<a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/'+cambiar_semestre+'/1"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 1</strong></a>';
    var sethref2 = '<a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/'+cambiar_semestre+'/2"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 1</strong></a>';
    $('#calidad_1').prepend(sethref);
    $('#calidad_2').prepend(sethref2);
}
 
</script>