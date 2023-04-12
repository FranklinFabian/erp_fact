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
</style>
<!-- Manage Category Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Indicadores Individuales de Continuidad de Suministro</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">Odeco</a></li>
                <li class="active">Indicadores de Calidad</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Manage Category -->
        <?php   date_default_timezone_set('America/La_Paz');
                $now = date('Y-m-d H:i');
                print_r($now);
         ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <ul class="nav nav-tabs">
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> Calcular Indicadores</a></li>
                             <li class="pdf_1"><a target="_blank" href="<?php echo base_url(); ?>odeco/individuales_calidad_pdf/<?= $semestre[0]['Sigla']; ?>/1"><i class="fa fa-file-pdf-o"> </i> Ver Formulario ST2 (Nivel Calidad 1)</a></li>
                             <li class="pdf_2"><a target="_blank" href="<?php echo base_url(); ?>odeco/individuales_calidad_pdf/<?= $semestre[0]['Sigla']; ?>/2"><i class="fa fa-file-pdf-o"> </i> Ver Formulario ST2 (Nivel Calidad 2)</a></li> 
                              <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p class="btn btn-info"> Semestre : <?= $semestre[0]['Sigla']; ?></p></li> 
                              <li class="col-sm-4 pull-right">
                                  <form method="POST" action="<?php echo base_url(); ?>odeco/indicadores_individuales" enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8">
                                    <label for="semestre" class="col-sm-4 col-form-label text-right">Cambiar Semestre: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true">
                                            <option value="<?= $semestre[0]['Sigla']; ?>" selected=""><?= $semestre[0]['Sigla']; ?></option>
                                            <?php foreach ($listar_semestres as $list) { ?>
                                            <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 pull-right">
                                        <button type="submit" class="btn btn-success btn-small btn-block"> Buscar </button>
                                    </div>
                                  </form>
                              </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="Tabla_restitucion" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nro. Cuenta</th>
                                        <th class="text-center">Nivel Calidad</th>
                                        <th class="text-center">Nombre Consumidor/Raz&oacute;n Social</th>
                                        <th class="text-center">Frec. Programada</th>
                                        <th class="text-center">Frec. Forzada</th>
                                        <th class="text-center">Frec. Total</th>
                                        <th class="text-center">Tiempo Programado</th>
                                        <th class="text-center">Tiempo Forzado</th>
                                        <th class="text-center">Tiempo Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($indicadores_individuales) { 
                                        foreach ($indicadores_individuales as $key => $valor) {
                                        ?>
                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td class="text-center"><?= $valor['NRO_INTERRUPCION']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_HORA_INI'])); ?></td>
                                            <td class="text-center"><?= $valor['NRO_REPOSICION']; ?></td>
                                            <td class="text-center"><?= $valor['NRO_CUENTA']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_HORA_REPOS'])); ?></td>
                                            <td class="text-center"><?= $valor['TIEMPO']; ?></td>
                                            <td class="text-center"><?= $valor['OBSERVACION']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_REGISTRO'])); ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_REGISTRO'])); ?></td>
                                        </tr>
                                    <?php }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Category End -->
<!-- Delete Category ajax code -->
<script type="text/javascript">
$(document).ready(function () {
    $('#Tabla_restitucion').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
            ],
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Restituciones de Suministros MT Registrados",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:&nbsp;&nbsp; ",
                "zeroRecords": "No se encontraron resultados.",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
});
/*function Semestre(obj)
{
    var semestre = $("select[name='semestre']").val();
    $('#semestre').val(semestre);
    $('li#pdf_1 a').remove();
    $('li#pdf_2 a').remove();
    var sethref = '<a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/'+semestre+'/1"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 1</strong></a>';
    var sethref2 = '<a target="_blank" href="<?php echo base_url(); ?>odeco/retraso_rep_suministro_pdf/'+semestre+'/2"><i class="fa fa-file-o btn"></i><strong>Nivel Calidad 1</strong></a>';
    $('li#pdf_1').prepend(sethref);
    $('li#pdf_2').prepend(sethref2);
}*/
</script>