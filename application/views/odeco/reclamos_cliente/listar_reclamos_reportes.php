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
            <h1><?php echo display('manage_claims') ?></h1>
            <small><?php echo display('manage_your_claim') ?></small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active"><?php echo display('manage_claims') ?></li>
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
                          <li class="active"><a href="#"><i class="ti-align-justify"> </i> FILTRAR REGISTRO DE RECLAMOS POR FECHA O NRO. DE CUENTA</a></li>   
                        </ul>
                           
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body"> 
                            <?php echo form_open('odeco/listar_reclamos_reportes_list', array('class' => '', 'id' => 'validate')) ?>
                            <?php $today = date('Y-m-d'); ?>

                            <div class="form-group row">
                                    <label for="from_date " class="col-sm-2 col-form-label">Buscar por fecha <?php echo display('from') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" name="from_date"  value="<?php echo (!empty($start)?$start:$today); ?>" class="datepicker form-control" id="from_date"/>
                                    </div>
                                     <label for="to_date" class="col-sm-1 col-form-label"> <?php echo display('to') ?></label>
                                    <div class="col-sm-2">
                                        <input type="text" name="to_date" value="<?php echo (!empty($end)?$end:$today); ?>" class="datepicker form-control" id="to_date"/>
                                    </div>
                                    <div class="col-sm-2 text-center">
                                      <button type="submit" class="btn btn-success "><i class="fa fa-search-plus" aria-hidden="true"></i> <?php echo display('search') ?></button>
                                  </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                        <div class="panel-body"> 
                            <?php echo form_open('odeco/listar_reclamos_reportes_por_cuenta', array('class' => '', 'id' => 'validate')) ?>
                            <div class="form-group row">
                                    <label for="nro_cuenta" class="col-sm-2 col-form-label">Buscar por Nro de Cuenta:</label>
                                    <div class="col-sm-2">
                                        <input type="text" name="nro_cuenta"  placeholder="Introducir Nro, de Cuenta" class="form-control" id="nro_cuenta"/>
                                    </div>
                                <div class="col-sm-2 text-center">
                                    <button type="submit" class="btn btn-success "><i class="fa fa-search-plus" aria-hidden="true"></i> <?php echo display('search') ?></button>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                     <div class="col-md-12">

                        <div class="panel panel-primary">
                           <div class="panel-body text-center">
                                <div class="table-responsive">
                                    <?php if (!empty($reclamos)) { ?>
                                   <table class="table table-bordered table-striped table-hover" id="Tabla_reportes">
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
                                            <th class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($reclamos) {
                                            foreach ($reclamos as $key => $valor) { ?>
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
                                                    <td class="text-center"><?= $valor['TIEMPO_TRAMITE']; ?></td>
                                                    <td class="text-center"><?= $valor['ESTADO']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }else{
                                        ?>
                                        <tr><td colspan="7"><center>No Record Found</center></td></tr>
                                        
                                        <?php }?>
                                    
                                    </tbody>
                                </table>
                            <?php }else{ echo 'No hay Registros en la Busqueda';}?>
                                </div>
                             </div>
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
      $('#Tabla_reportes').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "pdf",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Exportar PDF', orientation:'landscape'},
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Exportar Excel'},
                    {extend: "print",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13]}, title: "Lista de Reclamos Atendidos", className: "btn-success", text:'Imprimir'}
            ],
            ordering: true,
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay registros de reclamos",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Reclamos",
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


/*

var mydatatable = $('#InvList').DataTable({ 
             responsive: true,

             "aaSorting": [[ 1, "desc" ]],
             "columnDefs": [
                { "bSortable": false, "aTargets": [0,2,3,4,5,6] },

            ],
           'processing': true,
           'serverSide': true,

          
           'lengthMenu':[[10, 25, 50,100,250,500, "<?php echo $total_invoice;?>"], [10, 25, 50,100,250,500, "All"]],

             dom:"'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip", buttons:[ {
                extend: "copy",exportOptions: {
                       columns: [ 0, 1, 2, 3,4,5 ] //Your Colume value those you want
                           }, className: "btn-sm prints"
            }
            , {
                extend: "csv", title: "InvoiceList",exportOptions: {
                       columns: [ 0, 1, 2, 3,4,5] //Your Colume value those you want print
                           }, className: "btn-sm prints"
            }
            , {
                extend: "excel",exportOptions: {
                       columns: [ 0, 1, 2, 3,4,5] //Your Colume value those you want print
                           }, title: "InvoiceList", className: "btn-sm prints"
            }
            , {
                extend: "pdf",exportOptions: {
                       columns: [ 0, 1, 2, 3,4,5 ] //Your Colume value those you want print
                           }, title: "<?php echo $company_info[0]['company_name']?>\n<?php echo $company_info[0]['address']?>\n Invoice List", className: "btn-sm prints"
            }
            , {
                extend: "print",exportOptions: {
                       columns: [ 0, 1, 2, 3,4,5 ] //Your Colume value those you want print
                           }, title: "<center><?php echo $company_info[0]['company_name']?>\n<br><?php echo $company_info[0]['address']?>\n<br> Invoice List</center>", className: "btn-sm prints"
            }
            ],

            
            'serverMethod': 'post',
            'ajax': {
               'url':'<?=base_url()?>Cinvoice/CheckInvoiceList',
                 "data": function ( data) {
         data.fromdate = $('#from_date').val();
         data.todate = $('#to_date').val();

//data.status = $('#status').val();
}
            },
          'columns': [
             { data: 'sl' },
             { data: 'invoice' },
             { data: 'salesman' },
             { data: 'customer_name'},
             { data: 'final_date' },
             { data: 'total_amount',class:"total_sale"},
             { data: 'button'},
          ],

  "footerCallback": function(row, data, start, end, display) {
  var api = this.api();
   api.columns('.total_sale', {
    page: 'current'
  }).every(function() {
    var sum = this
      .data()
      .reduce(function(a, b) {
        var x = parseFloat(a) || 0;
        var y = parseFloat(b) || 0;
        return x + y;
      }, 0);
    $(this.footer()).html(sum.toFixed(2, 2));
  });
}


    });


$('#btn-filter').click(function(){ 
mydatatable.ajax.reload();  
});

});
*/
   
</script>