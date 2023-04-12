<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/admin/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="<?php echo base_url() ?>assets/plugins/admin/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/plugins/admin/jquery/jquery.min.js"></script>

    <!-- VUEJS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script>
        var BASE_URL = "<?php echo base_url() ?>";
        var BASE_URL_REST = "<?php echo base_url() ?>rest/";
    </script>

    <!-- Grocery Crud -->
    <?php (isset($grocery_crud)) ? $this->load->view("layout/grocery_crud_header", array("grocery_crud" => $grocery_crud)) : '' ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed accent-navy text-sm">
<div class="wrapper">

    <!-- Navbar -->
    <?php $this->load->view('layout/navbar'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php $this->load->view('layout/sidebar'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <?php $this->load->view('layout/header'); ?>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <?php if (isset($content)): ?>
                    {content}
                <?php endif; ?>
                <?php (isset($grocery_crud)) ? $this->load->view("layout/grocery_crud", array("grocery_crud" => $grocery_crud)) : '' ?>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php $this->load->view('layout/footer'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/plugins/admin/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url() ?>assets/plugins/admin/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/js/admin/adminlte.js"></script>

<script>
    $(document).ready(function () {
        // Append a caption to the table before the DataTables initialisation
        $('#dataTableExample3').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');

        $("#dataTableExample3").DataTable( {
            responsive: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp", "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn-sm prints'
                },

                {
                    extend: 'csv',
                    title: 'ExampleFile',
                    className: 'btn-sm prints',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    }
                },

                {
                    extend: 'excel',
                    title: 'ExampleFile',
                    className: 'btn-sm prints',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    }
                },

                {
                    extend: 'pdf',
                    title: 'ExampleFile',
                    className: 'btn-sm prints',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    }
                },

                {
                    extend: 'print',
                    className: 'btn-sm prints',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                        modifier: {
                            page: 'current'
                        }
                    }
                }
            ],
            order: [0, 'desc'],
        } );
    });
</script>
</body>
</html>
