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
            <h1>Gesti&oacute;n de Restitucion de Suministros en MT</h1>
            <small>Listar Restitucion de Suministros en MT</small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Listar Restitucion de Suministros en MT</li>
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
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> VER LISTA DE RESTITUCION DE SUMINISTROS MT</a></li>   
                              <li id="semestre_1"><a href="<?php echo base_url(); ?>odeco/agregar_restitucion_mt/<?= $semestre[0]['Sigla']; ?>"><i class="fa fa-plus"> </i> A&Ntilde;ADIR RESTITUCION DE SUMINISTRO MT</a></li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div>
                                <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true" onchange="Semestre(this);">
                                            <option value="<?= $semestre[0]['Sigla']; ?>" selected=""><?= $semestre[0]['Sigla']; ?></option>
                                            <?php foreach ($listar_semestres as $list) { ?>
                                            <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div><br><br>
                            <table id="Tabla_restitucion" class="table table-bordered table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nro. Interrupci&oacute;n</th>
                                        <th class="text-center">Fecha y Hora Int.</th>
                                        <th class="text-center">Nro. Restituci&oacute;n</th>
                                        <th class="text-center">Nro. Cuenta</th>
                                        <th class="text-center">Fecha Reposici&oacute;n</th>
                                        <th class="text-center">Tiempo</th>
                                        <th class="text-center">Observaci&oacute;n</th>
                                        <th class="text-center">Fecha Registro</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <!-- <tbody>
                                    <?php
                                    if ($restituciones_list) { 
                                        foreach ($restituciones_list as $key => $valor) {
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
                                            <td>
                                            <center>
                                                <?php echo form_open() ?>
                                                <a href="<?php echo base_url().'odeco/ver_editar_restitucion_mt/'.urlencode($valor['NRO_REPOSICION']); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Ver/Editar Restitucion MT"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php if($this->permission1->method('manage_claims','delete')->access()){ ?>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRestitucion('<?= urlencode($valor['NRO_REPOSICION']); ?>');" data-toggle="tooltip" data-placement="right" title="Anular Restitucion MT"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
$(document).ready(function () {
        var userDataTable = $('#Tabla_restitucion').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8]}, title: "Lista de Reposicion de Suministro MT", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            "aaSorting": [[ 8, "desc" ]],
             "columnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,9]}
            ],
            info:true,
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
            },
            lengthMenu:[10, 25, 50,100, 500, "All"],
            //section AJAX RENDER
            searchDelay: 500,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
              'url':'<?php echo base_url(); ?>odeco/listar_restituciones_mt_ajax',
              'data': function(data){
                    data.searchSemestre = $('#semestre').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data:  'nro_interrupcion', class:'text-center'},
                { data:  'fecha_hora_int', class:'text-center'},
                { data:  'nro_reposicion', class:'text-center'},
                { data:  'nro_cuenta', class:'text-center'},
                { data:  'fecha_hora_repos', class:'text-center'},
                { data:  'tiempo', class:'text-center'},
                { data:  'observacion', class:'text-center'},
                { data:  'fecha_registro', class:'text-center'},
                { data:  'button', class:'text-center'}
            ]
        });
        $('#semestre').change(function(){ //select options
            userDataTable.draw();
        });
});

    function EliminarRestitucion(nro_reposicion)
    {
        Swal.fire(
        {
            title: 'Esta seguro de Eliminar el Registro?',
            text: "Esta accion no puede ser revertido!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    data: {nro_reposicion},
                    url: '<?php echo base_url(); ?>odeco/anular_restitucion_mt',
                    type: 'POST',
                    dataType: 'json'
                    })
                .done(function(response)
                    {
                        Swal.fire(
                            {
                                icon: 'success',
                                title: 'Se elimin&oacute; exitosamente el Registro'
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones_mt";
                            });
                    })
                .fail(function(response)
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones_mt";
                            });
                    });
            }
        });
    }    
    function Semestre()
    {
        var semestre = $('#semestre').val();
        $('#semestre_1 a').remove();
        var sethref = '<a href="<?php echo base_url(); ?>odeco/agregar_restitucion_mt/'+semestre+'"><i class="fa fa-plus"> </i> A&Ntilde;ADIR RESTITUCION DE SUMINISTRO</a>';
        $('#semestre_1').prepend(sethref);

    }  

</script>