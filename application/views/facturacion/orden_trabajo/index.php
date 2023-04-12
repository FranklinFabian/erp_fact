<div class="content-wrapper" id="app-orden-trabajo">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-settings"></i>
        </div>
        <div class="header-title">
            <h1>Configuración</h1>
            <small>Factores</small>
            <?php echo $this->breadcrumb->render(); ?>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="customer_name" class="col-sm-2 col-form-label"> Nombre<i
                                        class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nombre">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6 text-center">
                                <button type="submit" class="btn btn-success ">
                                    <i class="fa fa-search-plus" aria-hidden="true"></i> Buscar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php echo form_open('Ccustomer/customer_ledgerData', array('class' => '', 'id' => 'validate')) ?>
                        <div class="text-center">
                            <h3> Juan Perez </h3>
                            <h4>Cliente : 171515</h4>
                            <h4>NIT : 141415521</h4>
                            <h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
                        </div>
                        <?php echo form_close() ?>

                    </div>
                    <div class="panel-footer">
                        <?php if ($this->permission1->method('manage_customer', 'read')->access()) { ?>
                            <a href="<?php echo base_url('Ccustomer/manage_customer') ?>"
                               class="btn btn-primary m-b-5 m-r-2"><i
                                        class="ti-align-justify"> </i> Nueva Orden </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-body">
                        <div id="printableArea" style="margin-left:2px;">

                            <?php if ($customer_name) { ?>
                                <div class="text-center">
                                    <h3> {customer_name} </h3>
                                    <h4><?php echo display('address') ?> : {address} </h4>
                                    <h4> <?php echo display('print_date') ?>: <?php echo date("d/m/Y h:i:s"); ?> </h4>
                                </div>
                            <?php } ?>

                            <div class="table-responsive">

                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center"><?php echo display('date') ?></th>
                                        <th class="text-center"><?php echo display('description') ?></th>
                                        <th class="text-center"><?php echo display('invoice_id') ?></th>
                                        <th class="text-center"><?php echo display('deposite_id') ?></th>
                                        <th class="text-right"><?php echo display('debit') ?></th>
                                        <th class="text-right"><?php echo display('credit') ?></th>
                                        <th class="text-right"><?php echo display('balance') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($ledgers) {
//                                        echo '<pre>';                                        print_r($ledgers);die();
                                        $sl = 0;
                                        $debit = $credit = $balance = 0;
                                        foreach ($ledgers as $ledger) {
                                            $sl++;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $ledger['date']; ?></td>
                                                <td><?php echo $ledger['description']; ?></td>
                                                <td>

                                                    <?php echo $ledger['invoice_no']; ?>
                                                </td>
                                                <td><?php echo @$ledger['deposit_no']; ?></td>
                                                <td align="right">
                                                    <?php
                                                    if ($ledger['d_c'] == 'd') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($ledger['amount'], 2, '.', ',');
                                                        $debit += $ledger['amount'];
//                                                         $d = 12;
                                                    } else {
                                                        $debit += '0.00';
                                                    }
                                                    ?>
                                                </td>
                                                <td align="right">
                                                    <?php
                                                    if ($ledger['d_c'] == 'c') {
                                                        echo (($position == 0) ? "$currency " : " $currency");
                                                        echo number_format($ledger['amount'], 2, '.', ',');
                                                        $credit += $ledger['amount'];
                                                    } else {
                                                        $credit += '0.00';
                                                    }
                                                    ?>
                                                </td>
                                                <td align='right'>
                                                    <?php
                                                    $balance = $debit - $credit;
                                                    echo (($position == 0) ? "$currency " : " $currency");
                                                    echo number_format($balance, 2, '.', ',');
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <tr><td colspan="7"><center>No Record Found</center></td></tr>

                                    <?php }?>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><b><?php echo display('grand_total') ?>:</b></td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$debit), 2, '.', ',');
                                                ?></b>
                                        </td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$credit), 2, '.', ',');
                                                ?></b>
                                        </td>
                                        <td align="right"><b><?php
                                                echo (($position == 0) ? "$currency " : "$currency");
                                                echo number_format((@$balance), 2, '.', ',');
                                                ?></b></td>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="text-right"><?php echo $links ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<!-- Vuejs -->
<!--<script src="--><?php //echo base_url() ?><!--my-assets/js/vue/components/facturacion/Factores.js"></script>-->













