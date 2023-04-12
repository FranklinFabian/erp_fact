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
            <h1> Administrar Pedidos (Administrativos) </h1>
            <small> Administrar tus Pedidos (Administrativos) </small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Inicio </a></li>
                <li><a href="#">Pedidos administrativos</a></li>
                <li class="active"> Administrar tus Pedidos (Administrativos) </li>
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
         <?php if($this->permission1->method('administrar_pedido_administrativo','create')->access()){ ?>
             <a href="<?php echo base_url('Cma_pedidoadministrativo') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-plus"> </i> Añadir Pedidos (Administrativos) </a>
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
                            <h4> Administrar Pedidos (Administrativos) </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap" style="width:100%" id="dataTable">

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
    var base_url = "<?php echo base_url();?>";
    var table;
    var snippet_datatable = function () {
        var initTable1 = function() {
            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax:{
                    url :  base_url+'/Cma_pedidoadministrativo/dataList/',
                    type : 'POST'
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'codigo', title: 'Codigo' },
                    { data: 'fecha_formateada', title: 'Fecha' },
                    { data: 'uso', title: 'Uso' },
                    { data: 'button', title: 'Acciones'},

                ],
                columnDefs:[
                    {
                        targets: [ 0 ],
                        searchable: false,
                        width: "10px",
                        orderable: false,
                        visible: false
                    },
                    {
                        targets: [ 4 ],
                        searchable: false,
                        orderable: false,
                    },
                ],
            });
        };

        return {

            //main function to initiate the module
            init: function() {
                initTable1();
            }

        };

    }();

    function itemDelete(id){
        swal.fire({
            title: 'Esta seguro de borrar el registro?',
            text: "Recuerde que el registro se eliminará permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!!!',
            cancelButtonText: "No, cancelar"
        }).then(function(result) {
            if (result.value) {
                itemDeleteAction(id);
            }
        });
    }

    function itemDeleteAction(id){
        $.ajax({
            url : base_url+'/Cma_pedidoadministrativo/deletePadre/',
            type: 'POST',
            data: {id:id},
        }).done(function(response){
            console.log(response);
            if  (response == 1){
                table.draw();
                swal.fire({
                    icon: 'success',
                    title: 'El registro fue borrado satisfactoriamente',
                    showConfirmButton: false,
                    timer: 2000
                });
            }else{
                swal.fire({
                    icon: 'error',
                    title: 'Este registro no puede ser eliminado!',
                    text: "Debido a que fue utilizado en uno o mas formularios",
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }

    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });
        $('.select2_general').select2({
            placeholder: "Seleccione una opción"
        });
        snippet_datatable.init();
    });

</script>
