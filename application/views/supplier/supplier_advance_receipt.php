<?php
$CI = & get_instance();
$CI->load->model('Web_settings');
$Web_settings = $CI->Web_settings->retrieve_setting_editdata();
?>
<!--its for pos style css start--> 
<style type="text/css">
    BODY, TD
    {
        background-color: #ffffff;
        color: #000000;
        font-family: "Times New Roman", Times, serif;
        font-size: 10pt;
    }

</style>
<!--its for pos style css close--> 
<!-- Printable area start -->
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        // document.body.style.marginTop="-45px";
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<!-- Printable area end -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('supplier') ?></h1>
            <small><?php echo display('supplier_advance') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('supplier') ?></a></li>
                <li class="active"><?php echo display('supplier_advance') ?></li>
            </ol>
        </div>
    </section>
    <!-- Main content -->
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
                <div class="panel panel-bd">
                    <div id="printableArea">
                        <div class="panel-body">
                            <div bgcolor='#e4e4e4' text='#ff6633' link='#666666' vlink='#666666' alink='#ff6633' style='margin:0;font-family:Arial,Helvetica,sans-serif;border-bottom:1' >
                                <table border="0" width="40%">
                                    <tr>
                                        <td>

                                            <table border="0" width="100%">
                                                
                                                <tr>
                                                    <td align="center" style="border-bottom:2px #333 solid;">
                                                        {company_info}
                                                        <span style="font-size: 17pt; font-weight:bold;">
                                                            {company_name}
                                                        </span><br>
                                                        {address}<br>
                                                        {mobile}<br>
                                                        {/company_info}
                                                        
                                                    </td>
                                                </tr>
                                                
                                                
                                                <tr>
                                                    <td align="center"><b>{supplier_name}</b><br>
                                                        <?php if ($address) { ?>
                                                            {address}<br>
                                                        <?php } ?>
                                                        <?php if ($mobile) { ?>
                                                            {mobile}
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center"><nobr>
                                                    <date>
                                                        <?= display('date')?>: <?php
                                                        echo date('d-M-Y');
                                                        ?> 
                                                    </date>
                                                </nobr></td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong><?php echo display('receipt_no'); ?> : {receipt_no}</strong></td>
                                    </tr>
                                </table>

                                <table width="100%">
                                    <tr>
                                   <td align="center"><?php echo display('transaction_type'); ?></td>
                                   <td align="center"><?php echo display('payment_type'); ?></td>
                                   <td align="center"><?php echo display('amount'); ?></td>
                                    </tr>
                                              
                                    <tr>
                         <td align="center"><nobr><?php echo $details->description;?></nobr></td>    
                         <td align="center"><nobr><?php if( $details->d_c =='d'){echo 'Payment';}else{
                        	echo 'Receive';
                        }?></nobr></td>
                        <td align="center"><nobr><?php echo $details->amount;?></nobr></td>
                                   
                                    </tr>
                                    
                                      
                                   
                                </table>
                               
                                </td>
                                </tr>
                                <tr>{company_info}
                                    <td>Powered  By: <a href="{website}"><strong>{company_name}</strong></a></td>
                                     {/company_info}
                                </tr>
                                </table>


                            </div>


                        </div>
                    </div>

                    <div class="panel-footer text-left">
                        <a  class="btn btn-danger" href="<?php echo base_url('Csupplier/supplier_advance'); ?>"><?php echo display('cancel') ?></a>
                        <a  class="btn btn-info" href="#" onclick="printDiv('printableArea')"><span class="fa fa-print"></span></a>

                    </div>
                </div>
            </div>
        </div>
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

