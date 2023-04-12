
<style type="text/css">
    .prints{
        background-color: #31B404;
        color:#fff;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Administrar cotizacion</h1>
            <small>Administra tu cotizacion</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#"> Cotización </a></li>
                <li class="active"> Administrar cotización </li>
            </ol>
        </div>
    </section>

    <section class="content">

        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('error_message');
        }
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="column">
         <?php if($this->permission1->method('administrar_almacen_cotizacion','create')->access()){ ?>
             <a href="<?php echo base_url('Cma_cotizacion') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Añadir cotización </a>
         <?php }?>
                </div>
            </div>
        </div>

        <!-- Manage Product report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Administrar cotización</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="list">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Codigo</th>
                                        <th>Fecha</th>
                                        <th>Cotizaciones</th>
                                        <th><div align="center">Acción</div></th>
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
<!-- Manage Product End -->
<script type="text/javascript">
$(document).ready(function() { 

    $('#list').DataTable({
             responsive: true,

             "aaSorting": [[ 1, "asc" ]],
             "columnDefs": [
                 { "bSortable": false, "aTargets": [0,2,3] },

                 {
                     targets: [3],
                     searchable: false,
                     orderable: false,
                     render: function(data, type, full, meta) {
                         var string = "";
                         if (data == null){
                             string = data;
                         } else {
                             var proveedor = data.split(';');
                             $.each(proveedor, function( index, value ) {
                                 var subproveedor = value.split(',');
                                 string += subproveedor[1] + ' <a href="print_cotizacion_individual/' + full.id + '/' + subproveedor[0] + ' " class="btn btn-purple btn-xs" data-toggle="tooltip" data-placement="left" title=" Ver " target="_blank">' +
                                     '<i class="fa fa-eye" aria-hidden="true"></i></a><br>';
                             });
                         }

                         return string;
                     }
                 }

            ],
           'processing': true,
           'serverSide': true,


            
            'serverMethod': 'post',
            'ajax': {
               'url':'<?=base_url()?>Cma_cotizacion/dataList'
            },
          'columns': [
             { data: 'sl' },
             { data: 'codigo' },
             { data: 'fecha_formateada'},
             { data: 'id_proveedor' },
             { data: 'button'},
          ],

    });

});




</script>
