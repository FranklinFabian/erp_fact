<script src='https://www.google.com/recaptcha/api.js'></script>

<!-- Admin login area start-->
<div class="container-center">
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
    $CI = & get_instance();
    $CI->load->model('Web_settings');
    $setting_detail = $CI->Web_settings->retrieve_setting_editdata();
    ?>
    <div class="panel panel-bd">
        <div class="panel-heading">
            <div class="view-header">
                <div class="header-icon">
                    <i class="pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Iniciar Sesión</h3>
                    <small><strong>Por favor ingrese sus credenciales</strong></small>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php echo form_open('Admin_dashboard/do_login', array('id' => 'login',)) ?>
            <div class="form-group">
                <label class="control-label" for="username">Correo electrónico</label>
                <input type="email" placeholder="Correo electrónico" title="Correo electrónico" required="" value="" name="username" id="username" class="form-control">
                <span class="help-block small">Tu correo electrónico único</span>
            </div>
            <div class="form-group">
                <label class="control-label" for="password">Contraseña</label>
                <input type="password" title="Please enter your password" placeholder="Contraseña" required="" value="" name="password" id="password" class="form-control">
                <span class="help-block small">Tu contraseña segura</span>
            </div>

            <div class="form-group text-right" hidden>
                <a href="#"  data-toggle="modal" data-target="#passwordrecoverymodal"><b class="text-right"><?php echo display('forgot_password')?></b></a>
            </div>

            <?php if ($setting_detail[0]['captcha'] == 0 && $setting_detail[0]['site_key'] != null && $setting_detail[0]['secret_key'] != null) { ?>
                <div style="margin-bottom: 10px" class="g-recaptcha" data-sitekey="<?php
                    if (isset($setting_detail[0]['site_key'])) {
                        echo $setting_detail[0]['site_key'];
                    } ?>">
                </div>
            <?php } ?>

            <div class="text-center">
                <button type="submit" class="btn btn-success btn-block" title="Iniciar sesión">Ingresar</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passwordrecoverymodal" tabindex="-1" role="dialog" aria-labelledby="recoverylabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="recoverylabel"><?php echo display('password_recovery')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div id="outputPreview" class="alert hide modal-title" role="alert" >
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <?php echo form_open('Admin_dashboard/password_recovery', array('id' => 'passrecoveryform',)) ?>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?php echo display('email')?> <i class="text-danger">*</i></label>
                        <div class="col-sm-6">
                            <input class="form-control" name ="rec_email" id="email" type="text" placeholder="Correo electrónico"  required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Send">
                </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<!-- Admin login area end -->
<script type="text/javascript">
    var checkoutFrm = $("#passrecoveryform");
    var outputPreview = $('#outputPreview');
    checkoutFrm.on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            method: checkoutFrm.attr('method'),
            url   : checkoutFrm.attr('action'),
            data  :  checkoutFrm.serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == true) {
                    outputPreview.removeClass("hide").removeClass("alert-danger").addClass('alert-success').html(data.success);
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload();
                    }, 5000);
                } else {
                    outputPreview.removeClass("hide").removeClass("alert-danger").addClass('alert-danger').html(data.exception);
                }
            },
            error: function(xhr) {
                alert('some error here!');
            }
        });
    });
</script>
