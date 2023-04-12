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
            <h1>Gesti&oacute;n de Restitucion de Suministros</h1>
            <small>Listar Restitucion de Suministros</small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Listar Restitucion de Suministros</li>
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
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> VER LISTA DE RESTITUCION DE SUMINISTROS</a></li>   
                              <li id="semestre_1"><a href="<?php echo base_url(); ?>odeco/agregar_restitucion/<?= $semestre[0]['Sigla']; ?>"><i class="fa fa-plus"> </i> A&Ntilde;ADIR RESTITUCION DE SUMINISTRO</a></li>
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
                                        <th class="text-center">Nro. Rest.</th>
                                        <th class="text-center">Nro. Int.</th>
                                        <th class="text-center">Cod. Protec.</th>
                                        <th class="text-center">Fecha Reposici&oacute;n</th>
                                        <th class="text-center">Cons.Rep.BT1</th>
                                        <th class="text-center">Cons.Rep.BT2</th>
                                        <th class="text-center">Cons.Rep.MT1</th>
                                        <th class="text-center">Cons.Rep.MT2</th>
                                        <th class="text-center">Pot.Rep.BT1</th>
                                        <th class="text-center">Pot.Rep.BT2</th>
                                        <th class="text-center">Pot.Rep.MT1</th>
                                        <th class="text-center">Pot.Rep.MT2</th>
                                        <th class="text-center">Tiempo</th>
                                        <th class="text-center">Motivo</th>
                                        <th class="text-center">Observaci&oacute;n</th>
                                        <th class="text-center">Fecha Reg.</th>
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
                                            <td class="text-center"><?= $valor['NRO_REPOSICION']; ?></td>
                                            <td class="text-center"><?= $valor['NRO_INTERRUPCION']; ?></td>
                                            <td class="text-center"><?= $valor['COD_PROTECCION']; ?></td>
                                            <td class="text-center"><?= $valor['FECHA_HORA_REPOS']; ?></td>
                                            <td class="text-center"><?= $valor['CONSUM_REP_BT_1']; ?></td>
                                            <td class="text-center"><?= $valor['CONSUM_REP_BT_2']; ?></td>
                                            <td class="text-center"><?= $valor['CONSUM_REP_MT_1']; ?></td>
                                            <td class="text-center"><?= $valor['CONSUM_REP_MT_2']; ?></td>
                                            <td class="text-center"><?= $valor['KVA_RESPUESTA_BT_1']; ?></td>
                                            <td class="text-center"><?= $valor['KVA_RESPUESTA_BT_2']; ?></td>
                                            <td class="text-center"><?= $valor['KVA_RESPUESTA_MT_1']; ?></td>
                                            <td class="text-center"><?= $valor['KVA_RESPUESTA_MT_2']; ?></td>
                                            <td class="text-center"><?= $valor['TIEMPO']; ?></td>
                                            <td class="text-center"><?= $valor['MOTIVO']; ?></td>
                                            <td class="text-center"><?= $valor['OBSERVACION']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_REGISTRO'])); ?></td>
                                            <td>
                                            <center>
                                                <?php echo form_open() ?>
                                                <a href="<?php echo base_url().'odeco/ver_editar_restitucion/'.urlencode($valor['NRO_REPOSICION']); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Ver/Editar Restitucion"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php if($this->permission1->method('manage_claims','delete')->access()){ ?>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRestitucion('<?= urlencode($valor['NRO_REPOSICION']); ?>');" data-toggle="tooltip" data-placement="right" title="Anular Restitucion"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
        var userDataTable = $('#Tabla_restitucion').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]}, title: "Lista de Restituciones de Suministros", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            "aaSorting": [[ 16, "desc" ]],
             "columnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,17]}
            ],
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Restituciones de Suministros Registrados",
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
              'url':'<?php echo base_url(); ?>odeco/listar_restituciones_ajax',
              'data': function(data){
                    data.searchSemestre = $('#semestre').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data:  'nro_reposicion', class:'text-center'},
                { data:  'nro_interrupcion', class:'text-center'},
                { data:  'cod_proteccion', class:'text-center'},
                { data:  'fecha_hora_repos', class:'text-center'},
                { data:  'consum_rep_bt_1', class:'text-center'},
                { data:  'consum_rep_bt_2', class:'text-center'},
                { data:  'consum_rep_mt_1', class:'text-center'},
                { data:  'consum_rep_mt_2', class:'text-center'},
                { data:  'kva_respuesta_bt_1', class:'text-center'},
                { data:  'kva_respuesta_bt_2', class:'text-center'},
                { data:  'kva_respuesta_mt_1', class:'text-center'},
                { data:  'kva_respuesta_mt_2', class:'text-center'},
                { data:  'tiempo', class:'text-center'},
                { data:  'motivo', class:'text-center'},
                { data:  'observacion', class:'text-center'},
                { data:  'fecha_registro', class:'text-center'},
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
    function EliminarRestitucion(nro_restitucion)
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
                    data: {nro_restitucion},
                    url: '<?php echo base_url(); ?>odeco/anular_restitucion',
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
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones";
                            });
                    })
                .fail(function(response)
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_restituciones";
                            });
                    });
            }
        });
    }    
    function Semestre()
    {
        var semestre = $('#semestre').val();
        $('#semestre_1 a').remove();
        var sethref = '<a href="<?php echo base_url(); ?>odeco/agregar_restitucion/'+semestre+'"><i class="fa fa-plus"> </i> A&Ntilde;ADIR RESTITUCION DE SUMINISTRO</a>';
        $('#semestre_1').prepend(sethref);

    }  
</script>