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
            <h1>Listado - Cronograma de Instalacion de Equipos</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">Odeco</a></li>
                <li class="active">Listado - Cronograma de Instalacion de Equipos</li>
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
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> VER LISTA DE CRONOGRAMA DE INSTALACION DE EQUIPOS</a></li>   
                              <li><a href="<?php echo base_url(); ?>odeco/agregar_cronograma"><i class="fa fa-plus"> </i> A&Ntilde;ADIR REGISTRO</a></li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="Tabla_cronograma" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">C&oacute;digo AE</th>
                                        <th class="text-center">Nro. ID</th>
                                        <th class="text-center">Fecha Instalaci&oacute;n</th>
                                        <th class="text-center">Fecha Retiro</th>
                                        <th class="text-center">Tipo Medici&oacute;n</th>
                                        <th class="text-center">Nro. Medici&oacute;n</th>
                                        <th class="text-center">Observaci&oacute;n</th>
                                        <th class="text-center">Fecha Registro</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($listar_cronogramas) { 
                                        foreach ($listar_cronogramas as $key => $valor) {
                                        ?>
                                        <tr>
                                            <td><?= $key+1; ?></td>
                                            <td class="text-center"><?= $valor['CODIGO_AE']; ?></td>
                                            <td class="text-center"><?= $valor['NRO_ID']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_HORA_INST'])); ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_HORA_RET'])); ?></td>
                                            <td class="text-center"><?= $valor['TIPO_MEDICION']; ?></td>
                                            <td class="text-center">0</td>
                                            <td class="text-center"><?= $valor['OBSERVACION']; ?></td>
                                            <td class="text-center"><?= date('d/m/Y H:i',strtotime($valor['FECHA_REGISTRO'])); ?></td>
                                            <td>
                                            <center>
                                                <?php echo form_open() ?>
                                                <a href="<?php echo base_url().'odeco/ver_editar_cronograma/'.urlencode($valor['CODIGO_AE']); ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <?php if($this->permission1->method('manage_claims','delete')->access()){ ?>
                                                <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRegistro('<?= urlencode($valor['CODIGO_AE']); ?>');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                <?php }?>
                                                <?php echo form_close() ?>
                                            </center>
                                            </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Delete Category ajax code -->
<script type="text/javascript">
$(document).ready(function () {
    $('#Tabla_cronograma').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8]}, title: "Lista de Cronograma de Instalacion", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Cronogramas Registrados",
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
            lengthMenu:[10, 25, 50,100]
        });
});
    function EliminarRegistro(cod_ae)
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
                    data: {cod_ae},
                    url: '<?php echo base_url(); ?>odeco/anular_cronograma',
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
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_cronogramas";
                            });
                    })
                .fail(function(response)
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_cronogramas";
                            });
                    });
            }
        });
    }    
</script>