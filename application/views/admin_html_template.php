<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo (isset($title)) ? $title : "ERP | Progreso Consulting Group S.R.L." ?></title>
    <?php
    $CI = &get_instance();
    $CI->load->model('Web_settings');
    $Web_settings = $CI->Web_settings->retrieve_setting_editdata();
    date_default_timezone_set($Web_settings[0]['timezone']);
    ?>
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php
    if (isset($Web_settings[0]['logo'])) {
        echo $Web_settings[0]['favicon'];
    }
    ?>" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo base_url() ?>assets/dist/img/ico/apple-touch-icon-144-precomposed.png">
    <!-- Start Global Mandatory Style-->

    <!-- jquery-ui css -->
    <link href="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <!-- Bootstrap -->
    <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <!-- Facturación module dependecy -->
    <link href="<?php echo base_url() ?>assets/css/fact/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/plugins/animate/animate.css" rel="stylesheet" type="text/css"/>

    <!-- modals css -->
    <!-- TODO verificar impacto porque se quito los estilos para container -->
    <link href="<?php echo base_url() ?>assets/plugins/modals/component.css" rel="stylesheet" type="text/css"/>
    <?php
    if ($Web_settings[0]['rtr'] == 1) { ?>
        <!-- Bootstrap rtl -->
        <link href="<?php echo base_url() ?>assets/bootstrap-rtl/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
        <?php
    }
    ?>
    <!-- Font Awesome -->
    <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!--<link href="--><?php //echo base_url() ?><!--assets/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>-->
    <!-- TODO verificar impacto porque se quito el fondo naranja para los inputs -->
    <link href="<?php echo base_url() ?>assets/css/cmxform.css" rel="stylesheet" type="text/css"/>
    <!-- Themify icons -->
    <link href="<?php echo base_url() ?>assets/themify-icons/themify-icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Pe-icon -->
    <link href="<?php echo base_url() ?>assets/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css"/>
    <!-- Data Tables -->
    <link href="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="<?php echo base_url() ?>assets/dist/css/styleBD.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <?php
    if ($Web_settings[0]['rtr'] == 1) {
        ?>
        <!-- Theme style rtl -->
        <link href="<?php echo base_url() ?>assets/dist/css/styleBD-rtl.css" rel="stylesheet" type="text/css"/>
        <?php
    }
    ?>

    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/plugins/jQuery/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js" type="text/javascript"></script>

    <!-- DateTime picker -->
    <link href="<?php echo base_url() ?>assets/plugins/datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>assets/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>

    <!-- Vuejs js-->
    <link href="<?php echo base_url() ?>my-assets/js/vue/commons/autocomplete/autocomplete.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/javascript-debounce@1.0.1/dist/javascript-debounce.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

    <script src="<?php echo base_url() ?>my-assets/js/vue/commons/autocomplete/Autocomplete.js"></script>
    <script src="<?php echo base_url() ?>my-assets/js/vue/commons/Datepicker.js"></script>
    <script src="<?php echo base_url() ?>my-assets/js/vue/commons/vue-plain-pagination.umd.min.js"></script>

    <script>
        var MONTH_NAMES = <?php echo json_encode(MONTH_NAMES) ?>;
        var BASE_URL = "<?php echo base_url() ?>";
        var BASE_URL_REST = "<?php echo base_url() ?>rest/";
    </script>

    <!-- Moment JS -->
    <script src="<?php echo base_url(); ?>assets/js/moment/moment.js" type="text/javascript"></script>
    <!-- Sweet alert JS -->
    <script src="<?php echo base_url(); ?>assets/js/sweet-alert/sweetalert.js"></script>
    <!-- ERP JS -->
    <script src="<?php echo base_url() ?>my-assets/js/erp.js"></script>
    <!-- ERP CSS -->
    <link href="<?php echo base_url() ?>my-assets/css/erp.css" rel="stylesheet" type="text/css"/>

    <!-- Grocery Crud -->
    <?php (isset($grocery_crud)) ? $this->load->view("include/grocery_crud_header", ["grocery_crud" => $grocery_crud]) : '' ?>

</head>
<body class="hold-transition sidebar-mini">
<div class="se-pre-con"></div>

<!-- Site wrapper -->
<div class="wrapper">
    <?php
    $url = $this->uri->segment(2);
    if ($url != "login") {
        $this->load->view('include/admin_header');
    }
    ?>
    <?php if (isset($content)): ?>
        {content}
    <?php endif; ?>

    <?php
    if ($url != "login") {
        $this->load->view('include/admin_footer');
    }
    ?>
</div>
<!-- ./wrapper -->

<!-- Modal -->
<div class="modal fade" id="ver_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="ver_modal_small" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="ver_modal_ancho" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            ...
        </div>
    </div>
</div>

<!-- Start Core Plugins-->
<!-- jquery-ui -->

<script src="<?php echo base_url() ?>assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<!-- FastClick -->
<script src="<?php echo base_url() ?>assets/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminBD frame -->
<script src="<?php echo base_url() ?>assets/dist/js/frame.min.js" type="text/javascript"></script>
<!-- Sparkline js -->
<script src="<?php echo base_url() ?>assets/plugins/sparkline/sparkline.min.js" type="text/javascript"></script>
<!-- Counter js -->
<script src="<?php echo base_url() ?>assets/plugins/counterup/waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<!-- dataTables js -->
<script src="<?php echo base_url() ?>assets/plugins/datatables/dataTables.min.js" type="text/javascript"></script>

<!-- "Facturacion" module dependecy -->
<script src="<?php echo base_url() ?>assets/js/fact/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/fact/form-wizard.js"></script>

<!-- Funciones -->
<script src="<?php echo base_url() ?>assets/js/admin/funciones.js" type="text/javascript"></script>

<!-- Modal js -->
<script src="<?php echo base_url() ?>assets/plugins/modals/classie.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/modals/modalEffects.js" type="text/javascript"></script>

<!-- Dashboard js -->
<script src="<?php echo base_url() ?>assets/dist/js/dashboard.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/jstree.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/TreeMenu.js" type="text/javascript"></script>

<!-- Librerias Modulo Gestión de Asociados-->
<!-- Librerias Modulo Almacen-->

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Mask Number -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<!-- Parsley JS -->
<script src="<?php echo base_url();?>assets/js/parsley.min.js"></script>
<script type="text/javascript">
    // Facturación - Dependencias
    jQuery(document).ready(function () {
        FormWizard.init();
    });
    // fin de Facturación

    $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
    $(".datetimepicker").datetimepicker({format: 'Y-m-d H:i:s'});
    $.datetimepicker.setLocale('es');


    // select 2 dropdown
    $("select.form-control:not(.dont-select-me)").select2({
        placeholder: "Select option",
        allowClear: true
    });

    //Insert supplier
    $("#insert_supplier").validate();
    $("#validate").validate();

    //Update supplier
    $("#supplier_update").validate();

    //Update customer
    $("#customer_update").validate();

    //Insert customer
    $("#insert_customer").validate();

    //Update product
    $("#product_update").validate();

    //Insert product
    $("#insert_product").validate();

    //Insert pos invoice
    $("#insert_pos_invoice").validate();

    //Insert invoice
    $("#insert_invoice").validate();

    //Update invoice
    $("#invoice_update").validate();

    //Insert purchase
    $("#insert_purchase").validate();

    //Update purchase
    $("#purchase_update").validate();

    //Add category
    $("#insert_category").validate();

    //Update category
    $("#category_update").validate();

    //Stock report
    $("#stock_report").validate();

    //Stock report
    $("#stock_report_supplier_wise").validate();
    //Stock report
    $("#stock_report_product_wise").validate();

    //Create account
    $("#create_account_data").validate();

    //Update account
    $("#update_account_data").validate();

    //Inflow entry
    $("#inflow_entry").validate();

    //Outflow entry
    $("#outflow_entry").validate();

    //Tax entry
    $("#tax_entry").validate();

    //Update tax
    $("#update_tax").validate();

    //Account summary
    $("#summary_datewise").validate();
    //Comission generate
    $("#commission_generate").validate();

</script>

</body>
</html>
