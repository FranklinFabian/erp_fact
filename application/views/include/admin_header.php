<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$CI->load->model('Reports');
$CI->load->model('Users');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
$users = $CI->Users->profile_edit_data();
$out_of_stock = $CI->Reports->out_of_stock_count();

?>
<!-- Admin header end -->
<style>
    .navbar .btn-success{
        margin: 13px 2px;
    }
    .prints{
        background-color: #31B404;
        color:#fff;
    }
</style>
<header class="main-header">
    <a href="<?php echo base_url() ?>" class="logo">
        <!-- Logo -->
        <span class="logo-mini">
            <!-- <b>A</b>BD -->
            <img src="<?php
                if (isset($Web_settings[0]['favicon'])) {
                    echo $Web_settings[0]['favicon'];
                }
            ?>" alt="">
        </span>

        <span class="logo-lg">
            <!-- <b>Admin</b>BD -->
            <img src="<?php
                if (isset($Web_settings[0]['logo'])) {
                    echo $Web_settings[0]['logo'];
                }
            ?>" alt="">
        </span>
    </a>
    <!-- Header Navbar -->


    <nav class="navbar navbar-static-top text-center">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
            <span class="sr-only">Toggle navigation</span>
            <span class="pe-7s-keypad"></span>
        </a>
        <?php
            $urcolp = '0';
            if ($this->uri->segment(2) =="gui_pos" ) {
                $urcolp = "gui_pos";
            }
            if ($this->uri->segment(2) =="pos_invoice" ) {
                $urcolp = "pos_invoice";
            }
            if ($this->uri->segment(2) != $urcolp ) {
                if (false && $this->permission1->method('new_invoice','create')->access()) {
        ?>
                    <a href="<?php echo base_url('Cinvoice')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-balance-scale"></i> <?php  echo display('invoice') ?></a>
        <?php } ?>

        <?php if (false && $this->permission1->method('customer_receive','create')->access()) { ?>
            <a href="<?php echo base_url('accounts/customer_receive')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money"></i> <?php echo display('customer_receive')?></a>
        <?php } ?>

        <?php if (false && $this->permission1->method('supplier_payment','create')->access()) { ?>
            <a href="<?php echo base_url('accounts/supplier_payment')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money" aria-hidden="true"></i> <?php echo display('supplier_payment')?></a>
        <?php } ?>

        <?php if (false && $this->permission1->method('add_purchase','create')->access()) { ?>
            <a href="<?php echo base_url('Cpurchase')?>" class="btn btn-success btn-outline" style=""><i class="ti-shopping-cart"></i> <?php echo display('purchase') ?></a>
        <?php }} ?>

        <a href="<?php echo base_url('rrhh/empleados')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-users"></i> Recursos Humanos</a>
        <a href="<?php echo base_url('cofi/administracion/empresa_gestion')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-money"></i> Contabilidad y Finanzas</a>
        <a href="<?php echo base_url('Cma_ingreso')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-archive"></i> Almacenes</a>
        <a href="<?php echo base_url('Cmactivos_administracion')?>" class="btn btn-success btn-outline" style=""><i class="fa fa-archive"></i> Activos Fijos</a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- <li class="dropdown notifications-menu">
                    <a href="<?php echo base_url('Creport/out_of_stock') ?>" >
                        <i class="pe-7s-attention" title="<?php echo display('out_of_stock') ?>"></i>
                        <span class="label label-danger"><?php echo $out_of_stock ?></span>
                    </a>
                </li> -->
                <!-- settings -->
                <li class="dropdown dropdown-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-config"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('Admin_dashboard/edit_profile') ?>"><i class="ti-user"></i><?php echo 'Mi perfil' #display('user_profile') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/change_password_form') ?>"><i class="ti-pencil"></i><?php echo 'Cambiar contraseña' #display('change_password') ?></a></li>
                        <li><a href="<?php echo base_url('Admin_dashboard/logout') ?>"><i class="ti-power-off"></i><?php echo 'Cerrar sesión' #display('logout') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<aside class="main-sidebar">
    <!-- sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel text-center">
            <div class="image">
                <img src="<?php echo $users[0]['logo'] ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <p><?php echo $this->session->userdata('user_name') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> <?php echo display('online') ?></a>
            </div>
        </div>
        <!-- sidebar menu -->
        <ul class="sidebar-menu">

            <li class="<?php
            if ($this->uri->segment('1') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="<?php echo base_url() ?>"><i class="ti-dashboard"></i> <span><?php echo display('dashboard') ?></span>
                    <span class="pull-right-container">
                        <span class="label label-success pull-right"></span>
                    </span>
                </a>
            </li>

            <!-- ATENCION AL CONSUMIDOR -->
            <?php if($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()){?>
                <li class="treeview <?php
                    if ($this->uri->segment('1') == ("caco"))   # General, preguntando si está en en controlador
                        echo "active";
                    else echo " "; ?>">
                    <a href="#">
                        <i class="fa fa-money"></i><span><?php echo "Atención al consumidor"; ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <!-- Administracion del Sistema -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("cobros")) ? 'active': '';
                                echo ($this->uri->segment('2') == ("siguiente")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/admin')?>"><?php echo "Administración"; ?></a>
                            </li>
                            <!-- Registrar localidades calles y zonas-->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("arqueos")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/localidad')?>"><?php echo "Registro Direccion"; ?></a>
                            </li>
                            <!-- Registrar Parametros del sistema de distribucion -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/propiedad')?>"><?php echo "Parametros Distribución"; ?></a>
                            </li>
                            <!-- Registro informacion de abonados-->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/categorias')?>"><?php echo "Información - Abonados"; ?></a>
                            </li>
                            <!-- Registro cobranzas venta material -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/venta')?>"><?php echo "Cobranzas - Otros"; ?></a>
                            </li>
                            <!-- Gestion De Facturas -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/gestion_factura')?>"><?php echo "Gestion De Facturas"; ?></a>
                            </li>
                            <!-- Reportes -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/reporte')?>"><?php echo "Reportes"; ?></a>
                            </li>
                        <?php }?>
                    </ul>
                </li>
            <?php }?>
            <!-- ATENCION AL CONSUMIDOR end -->

            <!-- FACTURACION Y COBRANZA -->
            <?php if($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()){?>
                <li class="treeview <?php
                    if ($this->uri->segment('1') == ("caco"))   # General, preguntando si está en en controlador
                        echo "active";
                    else echo " "; ?>">
                    <a href="#">
                        <i class="fa fa-money"></i><span><?php echo "Facturación Y Cobranzas"; ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <!-- Realizar Registro de Lecturas -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("cobros")) ? 'active': '';
                                echo ($this->uri->segment('2') == ("siguiente")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/lectura')?>"><?php echo "Transcripción De Lecturas"; ?></a>
                            </li>
                            <!-- Registrar Calculo de Facturas -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("arqueos")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/calcular_lecturas')?>"><?php echo "Calcular Facturas"; ?></a>
                            </li>
                            <!-- Registrar Configuracion de la facturacion del periodo -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/facturacion')?>"><?php echo "Configuración Facturación"; ?></a>
                            </li>
                            <!-- Registro cobranzas servicios basicos -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/cobranza')?>"><?php echo "Cobranzas - Servicios Basicos"; ?></a>
                            </li>
                            <!-- Registro cobranzas venta material -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/venta')?>"><?php echo "Cobranzas - Otros"; ?></a>
                            </li>
                            <!-- Gestion De Facturas -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/gestion_factura')?>"><?php echo "Gestion De Facturas"; ?></a>
                            </li>
                            <!-- Reportes -->
                            <li class="treeview <?php # marcar sub menu seleccionado
                                echo ($this->uri->segment('2') == ("comprobantes")) ? 'active': '';
                                ?>">
                                <a href="<?php echo base_url('fact/reporte')?>"><?php echo "Reportes"; ?></a>
                            </li>
                        <?php }?>
                    </ul>
                </li>
            <?php }?>
            <!-- FACTURACION Y COBRANZAS end -->

            <!-- RECURSOS HUMANOS - JLMG -->
            <?php if($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()){?>
                <li class="treeview <?php
                    echo ($this->uri->segment('1') == ("rrhh")) ? 'active': ''; ?>">
                    <a href="#">
                        <i class="fa fa-id-card-o"></i><span><?php echo "Recursos Humanos"; ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <!-- REGISTROS -->
                        <?php if($this->permission1->method('add_role','create')->access() || $this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php
                                echo ($this->uri->segment('1') == ("rrhh") &&
                                    (($this->uri->segment('2') == ("empleados"))||
                                    ($this->uri->segment('2') == ("items"))||
                                    ($this->uri->segment('2') == ("secciones"))||
                                    ($this->uri->segment('2') == ("asistencias"))||
                                    ($this->uri->segment('2') == ("vacaciones"))||
                                    ($this->uri->segment('2') == ("anticipos"))||
                                    ($this->uri->segment('2') == ("form101"))||
                                    ($this->uri->segment('2') == ("fondoRotativo"))||
                                    ($this->uri->segment('2') == ("sindicato"))||
                                    ($this->uri->segment('2') == ("horasExtras"))||
                                    ($this->uri->segment('2') == ("suplencias"))||
                                    ($this->uri->segment('2') == ("sanciones"))||
                                    ($this->uri->segment('2') == ("control"))||
                                    ($this->uri->segment('2') == ("factores")) )) ? 'active':'';
                                ?>">
                                <a href="#">
                                    <i class="fa fa-columns"></i> <span><?php echo "Registros"; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('add_role','create')->access()){?>
                                        <!-- Empleados -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("empleados"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/empleados')?>"><?php echo "Empleados"; ?></a>
                                        </li>
                                        <!-- Ítems -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("items"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/items')?>"><?php echo "Ítems"; ?></a>
                                        </li>
                                        <!-- Secciones -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("secciones"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/secciones')?>"><?php echo "Secciones"; ?></a>
                                        </li>
                                        <!-- Asistencias -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("asistencias"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/asistencias')?>"><?php echo "Asistencias"; ?></a>
                                        </li>
                                        <!-- Vacaciones -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("vacaciones"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/vacaciones')?>"><?php echo "Vacaciones"; ?></a>
                                        </li>
                                        <!-- Registro Mensual -->
                                        <li  class="treeview <?php
                                            echo (($this->uri->segment('2') == ("anticipos")) ||
                                                ($this->uri->segment('2') == ("form101"))||
                                                ($this->uri->segment('2') == ("fondoRotativo"))||
                                                ($this->uri->segment('2') == ("sindicato"))||
                                                ($this->uri->segment('2') == ("horasExtras"))||
                                                ($this->uri->segment('2') == ("suplencias"))||
                                                ($this->uri->segment('2') == ("sanciones"))
                                                ) ? 'active':'';
                                            ?>">
                                            <a href="#">
                                                <?php echo "Registro Mensual"; ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>

                                            <ul class="treeview-menu">
                                                <?php if($this->permission1->method('add_role','create')->access()){?>
                                                    <!-- Anticipos -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("anticipos")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/anticipos') ?>"><?php echo "Anticipos"; ?></a>
                                                    </li>
                                                    <!-- Formulario 101 -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("form101")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/form101') ?>"><?php echo "Formulario 101"; ?></a>
                                                    </li>
                                                    <!-- Fondo Rotativo -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("fondoRotativo")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/fondoRotativo') ?>"><?php echo "Fondo Rotativo"; ?></a>
                                                    </li>
                                                    <!-- Sindicato -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("sindicato")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/sindicato') ?>"><?php echo "Sindicato"; ?></a>
                                                    </li>
                                                    <!-- Horas Extras -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("horasExtras")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/horasExtras') ?>"><?php echo "Horas Extras"; ?></a>
                                                    </li>
                                                    <!-- Suplencias -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("suplencias")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/suplencias') ?>"><?php echo "Suplencias"; ?></a>
                                                    </li>
                                                    <!-- Sanciones -->
                                                    <li  class="treeview <?php
                                                            echo ($this->uri->segment('2') == ("sanciones")) ? 'active':'';
                                                        ?>">
                                                        <a href="<?php echo base_url('rrhh/sanciones') ?>"><?php echo "Sanciones"; ?></a>
                                                    </li>
                                                <?php }?>
                                            </ul>

                                        </li>
                                        <!-- Control -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("control"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/control')?>"><?php echo "Control"; ?></a>
                                        </li>
                                        <!-- Factores -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("factores"))
                                                echo "active";
                                            else echo " "; ?>">
                                            <a href="<?php echo base_url('rrhh/factores')?>"><?php echo "Factores"; ?></a>
                                        </li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- REGISTROS End -->

                        <!-- CALCULOS -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php
                                    echo ($this->uri->segment('1') == ("rrhh") &&
                                    (($this->uri->segment('2') == ("calculos")) )) ? 'active':'';
                                ?>">
                                <a href="<?php echo base_url('rrhh/calculos') ?>">
                                    <i class="fa fa-calculator"></i><?php echo "Calculos"; ?>
                                </a>
                            </li>
                        <?php }?>
                        <!-- CALCULOS End -->

                        <!-- PLANILLAS -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php
                                    echo ($this->uri->segment('1') == ("rrhh") &&
                                    (($this->uri->segment('2') == ("planillas")) )) ? 'active':'';
                                ?>">
                                <a href="<?php echo base_url('rrhh/planillas') ?>">
                                    <i class="fa fa-archive"></i><?php echo "Planillas"; ?>
                                </a>
                            </li>
                        <?php }?>
                        <!-- PLANILLAS End -->

                    </ul>
                </li>
            <?php }?>
            <!-- RECURSOS HUMANOS - JLMG end -->

            <!-- CONTABILIDAD Y FINANZAS - JLMG -->
            <?php if($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()){?>
                <li class="treeview <?php
                    if ($this->uri->segment('1') == "cofi" || $this->uri->segment('1') == "cofi")   # General, preguntando si está en en controlador
                        echo "active";
                    else echo " "; ?>">
                    <a href="#">
                        <i class="fa fa-money"></i><span><?php echo "Contabilidad y Finanzas"; ?></span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <!-- ADMINISTRACIÓN -->
                        <?php if($this->permission1->method('add_role','create')->access() || $this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li class="treeview <?php echo ($this->uri->segment('2') === "administracion") ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="ti-pencil-alt"></i> <span>Administración</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('add_role','create')->access()) { ?>
                                        <!-- Seleccionar Empresa y Gestión -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "empresa_gestion") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/administracion/empresa_gestion')?>">Empresa y Gestión</a>
                                        </li>
                                        <!-- Adicionar Empresa -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "adicionar_empresa") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/administracion/adicionar_empresa')?>">Adicionar Empresa</a>
                                        </li>
                                        <!-- Adicionar Gestion -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "adicionar_gestion") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/administracion/adicionar_gestion')?>">Adicionar Gestión</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- ADMINISTRAR SISTEMA CONTABLE End -->

                        <!-- PLAN DE CUENTAS -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php echo ($this->uri->segment('2') === "planDeCuentas") ? 'active' : ''; ?>">
                                <a href="<?php echo base_url('cofi/planDeCuentas') ?>"> <i class="ti-clipboard"></i> Plan de Cuentas</a>
                            </li>
                        <?php } ?>
                        <!-- PLAN DE CUENTAS End -->

                        <!-- COMPROBANTES -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php echo ($this->uri->segment('2') == "comprobantes") ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="ti-key"></i> <span><?php echo "Comprobantes"; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('add_role','create')->access()){?>
                                        <!-- Registrar Comprobantes -->
                                        <li class="treeview <?php echo (
                                            $this->uri->segment('3') === "crear" ||
                                            $this->uri->segment('3') === "editar"
                                        ) ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/comprobantes/crear')?>"><?php echo "Registrar Comprobante"; ?></a>
                                        </li>
                                        <!-- Mis Comprobantes -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') == "") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/comprobantes')?>"><?php echo "Listar Comprobantes"; ?></a>
                                        </li>
                                        <!-- Comprobantes Anulados -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "anulados") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/comprobantes/anulados')?>"><?php echo "Comprobantes Anulados"; ?></a>
                                        </li>
                                        <!-- Configuraciones -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "configuraciones") ? 'active' : ''; ?>">
                                            <a href="<?php echo base_url('cofi/comprobantes/configuraciones')?>"><?php echo "Configuraciones"; ?></a>
                                        </li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- COMPROBANTES End -->

                        <!-- LIBROS -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php echo ($this->uri->segment('2') === 'libros') ? 'active':''; ?>">
                                <a href="#">
                                    <i class="ti-book"></i> <span>Libros</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if ($this->permission1->method('add_role','create')->access()) { ?>
                                        <!-- Libro de Ventas IVA -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("libroVentasIva"))
                                                echo "active";
                                            else echo " "; ?>" hidden>
                                            <a href="<?php echo base_url('cofi/libroVentasIva')?>"><?php echo "Libro de Ventas IVA"; ?></a>
                                        </li>
                                        <!-- Libro de Compras IVA -->
                                        <li class="treeview <?php
                                            if ($this->uri->segment('2') == ("libroComprasIva"))
                                                echo "active";
                                            else echo " "; ?>" hidden>
                                            <a href="<?php echo base_url('cofi/libroComprasIva')?>"><?php echo "Libro de Compras IVA"; ?></a>
                                        </li>
                                        <!-- Libro Diario -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') == "diario") ? 'active':''; ?>">
                                            <a href="<?php echo base_url('cofi/libros/diario')?>">Libro Diario</a>
                                        </li>
                                        <!-- Libro Mayor -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') == "mayor") ? 'active':''; ?>">
                                            <a href="<?php echo base_url('cofi/libros/mayor')?>">Libro Mayor</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- LIBROS End -->

                        <!-- ESTADOS FINANCIEROS -->
                        <?php if ($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()) { ?>
                            <li  class="treeview <?php echo ($this->uri->segment('2') === "estadosFinancieros") ? 'active':''; ?>">
                                <a href="#">
                                    <i class="ti-files"></i> <span><?php echo "Estados Financieros"; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if ($this->permission1->method('add_role','create')->access()) { ?>
                                        <!-- Estados Financieros -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') == "") ? 'active':''; ?>">
                                            <a href="<?php echo base_url('cofi/estadosFinancieros')?>"><?php echo "Estados Financieros"; ?></a>
                                        </li>
                                        <!-- Estado de Cuentas -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "estado_cuentas") ? 'active':''; ?>">
                                            <a href="<?php echo base_url('cofi/estadosFinancieros/estado_cuentas')?>"><?php echo "Estado de Cuentas"; ?></a>
                                        </li>
                                        <!-- Balance Gral. y Estado de Resultados Comparativos -->
                                        <li class="treeview <?php echo ($this->uri->segment('3') === "balance_gral_estado_res_comp") ? 'active':''; ?>">
                                            <a href="<?php echo base_url('cofi/estadosFinancieros/balance_gral_estado_res_comp')?>"><?php echo "Balance Gral. y Estado de<br>Resultados Comparativos"; ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- ESTADOS FINANCIEROS End -->

                        <!-- PLANTILLAS -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php echo
                                (
                                    $this->uri->segment('1') == "cofi" && (
                                        $this->uri->segment('2') == "plantillas"
                                    )
                                ) ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="fa fa-archive"></i> <span><?php echo "Plantillas"; ?></span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('add_role','create')->access()): ?>
                                        <!-- Listar Plantillas -->
                                        <li class="treeview <?php echo
                                            ($this->uri->segment('2') == "plantillas" && $this->uri->segment('3') == "") ? 'active':'';
                                            ?>">
                                            <a href="<?php echo base_url('cofi/plantillas')?>"><?php echo "Listar Plantillas"; ?></a>
                                        </li>
                                        <!-- Registrar Plantilla -->
                                        <li class="treeview <?php echo
                                            ($this->uri->segment('2') == "plantillas" && (
                                                $this->uri->segment('3') == "crear" ||
                                                $this->uri->segment('3') == "editar"
                                            )) ? 'active':'';
                                            ?>">
                                            <a href="<?php echo site_url('cofi/plantillas/crear')?>"><?php echo "Registrar Plantilla"; ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- PLANTILLAS End -->

                        <!-- UTILIDADES -->
                        <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                            <li  class="treeview <?php echo
                                ($this->uri->segment('1') == "cofi" && (
                                    $this->uri->segment('2') == "utilidades"
                                )) ? 'active' : ''; ?>">
                                <a href="#">
                                    <i class="ti-hummer"></i> <span>Utilidades</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('add_role','create')->access()) { ?>
                                        <!-- Tasas de Cambio -->
                                        <li class="treeview <?php echo
                                            ($this->uri->segment('2') == "utilidades" && (
                                                $this->uri->segment('3') == "tasa_de_cambio" ||
                                                $this->uri->segment('3') == "tasa_de_cambio_administrar"
                                            )) ? 'active':'';
                                            ?>">
                                            <a href="<?php echo base_url('cofi/utilidades/tasa_de_cambio')?>">Tasas de Cambio</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- UTILIDADES End -->

                    </ul>
                </li>
            <?php }?>
            <!-- CONTABILIDAD Y FINANZAS MENU - JLMG end -->

            <!-- Facturacion menu start -->
            <?php if($this->permission1->method('new_invoice','create')->access()){?>
                <li hidden class="treeview <?php
                //incluir todos los controladores de los menus
                if ($this->uri->segment('1') == ("FactFactura")
                    || $this->uri->segment('1') == ("FactCategoria")
                    || $this->uri->segment('1') == ("FactEmision")
                    || $this->uri->segment('1') == ("FactFactor")
                    || $this->uri->segment('1') == ("ConfEnergia")
                    || $this->uri->segment('1') == ("FactAutorizacion")
                    || $this->uri->segment('1') == ("SisServicio")
                    || $this->uri->segment('1') == ("SisTipoSuministro")
                    || $this->uri->segment('1') == ("SisTipoConsumidor")
                    || $this->uri->segment('1') == ("SisTipoMedicion")
                    || $this->uri->segment('1') == ("FactLiberacionServicio")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-file-archive-o"></i><span><?php echo "Facturación" ?></span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">

                        <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('1') == ("FactFactura")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('FactFactura') ?>"><?php echo "Generar factura" ?></a></li>
                        <?php } ?>

                        <!-- Submenu Facturación -->
                        <?php if($this->permission1->method('new_invoice','create')->access()){?>
                            <li class="treeview <?php
                            //se pone los controladores de los submenus
                            if ($this->uri->segment('1') == ("FactCategoria")
                                || $this->uri->segment('1') == ("FactEmision")
                                || $this->uri->segment('1') == ("FactFactor")
                                || $this->uri->segment('1') == ("ConfEnergia")
                                || $this->uri->segment('1') == ("FactAutorizacion")
                                || $this->uri->segment('1') == ("SisServicio")
                                || $this->uri->segment('1') == ("SisTipoSuministro")
                                || $this->uri->segment('1') == ("SisTipoConsumidor")
                                || $this->uri->segment('1') == ("SisTipoMedicion")
                                || $this->uri->segment('1') == ("FactLiberacionServicio") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-settings"></i> <span>Configuración</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <?php if($this->permission1->method('manage_company','read')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("FactCategoria")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('FactCategoria') ?>">Categorias</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("FactEmision")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('FactEmision') ?>">Emisión</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("FactFactor")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('FactFactor') ?>">Factores</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("ConfEnergia")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('ConfEnergia') ?>">Bonos y Descuentos</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("FactAutorizacion")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('FactAutorizacion') ?>">Autorización</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("SisServicio")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('SisServicio') ?>">Servicios</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("SisTipoSuministro")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('SisTipoSuministro') ?>">Tipos de Suminsitros</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("SisTipoConsumidor")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('SisTipoConsumidor') ?>">Tipos de Consumidores</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("SisTipoMedicion")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('SisTipoMedicion') ?>">Tipos de Mediciones</a></li>
                                    <?php }?>
                                    <?php if($this->permission1->method('add_user','create')->access()){?>
                                        <li class="treeview <?php if ($this->uri->segment('1') == ("FactLiberacionServicio")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('FactLiberacionServicio') ?>">Liberación de Servicios</a></li>
                                    <?php }?>
                                </ul>
                            </li>
                        <?php }?>
                        <!-- Submenu Configuracion end -->
                    </ul>
                </li>
            <?php } ?>
            <!-- Facturacion menu end -->

            
            <!-- Menu Gestión de Asociados -->
            <?php if(
                $this->permission1->method('administrar_gestion_asociado_cliente','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_suscripcion','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_pago','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_certificado','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_departamento','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_ocupacion','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_nivel_educacion','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_profesion','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_estado_civil','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_valor_certificado','read')->access() ||
                $this->permission1->method('administrar_gestion_asociado_reporte','read')->access()
            ){ ?>
                <li hidden class="treeview <?php
                if (
                    $this->uri->segment('1') == ("Cga_cliente") ||
                    $this->uri->segment('1') == ("Cga_suscripcion") ||
                    $this->uri->segment('1') == ("Cga_pago") ||
                    $this->uri->segment('1') == ("Cga_certificado") ||
                    $this->uri->segment('1') == ("Cga_departamento") ||
                    $this->uri->segment('1') == ("Cga_ocupacion") ||
                    $this->uri->segment('1') == ("Cga_nivel_educacion") ||
                    $this->uri->segment('1') == ("Cga_profesion") ||
                    $this->uri->segment('1') == ("Cga_estado_civil") ||
                    $this->uri->segment('1') == ("Cga_valor_certificado") ||
                    $this->uri->segment('1') == ("Cga_reporte")
                ) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-archive"></i><span>Gestión de Asociados</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>

                    <ul class="treeview-menu" >

                        <!-- Cliente -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_asociado_cliente','create')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_cliente','read')->access()   ||
                            $this->permission1->method('administrar_gestion_asociado_cliente','delete')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_cliente','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cga_cliente") || $this->uri->segment('1') == ("") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-user"></i> <span>Cliente</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cga_cliente") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_cliente') ?>">Añadir cliente</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_cliente/administrar') ?>">Administrar cliente</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin cliente -->

                        <!-- Suscripción -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_asociado_suscripcion','create')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_suscripcion','read')->access()   ||
                            $this->permission1->method('administrar_gestion_asociado_suscripcion','delete')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_suscripcion','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cga_suscripcion") || $this->uri->segment('1') == ("") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-marker"></i> <span>Suscripción</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_suscripcion/administrar') ?>">Administrar suscripción</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin suscripción -->

                        <!-- Pago -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_asociado_pago','create')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_pago','read')->access()   ||
                            $this->permission1->method('administrar_gestion_asociado_pago','delete')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_pago','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cga_pago") || $this->uri->segment('1') == ("") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-money"></i> <span>Pago</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_pago/administrar') ?>">Administrar pago</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin pago -->

                        <!-- Certificado -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_pago','create')->access() ||
                            $this->permission1->method('administrar_gestion_pago','read')->access()   ||
                            $this->permission1->method('administrar_gestion_pago','delete')->access() ||
                            $this->permission1->method('administrar_gestion_pago','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cga_certificado") || $this->uri->segment('1') == ("") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-receipt"></i> <span>Certificado</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_certificado/administrar') ?>">Administrar certificado</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin certificado -->


                        <!-- Parametricas -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_asociado_departamento','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_ocupacion','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_nivel_educacion','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_profesion','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_estado_civil','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_valor_certificado','read')->access()){?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cga_departamento") ||
                                $this->uri->segment('1') == ("Cga_ocupacion") ||
                                $this->uri->segment('1') == ("Cga_nivel_educacion") ||
                                $this->uri->segment('1') == ("Cga_profesion") ||
                                $this->uri->segment('1') == ("Cga_estado_civil") ||
                                $this->uri->segment('1') == ("Cga_valor_certificado") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-settings"></i> <span>Parametricas</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_departamento','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_departamento','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_departamento','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_departamento','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_departamento")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_departamento') ?>">Departamento</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_ocupacion','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_ocupacion','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_ocupacion','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_ocupacion','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_ocupacion")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_ocupacion') ?>">Ocupacion</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_nivel_educacion','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_nivel_educacion','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_nivel_educacion','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_nivel_educacion','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_nivel_educacion")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_nivel_educacion') ?>">Nivel de educación</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_profesion','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_profesion','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_profesion','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_profesion','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_profesion")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_profesion') ?>">Profesión</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_estado_civil','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_estado_civil','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_estado_civil','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_estado_civil','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_estado_civil")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_estado_civil') ?>">Estado civil</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_gestion_asociado_valor_certificado','create')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_valor_certificado','read')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_valor_certificado','delete')->access() ||
                                        $this->permission1->method('administrar_gestion_asociado_valor_certificado','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cga_valor_certificado")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cga_valor_certificado') ?>">Valor certificado</a></li>
                                    <?php } ?>

                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin parametricas -->

                        <!-- Reportes -->
                        <?php if(
                            $this->permission1->method('administrar_gestion_asociado_reporte','create')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_reporte','read')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_reporte','delete')->access() ||
                            $this->permission1->method('administrar_gestion_asociado_reporte','update')->access()){ ?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cga_reporte") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-bar-chart"></i> <span> Reportes </span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cga_reporte") && $this->uri->segment('2') == ("cliente")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cga_reporte/cliente') ?>">Clientes</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin reportes -->
                    </ul>
                </li>
            <?php } ?>
            <!-- Fin Gestion de Asociados -->

            <!-- Menu Almacen -->
            <?php if(
                $this->permission1->method('administrar_almacen_ingreso','read')->access() ||
                $this->permission1->method('administrar_almacen_egreso','read')->access() ||
                $this->permission1->method('administrar_almacen_almacen','read')->access() ||
                $this->permission1->method('administrar_almacen_grupo','read')->access() ||
                $this->permission1->method('administrar_almacen_articulo','read')->access() ||
                $this->permission1->method('administrar_almacen_proveedor','read')->access() ||
                $this->permission1->method('administrar_almacen_unidad','read')->access() ||
                $this->permission1->method('administrar_almacen_departamento','read')->access() ||
                $this->permission1->method('administrar_almacen_orden_compra','read')->access()||
                $this->permission1->method('administrar_almacen_orden_trabajo','read')->access()||
                $this->permission1->method('administrar_almacen_cotizacion','read')->access()||
                $this->permission1->method('administrar_almacen_proforma','read')->access() ||
                $this->permission1->method('administrar_almacen_pedido_tecnico','read')->access()||
                $this->permission1->method('administrar_almacen_pedido_administrativo','read')->access()||
                $this->permission1->method('administrar_almacen_reporte','read')->access()
            ){ ?>
                <li class="treeview <?php
                if (
                    $this->uri->segment('1') == ("Cma_ingreso") ||
                    $this->uri->segment('1') == ("Cma_egreso") ||
                    $this->uri->segment('1') == ("Cma_almacen") ||
                    $this->uri->segment('1') == ("Cma_grupo") ||
                    $this->uri->segment('1') == ("Cma_articulo") ||
                    $this->uri->segment('1') == ("Cma_proveedor") ||
                    $this->uri->segment('1') == ("Cma_unidad") ||
                    $this->uri->segment('1') == ("Cma_departamento") ||
                    $this->uri->segment('1') == ("Cma_orden_compra") ||
                    $this->uri->segment('1') == ("Cma_orden_trabajo") ||
                    $this->uri->segment('1') == ("Cma_cotizacion") ||
                    $this->uri->segment('1') == ("Cma_proforma") ||
                    $this->uri->segment('1') == ("Cma_pedidotecnico") ||
                    $this->uri->segment('1') == ("Cma_pedidoadministrativo") ||
                    $this->uri->segment('1') == ("Cma_reporte")
                ){
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-archive"></i><span>Almacen y Adquisiciones</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>

                    <ul class="treeview-menu" >

                        <!-- Ingreso -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_ingreso','create')->access() ||
                            $this->permission1->method('administrar_almacen_ingreso','read')->access()   ||
                            $this->permission1->method('administrar_almacen_ingreso','delete')->access() ||
                            $this->permission1->method('administrar_almacen_ingreso','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_ingreso") || $this->uri->segment('1') == ("") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-arrow-right"></i> <span>Ingresos</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_ingreso") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_ingreso') ?>">Añadir ingreso</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_ingreso/administrar') ?>">Administrar ingresos</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin ingreso -->

                        <!-- Egreso -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_egreso','create')->access() ||
                            $this->permission1->method('administrar_almacen_egreso','read')->access()   ||
                            $this->permission1->method('administrar_almacen_egreso','delete')->access() ||
                            $this->permission1->method('administrar_almacen_egreso','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_egreso") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-arrow-left"></i> <span>Egresos</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_egreso") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_egreso') ?>">Añadir egreso</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_egreso/administrar') ?>">Administrar egresos</a></li>


                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin egreso -->

                        <!-- Articulo -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_articulo','create')->access() ||
                            $this->permission1->method('administrar_almacen_articulo','read')->access() ||
                            $this->permission1->method('administrar_almacen_articulo','delete')->access() ||
                            $this->permission1->method('administrar_almacen_articulo','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_articulo")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cma_articulo') ?>"><i class="ti-clipboard"></i>Articulo</a>
                            </li>
                        <?php } ?>
                        <!-- Fin articulo -->

                        <!-- Formulario Orden de compra -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_orden_compra','create')->access() ||
                            $this->permission1->method('administrar_almacen_orden_compra','read')->access() ||
                            $this->permission1->method('administrar_almacen_orden_compra','delete')->access() ||
                            $this->permission1->method('administrar_almacen_orden_compra','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_orden_compra") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-shopping-cart"></i> <span>Ordenes de Compra</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_orden_compra") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_orden_compra') ?>">Añadir Nuevo</a></li>


                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_orden_compra/administrar') ?>">Administrar</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin formulario orden de compra -->

                        <!-- Formulario orden de trabajo -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_orden_trabajo','create')->access() ||
                            $this->permission1->method('administrar_almacen_orden_trabajo','read')->access() ||
                            $this->permission1->method('administrar_almacen_orden_trabajo','delete')->access() ||
                            $this->permission1->method('administrar_almacen_orden_trabajo','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_orden_trabajo") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-hand-open"></i> <span>Ordenes de Trabajo</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">

                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_orden_trabajo") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_orden_trabajo') ?>">Añadir Nuevo</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_orden_trabajo/administrar') ?>">Administrar</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin formulario orden de trabajo -->

                        <!-- Cotizacion -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_cotizacion','create')->access() ||
                            $this->permission1->method('administrar_almacen_cotizacion','read')->access() ||
                            $this->permission1->method('administrar_almacen_cotizacion','delete')->access() ||
                            $this->permission1->method('administrar_almacen_cotizacion','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_cotizacion") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-money"></i> <span>Cotizaciones</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_cotizacion") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_cotizacion') ?>">Añadir cotizacion</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_cotizacion/administrar') ?>">Administrar</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin cotizacion -->

                        <!-- Proforma -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_proforma','create')->access() ||
                            $this->permission1->method('administrar_almacen_proforma','read')->access() ||
                            $this->permission1->method('administrar_almacen_proforma','delete')->access() ||
                            $this->permission1->method('administrar_almacen_proforma','update')->access()){ ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_proforma") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-money"></i> <span>Proformas</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_proforma") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_proforma') ?>">Añadir proforma</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_proforma/administrar') ?>">Administrar</a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin proforma -->

                        <!-- Formulario Pedido Tecnico -->
                        <!-- <?php if(
                            $this->permission1->method('administrar_almacen_pedido_tecnico','create')->access() ||
                            $this->permission1->method('administrar_almacen_pedido_tecnico','read')->access() ||
                            $this->permission1->method('administrar_almacen_pedido_tecnico','delete')->access() ||
                            $this->permission1->method('administrar_almacen_pedido_tecnico','update')->access() ){?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_pedidotecnico") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-marker-alt"></i> <span>Pedidos (Técnicos)</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_pedidotecnico") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_pedidotecnico') ?>">Añadir Nuevo</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_pedidotecnico/administrar') ?>">Administrar</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <?php if(
                            $this->permission1->method('administrar_pedido_administrativo','create')->access() ||
                            $this->permission1->method('administrar_pedido_administrativo','read')->access() ||
                            $this->permission1->method('administrar_pedido_administrativo','delete')->access() ||
                            $this->permission1->method('administrar_pedido_administrativo','update')->access() ){?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cma_pedidoadministrativo") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-user"></i> <span>Pedidos (Administrativos)</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_pedidoadministrativo") && $this->uri->segment('2') == ("") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_pedidoadministrativo') ?>">Añadir Nuevo</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('2') == ("administrar")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_pedidoadministrativo/administrar') ?>">Administrar</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        -->

                        <!-- Parametricas -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_grupo','read')->access() ||
                            $this->permission1->method('administrar_almacen_almacen','read')->access() ||
                            $this->permission1->method('administrar_almacen_unidad','read')->access() ||
                            $this->permission1->method('administrar_almacen_proveedor','read')->access() ||
                            $this->permission1->method('administrar_almacen_departamento','read')->access()   ){?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cma_grupo") ||
                                $this->uri->segment('1') == ("Cma_almacen") ||
                                $this->uri->segment('1') == ("Cma_unidad") ||
                                $this->uri->segment('1') == ("Cma_proveedor") ||
                                $this->uri->segment('1') == ("Cma_departamento")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-settings"></i> <span>Parametricas</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">

                                    <?php if(
                                        $this->permission1->method('administrar_almacen_almacen','create')->access() ||
                                        $this->permission1->method('administrar_almacen_almacen','read')->access() ||
                                        $this->permission1->method('administrar_almacen_almacen','delete')->access() ||
                                        $this->permission1->method('administrar_almacen_almacen','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cma_almacen")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cma_almacen') ?>">Almacen</a></li>
                                    <?php } ?>


                                    <?php if(
                                        $this->permission1->method('administrar_almacen_grupo','create')->access() ||
                                        $this->permission1->method('administrar_almacen_grupo','read')->access() ||
                                        $this->permission1->method('administrar_almacen_grupo','delete')->access() ||
                                        $this->permission1->method('administrar_almacen_grupo','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cma_grupo")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cma_grupo') ?>">Grupo</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_almacen_proveedor','create')->access() ||
                                        $this->permission1->method('administrar_almacen_proveedor','read')->access() ||
                                        $this->permission1->method('administrar_almacen_proveedor','delete')->access() ||
                                        $this->permission1->method('administrar_almacen_proveedor','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cma_proveedor")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cma_proveedor') ?>">Proveedor</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_almacen_departamento','create')->access() ||
                                        $this->permission1->method('administrar_almacen_departamento','read')->access() ||
                                        $this->permission1->method('administrar_almacen_departamento','delete')->access() ||
                                        $this->permission1->method('administrar_almacen_departamento','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cma_departamento")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cma_departamento') ?>">Departamento</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_almacen_unidad','create')->access() ||
                                        $this->permission1->method('administrar_almacen_unidad','read')->access() ||
                                        $this->permission1->method('administrar_almacen_unidad','delete')->access() ||
                                        $this->permission1->method('administrar_almacen_unidad','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cma_unidad")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cma_unidad') ?>">Unidad</a></li>
                                    <?php } ?>



                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin parametricas -->

                        <!-- Reportes -->
                        <?php if(
                            $this->permission1->method('administrar_almacen_reporte','create')->access() ||
                            $this->permission1->method('administrar_almacen_reporte','read')->access() ||
                            $this->permission1->method('administrar_almacen_reporte','delete')->access() ||
                            $this->permission1->method('administrar_almacen_reporte','update')->access()){ ?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cma_reporte") ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-bar-chart"></i> <span> Reportes </span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">
                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_reporte") && $this->uri->segment('2') == ("inventario_fisico") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_reporte/inventario_fisico') ?>"> Inventario Físico</a></li>

                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_reporte") && $this->uri->segment('2') == ("kardex_general")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_reporte/kardex_general') ?>"> Kardex General</a></li>


                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_reporte") && $this->uri->segment('2') == ("salida_almacen")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_reporte/salida_almacen') ?>"> Salida de Almacen</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin reportes -->
                    </ul>
                </li>
            <?php } ?>
            <!-- Fin Almacen -->


            <!-- ****************************Menu Activos Fijos***************************** -->
            <?php if(
                $this->permission1->method('administrar_almacen_administracion','read')->access() ||
                $this->permission1->method('administrar_activos_cuenta','read')->access() ||
                $this->permission1->method('administrar_activos_responsable','read')->access() ||
                $this->permission1->method('administrar_almacen_depreciar','read')->access() ||

                //Paramétricas
                $this->permission1->method('administrar_activos_empresa','read')->access() ||
                $this->permission1->method('administrar_activos_servicio','read')->access()||
                $this->permission1->method('administrar_activos_grupo','read')->access()||
                $this->permission1->method('administrar_activos_tipo_responsable','read')->access()||
                $this->permission1->method('administrar_activos_lugar','read')->access()||
                $this->permission1->method('administrar_activos_ubicacion','read')->access()||
                $this->permission1->method('administrar_almacen_pedido_administrativo','read')->access()||
                $this->permission1->method('administrar_activos_unidad','read')->access() ||

                //Reportes
                $this->permission1->method('administrar_almacen_depreciacion','read')->access()
            ){ ?>
                <li class="treeview <?php
                if (
                    $this->uri->segment('1') == ("Cmactivos_administracion") ||
                    $this->uri->segment('1') == ("Cmactivos_cuenta") ||
                    $this->uri->segment('1') == ("Cmactivos_responsable") ||
                    $this->uri->segment('1') == ("Cmactivos_depreciar") ||

                    //Paramétricas
                    $this->uri->segment('1') == ("Cmactivos_empresa") ||
                    $this->uri->segment('1') == ("Cmactivos_servicio") ||
                    $this->uri->segment('1') == ("Cmactivos_grupo") ||
                    $this->uri->segment('1') == ("Cmactivos_tipo_responsable") ||
                    $this->uri->segment('1') == ("Cmactivos_lugar") ||
                    $this->uri->segment('1') == ("Cmactivos_ubicacion") ||
                    $this->uri->segment('1') == ("Cmactivos_ufv") ||
                    $this->uri->segment('1') == ("Cmactivos_unidad") ||

                    //Reportes
                    $this->uri->segment('1') == ("Cmactivos_depreciacion")
                ){
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-archive"></i><span>Activos Fijos</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>

                    <ul class="treeview-menu" >

                        <!-- Administración -->
                        <?php if(
                            $this->permission1->method('administrar_activos_administracion','create')->access() ||
                            $this->permission1->method('administrar_activos_administracion','read')->access() ||
                            $this->permission1->method('administrar_activos_administracion','delete')->access() ||
                            $this->permission1->method('administrar_activos_administracion','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmactivos_administracion")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmactivos_administracion') ?>">
                                    <i class="ti-pencil-alt"></i>  <span> Administración </span> </a></li>
                        <?php } ?>
                        <!-- Fin Administración -->

                        <!-- Cuenta -->
                        <?php if(
                            $this->permission1->method('administrar_activos_cuenta','create')->access() ||
                            $this->permission1->method('administrar_activos_cuenta','read')->access() ||
                            $this->permission1->method('administrar_activos_cuenta','delete')->access() ||
                            $this->permission1->method('administrar_activos_cuenta','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmactivos_cuenta")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmactivos_cuenta') ?>">
                                    <i class="ti-layers-alt"></i>  <span> Cuentas </span> </a></li>
                        <?php } ?>
                        <!-- Fin Cuenta -->

                        <!-- Responsable -->
                        <?php if(
                            $this->permission1->method('administrar_activos_responsable','create')->access() ||
                            $this->permission1->method('administrar_activos_responsable','read')->access() ||
                            $this->permission1->method('administrar_activos_responsable','delete')->access() ||
                            $this->permission1->method('administrar_activos_responsable','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmactivos_responsable")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmactivos_responsable') ?>">
                                    <i class="ti-user"></i>  <span> Responsable </span> </a></li>
                        <?php } ?>
                        <!-- Fin Responsable -->

                        <!-- Depreciar -->
                        <?php if(
                            $this->permission1->method('administrar_activos_depreciar','create')->access() ||
                            $this->permission1->method('administrar_activos_depreciar','read')->access() ||
                            $this->permission1->method('administrar_activos_depreciar','delete')->access() ||
                            $this->permission1->method('administrar_activos_depreciar','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmactivos_depreciar")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmactivos_depreciar') ?>">
                                    <i class="ti-money"></i>  <span> Depreciar </span> </a></li>
                        <?php } ?>
                        <!-- Fin Depreciar -->

                        <!-- Parametricas -->
                        <?php if(
                            $this->permission1->method('administrar_activos_empresa','read')->access() ||
                            $this->permission1->method('administrar_activos_servicio','read')->access() ||
                            $this->permission1->method('administrar_activos_grupo','read')->access() ||
                            $this->permission1->method('administrar_activos_tipo_responsable','read')->access() ||
                            $this->permission1->method('administrar_activos_lugar','read')->access() ||
                            $this->permission1->method('administrar_activos_ubicacion','read')->access() ||
                            $this->permission1->method('administrar_activos_ufv','read')->access() ||
                            $this->permission1->method('administrar_activos_unidad','read')->access()
                        ){?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cmactivos_empresa") ||
                                $this->uri->segment('1') == ("Cmactivos_servicio") ||
                                $this->uri->segment('1') == ("Cmactivos_grupo") ||
                                $this->uri->segment('1') == ("Cmactivos_tipo_responsable") ||
                                $this->uri->segment('1') == ("Cmactivos_lugar") ||
                                $this->uri->segment('1') == ("Cmactivos_ubicacion") ||
                                $this->uri->segment('1') == ("Cmactivos_ufv") ||
                                $this->uri->segment('1') == ("Cmactivos_unidad")
                            ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-settings"></i> <span>Parametricas</span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">

                                    <?php if(
                                        $this->permission1->method('administrar_activos_empresa','create')->access() ||
                                        $this->permission1->method('administrar_activos_empresa','read')->access() ||
                                        $this->permission1->method('administrar_activos_empresa','delete')->access() ||
                                        $this->permission1->method('administrar_activos_empresa','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_empresa")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_empresa') ?>">Empresa</a></li>
                                    <?php } ?>


                                    <?php if(
                                        $this->permission1->method('administrar_activos_servicio','create')->access() ||
                                        $this->permission1->method('administrar_activos_servicio','read')->access() ||
                                        $this->permission1->method('administrar_activos_servicio','delete')->access() ||
                                        $this->permission1->method('administrar_activos_servicio','update')->access())
                                    { ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_servicio")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_servicio') ?>">Servicio</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_grupo','create')->access() ||
                                        $this->permission1->method('administrar_activos_grupo','read')->access() ||
                                        $this->permission1->method('administrar_activos_grupo','delete')->access() ||
                                        $this->permission1->method('administrar_activos_grupo','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_grupo")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_grupo') ?>">Grupo</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_tipo_responsable','create')->access() ||
                                        $this->permission1->method('administrar_activos_tipo_responsable','read')->access() ||
                                        $this->permission1->method('administrar_activos_tipo_responsable','delete')->access() ||
                                        $this->permission1->method('administrar_activos_tipo_responsable','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_tipo_responsable")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_tipo_responsable') ?>">Tipo Responsable</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_lugar','create')->access() ||
                                        $this->permission1->method('administrar_activos_lugar','read')->access() ||
                                        $this->permission1->method('administrar_activos_lugar','delete')->access() ||
                                        $this->permission1->method('administrar_activos_lugar','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_lugar")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_lugar') ?>">Lugar</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_ubicacion','create')->access() ||
                                        $this->permission1->method('administrar_activos_ubicacion','read')->access() ||
                                        $this->permission1->method('administrar_activos_ubicacion','delete')->access() ||
                                        $this->permission1->method('administrar_activos_ubicacion','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_ubicacion")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_ubicacion') ?>">Ubicación</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_ufv','create')->access() ||
                                        $this->permission1->method('administrar_activos_ufv','read')->access() ||
                                        $this->permission1->method('administrar_activos_ufv','delete')->access() ||
                                        $this->permission1->method('administrar_activos_ufv','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_ufv")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_ufv') ?>">UFV</a></li>
                                    <?php } ?>

                                    <?php if(
                                        $this->permission1->method('administrar_activos_unidad','create')->access() ||
                                        $this->permission1->method('administrar_activos_unidad','read')->access() ||
                                        $this->permission1->method('administrar_activos_unidad','delete')->access() ||
                                        $this->permission1->method('administrar_activos_unidad','update')->access()){ ?>
                                        <li class="treeview <?php
                                        if ($this->uri->segment('1') == ("Cmactivos_unidad")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }
                                        ?>"><a href="<?php echo base_url('Cmactivos_unidad') ?>">Unidad</a></li>
                                    <?php } ?>



                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin parametricas -->

                        <!-- Reportes -->
                        <?php if(
                            $this->permission1->method('administrar_activos_depreciacion','create')->access() ||
                            $this->permission1->method('administrar_activos_depreciacion','read')->access() ||
                            $this->permission1->method('administrar_activos_depreciacion','delete')->access() ||
                            $this->permission1->method('administrar_activos_depreciacion','update')->access()){ ?>
                            <li class="treeview <?php
                            if (
                                $this->uri->segment('1') == ("Cmactivos_depreciacion")
                            ) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                                <a href="#">
                                    <i class="ti-bar-chart"></i> <span> Reportes </span>
                                    <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                                </a>

                                <ul class="treeview-menu">

                                    <!-- Depreciacion -->

                                    <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cmactivos_depreciacion")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cmactivos_depreciacion') ?>"><span> Historial de Depreciación </span> </a></li>
                                    <!-- Fin depreciación -->

                                    <!-- <li class="treeview <?php
                                    if ($this->uri->segment('1') == ("Cma_reporte") && $this->uri->segment('2') == ("inventario_fisico") ) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('Cma_reporte/inventario_fisico') ?>"> Inventario Físico</a></li> -->



                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Fin reportes -->
                    </ul>
                </li>
            <?php } ?>
            <!-- ******************Fin Activos Fijos*********************** -->

            <!-- ****************************Menu Caja Chica***************************** -->
            <?php if(
                $this->permission1->method('administrar_caja_chica_administracion','read')->access() ||
                $this->permission1->method('administrar_caja_chica_cuenta','read')->access() ||
                $this->permission1->method('administrar_caja_chica_solicitante','read')->access() ||
                $this->permission1->method('administrar_caja_chica_configuracion','read')->access()


            ){ ?>
                <li class="treeview <?php
                if (
                    $this->uri->segment('1') == ("Cmcajachica_administracion") ||
                    $this->uri->segment('1') == ("Cmcajachica_cuenta") ||
                    $this->uri->segment('1') == ("Cmcajachica_solicitante") ||
                    $this->uri->segment('1') == ("Cmcajachica_configuracion")

                ){
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-archive"></i><span>Caja Chica</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>

                    <ul class="treeview-menu" >

                        <!-- Administración -->
                        <?php if(
                            $this->permission1->method('administrar_caja_chica_administracion','create')->access() ||
                            $this->permission1->method('administrar_caja_chica_administracion','read')->access() ||
                            $this->permission1->method('administrar_caja_chica_administracion','delete')->access() ||
                            $this->permission1->method('administrar_caja_chica_administracion','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmcajachica_administracion")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmcajachica_administracion') ?>">
                                    <i class="ti-pencil-alt"></i>  <span> Administración </span> </a></li>
                        <?php } ?>
                        <!-- Fin Administración -->

                        <!-- Cuenta -->
                        <?php if(
                            $this->permission1->method('administrar_caja_chica_cuenta','create')->access() ||
                            $this->permission1->method('administrar_caja_chica_cuenta','read')->access() ||
                            $this->permission1->method('administrar_caja_chica_cuenta','delete')->access() ||
                            $this->permission1->method('administrar_caja_chica_cuenta','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmcajachica_cuenta")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmcajachica_cuenta') ?>">
                                    <i class="ti-layers-alt"></i>  <span> Cuentas </span> </a></li>
                        <?php } ?>
                        <!-- Fin Cuenta -->

                        <!-- Solicitante -->
                        <?php if(
                            $this->permission1->method('administrar_caja_chica_solicitante','create')->access() ||
                            $this->permission1->method('administrar_caja_chica_solicitante','read')->access() ||
                            $this->permission1->method('administrar_caja_chica_solicitante','delete')->access() ||
                            $this->permission1->method('administrar_caja_chica_solicitante','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmcajachica_solicitante")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmcajachica_solicitante') ?>">
                                    <i class="ti-user"></i>  <span> Solicitante </span> </a></li>
                        <?php } ?>
                        <!-- Fin Solicitante -->

                        <!-- Configuración -->
                        <?php if(
                            $this->permission1->method('administrar_caja_chica_configuracion','create')->access() ||
                            $this->permission1->method('administrar_caja_chica_configuracion','read')->access() ||
                            $this->permission1->method('administrar_caja_chica_configuracion','delete')->access() ||
                            $this->permission1->method('administrar_caja_chica_configuracion','update')->access())
                        { ?>
                            <li class="treeview <?php
                            if ($this->uri->segment('1') == ("Cmcajachica_configuracion")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('Cmcajachica_configuracion') ?>">
                                    <i class="ti-money"></i>  <span> Configuración </span> </a></li>
                        <?php } ?>
                        <!-- Fin Configuración -->


                    </ul>
                </li>
            <?php } ?>
            <!-- ****************** Fin Caja Chica *********************** -->

          
  
 
            <!-- Centinela Web (Odeco) menu start -->
            <?php if($this->permission1->method('new_invoice','create')->access()){?>
                <li class="treeview <?php
                //incluir todos los controladores de los menus
                if ($this->uri->segment('1') == ("odeco")) {
                    echo "active";
                } else {
                    echo " ";
                }
                ?>">
                    <a href="#">
                        <i class="fa fa-user-o"></i><span>Centinela Web</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('1') == ("odeco") && $this->uri->segment('2') == ("")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('odeco') ?>">Generar Reclamo</a></li>
                        <?php } ?>

                        <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('2') == ("listar_reclamos")
                                ||$this->uri->segment('2') == ("listar_reclamos_atendidos")
                                ||$this->uri->segment('2') == ("ver_detalle_reclamo")
                                ||$this->uri->segment('2') == ("emitir_pronunciamiento")
                                ||$this->uri->segment('2') == ("editar_pronunciamiento")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('odeco/listar_reclamos') ?>">Gestión de Reclamos</a></li>
                        <?php } ?>
                        <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('2') == ("listar_reclamos_reportes")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('odeco/listar_reclamos_reportes') ?>">Reportes de Reclamos</a></li>
                        <?php } ?>
                        <!-- Submenu Sistema de Distribucion -->
                        <?php if($this->permission1->method('new_invoice','create')->access()){?>
                        <li class="treeview <?php
                            //se pone los controladores de los submenus
                            if ($this->uri->segment('1') == ("odeco") && (($this->uri->segment('2') == ("alimentadores_listar"))||($this->uri->segment('2') == ("agregar_alimentador"))||($this->uri->segment('2') == ("listar_maniobras"))||($this->uri->segment('2') == ("agregar_maniobra"))||($this->uri->segment('2') == ("listar_centros"))||($this->uri->segment('2') == ("agregar_centro"))))
                                    echo "active";
                                else echo " "; ?>">
                                <a href="#">
                                    <i class="ti-settings"></i> <span>Sistema de Distribuci&oacute;n</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                            <ul class="treeview-menu">

                                <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("alimentadores_listar")
                                        || $this->uri->segment('2') == ("agregar_alimentador")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/alimentadores_listar') ?>"> Alimentadores</a></li>
                                <?php } ?>

                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_maniobras")
                                        || $this->uri->segment('2') == ("agregar_maniobra")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_maniobras') ?>"> Elementos de Maniobra</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_centros")
                                        || $this->uri->segment('2') == ("agregar_centro")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_centros') ?>">Centros de Transformacion</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php }?>
                        <!-- Submenu Servicio tecnico -->
                            <li class="treeview <?php
                            //incluir todos los controladores de los menus
                            if ($this->uri->segment('1') == ("odeco") && (($this->uri->segment('2') == ("listar_cortes"))||($this->uri->segment('2') == ("agregar_corte"))||($this->uri->segment('2') == ("ver_editar_corte")) ||($this->uri->segment('2') == ("listar_libros"))||$this->uri->segment('2') == ("agregar_libro") ||$this->uri->segment('2') == ("ver_editar_libro") ||($this->uri->segment('2') == ("listar_interrupciones")) ||($this->uri->segment('2') == ("agregar_interrupcion")) ||($this->uri->segment('2') == ("ver_editar_interrupcion"))||($this->uri->segment('2') == ("listar_restituciones"))||($this->uri->segment('2') == ("listar_restituciones_mt"))))
                                    echo "active";
                                else echo " "; ?>">
                            <a href="#">
                                <i class="fa fa-adjust"></i><span>Servicio T&eacute;cnico</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_cortes")
                                        ||$this->uri->segment('2') == ("agregar_corte")
                                        ||$this->uri->segment('2') == ("ver_editar_corte")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_cortes') ?>">Cortes Programados</a></li>
                                <?php } ?>

                                <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_libros")
                                        ||$this->uri->segment('2') == ("agregar_libro")
                                        ||$this->uri->segment('2') == ("ver_editar_libro")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_libros') ?>">Libro de Guardia</a></li>
                                <?php } ?>

                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_interrupciones")
                                        ||$this->uri->segment('2') == ("agregar_interrupcion")
                                        ||$this->uri->segment('2') == ("ver_editar_interrupcion")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_interrupciones') ?>">Interrupciones</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_restituciones")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_restituciones') ?>">Restituci&oacute;n de Suministro</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("listar_restituciones_mt")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/listar_restituciones_mt') ?>">Restituci&oacute;n de Suministro MT</a></li>
                                <?php } ?>
                            </ul>
                        </li>

                        <!-- <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('1') == ("odeco") && ($this->uri->segment('2') == ("listar_cronogramas"))) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('odeco/listar_cronogramas') ?>">Cronograma de Instalaci&oacute;n de Equipos del PT</a></li>
                        <?php } ?> -->
                        <!-- Submenu Indicadores de Calidad -->
                        <!-- <?php if($this->permission1->method('new_invoice','create')->access()){?>
                        <li class="treeview <?php
                            //se pone los controladores de los submenus
                            if ($this->uri->segment('1') == ("odeco") && (($this->uri->segment('2') == ("indicadores_individuales"))||($this->uri->segment('2') == ("indicadores_globales"))||($this->uri->segment('2') == ("indicadores"))||($this->uri->segment('2') == ("retraso_rep_suministro"))))
                                    echo "active";
                                else echo " "; ?>">
                                <a href="#">
                                    <i class="fa fa-signal"></i> <span>Indicadores de Calidad</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                            <ul class="treeview-menu">
                                <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("indicadores_individuales")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/indicadores_individuales') ?>"> ST: Indicadores Individuales</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("indicadores_globales")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/indicadores_globales') ?>"> ST: Indicadores Globales</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("indicadores")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/indicadores') ?>">SC: Indicadores</a></li>
                                <?php } ?>
                                <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                                    <li  class="treeview <?php
                                    if ($this->uri->segment('2') == ("retraso_rep_suministro")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }
                                    ?>"><a href="<?php echo base_url('odeco/retraso_rep_suministro') ?>">Retraso Rep. Suministro</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php }?> -->
                        <?php if($this->permission1->method('new_invoice','read')->access()){ ?>
                            <li  class="treeview <?php
                            if ($this->uri->segment('1') == ("odeco") && ($this->uri->segment('2') == ("listar_feriados"))) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>"><a href="<?php echo base_url('odeco/listar_feriados') ?>">Parametrica de Feriados</a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <!-- Centinela Web menu end -->

            <!-- Invoice menu start -->
            <?php if($this->permission1->method('new_invoice','create')->access() || $this->permission1->method('manage_invoice','read')->access() || $this->permission1->method('pos_invoice','create')->access() || $this->permission1->method('gui_pos','create')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cinvoice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-balance-scale"></i><span><?php echo display('invoice') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if($this->permission1->method('new_invoice','create')->access()){ ?>
                    <li  class="treeview <?php
            if ($this->uri->segment('1') == ("Cinvoice") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cinvoice') ?>"><?php echo display('new_invoice') ?></a></li>
                <?php } ?>
                <?php if($this->permission1->method('manage_invoice','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_invoice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cinvoice/manage_invoice') ?>"><?php echo display('manage_invoice') ?></a></li>
                    <?php } ?>
                    <?php if($this->permission1->method('pos_invoice','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("pos_invoice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cinvoice/pos_invoice') ?>"><?php echo display('pos_invoice') ?></a></li>
            <?php } ?>
            <?php if($this->permission1->method('gui_pos','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("gui_pos")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cinvoice/gui_pos') ?>"><?php echo display('gui_pos') ?></a></li>
                    <?php } ?>
                </ul>
            </li>
             <?php } ?>
            <!-- Invoice menu end -->

            <!-- Customer menu start -->
            <?php if($this->permission1->method('add_customer','create')->access() || $this->permission1->method('manage_customer','read')->access() || $this->permission1->method('credit_customer','read')->access() || $this->permission1->method('paid_customer','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Ccustomer")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-handshake-o"></i><span><?php echo display('customer') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_customer','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Ccustomer") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer') ?>"><?php echo display('add_customer') ?></a></li>
                <?php } ?>
                <?php if($this->permission1->method('manage_customer','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_customer")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/manage_customer') ?>"><?php echo display('manage_customer') ?></a></li>
                     <?php } ?>
            <?php if($this->permission1->method('customer_ledger','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("customer_ledger_report")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/customer_ledger_report') ?>"><?php echo display('customer_ledger') ?></a></li>
                     <?php } ?>
                <?php if($this->permission1->method('credit_customer','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("credit_customer")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/credit_customer') ?>"><?php echo display('credit_customer') ?></a></li>
                     <?php } ?>
                     <?php if($this->permission1->method('paid_customer','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("paid_customer")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/paid_customer') ?>"><?php echo display('paid_customer') ?></a></li>
                     <?php } ?>
                     <?php if($this->permission1->method('customer_advance','create')->access()){ ?>
                      <li class="treeview <?php
            if ($this->uri->segment('2') == ("customer_advance")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccustomer/customer_advance') ?>"><?php echo display('customer_advance') ?></a></li>
                      <?php } ?>
                </ul>
            </li>
        <?php }?>
            <!-- Customer menu end -->
             <!-- Product menu start -->
             <?php if($this->permission1->method('create_product','create')->access() || $this->permission1->method('add_product_csv','create')->access() || $this->permission1->method('manage_product','read')->access() || $this->permission1->method('create_category','create')->access() || $this->permission1->method('manage_category','read')->access() || $this->permission1->method('add_unit','create')->access() || $this->permission1->method('manage_unit','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cproduct") ||$this->uri->segment('1') == ("Cunit")|| $this->uri->segment('1') == ("Ccategory")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-bag"></i><span><?php echo display('product') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                     <!-- Category menu end -->
        <?php if($this->permission1->method('manage_category','create')->access() || $this->permission1->method('manage_category','read')->access()|| $this->permission1->method('manage_category','update')->access()|| $this->permission1->method('manage_category','delete')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Ccategory")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Ccategory') ?>"><?php echo display('category') ?></a></li>
                <?php } ?>
            <!-- Category menu end -->
                   <!--Unit menu start-->
       <?php if($this->permission1->method('manage_unit','create')->access() || $this->permission1->method('manage_unit','read')->access() || $this->permission1->method('manage_unit','delete')->access() || $this->permission1->method('manage_unit','update')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == "Cunit") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cunit'); ?>"><?php echo display('unit'); ?></a></li>
                     <?php } ?>
                     <?php if($this->permission1->method('create_product','create')->access()){ ?>
                    <li  class="treeview <?php
            if ($this->uri->segment('1') == ("Cproduct") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cproduct') ?>"><?php echo display('add_product') ?></a></li>
                     <?php }?>
                     <?php if($this->permission1->method('add_product_csv','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("add_product_csv")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cproduct/add_product_csv') ?>"><?php echo display('import_product_csv') ?></a></li>
                    <?php }?>
                    <?php if($this->permission1->method('manage_product','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_product")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cproduct/manage_product') ?>"><?php echo display('manage_product') ?></a></li>
                    <?php }?>
                </ul>
            </li>
        <?php }?>
            <!-- Product menu end -->
             <!-- --- supplier menu start -->
<?php if($this->permission1->method('add_supplier','create')->access() || $this->permission1->method('manage_supplier','read')->access() || $this->permission1->method('supplier_ledger_report','read')->access() || $this->permission1->method('supplier_sales_details_all','read')->access()){?>
            <!-- Supplier menu start -->
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Csupplier")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-user"></i><span><?php echo display('supplier') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_supplier','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == "Csupplier" && $this->uri->segment('2') == "") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Csupplier') ?>"><?php echo display('add_supplier') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('manage_supplier','read')->access()){ ?>
                    <li class="treeview <?php
            if ( $this->uri->segment('2') == "manage_supplier") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Csupplier/manage_supplier') ?>"><?php echo display('manage_supplier') ?></a></li>
                    <?php } ?>
                    <?php if($this->permission1->method('supplier_ledger_report','read')->access()){ ?>
                    <li  class="treeview <?php
            if ($this->uri->segment('2') == "supplier_ledger_report" || $this->uri->segment('2') == "supplier_ledger") {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Csupplier/supplier_ledger_report') ?>"><?php echo display('supplier_ledger') ?></a></li>
                     <?php } ?>

                <?php if($this->permission1->method('supplier_advance','create')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("supplier_advance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csupplier/supplier_advance') ?>"><?php echo display('supplier_advance') ?></a></li>
                  <?php } ?>
                </ul>
            </li>
        <?php } ?>
            <!-- Supplier menu end -->

                     <!-- Purchase menu start -->
            <?php if($this->permission1->method('add_purchase','create')->access() || $this->permission1->method('manage_purchase','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cpurchase")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-shopping-cart"></i><span><?php echo display('purchase') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_purchase','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cpurchase") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cpurchase') ?>"><?php echo display('add_purchase') ?></a></li>
                       <?php } ?>
                     <?php if($this->permission1->method('manage_purchase','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_purchase")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cpurchase/manage_purchase') ?>"><?php echo display('manage_purchase') ?></a></li>
                       <?php } ?>
                </ul>
            </li>
        <?php } ?>
            <!-- Purchase menu end -->
             <!-- Quotation Menu Start -->
         <?php if($this->permission1->method('add_quotation','create')->access() || $this->permission1->method('manage_quotation','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cquotation")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-book"></i><span><?php echo display('quotation') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
            <?php if($this->permission1->method('add_quotation','create')->access()){ ?>
                    <li><a href="<?php echo base_url('Cquotation') ?>"><?php echo display('add_quotation') ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('manage_quotation','read')->access()){ ?>
                    <li><a href="<?php echo base_url('Cquotation/manage_quotation') ?>"><?php echo display('manage_quotation') ?></a></li>
                <?php } ?>
                </ul>
            </li>
        <?php }?>
            <!-- quotation Menu end -->
             <!-- Stock menu start -->
            <?php if($this->permission1->method('stock_report','read')->access() || $this->permission1->method('stock_report_sp_wise','read')->access() || $this->permission1->method('stock_report_pro_wise','read')->access()){?>
        <li hidden class="treeview <?php
        if ($this->uri->segment('1') == ("Creport")) {
            echo "active";
        } else {
            echo " ";
        }
        ?>">
            <a href="#">
                <i class="ti-bar-chart"></i><span><?php echo display('stock') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                 <?php if($this->permission1->method('stock_report','read')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('1') == ("Creport") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Creport') ?>"><?php echo display('stock_report') ?></a></li>
            <?php }?>

            </ul>
        </li>
    <?php }?>
        <!-- Stock menu end -->
        <?php if($this->permission1->method('add_return','create')->access() || $this->permission1->method('return_list','read')->access() || $this->permission1->method('supplier_return_list','read')->access() || $this->permission1->method('wastage_return_list','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cretrun_m")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-retweet" aria-hidden="true"></i><span><?php echo display('return'); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_return','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('1') == ("Cretrun_m") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cretrun_m') ?>"><?php echo display('return'); ?></a></li>
                      <?php } ?>
                     <?php if($this->permission1->method('return_list','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("return_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cretrun_m/return_list') ?>"><?php echo display('stock_return_list') ?></a></li>
                      <?php } ?>
                     <?php if($this->permission1->method('supplier_return_list','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("supplier_return_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cretrun_m/supplier_return_list') ?>"><?php echo display('supplier_return_list') ?></a></li>
                      <?php } ?>
                    <?php if($this->permission1->method('wastage_return_list','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("wastage_return_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cretrun_m/wastage_return_list') ?>"><?php echo display('wastage_return_list') ?></a></li>
                      <?php } ?>

                </ul>
            </li>

<?php } ?>

            <!-- Report menu start -->
             <?php if($this->permission1->method('add_closing','create')->access() || $this->permission1->method('closing_report','read')->access() || $this->permission1->method('all_report','read')->access() || $this->permission1->method('todays_customer_receipt','read')->access() || $this->permission1->method('todays_sales_report','read')->access() || $this->permission1->method('retrieve_dateWise_DueReports','read')->access() || $this->permission1->method('todays_purchase_report','read')->access() || $this->permission1->method('purchase_report_category_wise','read')->access() || $this->permission1->method('product_sales_reports_date_wise','read')->access() || $this->permission1->method('sales_report_category_wise','read')->access() || $this->permission1->method('shipping_cost_report','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('2') == ("all_report") || $this->uri->segment('2') == ("todays_sales_report") || $this->uri->segment('2') == ("todays_purchase_report") || $this->uri->segment('2') == ("product_sales_reports_date_wise") || $this->uri->segment('2') == ("total_profit_report") || $this->uri->segment('2') == ("purchase_report_category_wise") || $this->uri->segment('2') == ("sales_report_category_wise") || $this->uri->segment('2') == ("filter_purchase_report_category_wise") || $this->uri->segment('2') == ("sales_report_category_wise") || $this->uri->segment('2') == ("todays_customer_receipt") || $this->uri->segment('2') == ("filter_sales_report_category_wise") || $this->uri->segment('2') == ("filter_customer_wise_receipt") || $this->uri->segment('2') == ("closing") || $this->uri->segment('2') == ("closing_report") || $this->uri->segment('2') == ("date_wise_closing_reports") || $this->uri->segment('2') == ("retrieve_dateWise_Shippingcost") || $this->uri->segment('2') == ("product_sales_search_reports") || $this->uri->segment('2') == ("user_sales_report") || $this->uri->segment('2') == ("retrieve_dateWise_DueReports") || $this->uri->segment('2') == ("sales_return") || $this->uri->segment('2') == ("supplier_return")|| $this->uri->segment('2') == ("retrieve_dateWise_tax")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-book"></i><span><?php echo display('report') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_closing','read')->access()){ ?>
                 <li class="treeview <?php if ($this->uri->segment('2') == ("closing")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/closing') ?>"><?php echo display('closing') ?></a></li>
                  <?php } ?>
             <?php if($this->permission1->method('closing_report','read')->access()){ ?>
                   <li class="treeview <?php if ($this->uri->segment('2') == ("closing_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/closing_report') ?>"><?php echo display('closing_report') ?></a></li>
                    <?php } ?>
             <?php if($this->permission1->method('all_report','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("all_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/all_report') ?>"><?php echo display('todays_report') ?></a></li>
                     <?php } ?>
             <?php if($this->permission1->method('todays_customer_receipt','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("todays_customer_receipt")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/todays_customer_receipt') ?>"><?php echo display('todays_customer_receipt') ?></a></li>
                     <?php } ?>
             <?php if($this->permission1->method('todays_sales_report','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("todays_sales_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/todays_sales_report') ?>"><?php echo display('sales_report') ?></a></li>
                     <?php } ?>
                     <?php if($this->permission1->method('user_wise_sales_report','read')->access()){ ?>
                       <li class="treeview <?php if ($this->uri->segment('2') == ("user_sales_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/user_sales_report') ?>"><?php echo display('user_wise_sales_report') ?></a></li>
                         <?php } ?>
             <?php if($this->permission1->method('retrieve_dateWise_DueReports','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("retrieve_dateWise_DueReports")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/retrieve_dateWise_DueReports') ?>"><?php echo display('due_report'); ?></a></li>
                     <?php } ?>
                      <?php if($this->permission1->method('shipping_cost_report','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("retrieve_dateWise_Shippingcost")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/retrieve_dateWise_Shippingcost') ?>"><?php echo display('shipping_cost_report'); ?></a></li>
                       <?php } ?>
             <?php if($this->permission1->method('todays_purchase_report','read')->access()){ ?>
                    <li><a href="<?php echo base_url('Admin_dashboard/todays_purchase_report') ?>"><?php echo display('purchase_report') ?></a></li>
                     <?php } ?>
             <?php if($this->permission1->method('purchase_report_category_wise','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("purchase_report_category_wise")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/purchase_report_category_wise') ?>"><?php echo display('purchase_report_category_wise') ?></a></li>
                     <?php } ?>
             <?php if($this->permission1->method('product_sales_reports_date_wise','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("product_sales_reports_date_wise")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/product_sales_reports_date_wise') ?>"><?php echo display('sales_report_product_wise') ?></a></li>
                     <?php } ?>
             <?php if($this->permission1->method('sales_report_category_wise','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("sales_report_category_wise")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/sales_report_category_wise') ?>"><?php echo display('sales_report_category_wise') ?></a></li>
                     <?php } ?>
                     <?php if($this->permission1->method('invoice_return','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("sales_return")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/sales_return') ?>"><?php echo display('invoice_return') ?></a></li>
                       <?php } ?>
                       <?php if($this->permission1->method('supplier_return','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("supplier_return")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/supplier_return') ?>"><?php echo display('supplier_return') ?></a></li>
                      <?php } ?>
                       <?php if($this->permission1->method('tax_report','read')->access()){ ?>
                     <li class="treeview <?php if ($this->uri->segment('2') == ("retrieve_dateWise_tax")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/retrieve_dateWise_tax') ?>"><?php echo display('tax_report') ?></a></li>
                      <?php } ?>
                      <?php if($this->permission1->method('profit_report','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("total_profit_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Admin_dashboard/total_profit_report') ?>"><?php echo display('profit_report') ?></a></li>
                    <?php } ?>
                </ul>
            </li>
        <?php }?>
            <!-- Report menu end -->


<!--New Account start-->
 <?php if($this->permission1->method('show_tree','read')->access() || $this->permission1->method('supplier_payment','create')->access()|| $this->permission1->method('customer_receive','create')->access() || $this->permission1->method('debit_voucher','create')->access() || $this->permission1->method('credit_voucher','create')->access() || $this->permission1->method('aprove_v','read')->access() || $this->permission1->method('contra_voucher','create')->access() || $this->permission1->method('journal_voucher','create')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("accounts")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-money"></i><span><?php echo display('accounts') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('show_tree','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("show_tree")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/show_tree') ?>"><?php echo display('c_o_a'); ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('supplier_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("supplier_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/supplier_payment') ?>"><?php echo display('supplier_payment'); ?></a></li>
                    <?php }?>
                      <?php if($this->permission1->method('customer_receive','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("customer_receive")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/customer_receive') ?>"><?php echo display('customer_receive'); ?></a></li>
                    <?php }?>

                     <?php if($this->permission1->method('cash_adjustment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("cash_adjustment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/cash_adjustment') ?>"><?php echo display('cash_adjustment'); ?></a></li>
                    <?php }?>
                     <?php if($this->permission1->method('debit_voucher','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("debit_voucher")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/debit_voucher') ?>"><?php echo display('debit_voucher') ?></a></li>
                     <?php }?>
                      <?php if($this->permission1->method('credit_voucher','create')->access()){ ?>
                     <li class="treeview <?php if ($this->uri->segment('2') == ("credit_voucher")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/credit_voucher') ?>"><?php echo display('credit_voucher'); ?></a></li>
                     <?php }?>
                      <?php if($this->permission1->method('aprove_v','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("aprove_v")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/aprove_v') ?>"><?php echo display('voucher_approval'); ?></a></li>
                     <?php }?>
                      <?php if($this->permission1->method('contra_voucher','create')->access()){ ?>
                       <li class="treeview <?php if ($this->uri->segment('2') == ("contra_voucher")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/contra_voucher') ?>"><?php echo display('contra_voucher'); ?></a></li>
                     <?php }?>
                      <?php if($this->permission1->method('journal_voucher','create')->access()){ ?>
                        <li class="treeview <?php if ($this->uri->segment('2') == ("journal_voucher")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/journal_voucher') ?>"><?php echo display('journal_voucher'); ?></a></li>
                     <?php }?>
                    <?php if($this->permission1->method('ac_report','create')->access()){ ?>
                             <li class="treeview <?php
                    if ($this->uri->segment('2') == ("voucher_report") || $this->uri->segment('2') == ("cash_book") || $this->uri->segment('2') == ("bank_book") || $this->uri->segment('2') == ("general_ledger")|| $this->uri->segment('2') == ("trial_balance")|| $this->uri->segment('2') == ("profit_loss_report")|| $this->uri->segment('2') == ("cash_flow_report")|| $this->uri->segment('2') == ("inventory_ledger")|| $this->uri->segment('2') == ("coa_print")) {
                        echo "active";
                    } else {
                        echo " ";
                    }
                    ?>"><a href=""style="position: relative;"><?php echo display('report') ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                      <!--       <li class="treeview <?php if ($this->uri->segment('2') == ("voucher_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/voucher_report') ?>"><?php echo 'Voucher Report' ?></a></li> -->
                    <?php if($this->permission1->method('cash_book','read')->access()){ ?>
                 <li class="treeview <?php if ($this->uri->segment('2') == ("cash_book")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/cash_book') ?>"><?php echo display('cash_book'); ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('inventory_ledger','read')->access()){ ?>
                     <li class="treeview <?php if ($this->uri->segment('2') == ("inventory_ledger")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/inventory_ledger') ?>"><?php echo display('Inventory_ledger'); ?></a></li>
                <?php } ?>
                  <?php if($this->permission1->method('bank_book','read')->access()){ ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("bank_book")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/bank_book') ?>"><?php echo display('bank_book'); ?></a></li>
                      <?php } ?>
                      <?php if($this->permission1->method('general_ledger','read')->access()){ ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("general_ledger")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/general_ledger') ?>"><?php echo display('general_ledger'); ?></a></li>
                      <?php } ?>
                       <?php if($this->permission1->method('trial_balance','read')->access()){ ?>
                            <li class="treeview <?php if ($this->uri->segment('2') == ("trial_balance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/trial_balance') ?>"><?php echo display('trial_balance'); ?></a></li>
                     <?php } ?>
                              <li class="treeview <?php if ($this->uri->segment('2') == ("profit_loss_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/profit_loss_report') ?>"><?php echo display('profit_loss'); ?></a></li>
                     <?php if($this->permission1->method('cash_flow_report','read')->access()){ ?>
                              <li class="treeview <?php if ($this->uri->segment('2') == ("cash_flow_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/cash_flow_report') ?>"><?php echo display('cash_flow'); ?></a></li>
                     <?php } ?>
                      <?php if($this->permission1->method('coa_print','read')->access()){ ?>
                               <li class="treeview <?php if ($this->uri->segment('2') == ("coa_print")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('accounts/coa_print') ?>"><?php echo display('coa_print'); ?></a></li>
                    <?php } ?>
                        </ul>

            </li>
        <?php } ?>
                </ul>
            </li>
           <?php } ?>
<!-- New Account End -->

            <!-- Bank menu start -->
              <?php if($this->permission1->method('add_bank','create')->access() || $this->permission1->method('bank_transaction','create')->access() || $this->permission1->method('bank_list','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('2') == ("index") || $this->uri->segment('2') == ("bank_list") || $this->uri->segment('2') == ("bank_ledger") || $this->uri->segment('2') == ("bank_transaction")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-briefcase"></i><span><?php echo display('bank') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                      <?php if($this->permission1->method('add_bank','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('1') == ("Csettings") && $this->uri->segment('2') == ("index")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/index') ?>"><?php echo display('add_new_bank') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('bank_transaction','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("bank_transaction")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/bank_transaction') ?>"><?php echo display('bank_transaction') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('bank_list','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("bank_list")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/bank_list') ?>"><?php echo display('manage_bank') ?></a></li>
                <?php }?>
                </ul>
            </li>
        <?php } ?>
            <!-- Bank menu end -->



            <!-- Tax menu start -->
              <?php if($this->permission1->method('add_incometax','create')->access() || $this->permission1->method('manage_income_tax','read')->access()|| $this->permission1->method('tax_settings','create')->access() || $this->permission1->method('tax_report','read')->access() || $this->permission1->method('invoice_wise_tax_report','read')->access() || $this->permission1->method('tax_settings','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Caccounts") || $this->uri->segment('1') == ("Account_Controller") || $this->uri->segment('1') == ("Cpayment")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-money"></i><span><?php echo display('tax') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
             <?php if($this->permission1->method('tax_settings','create')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("tax_settings")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Caccounts/tax_settings') ?>"><?php echo display('tax_settings') ?></a></li>
                      <?php } ?>

                <?php if($this->permission1->method('add_incometax','create')->access()){ ?>
                 <li class="treeview <?php if ($this->uri->segment('2') == ("add_incometax")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Caccounts/add_incometax') ?>"><?php echo display('add_incometax') ?></a></li>
                 <?php } ?>
                 <?php if($this->permission1->method('manage_income_tax','read')->access()){ ?>
                  <li class="treeview <?php if ($this->uri->segment('2') == ("manage_income_tax")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Caccounts/manage_income_tax') ?>"><?php echo display('manage_income_tax') ?></a></li>
                    <?php } ?>
                <?php if($this->permission1->method('tax_report','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("tax_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Caccounts/tax_report') ?>"><?php echo display('tax_report') ?></a></li>
                    <?php } ?>
                <?php if($this->permission1->method('invoice_wise_tax_report','read')->access()){ ?>
                <li class="treeview <?php if ($this->uri->segment('2') == ("invoice_wise_tax_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Caccounts/invoice_wise_tax_report') ?>"><?php echo display('invoice_wise_tax_report') ?></a></li>
                <?php } ?>
                     </ul>



            </li>
       <?php } ?>

             <!-- human resource management menu start -->
             <?php if($this->permission1->method('add_designation','create')->access() || $this->permission1->method('manage_designation','read')->access() || $this->permission1->method('add_employee','create')->access() || $this->permission1->method('manage_employee','read')->access() ||$this->permission1->method('add_person','create')->access() || $this->permission1->method('add_loan','create')->access() || $this->permission1->method('add_payment','create')->access() || $this->permission1->method('manage_person','read')->access()||$this->permission1->method('add_attendance','create')->access() || $this->permission1->method('manage_attendance','read')->access() || $this->permission1->method('attendance_report','read')->access() || $this->permission1->method('add_benefits','create')->access() || $this->permission1->method('manage_benefits','read')->access() || $this->permission1->method('add_salary_setup','create')->access() || $this->permission1->method('manage_salary_setup','read')->access() || $this->permission1->method('salary_generate','create')->access() || $this->permission1->method('manage_salary_generate','read')->access() || $this->permission1->method('salary_payment','create')->access() || $this->permission1->method('add_expense_item','create')->access() || $this->permission1->method('manage_expense_item','read')->access() || $this->permission1->method('add_expense','create')->access() || $this->permission1->method('manage_expense','read')->access() || $this->permission1->method('add1_person','create')->access() || $this->permission1->method('add_office_loan','create')->access() || $this->permission1->method('add_loan_payment','create')->access() || $this->permission1->method('manage1_person','read')->access()){?>
            <!-- Supplier menu start -->
            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm") || $this->uri->segment('1') == ("Cattendance") || $this->uri->segment('1') == ("Cpayroll") || $this->uri->segment('1') == ("Cexpense") || $this->uri->segment('1') == ("Cloan") || $this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("manage_person") || $this->uri->segment('2') == ("person_loan_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users"></i><span><?php echo display('hrm_management') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
       <?php if($this->permission1->method('add_designation','create')->access() || $this->permission1->method('manage_designation','read')->access() || $this->permission1->method('add_employee','create')->access() || $this->permission1->method('manage_employee','read')->access()){?>
            <!-- Supplier menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users"></i><span><?php echo display('hrm') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
         <?php if($this->permission1->method('add_designation','create')->access()){ ?>
          <li class="treeview <?php if ($this->uri->segment('2') == ("add_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_designation') ?>"><?php echo display('add_designation') ?></a></li>
     <?php } ?>
         <?php if($this->permission1->method('manage_designation','read')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_designation') ?>"><?php echo display('manage_designation') ?></a></li>
                          <?php } ?>
        <?php if($this->permission1->method('add_employee','create')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("add_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_employee') ?>"><?php echo display('add_employee') ?></a></li>
                    <?php } ?>
            <?php if($this->permission1->method('manage_employee','read')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_employee') ?>"><?php echo display('manage_employee') ?></a></li>
                          <?php } ?>

                </ul>
            </li>
        <?php } ?>


              <!-- ================== Attendance menu start ================= -->
            <?php if($this->permission1->method('add_attendance','create')->access() || $this->permission1->method('manage_attendance','read')->access() || $this->permission1->method('attendance_report','read')->access()){?>
                          <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cattendance")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-clock-o"></i><span><?php echo display('attendance') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
         <?php if($this->permission1->method('add_attendance','create')->access()){ ?>
               <li class="treeview <?php if ($this->uri->segment('2') == ("add_attendance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/add_attendance') ?>"><?php echo display('add_attendance') ?></a></li>
           <?php } ?>
        <?php if($this->permission1->method('manage_attendance','read')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_attendance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/manage_attendance') ?>"><?php echo display('manage_attendance') ?></a></li>
                          <?php } ?>
        <?php if($this->permission1->method('attendance_report','read')->access()){ ?>
                          <li class="treeview <?php if ($this->uri->segment('2') == ("attendance_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/attendance_report') ?>"><?php echo display('attendance_report') ?></a></li>
                          <?php } ?>
                </ul>
            </li>
              <?php } ?>
               <!-- ====================== Attendance menu end ================== -->

                            <!-- ========================== Payroll menu start =================== -->
                    <?php if($this->permission1->method('add_benefits','create')->access() || $this->permission1->method('manage_benefits','read')->access() || $this->permission1->method('add_salary_setup','create')->access() || $this->permission1->method('manage_salary_setup','read')->access() || $this->permission1->method('salary_generate','create')->access() || $this->permission1->method('manage_salary_generate','read')->access() || $this->permission1->method('salary_payment','create')->access()){?>
            <!-- Supplier menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cpayroll")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-paypal"></i><span><?php echo display('payroll') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
            <?php if($this->permission1->method('add_benefits','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("Salarybenificial")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/Salarybenificial') ?>">
                        <?php echo display('add_benefits') ?></a></li><?php }?>
            <?php if($this->permission1->method('manage_benefits','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("manage_benefits")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_benefits') ?>"><?php echo display('manage_benefits') ?></a></li>
                      <?php }?>
             <?php if($this->permission1->method('add_salary_setup','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("salary_setup_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_setup_form') ?>"><?php echo display('add_salary_setup') ?></a></li>
                       <?php }?>
            <?php if($this->permission1->method('manage_salary_setup','read')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("manage_salary_setup")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_salary_setup') ?>"><?php echo display('manage_salary_setup') ?></a></li>
                       <?php }?>
            <?php if($this->permission1->method('salary_generate','create')->access()){ ?>
                       <li class="treeview <?php if ($this->uri->segment('2') == ("salary_generate_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_generate_form') ?>"><?php echo display('salary_generate') ?></a></li>
                       <?php }?>
            <?php if($this->permission1->method('manage_salary_generate','read')->access()){ ?>
                       <li class="treeview <?php if ($this->uri->segment('2') == ("manage_salary_generate")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_salary_generate') ?>"><?php echo display('manage_salary_generate') ?></a></li>
                        <?php }?>
                        <?php if($this->permission1->method('salary_payment','create')->access()){ ?>
                     <li class="treeview <?php if ($this->uri->segment('2') == ("salary_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_payment') ?>"><?php echo display('salary_payment') ?></a></li>   <?php }?>

                </ul>
            </li>
        <?php } ?>
               <!-- =============================== Payroll menu end =================== -->
                 <!-- =======================   Expense menu start ========================= -->
         <?php if($this->permission1->method('add_expense_item','create')->access() || $this->permission1->method('manage_expense_item','read')->access() || $this->permission1->method('add_expense','create')->access() || $this->permission1->method('manage_expense','read')->access()){?>
             <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cexpense")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-credit-card"></i><span><?php echo display('expense') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                      <?php
                    if($this->permission1->method('add_expense_item','create')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("add_expense_item")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/add_expense_item') ?>"><?php echo display('add_expense_item') ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('manage_expense_item','read')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_expense_item")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/manage_expense_item') ?>"><?php echo display('manage_expense_item') ?></a></li>
                <?php }?>
                    <?php if($this->permission1->method('add_expense','create')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("add_expense")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/add_expense') ?>"><?php echo display('add_expense') ?></a></li>
                <?php } ?>
                <?php if($this->permission1->method('manage_expense','read')->access()){ ?>
                     <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_expense")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/manage_expense') ?>"><?php echo display('manage_expense') ?></a></li>
                     <?php } ?>
                      <?php if($this->permission1->method('expense_statement','read')->access()){ ?>
                      <li  class="treeview <?php  if ($this->uri->segment('2') == ("expense_statement_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/expense_statement_form') ?>"><?php echo display('expense_statement') ?></a></li>
                  <?php }?>
                </ul>
            </li>
        <?php }?>
    <!-- ========================== Expense menu end ========================== -->

            <!-- Office loan start -->
             <?php if($this->permission1->method('add1_person','create')->access() || $this->permission1->method('add_office_loan','create')->access() || $this->permission1->method('add_loan_payment','create')->access() || $this->permission1->method('manage1_person','read')->access()){?>
           <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cloan") && $this->uri->segment('2') == ("add1_person") || $this->uri->segment('2') == ("manage1_person") || $this->uri->segment('2') == ("person_ledger") || $this->uri->segment('2') == ("add_office_loan") || $this->uri->segment('2') == ("add_loan_payment") || $this->uri->segment('2') == ("person_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-university" aria-hidden="true"></i>

                    <span><?php echo display('office_loan') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add1_person','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add1_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add1_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('add_office_loan','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("add_office_loan")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_office_loan') ?>"><?php echo display('add_loan') ?></a></li>
                  <?php }?>
                   <?php if($this->permission1->method('add_loan_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_loan_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_loan_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('manage1_person','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage1_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/manage1_person') ?>"><?php echo display('manage_loan') ?></a></li>
                <?php }?>
                </ul>
            </li>
        <?php }?>
            <!-- Office loan end -->
            <!--  Personal loan start -->
               <?php if($this->permission1->method('add_person','create')->access() || $this->permission1->method('add_loan','create')->access() || $this->permission1->method('add_payment','create')->access() || $this->permission1->method('manage_person','read')->access()){?>
            <li class="treeview <?php
            if ($this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("manage_person") || $this->uri->segment('2') == ("person_loan_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <span><?php echo display('personal_loan') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if($this->permission1->method('add_person','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('add_loan','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_loan")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_loan') ?>"><?php echo display('add_loan') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('add_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('manage_person','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/manage_person') ?>"><?php echo display('manage_loan') ?></a></li>
                    <?php }?>
                </ul>
            </li>
        <?php }?>
            <!-- loan end -->
                </ul>
            </li>
        <?php } ?>
             <!-- Human resource management menu end -->

            <!-- service menu start -->
             <?php if($this->permission1->method('create_service','create')->access() || $this->permission1->method('manage_service','read')->access() || $this->permission1->method('service_invoice','create')->access() || $this->permission1->method('manage_service_invoice','read')->access()){?>

            <li hidden class="treeview <?php
            if ($this->uri->segment('1') == ("Cservice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-asl-interpreting"></i><span><?php echo display('service') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if($this->permission1->method('create_service','create')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cservice") && $this->uri->segment('2') == ("")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cservice') ?>"><?php echo display('add_service') ?></a></li>
                <?php } ?>
                 <?php if($this->permission1->method('manage_service','read')->access()){ ?>
                    <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_service")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cservice/manage_service') ?>"><?php echo display('manage_service') ?></a></li>
                      <?php } ?>
                       <?php if($this->permission1->method('service_invoice','create')->access()){ ?>
                       <li class="treeview <?php
            if ($this->uri->segment('2') == ("service_invoice_form")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cservice/service_invoice_form') ?>"><?php echo display('service_invoice') ?></a></li>
                       <?php } ?>
                        <?php if($this->permission1->method('manage_service_invoice','read')->access()){ ?>
                       <li class="treeview <?php
            if ($this->uri->segment('2') == ("manage_service_invoice")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>"><a href="<?php echo base_url('Cservice/manage_service_invoice') ?>"><?php echo display('manage_service_invoice') ?></a></li>
                       <?php } ?>
                </ul>
            </li>
        <?php } ?>



            <!-- Comission start -->
             <?php if($this->permission1->method('commission','create')->access() || $this->permission1->method('commission','read')->access()){?>
            <li hidden class="treeview <?php
            if ($this->uri->segment('2') == ("commission") || $this->uri->segment('2') == ("commission_generate")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="ti-layout-grid2"></i><span><?php echo display('commission') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('commission','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("commission")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/commission') ?>"><?php echo display('generate_commission') ?></a></li>
                      <?php } ?>
                </ul>
            </li>
        <?php } ?>
        <!-- Comission end -->

        <!-- RECURSOS HUMANOS - JLMG -->
        <?php if($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()){?>
            <li class="treeview <?php echo $this->uri->segment('1') === "security" ? 'active': ''; ?>">
                <a href="#">
                    <i class="fa fa-id-card-o"></i><span>Seguridad</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!-- REPORTES -->
                    <?php if($this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                        <li class="treeview <?php echo $this->uri->segment('2') === 'reports' ? 'active':''; ?>">
                            <a href="<?php echo base_url('security/reports') ?>">
                                <i class="ti-bar-chart"></i> Reportes
                            </a>
                        </li>
                    <?php }?>
                    <!-- REPORTES End -->

                    <!-- OTROS -->
                    <?php if($this->permission1->method('add_role','create')->access() || $this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()){?>
                        <li hidden class="treeview <?php
                            echo ($this->uri->segment('1') == ("rrhh") &&
                                (($this->uri->segment('2') == ("empleados")) ||
                                ($this->uri->segment('2') == ("factores")) )) ? 'active':'';
                            ?>">
                            <a href="#">
                                <i class="fa fa-columns"></i> <span><?php echo "Registros"; ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if($this->permission1->method('add_role','create')->access()){?>
                                    <!-- Empleados -->
                                    <li class="treeview <?php
                                        if ($this->uri->segment('2') == ("empleados"))
                                            echo "active";
                                        else echo " "; ?>">
                                        <a href="<?php echo base_url('rrhh/empleados')?>"><?php echo "Empleados"; ?></a>
                                    </li>
                                <?php }?>
                            </ul>
                        </li>
                    <?php }?>
                    <!-- REGISTROS End -->
                </ul>
            </li>
        <?php }?>
        <!-- RECURSOS HUMANOS - JLMG end -->

        <!-- CONFIGURACIONES -->
        <?php if ($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('add_role','create')->access() ||$this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access() || $this->permission1->method('sms_configure','create')->access()) { ?>
            <li class="treeview <?php echo (
                    $this->uri->segment('1') === "Company_setup" ||
                    $this->uri->segment('1') === "User" ||
                    $this->uri->segment('1') === "Cweb_setting" ||
                    $this->uri->segment('1') === "Language" ||
                    $this->uri->segment('1') === "Currency" ||
                    $this->uri->segment('1') === "Permission" ||
                    $this->uri->segment('1') === "Csms" ||
                    $this->uri->segment('1') === "Backup_restore"
                ) ? 'active':'';
            ?>">
                <a href="#">
                    <i class="ti-settings"></i><span>Configuraciones</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!-- Software Settings menu start -->
                    <?php if ($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('back_up','create')->access() || $this->permission1->method('back_up','read')->access() || $this->permission1->method('restore','create')->access() || $this->permission1->method('sql_import','create')->access()) { ?>
                        <li class="treeview <?php echo
                            (
                                $this->uri->segment('1') === "Company_setup" ||
                                $this->uri->segment('1') === "Cweb_setting" ||
                                $this->uri->segment('1') === "Language" ||
                                $this->uri->segment('1') === "Currency"
                            ) ? 'active':''; ?>">
                            <a href="#">
                                <i class="ti-settings"></i> <span>Sistema</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('manage_company','read')->access() || $this->permission1->method('manage_company','update')->access()) { ?>
                                    <li class="treeview <?php echo (
                                            $this->uri->segment('2') === "manage_company" ||
                                            $this->uri->segment('2') === "company_update_form"
                                        ) ? 'active':''; ?>"><a href="<?php echo base_url('Company_setup/manage_company') ?>">Administrar Empresa</a>
                                    </li>
                                <?php } ?>
                                <?php if($this->permission1->method('add_language','create')->access() || $this->permission1->method('add_language','update')->access()){?>
                                    <li hidden class="treeview <?php if ($this->uri->segment('1') == ("Language") && $this->uri->segment('2') == ("")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Language') ?>"><?php echo display('language') ?> </a>
                                    </li>
                                <?php } ?>
                                <?php if($this->permission1->method('add_currency','create')->access()){?>
                                    <li hidden class="treeview <?php if ($this->uri->segment('1') == ("Currency") && $this->uri->segment('2') == ("")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Currency') ?>"><?php echo display('currency') ?> </a>
                                    </li>
                                <?php } ?>
                                <?php if ($this->permission1->method('soft_setting','create')->access() || $this->permission1->method('soft_setting','update')->access()) { ?>
                                    <li class="treeview <?php echo ($this->uri->segment('1') === "Cweb_setting" && $this->uri->segment('2') == "") ? 'active':''; ?>">
                                        <a href="<?php echo base_url('Cweb_setting') ?>">Configuraciones</a>
                                    </li>
                                <?php } ?>
                                <?php if($this->permission1->method('mail_setting','create')->access()) { ?>
                                    <li hidden class="treeview <?php if ($this->uri->segment('1') == ("Cweb_setting") && $this->uri->segment('2') == ("mail_setting")) {
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Cweb_setting/mail_setting') ?>"><?php echo display('mail_setting') ?> </a>
                                    </li>
                                <?php } ?>
                                <li hidden class="treeview <?php if ($this->uri->segment('1') == "Cweb_setting" && $this->uri->segment('2') == "app_setting"){
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }?>"><a href="<?php echo base_url('Cweb_setting/app_setting') ?>"><?php echo display('app_setting') ?> </a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Software Settings menu End -->

                    <!-- Users start -->
                    <?php if ($this->permission1->method('manage_company','read')->access() ||$this->permission1->method('manage_company','create')->access() || $this->permission1->method('add_user','create')->access() || $this->permission1->method('manage_user','read')->access() || $this->permission1->method('add_language','create')->access() || $this->permission1->method('add_currency','create')->access() || $this->permission1->method('soft_setting','create')->access() || $this->permission1->method('back_up','create')->access() || $this->permission1->method('back_up','read')->access() || $this->permission1->method('restore','create')->access() || $this->permission1->method('sql_import','create')->access()) { ?>
                        <li class="treeview <?php echo ($this->uri->segment('1') === "User") ? 'active':''; ?>">
                            <a href="#">
                                <i class="ti-user"></i> <span>Usuarios</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if ($this->permission1->method('manage_user','read')->access()) { ?>
                                    <li class="treeview <?php echo ($this->uri->segment('1') === "User" && (
                                            $this->uri->segment('2') === "manage_user" ||
                                            $this->uri->segment('2') === "user_update_form" ||
                                            $this->uri->segment('2') == "")
                                        ) ? 'active' : ''; ?>"><a href="<?php echo base_url('User/manage_user') ?>">Administrar Usuarios</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Users End -->

                    <!-- Role permission start -->
                    <?php if($this->permission1->method('add_role','create')->access() || $this->permission1->method('role_list','read')->access() || $this->permission1->method('user_assign','create')->access()) { ?>
                        <li hidden class="treeview <?php
                            if ($this->uri->segment('1') == ("Permission")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                            ?>">
                            <a href="#">
                                <i class="ti-key"></i> <span><?php echo display('role_permission') ?></span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <!--<li><a href="<?php echo base_url('Permission/module_form')?>"><?php echo display('add_module') ?></a></li>
                                <li><a href="<?php echo base_url('Permission/menu_form')?>"><?php echo display('add_menu') ?></a></li>-->
                                <?php if($this->permission1->method('add_role','create')->access()){?>
                                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_role")){
                                    echo "active";
                                } else {
                                    echo " ";
                                }?>"><a href="<?php echo base_url('Permission/add_role')?>"><?php echo display('add_role') ?></a></li>
                                <?php }?>
                                <?php if($this->permission1->method('role_list','read')->access()){?>
                                    <li class="treeview <?php if ($this->uri->segment('2') == ("role_list")){
                                    echo "active";
                                } else {
                                    echo " ";
                                }?>"><a href="<?php echo base_url('Permission/role_list')?>"><?php echo display('role_list') ?></a></li>
                                <?php }?>
                                <?php if($this->permission1->method('user_assign','create')->access()){?>
                                    <li class="treeview <?php if ($this->uri->segment('2') == ("user_assign")){
                                    echo "active";
                                } else {
                                    echo " ";
                                }?>"><a href="<?php echo base_url('Permission/user_assign')?>"><?php echo display('user_assign_role')?></a></li>
                                <?php }?>
                                <!--  <li><a href="<?php echo base_url('Permission')?>"><?php echo display('permission') ?></a></li> -->
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Role permission End -->

                    <!-- sms menu start -->
                    <?php if($this->permission1->method('sms_configure','create')->access()) { ?>
                        <li hidden class="treeview <?php if ($this->uri->segment('1') == ("Csms")) { echo "active";}else{ echo " ";}?>">
                            <a href="#">
                                <i class="fa fa-comments"></i> <span><?php echo display('sms'); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview <?php if ($this->uri->segment('2') == ("configure")){
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }?>"><a href="<?php echo base_url('Csms/configure')?>"><?php echo display('sms_configure'); ?></a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- sms menu end -->

                    <!-- Synchronizer setting start -->
                    <?php if($this->permission1->method('back_up','create')->access() || $this->permission1->method('back_up','read')->access() || $this->permission1->method('restore','create')->access() || $this->permission1->method('sql_import','create')->access()) { ?>
                        <li hidden class="treeview <?php
                            if ($this->uri->segment('2') == ("form") || $this->uri->segment('2') == ("synchronize") || $this->uri->segment('1') == ("Backup_restore")) {
                                echo "active";
                            } else {
                                echo " ";
                            }
                        ?>">
                            <a href="#">
                                <i class="ti-reload"></i>  <span><?php echo display('data_synchronizer') ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                $localhost = false;
                                if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1', 'localhost'))) {
                                    ?>
                                        <li><a href="<?php echo base_url('data_synchronizer/form') ?>"><?php echo display('setting') ?></a></li>
                                    <?php
                                }
                                ?>
                                <?php if($this->permission1->method('restore','create')->access()) { ?>
                                    <li class="treeview <?php if ($this->uri->segment('2') == ("restore_form")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Backup_restore/restore_form') ?>"><?php echo display('restore') ?></a>
                                    </li>
                                <?php } ?>
                                <!--  <?php if($this->permission1->method('back_up','create')->access() || $this->permission1->method('back_up','read')->access()){ ?>
                                    <li class="treeview <?php if ($this->uri->segment('1') == ("Backup_restore") && $this->uri->segment('2') == ("")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Backup_restore') ?>"><?php echo display('backup_restore') ?></a>
                                    </li>
                                <?php } ?> -->
                                <?php if($this->permission1->method('sql_import','create')->access()) { ?>
                                    <li class="treeview <?php if ($this->uri->segment('2') == ("import_form")){
                                            echo "active";
                                        } else {
                                            echo " ";
                                        }?>"><a href="<?php echo base_url('Backup_restore/import_form') ?>"><?php echo display('import') ?></a>
                                    </li>
                                <?php } ?>

                                <li class="treeview <?php if ($this->uri->segment('2') == ("backup_create")) {
                                        echo "active";
                                    } else {
                                        echo " ";
                                    }?>"><a href="<?php echo base_url('Backup_restore/download') ?>"><?php echo display('backup') ?></a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- Synchronizer setting end -->
                </ul>
            </li>
        <?php } ?>
        <!-- Software Settings menu end -->

        <!-- <li class="treeview <?php if ($this->uri->segment('1') == ("Autoupdate")) { echo "active";}else{ echo " ";}?>">
            <a href="#">
                <span><?php echo display('update'); ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="treeview <?php if ($this->uri->segment('1') == ("Autoupdate") && $this->uri->segment('2') == ("")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Autoupdate')?>"><?php echo display('update_now'); ?></a>
                </li>
            </ul>
        </li> -->

        </ul>
    </div> <!-- /.sidebar -->
</aside>
<script type="application/javascript">
    $(document).ready(function () {
        $("form :input").attr("autocomplete", "off");
    })
</script>
