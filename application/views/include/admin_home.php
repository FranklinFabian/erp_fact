<style type="text/css">
    .small-box {
        border-radius: 2px;
        position: relative;
        display: block;
        margin-bottom: 20px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    .small-box>.inner {
        padding: 10px;
    }

    .small-box>.small-box-footer {
        position: relative;
        text-align: center;
        padding: 3px 0;
        color: #fff;
        color: rgba(255, 255, 255, 0.8);
        display: block;
        z-index: 10;
        background: rgba(0, 0, 0, 0.1);
        text-decoration: none;
    }

    .small-box>.small-box-footer:hover {
        color: #fff;
        background: rgba(0, 0, 0, 0.15);
    }

    .small-box h3 {
        font-size: 38px;
        font-weight: bold;
        margin: 0 0 10px 0;
        white-space: nowrap;
        padding: 0;
    }

    .small-box p {
        font-size: 15px;
        color: #fff;
    }

    .small-box p>small {
        display: block;
        font-size: 13px;
        margin-top: 5px;
        color: #fff;
    }

    .small-box h3,
    .small-box p {
        z-index: 5;
        color: #fff;
    }

    .small-box .icon {
        -webkit-transition: all 0.3s linear;
        -o-transition: all 0.3s linear;
        transition: all 0.3s linear;
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        color: rgba(0, 0, 0, 0.15);
    }

    .small-box:hover {
        text-decoration: none;
        color: #f9f9f9;
    }

    .small-box:hover .icon {
        font-size: 95px;
    }

    @media (max-width: 767px) {
        .small-box {
            text-align: center;
        }

        .small-box .icon {
            display: none;
        }

    }
</style>

<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>

        </div>
        <div class="header-title">
            <h1><?php echo display('dashboard') ?></h1>
            <small><?php echo display('home') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li class="active"><?php echo display('dashboard') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Alert Message -->
        <?php
        if (isset($_POST['btnSearch'])) {
            $postdate = $_POST['alldata'];
        }
        $searchdate = (!empty($postdate) ? $postdate : date('F Y'));

        ?>
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
        <!-- First Counter -->
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="small-box bg-green" style="color:#fff;">
                    <div class="inner">
                        <h4><span class="count-number"><?php echo $total_customer ?></span></h4>
                        <p><?php echo display('total_customer') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="<?php echo base_url('Ccustomer/manage_customer') ?>" class="small-box-footer"><?php echo display('total_customer') ?></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="small-box" style="background-color: #6cabbc; color:#fff;  ">
                    <div class="inner">
                        <h4><span class="count-number"><?php echo $total_product ?></span></h4>

                        <p><?php echo display('total_product') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                    <a href="<?php echo base_url('Cproduct/manage_product') ?>" class="small-box-footer"><?php echo display('total_product') ?></a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="small-box" style="background-color:#8459cf; color:#fff;">
                    <div class="inner">
                        <h4><span class="count-number"><?php echo $total_suppliers ?></span></h4>

                        <p><?php echo display('total_supplier') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="<?php echo base_url('Csupplier/manage_supplier') ?>" class="small-box-footer"><?php echo display('total_supplier') ?> </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="small-box" style="background-color:#749057; color:#fff;">
                    <div class="inner">
                        <h4><span class="count-number"><?php echo $total_sales ?></span> </h4>

                        <p><?php echo display('total_invoice') ?></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="<?php echo base_url('Cinvoice/manage_invoice') ?>" class="small-box-footer"><?php echo display('total_invoice') ?> </a>
                </div>
            </div>
        </div>
        <hr>
        <?php if ($this->session->userdata('user_type') == '1') { ?>
            <div class="row">
                <!-- This month progress -->
                <div class="col-sm-12 col-md-7">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 style="display: inline-block; line-height: 34px;"> <?php echo display('best_sale_product') ?></h4>
                                <a href="<?php echo base_url(); ?>Admin_dashboard/see_all_best_sales" class="btn btn-success text-white" style="display: inline-block; float: right;">See All</a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <canvas id="lineChart" height="160"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <form name="form1" id="form1" action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-sm-8" style="margin-right: 0px;padding-right: 0px;">
                                            <input type="text" class="form-control " value="<?php echo $searchdate; ?>" name="alldata" id="alldata">
                                        </div>
                                        <div class="col-sm-2" style="margin-left: 0px;padding-left: 0px;">
                                            <button type="submit" name="btnSearch" class="btn" style="background-color: green;color:#fff"><i class="fa fa-search"></i> Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div id="chartContainer" style="height: 280px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 style="display: inline-block; line-height: 34px;"></h4>
                            </div>
                            <div class="panel-body">
                                <canvas id="yearlyreport" width="600" height="350"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Report -->
                <div class="col-md-4">
                    <div class="panel panel-bd lobidisable">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4><?php echo display('todays_overview') ?></h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="message_inner">
                                <div class="message_widgets">

                                    <table class="table table-bordered table-striped table-hover">
                                        <tr>
                                            <th><?php echo display('todays_report') ?></th>
                                            <th><?php echo display('money') ?></th>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('total_sales') ?></th>
                                            <td><?php echo (($position == 0) ? "$currency $sales_amount" : "$sales_amount $currency") ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo display('total_purchase') ?></th>
                                            <td><?php echo (($position == 0) ? "$currency $todays_total_purchase" : "$todays_total_purchase $currency") ?></td>
                                        </tr>

                                    </table>

                                    <table class="table table-bordered table-striped table-hover">
                                        <tr>
                                            <th><?php echo display('last_sales') ?></th>
                                            <th><?php echo display('money') ?></th>
                                        </tr>
                                        <?php
                                        if ($todays_sale_product) {
                                        ?>
                                            {todays_sale_product}
                                            <tr>
                                                <th>{product_name}</th>
                                                <td><?php echo (($position == 0) ? "$currency {price}" : "{price} $currency") ?></td>
                                            </tr>
                                            {/todays_sale_product}
                                        <?php } ?>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- This today transaction progress -->
                <div class="col-sm-12 col-md-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4 style="display: inline-block; line-height: 34px;"> <?php echo display('todays_sales_report') ?></h4>
                                <!--<a href="<?php echo base_url(); ?>Admin_dashboard/see_all_best_sales" class="btn btn-success text-white" style="display: inline-block; float: right;">See All</a>-->
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow: scroll; height: 300px;">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('sl') ?></th>
                                            <th><?php echo display('customer_name') ?></th>
                                            <th><?php echo display('invoice_no') ?></th>
                                            <th><?php echo display('total_amount') ?></th>
                                            <th><?php echo display('paid_ammount') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ttl_amount = $ttl_paid = $ttl_due = $ttl_discout = $ttl_receipt = 0;
                                        $todays = date('Y-m-d');
                                        if ($todays_sales_report) {
                                            $sl = 0;
                                            //                                            echo '<pre>';   print_r($todays_sales_report); echo '<pre>';
                                            foreach ($todays_sales_report as $single) {
                                                $sql = "SELECT (SELECT SUM(total_price) FROM invoice_details a JOIN invoice b ON b.invoice_id = a.invoice_id WHERE a.invoice_id = '" . $single->invoice_id . "' AND b.customer_id = '" . $single->customer_id . "') as total_amount, 
    (SELECT SUM(paid_amount) FROM invoice_details a JOIN invoice b ON b.invoice_id = a.invoice_id WHERE a.invoice_id = '" . $single->invoice_id . "' AND b.customer_id = '" . $single->customer_id . "') as total_paid, 
    (SELECT SUM(due_amount) FROM invoice_details a JOIN invoice b ON b.invoice_id = a.invoice_id WHERE a.invoice_id = '" . $single->invoice_id . "' AND b.customer_id = '" . $single->customer_id . "') as total_due, 
    (SELECT SUM(total_discount) FROM invoice_details a JOIN invoice b ON b.invoice_id = a.invoice_id WHERE a.invoice_id = '" . $single->invoice_id . "' AND b.customer_id = '" . $single->customer_id . "') as total_discount";
                                                $result = $this->db->query($sql)->row();



                                                $todays_receipt_sql = "SELECT SUM(a.amount) today_receipt FROM customer_ledger a JOIN customer_information b ON b.customer_id = a.customer_id WHERE a.date = '" . $todays . "' AND a.customer_id = '" . $single->customer_id . "' AND a.d_c = 'c'";
                                                $todays_receipt_result = $this->db->query($todays_receipt_sql)->row();

                                                //                                               echo '<pre>'; print_r($result);
                                                $sl++;
                                        ?>
                                                <tr>
                                                    <td><?php echo $sl; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>Ccustomer/customerledger/<?php echo $single->customer_id; ?>">
                                                            <?php echo $single->customer_name; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url() . 'Cinvoice/invoice_inserted_data/'; ?><?php echo $single->invoice_id; ?>">
                                                            <?php echo $single->invoice; ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        $ttl_amount += $result->total_amount - $result->total_discount;
                                                        echo number_format($result->total_amount - $result->total_discount, '2', '.', ',');
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        $ttl_paid += $result->total_paid;
                                                        echo number_format($result->total_paid, '2', '.', ','); ?>
                                                    </td>





                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <th class="text-center" colspan="5"><?php echo display('not_found'); ?></th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php // $ttl_amount = 0;
                                        ?>
                                        <tr>
                                            <td colspan="3" align="right" style="text-align:right;font-size:14px !Important">&nbsp;<b><?php echo display('total') ?>:</b></td>
                                            <td class="text-right">
                                                <?php
                                                $ttl_amount_float = number_format($ttl_amount, '2', '.', ',');
                                                echo (($position == 0) ? "$currency $ttl_amount_float" : "$ttl_amount_float $currency"); ?>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $ttl_paid_float = number_format($ttl_paid, '2', '.', ',');
                                                echo (($position == 0) ? "$currency $ttl_paid_float" : "$ttl_paid_float $currency"); ?>
                                            </td>



                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>


                    </div>

                </div>




            </div>
        <?php } ?>
        <?php // echo '<pre>';                    print_r($best_sales_product);   
        ?>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<!-- ChartJs JavaScript -->
<script src="<?php echo base_url() ?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/canvasjs.min.js" type="text/javascript"></script>


<script>
    window.onload = function() {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Expense statement",
                fontColor: "green"
            },

            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\" <?= $currency ?>\"",
                indexLabel: "{label} {y}",
                dataPoints: [{
                        y: "<?php echo $this->Reports->total_sales_amount($searchdate) ?>",
                        label: "Total Sale"
                    },
                    {
                        y: "<?php echo $this->Reports->total_purchase_amount($searchdate) ?>",
                        label: "Total Purchase"
                    },
                    {
                        y: "<?php echo $this->Reports->total_expense_amount($searchdate) ?>",
                        label: "Total Expense"
                    },
                    {
                        y: "<?php echo $this->Reports->total_employee_salary($searchdate) ?>",
                        label: "Employee Salary"
                    },
                    {
                        y: "<?php echo $this->Reports->total_service_amount($searchdate) ?>",
                        label: "Service "
                    }
                ]
            }]
        });
        chart.render();

    }
</script>

<script type="text/javascript">
    new Chart(document.getElementById("yearlyreport"), {
        type: 'line',
        data: {
            labels: [<?php
                        for ($i = 1; $i <= 12; $i++) {
                            if ($i == 1) {
                                echo '"January",';
                            } elseif ($i == 2) {
                                echo '"February",';
                            } elseif ($i == 3) {
                                echo '"March",';
                            } elseif ($i == 4) {
                                echo '"April",';
                            } elseif ($i == 5) {
                                echo '"May",';
                            } elseif ($i == 6) {
                                echo '"June",';
                            } elseif ($i == 7) {
                                echo '"July",';
                            } elseif ($i == 8) {
                                echo '"August",';
                            } elseif ($i == 9) {
                                echo '"September",';
                            } elseif ($i == 10) {
                                echo '"October",';
                            } elseif ($i == 11) {
                                echo '"November",';
                            } elseif ($i == 12) {
                                echo '"December"';
                            }
                        }
                        ?>],
            datasets: [{
                data: [<?php
                        for ($i = 1; $i <= 12; $i++) {

                            $sale = $this->Reports->yearly_invoice_report($i);
                            if (!empty($sale->total_sale)) {
                                echo $sale->total_sale . ",";
                            } else {
                                echo ",";
                            }
                        }
                        ?>],
                label: "Sales",
                borderColor: "#008000",
                fill: false
            }, {
                data: [<?php
                        for ($i = 1; $i <= 12; $i++) {
                            $purchase = $this->Reports->yearly_purchase_report($i);
                            if (!empty($purchase->total_purchase)) {
                                echo $purchase->total_purchase . ",";
                            } else {
                                echo ",";
                            }
                        }
                        ?>],
                label: "Purchase",
                borderColor: "#3e95cd",
                fill: false
            }]
        },
        options: {
            title: {
                display: true,
                text: '<?php echo display("sales_and_purchase_report_summary"); ?>- <?= date("Y") ?>'
            }
        }
    });
</script>

<script>
    $(function() {
        $('#alldata').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            maxDate: "+0M",
            dateFormat: 'MM yy'
        }).focus(function() {
            var thisCalendar = $(this);
            $('.ui-datepicker-calendar').detach();
            $('.ui-datepicker-close').click(function() {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                thisCalendar.datepicker('setDate', new Date(year, month, 1));
            });
        });
    });
</script>