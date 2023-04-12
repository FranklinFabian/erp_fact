<!-- Add new  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Parametricas</h1>
            <small>Proveedor</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Parametricas</a></li>
                <li class="active">Proveedor</li>
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
                            <h4>Proveedor</h4>
                        </div>
                    </div>
                   
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#lists"><i class="ti-align-justify"> </i>Administrar proveedores</a></li>
                            <li><a data-toggle="tab" href="#add"><i class="fa fa-plus"> </i>Añadir proveedor</a></li>
                        </ul>


<div class="tab-content">

  <div id="lists" class="tab-pane fade in active">
    <div class="row" style="padding: 20px;">
         <div class="table-responsive">
                                <table id="dataTableExample3" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Dirección</th>
                                        <th class="text-center">Telefono</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Ciudad</th>
                                        <th class="text-center">NIT</th>
                                        <th class="text-center">Banco</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($list) {
                                        ?>
                                        {list}
                                        <tr>
                                            <td class="text-center">{nombre}</td>
                                            <td class="text-center">{direccion}</td>
                                            <td class="text-center">{telefono}</td>
                                            <td class="text-center">{correo}</td>
                                            <td class="text-center">{ciudad}</td>
                                            <td class="text-center">{nit}</td>
                                            <td class="text-center">{banco}<br>{cuenta}</td>
                                            <td>
                                    <center>
                                        <?php echo form_open() ?>
             <?php if($this->permission1->method('administrar_almacen_proveedor','update')->access()){ ?>
                                        <a href="<?php echo base_url() . 'Cma_proveedor/update_form/{id}'; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Actualizar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php }?>
              <?php if($this->permission1->method('administrar_almacen_proveedor','delete')->access()){ ?>
                                        <a href="<?php echo base_url() . 'Cma_proveedor/delete/{id}'; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Esta seguro de eliminar el registro?')" data-toggle="tooltip" data-placement="right" title="" data-original-title="Borrar "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
            <?php echo form_open('Cma_proveedor/insert', array('class' => 'form-vertical', 'id' => 'insert')) ?>

            <div class="form-group row">
                <label for="nombre" class="col-sm-3 col-form-label">Nombre<i class="text-danger">*</i></label>
                <div class="col-sm-6">
                    <input class="form-control" name ="nombre" id="nombre" type="text" placeholder="Nombre"  required="">
                </div>
            </div>

            <div class="form-group row">
                <label for="direccion" class="col-sm-3 col-form-label">Dirección</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="direccion" id="direccion" type="text" placeholder="Dirección" >
                </div>
            </div>

            <div class="form-group row">
                <label for="telefono" class="col-sm-3 col-form-label">Telefono</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="telefono" id="telefono" type="text" placeholder="Telefono" >
                </div>
            </div>
            <div class="form-group row">
                <label for="correo" class="col-sm-3 col-form-label">Correo</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="correo" id="correo" type="text" placeholder="Correo" >
                </div>
            </div>

            <div class="form-group row">
                <label for="designation" class="col-sm-3 col-form-div"> Ciudad <i class="text-danger">*</i></label>
                <div class="col-sm-6">
                    <?php echo form_dropdown('id_ciudad',$departamentos,null,'class="form-control" style="width:100%"') ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="nit" class="col-sm-3 col-form-label">Nit</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="nit" id="nit" type="text" placeholder="Nit" >
                </div>
            </div>

            <div class="form-group row">
                <label for="banco" class="col-sm-3 col-form-label">Banco</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="banco" id="banco" type="text" placeholder="Banco" >
                </div>
            </div>

            <div class="form-group row">
                <label for="cuenta" class="col-sm-3 col-form-label">Cuenta</label>
                <div class="col-sm-6">
                    <input class="form-control" name ="cuenta" id="cuenta" type="text" placeholder="Cuenta" >
                </div>
            </div>

            <div class="form-group row">
                <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                <div class="col-sm-6">
                    <textarea class="form-control" tabindex="4" id="descripcion" name="descripcion" placeholder="Descripción" rows="1" autocomplete="off"></textarea>
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




