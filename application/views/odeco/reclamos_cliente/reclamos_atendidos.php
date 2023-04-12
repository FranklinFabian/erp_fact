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
            <h1>Gesti&oacute;n de Reclamos</h1>
            <small>Ver Reclamos Recepcionados</small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">Odeco</a></li>
                <li class="active">Gesti&oacute;n de Reclamos</li>
            </ol>
        </div>
    </section>

    <section class="content">

        <!-- Manage Category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#"><i class="ti-align-justify"> </i> LISTA DE RECLAMOS ATENDIDOS</a></li>  
                                <li><a href="<?php echo base_url(); ?>odeco/listar_reclamos"><i class="fa fa-plus"> </i> VER RECLAMOS RECEPCIONADOS</a></li>
                            </ul>                        
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div>
                                <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                    <div class="col-sm-3">
                                        <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true">
                                            <option value="<?= $semestre[0]['Sigla']; ?>" selected=""><?= $semestre[0]['Sigla']; ?></option>
                                            <?php foreach ($listar_semestres as $list) { ?>
                                            <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div><br><br>
                            <table id="Tabla_reportes" class="table table-bordered table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Nro. de Reclamo</th>
                                        <th class="text-center">Fecha de Recepci&oacute;n</th>
                                        <th class="text-center">Medio de Recepci&oacute;n</th>
                                        <th class="text-center">Reclamante</th>
                                        <th class="text-center">Fecha de Evento</th>
                                        <th class="text-center">Descripci&oacute;n del Evento</th>
                                        <th class="text-center">Equipos Da&ntilde;ados</th>
                                        <th class="text-center">Direcci&oacute;n</th>
                                        <th class="text-center">Nro. Documento</th>
                                        <th class="text-center">Telf/Celular</th>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Tiempo</th>
                                        <th class="text-center">Acciones</th>

                                    </tr>
                                </thead>
                                <!-- <tbody>
                                    <?php
                                    if ($odeco_list) {
                                        foreach ($odeco_list as $key => $valor) {
                                        ?>
                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td class="text-center"><?= $valor['NUMERO']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y',strtotime($valor['FECHA_HORA_REC'])); ?> <?= date('H:i',strtotime($valor['FECHA_HORA_REC'])); ?></td>
                                            <td class="text-center"><?= $valor['Medio_recepcion']; ?></td>
                                            <td class="text-center"><?= $valor['Nombre_reclamante']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y',strtotime($valor['Fecha_evento_causa'])); ?> <?= date('H:i',strtotime($valor['Hora_evento_causa'])); ?></td>
                                            <td class="text-center"><?= $valor['MOTIVO']; ?></td>
                                            <td class="text-center"><?php if($valor['Equipo'] ==1){echo 'SI';}else{echo 'NO';} ?></td>
                                            <td class="text-center"><?= $valor['Direccion_reclamante']; ?></td>
                                            <td class="text-center"><?= $valor['Ci_reclamante']; ?></td>
                                            <td class="text-center"><?= $valor['Telefono_1_reclamante']; ?></td>
                                            <td class="text-center"><?= $valor['CATEGORIA']; ?></td>
                                            <td class="text-center"><?php $var = $valor['TIEMPO_TRAMITE']; settype($var, 'string'); $datos = explode('.',$var); echo $datos[0].'.'.(round($datos[1]*100/60));  ?></td>
                                            <td>
                                            <center>
                                                <?php echo form_open() ?>
                                                <a href="<?php echo base_url().'odeco/ver_detalle_reclamo/'.$valor['NUMERO']; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Ver Detalle"><i class="fa fa-search" aria-hidden="true"></i></a>
                                                <a target="_blank" href="<?php echo base_url().'odeco/formulario_pdf/'.$valor['NUMERO']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Formulario Reclamo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                                <a target="_blank" href="<?php echo base_url().'odeco/respuesta_pdf/'.$valor['NUMERO']; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Formulario Respuesta"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                                <?php if($this->permission1->method('manage_claims','update')->access()){ ?>
                                                <a href="<?php echo base_url().'odeco/editar_pronunciamiento/'.$valor['NUMERO']; ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Editar Pronunciamiento"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php }?>
                                                <?php echo form_close() ?>
                                            </center>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                                ?>
                                </tbody> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Category End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Delete Category ajax code -->
<script type="text/javascript">
    $(document).ready(function(){
        var userDataTable = $('#Tabla_reportes').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "pdf",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Exportar PDF', orientation:'landscape'},
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Exportar Excel'},
                    {extend: "print",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Imprimir'}
            ],
            ordering: true,
            "aaSorting": [[ 2, "desc" ]],
             "columnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,12,13]}
            ],
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Reclamos Atendidos",
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
            },
            lengthMenu:[10, 25, 50,100, 500, "All"],
            //section AJAX RENDER
            searchDelay: 500,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?php echo base_url(); ?>odeco/listar_reclamos_atendidos_ajax',
              'data': function(data){
                    data.searchSemestre = $('#semestre').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data:  'Numero', class:'text-center'},
                { data:  'Fecha_hora_rec', class:'text-center'},
                { data:  'Medio_recepcion', class:'text-center'},
                { data:  'Nombre_reclamante', class:'text-center'},
                { data:  'Fecha_evento_causa', class:'text-center'},
                { data:  'Motivo', class:'text-center'},
                { data:  'Equipo', class:'text-center'},
                { data:  'Direccion_reclamante', class:'text-center'},
                { data:  'Ci_reclamante', class:'text-center'},
                { data:  'Telefono_1_reclamante', class:'text-center'},
                { data:  'Categoria', class:'text-center'},
                { data:  'Tiempo', class:'text-center'},
                { data:  'button', class:'text-center'}
            ]
        });

        $('#semestre').change(function(){ //select options
            userDataTable.draw();
        });
        /*$('#searchName').keyup(function(){//para inputs box
            userDataTable.draw();
        });*/
    });
</script>