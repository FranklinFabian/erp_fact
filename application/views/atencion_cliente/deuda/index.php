<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-users"></i>
        </div>
        <div class="header-title">
            <h1>Facturación</h1>
            <small>Abonados</small>
            <?php echo $this->breadcrumb->render(); ?>
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
                <div class="panel panel-bd lobidrag">
                    <div class="panel-body">

                        <?php echo form_open_multipart('FactFactura/generar',array('class' => 'form-vertical','id' => 'tax_settings' ))?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <label for="costo">Abonado:</label>
                                        <input type="text" class="form-control" id="abonado" name="abonado">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <label for="costo">Emisión:</label>
                                        <select class="form-control dont-select-me" name="emision" id="emision">
                                            <option value="<?php echo $emision->Id_Emision ?>"><?php echo $emision->Emision ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-form">
                                        <input type="submit" id="add-settings" class="btn btn-success" name="add-settings" value="Calcular" />
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close()?>

                    </div>
                </div>
            </div>
        </div>



    </section>
</div>













