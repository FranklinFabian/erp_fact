<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Parametrica</h1>
            <small>Valor certificado</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Parametrica</a></li>
                <li class="active">Valor certificado</li>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Valor certificado</h4>
                        </div>
                    </div>
                   
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#lists"><i class="ti-align-justify"> </i> Administrar el valor del certificado </a></li>
                            <!-- <li><a data-toggle="tab" href="#add"><i class="fa fa-plus"> </i> Añadir el valor del certificado </a></li> -->
                        </ul>


<div class="tab-content">

  <div id="lists" class="tab-pane fade in active">
    <div class="row" style="padding: 20px;">
         <div class="table-responsive">
                                <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list) {
                                        ?>
                                        {list}
                                        <tr>
                                            <td class="text-center">{monto}</td>
                                            <td>
                                    <center>
                                        <?php echo form_open() ?>
             <?php if($this->permission1->method('administrar_gestion_asociado_valor_certificado','update')->access()){ ?>
                                        <a href="<?php echo base_url() . 'Cga_valor_certificado/update_form/{id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="<?php echo display('update') ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php }?>
              <?php if($this->permission1->method('administrar_gestion_asociado_valor_certificado','delete')->access()){ ?>
                                        <!-- <a href="<?php echo base_url() . 'Cga_valor_certificado/delete/{id}'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Esta seguro de eliminar el registro?')" data-toggle="tooltip" data-placement="right" title="" data-original-title="<?php echo display('delete') ?> "><i class="fa fa-trash-o" aria-hidden="true"></i></a> -->
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
            <?php echo form_open('Cga_valor_certificado/insert', array('class' => 'form-vertical', 'id' => 'insert')) ?>

            <div class="form-group row">
                <label for="nombre" class="col-sm-3 col-form-label"> Nombre <i class="text-danger">*</i></label>
                <div class="col-sm-6">
                    <input class="form-control" name ="nombre" id="nombre" type="text" placeholder="Nombre"  required="">
                </div>
            </div>

            <div class="form-group row">
                <label for="descripcion" class="col-sm-3 col-form-label"> Descripción</label>
                <div class="col-sm-6">
                    <textarea class="form-control" tabindex="4" id="descripcion" name="descripcion" placeholder=" Descripción " rows="1" autocomplete="off"></textarea>
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




