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
            <h1>Gesti&oacute;n de Cortes Programados</h1>
            <small>Listar Cortes Programados</small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Listar Cortes programados</li>
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
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> VER LISTA DE CORTES PROGRAMADOS</a></li>   
                              <li><a href="<?php echo base_url(); ?>odeco/agregar_corte"><i class="fa fa-plus"> </i> A&Ntilde;ADIR CORTE A PROGRAMAR</a></li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div>
                                <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true">
                                            <option value="<?= $semestre[0]['Sigla']; ?>" selected=""><?= $semestre[0]['Sigla']; ?></option>
                                            <?php foreach ($listar_semestres as $list) { ?>
                                            <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div><br><br>
                            <table id="Tabla_cortes" class="table table-bordered table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Nro Programado</th>
                                        <th class="text-center">Cod. Alimentador</th>
                                        <th class="text-center">Cod. Protecci&oacute;n</th>
                                        <th class="text-center">Fecha Inicial</th>
                                        <th class="text-center">Fecha Final</th>
                                        <th class="text-center">Cod. Origen</th>
                                        <th class="text-center">Cod. Causa</th>
                                        <th class="text-center">Tiempo Interr.</th>
                                        <th class="text-center">Kva Interrumpida</th>
                                        <th class="text-center">Consum. Afectados</th>
                                        <th class="text-center">Fecha Registro</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
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
        var userDataTable = $('#Tabla_cortes').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11]}, title: "Lista de Cortes Programados", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            "aaSorting": [[ 11, "desc" ]],
             "columnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,6,7,8,12]}
            ],
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Cortes Programados Registrados",
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
              'url':'<?php echo base_url(); ?>odeco/listar_cortes_ajax',
              'data': function(data){
                    data.searchSemestre = $('#semestre').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data:  'nro_programado', class:'text-center'},
                { data: 'cod_alimentador', class:'text-center'},
                { data:  'cod_proteccion', class:'text-center'},
                { data:  'fecha_hora_ini', class:'text-center'},
                { data:  'fecha_hora_fin', class:'text-center'},
                { data:  'descripcion_origen', class:'text-center'},
                { data:  'descripcion_causa', class:'text-center'},
                { data:  'tiempo_interrump', class:'text-center'},
                { data:  'kva_interrump', class:'text-center'},
                { data:  'consum_afectados', class:'text-center'},
                { data: 'fecha_registro', class:'text-center'},
                { data: 'button', class:'text-center'}
            ]
        });

        $('#semestre').change(function(){ //select options
            userDataTable.draw();
        });
        /*$('#searchName').keyup(function(){//para inputs box
            userDataTable.draw();
        });*/
    });
    function EliminarCorte(nro_programado)
    {
        Swal.fire(
        {
            title: 'Esta seguro de Eliminar el Corte Programado?',
            text: "Esta accion no puede ser revertido!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    data: {nro_programado},
                    url: '<?php echo base_url(); ?>odeco/anular_corte',
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
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_cortes";
                            });
                    })
                .fail(function(response)
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_cortes";
                            });
                    });
            }
        });
    }    
</script>