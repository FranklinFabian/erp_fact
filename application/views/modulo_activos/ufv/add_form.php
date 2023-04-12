<!-- Add new  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Parametricas</h1>
            <small>Ufv</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Parametricas</a></li>
                <li class="active">Ufv</li>
            </ol>
        </div>
    </section>

    <section class="content">
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Ufv</h4>
                        </div>
                    </div>
                   
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#lists"><i class="ti-align-justify"> </i>Administrar Ufvs</a></li>
                            <li><a data-toggle="tab" href="#add"><i class="fa fa-plus"> </i> Añadir Ufvs</a></li>
                        </ul>


<div class="tab-content">

  <div id="lists" class="tab-pane fade in active">
    <div class="row" style="padding: 20px;">
         <div class="table-responsive">
                                <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list) {
                                        ?>
                                        {list}
                                        <tr>
                                            <td class="text-center">{fecha_formateada}</td>
                                            <td class="text-center">{valor}</td>
                                            <td>
                                    <center>
                                        <?php echo form_open() ?>
             <?php if($this->permission1->method('administrar_activos_ufv','update')->access()){ ?>
                                        <a href="<?php echo base_url() . 'Cmactivos_ufv/update_form/{id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php }?>
              <?php if($this->permission1->method('administrar_activos_ufv','delete')->access()){ ?>
                                        <a href="<?php echo base_url() . 'Cmactivos_ufv/delete/{id}'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Esta seguro de eliminar el registro?')" data-toggle="tooltip" data-placement="right" title="" data-original-title="Borrar "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                         <?php }?>
                                            <?php echo form_close() ?>
                                    </center>
                                    </td>
                                    </tr>
                                    {/list}
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
  </div>

    <div id="add" class="tab-pane fade">
        <div class="row" style="padding: 20px;">
            <?php echo form_open('Cmactivos_ufv/insert', array('class' => 'form-vertical', 'id' => 'insert')) ?>

            <div class="form-group row">
                <label for="date" class="col-sm-3 col-form-label">Fecha: <i class="text-danger">*</i></label>
                <div class="col-sm-6">
                    <?php

                    $fecha = date('d-m-Y');

                    ?>
                    <input class="form-control" type="text" size="50" name="fecha" id="fecha" required value="<?php echo $fecha; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label for="valor" class="col-sm-3 col-form-label">Valor<i class="text-danger">*</i></label>
                <div class="col-sm-6">
                    <input class="form-control" name ="valor" id="nombre" type="text" placeholder="Valor"  required="">
                </div>
            </div>


            <div class="form-group row">
                <div class="col-sm-9" align="right">
                    <input type="submit" id="add" class="btn btn-success btn-large" name="add" value="Guardar" />
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>


</div>

                    </div>
                   
                </div>
            </div>
  
        </div>
    </section>
</div>
<!-- Add new  end -->

<script type="text/javascript">
    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });
    });
</script>



