<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>


<div class="content-wrapper" id="app-invoice">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('new_invoice') ?></h1>
            <small><?php echo display('add_new_invoice') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('invoice') ?></a></li>
                <li class="active"><?php echo display('new_invoice') ?></li>
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
                    <?php if ($this->permission1->method('manage_invoice', 'read')->access()) { ?>
                        <a href="<?php echo base_url('Cinvoice/manage_invoice') ?>" class="btn btn-info m-b-5 m-r-2"><i
                                    class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a>
                    <?php } ?>
                    <?php if ($this->permission1->method('pos_invoice', 'create')->access()) { ?>
                        <a href="<?php echo base_url('Cinvoice/pos_invoice') ?>" class="btn btn-primary m-b-5 m-r-2"><i
                                    class="ti-align-justify"> </i> <?php echo display('pos_invoice') ?> </a>
                    <?php } ?>

                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-12">
                <?php echo $cc;?>
                {{ message }}
                <formulario></formulario>

            </div>
        </div>




    </section>
</div>

<!-- Vuejs -->
<script src="<?php echo base_url() ?>my-assets/js/vue/components/cofi/formulario.js"></script>













