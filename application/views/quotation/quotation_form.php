<link href="<?php echo base_url() ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/service_quotation.js.php" ></script>
<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/productquotation.js" ></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('quotation') ?></h1>
            <small><?php echo display('add_quotation') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('quotation') ?></a></li>
                <li class="active"><?php echo display('add_quotation') ?></li>
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
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        ?>


        <!-- New category -->
        <div class="row">
            <div class="col-sm-12">                
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo display('add_quotation') ?> </h4>
                        </div>
                    </div>
                    <?php echo form_open('Cquotation/insert_quotation', array('class' => 'form-vertical', 'id' => 'insert_quotation')) ?>
                    <div class="panel-body">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="customer" class="col-sm-4 col-form-label"><?php echo display('customer') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <?php //dd($customers);?>
                                    <?php if ($user_type == 3) { ?>
                                        <input type="text" name="cname" value="<?php echo $this->session->userdata('user_name') ?>" class="form-control" readonly>
                                        <input type="hidden" name="customer_id" value="<?php echo $this->session->userdata('user_id') ?>" class="form-control">
                                    <?php } else { ?>
                                        <select name="customer_id" class="form-control" onchange="get_customer_info(this.value)"  data-placeholder="<?php echo display('select_one'); ?>">
                                            <option value=""></option>
                                            <?php
                                            foreach ($customers as $customer) {
                                                ?>
                                                <option value="<?php echo $customer['customer_id'] ?>">
                                                    <?php echo $customer['customer_name'] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="quotation_no" class="col-sm-4 col-form-label"><?php echo display('quotation_no') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="quotation_no" id="quotation_no" class="form-control" placeholder="<?php echo display('quotation_no') ?>" value="<?php echo $quotation_no; ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <?php
                        $customer_address = $customer_phone = $customer_mobile = $website = $work_order = '';
                        
                        ?>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="address" class="col-sm-4 col-form-label"><?php echo display('address') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="address" class="form-control" value="<?php echo $customer_address; ?>" id="address" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="qdate" class="col-sm-4 col-form-label"><?php echo display('quotation_date') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="qdate" class="form-control datepicker" id="qdate" value="<?php echo date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="mobile" class="col-sm-4 col-form-label"><?php echo display('mobile') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" value="<?php echo $customer_mobile; ?>" id="mobile" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                 <label for="expiry_date" class="col-sm-4 col-form-label"><?php echo display('expiry_date') ?> </label>
                                <div class="col-sm-8">
                                    <input type="text" name="expiry_date" class="form-control datepicker" id="expiry_date" value="<?php echo date('Y-m-d') ?>">
                                </div>
                            </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label for="details" class="col-sm-2 col-form-label"><?php echo display('details') ?> <i class="text-danger"></i></label>
                                <div class="col-sm-10">
                                    <textarea  name="details" class="form-control" id="details"></textarea>
                                </div>
                            </div>
                        </div>

                              <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="normalinvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 220px"><?php echo display('item_information') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('item_description')?></th>
                                         <th class="text-center"><?php echo display('serial_no')?></th>
                                        <th class="text-center"><?php echo display('available_qnty') ?></th>
                                        <th class="text-center"><?php echo display('unit') ?></th>
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('rate') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                            <th class="text-center" style="width: 100px"><?php echo display('discount_percentage') ?> %</th>
                                        <?php } elseif ($discount_type == 2) { ?>
                                            <th class="text-center" style="width: 100px"><?php echo display('discount') ?> </th>
                                        <?php } elseif ($discount_type == 3) { ?>
                                            <th class="text-center" style="width: 100px"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center" style="width: 150px"><?php echo display('total') ?> 
                                        </th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addinvoiceItem">
                                    <tr>
                                        <td style="width: 220px">
                                            <input type="text" name="product_name" onkeypress="invoice_productList(1);" class="form-control productSelection" placeholder='<?php echo display('product_name') ?>'  id="product_name_1" tabindex="5">

                                            <input type="hidden" class="autocomplete_hidden_value product_id_1" name="product_id[]" id="SchoolHiddenId"/>

                                            <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                        </td>
                                          <td>
                                            <input type="text" name="desc[]" class="form-control text-right "  tabindex="6"/>
                                        </td>
                                        <td  style="width: 100px">
                                             <select class="form-control" id="serial_no_1" name="serial_no[]"   tabindex="7">
                                                <option></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="available_quantity[]" class="form-control text-right available_quantity_1" value="0" readonly="" />
                                        </td>
                                        <td>
                                            <input name="" id="" class="form-control text-right unit_1 valid" value="None" readonly="" aria-invalid="false" type="text">
                                        </td>
                                        <td>
                                            <input type="text" name="product_quantity[]" onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" class="total_qntt_1 form-control text-right" id="total_qntt_1" placeholder="0.00" min="0" tabindex="8"  value="1"/>
                                        </td>
                                        <td style="width: 85px">
                                            <input type="text" name="product_rate[]" id="price_item_1" class="price_item1 price_item form-control text-right" tabindex="9"  onkeyup="quantity_calculate(1);" onchange="quantity_calculate(1);" placeholder="0.00" min="0" />
                                             <input type="hidden" name="supplier_price[]" id="supplier_price_1">
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                            <input type="text" name="discount[]" onkeyup="quantity_calculate(1);"  onchange="quantity_calculate(1);" id="discount_1" class="form-control text-right" min="0" tabindex="10" placeholder="0.00"/>
                                            <input type="hidden" value="" name="discount_type" id="discount_type_1">

                                        </td>


                                        <td style="width: 100px">
                                            <input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_1" value="0.00" readonly="readonly" />
                                        </td>

                                        <td>
                                            <!-- Tax calculate start-->
                                            <?php $x=0;
                                     foreach($taxes as $taxfldt){?>
                                            <input id="total_tax<?php echo $x;?>_1" class="total_tax<?php echo $x;?>_1" type="hidden">
                                            <input id="all_tax<?php echo $x;?>_1" class="total_tax<?php echo $x;?>" type="hidden" name="tax[]">
                                           
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                           
                                            <?php $x++;} ?>
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                            <input type="hidden" id="total_discount_1" class="" />
                                            <input type="hidden" id="all_discount_1" class="total_discount dppr" name="discount_amount[]" />
                                            <!-- Discount calculate end -->

                                        
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                     <tr>
                                       
                                    <td style="text-align:right;" colspan="8"><b><?php echo display('invoice_discount') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" onkeyup="quantity_calculate(1);"  onchange="quantity_calculate(1);" id="invoice_discount" class="form-control text-right total_discount" name="invoice_discount" placeholder="0.00"   tabindex="13"/>
                                        <input type="hidden" id="txfieldnum">
                                    </td>
                                    <td><a  id="add_invoice_item" class="btn btn-info" name="add-invoice-item"  onClick="addInputField('addinvoiceItem');"  tabindex="11"><i class="fa fa-plus"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;" colspan="8"><b><?php echo display('total_discount') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="total_discount_ammount" class="form-control text-right" name="total_discount" value="0.00" readonly="readonly" />
                                    </td>
                                </tr>
                                    <tr>
                                <td style="text-align:right;" colspan="8"><b><?php echo display('total_tax') ?>:</b></td>
                                <td class="text-right">
                                    
                                    <?php $x=0;
                                     foreach($taxes as $taxfldt){?>
                                  
                                    <input id="total_tax_ammount<?php echo $x;?>" tabindex="-1" class="form-control text-right valid totalTax" name="total_tax<?php echo $x;?>" value="0.00" readonly="readonly" aria-invalid="false" type="hidden">
                                
                            <?php $x++;}?>
                                    <input id="total_tax_amount" tabindex="-1" class="form-control text-right valid" name="total_tax" value="0.00" readonly="readonly" aria-invalid="false" type="text">
                                </td>
                                
                                </tr>
                               
                                <tr>
                                    <td colspan="8"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="grandTotal" class="form-control text-right" name="grand_total_price" value="0.00" readonly="readonly" />
                                    </td>
                                </tr>
                                
                               
                               
                               
                               
                                </tfoot>
                            </table>
                        </div>


                            </div>
                        </div>
                    
                        <hr>
                        <div>
                          <button type="button" class="btn btn-primary"  id="service_quotation_div">Add Service Quotation</button>  
                        </div>

                         <div class="row" id="quotation_service" style="display:none">
                            <div class="col-sm-12">
                               
                           <div class="table-responsive" style="margin-top: 10px">
                            <table class="table table-bordered table-hover" id="serviceInvoice">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 220px"><?php echo display('service_name') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center"><?php echo display('quantity') ?> <i class="text-danger">*</i></th>
                                        <th class="text-center" style="width: 120px"><?php echo display('charge') ?> <i class="text-danger">*</i></th>

                                        <?php if ($discount_type == 1) { ?>
                                            <th class="text-center"><?php echo display('discount_percentage') ?> %</th>
                                        <?php } elseif ($discount_type == 2) { ?>
                                            <th class="text-center"><?php echo display('discount') ?> </th>
                                        <?php } elseif ($discount_type == 3) { ?>
                                            <th class="text-center"><?php echo display('fixed_dis') ?> </th>
                                        <?php } ?>

                                        <th class="text-center"><?php echo display('total') ?> 
                                        </th>
                                        <th class="text-center"><?php echo display('action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="addservicedata">
                                    <tr>
                                        <td style="width: 220px">
                                            <input type="text" name="service_name" onkeypress="invoice_serviceList(1);" class="form-control serviceSelection" placeholder='<?php echo display('service_name') ?>'  id="service_name" tabindex="7">

                                            <input type="hidden" class="autocomplete_hidden_value service_id_1" name="service_id[]"/>

                                            <input type="hidden" class="baseUrl" value="<?php echo base_url(); ?>" />
                                        </td>

                                        <td>
                                            <input type="text" name="service_quantity[]" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" class="total_service_qty_1 form-control text-right" id="total_service_qty_1" placeholder="0.00" min="0" tabindex="8"/>
                                        </td>
                                        <td style="width: 85px">
                                            <input type="text" name="service_rate[]" id="service_rate_1" class="service_rate1 service_rate form-control text-right" tabindex="9" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" placeholder="0.00" min="0" />
                                           
                                        </td>
                                        <!-- Discount -->
                                        <td>
                                         <input type="text" name="sdiscount[]" onkeyup="serviceCAlculation(1);" onchange="serviceCAlculation(1);" id="sdiscount_1" class="form-control text-right common_servicediscount" placeholder="0.00" min="0">
                                            <input type='hidden' value='' name='discount_type' id='sdiscount_type_1'>
                                        </td>


                                        <td style="width: 100px">
                                            <input class="total_serviceprice form-control text-right" type="text" name="total_serviceprice[]" id="total_service_amount_1" value="0.00" readonly="readonly" />
                                        </td>

                                        <td>
                                            <!-- Tax calculate start-->
                                      <?php $x=0;
                                     foreach($taxes as $taxfldt){?>
                                            <input id="total_service_tax<?php echo $x;?>_1" class="total_service_tax<?php echo $x;?>_1" type="hidden">
                                            <input id="all_servicetax<?php echo $x;?>_1" class="total_service_tax<?php echo $x;?>" type="hidden" name="stax[]">
                                           
                                            <!-- Tax calculate end-->

                                            <!-- Discount calculate start-->
                                           
                                            <?php $x++;} ?>
                                            <!-- Tax calculate end-->
    <input type="hidden" id="totalServiceDicount_1" class="totalServiceDicount_1">

<input type="hidden" id="all_service_discount_1" class="totalServiceDicount" name="sdiscount_amount[]">
                                           
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                <tr>
                                <td style="text-align:right;" colspan="4"><b><?php echo display('service_discount') ?>:</b></td>
                                <td class="text-right">
                                    <input type="text" onkeyup="serviceCAlculation(1);"  onchange="serviceCAlculation(1);" id="service_discount" class="form-control text-right" name="service_discount" placeholder="0.00"  />
                                        <input type="hidden" id="sertxfieldnum">
                                </td>
                                <td><button type="button" id="add_service_item" class="btn btn-info" name="add-invoice-item"  onClick="addService('addservicedata');"><i class="fa fa-plus"></i></button></td>
                                </tr>
                                <tr>
                                    
                                    <td style="text-align:right;" colspan="4"><b><?php echo display('totalServiceDicount') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="total_service_discount" class="form-control text-right" name="totalServiceDicount" value="0.00" readonly="readonly" />
                                    </td>
                                      
                                </tr>   
                                
                                    
                                 
                    <tr>
                                    
                                    <td style="text-align:right;" colspan="4"><b><?php echo display('total_service_tax') ?>:</b></td>
                                    <td class="text-right">
                                          <?php $x=0;
                                     foreach($taxes as $taxfldt){?>
                                         <input id="total_service_tax_amount<?php echo $x;?>" tabindex="-1" class="form-control text-right valid totalServiceTax" name="total_service_tax<?php echo $x;?>" value="0.00" readonly="readonly" aria-invalid="false" type="hidden">
                                      <?php $x++;}?> 

                                        <input type="text" id="total_service_tax" class="form-control text-right" name="total_service_tax" value="0.00" readonly="readonly" />
                                    </td>
                                    
                                </tr>                

                                
                                <tr>
                                    <td colspan="4"  style="text-align:right;"><b><?php echo display('grand_total') ?>:</b></td>
                                    <td class="text-right">
                                        <input type="text" id="serviceGrandTotal" class="form-control text-right" name="grand_total_service_amount" value="0.00" readonly="readonly" />
                                    </td>
                                </tr>
                                
                           
                                
                                </tfoot>
                            </table>
                        </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
                        
                                    <input type="submit" id="add-quotation" class="btn btn-success btn-large" name="add-quotation" value="<?php echo display('save') ?>" />
                                   
                            </div>
                        </div>
                    </div>               
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>
  <script>
   
   $(document).ready(function() {
     $("#service_quotation_div").click(function () {
         $("#quotation_service").toggle(1500,"easeOutQuint",function(){
          });
  });  
  });
   </script>

<script type="text/javascript">
    "use strict";
    function get_customer_info(t) {
        $.ajax({
            url: "<?php echo base_url('Cquotation/get_customer_info'); ?>",
            type: 'POST',
            data: {customer_id: t},
            success: function (r) {
                r = JSON.parse(r);
                $("#address").val(r.customer_address);
                $("#mobile").val(r.customer_mobile);
                $("#website").val(r.customer_email);
            }
        });
        $.ajax({
            url: "<?php echo base_url('Cjob/customer_wise_vehicle_info'); ?>",
            type: 'POST',
            data: {customer_id: t},
            success: function (r) {
                r = JSON.parse(r);
                $("#registration_no").empty();
                $.each(r, function (ar, typeval) {
                    $('#registration_no').append($('<option>').text(typeval.vehicle_registration).attr('value', typeval.vehicle_id));
                });
            }
        });
    }
</script>

  <!-- Item part  -->
  <script type="text/javascript">

function invoice_productList(sl) {

 var priceClass = 'price_item'+sl;
        var available_quantity = 'available_quantity_'+sl;
        var unit = 'unit_'+sl;
        var tax = 'total_tax_'+sl;
        var serial_no = 'serial_no_'+sl;
        var discount_type = 'discount_type_'+sl;

    // Auto complete
    var options = {
        minLength: 0,
        source: function( request, response ) {
            var product_name = $('#product_name_'+sl).val();
        $.ajax( {
          url: "<?php echo base_url('Cinvoice/autocompleteproductsearch')?>",
          method: 'post',
          dataType: "json",
          data: {
            term: request.term,
            product_name:product_name,
          },
          success: function( data ) {
            response( data );

          }
        });
      },
       focus: function( event, ui ) {
           $(this).val(ui.item.label);
           return false;
       },
       select: function( event, ui ) {
            $(this).parent().parent().find(".autocomplete_hidden_value").val(ui.item.value); 
                $(this).val(ui.item.label);
                var id=ui.item.value;
                var dataString = 'product_id='+ id;
                var base_url = $('.baseUrl').val();

                $.ajax
                   ({
                        type: "POST",
                        url: base_url+"Cinvoice/retrieve_product_data_inv",
                        data: dataString,
                        cache: false,
                        success: function(data)
                        {
                            var obj = jQuery.parseJSON(data);
                            for (var i = 0; i < (obj.txnmber); i++) {
                            var txam = obj.taxdta[i];
                            var txclass = 'total_tax'+i+'_'+sl;
                           $('.'+txclass).val(obj.taxdta[i]);
                            }
                            $('.'+priceClass).val(obj.price);
                            $('.'+available_quantity).val(obj.total_product.toFixed(2,2));
                            $('.'+unit).val(obj.unit);
                            $('.'+tax).val(obj.tax);
                            $('#txfieldnum').val(obj.txnmber);
                            $('#supplier_price_'+sl).val(obj.supplier_price);
                            $('#'+serial_no).html(obj.serial);
                            $('#'+discount_type).val(obj.discount_type);
                                   quantity_calculate(sl);
                                   //This Function Stay on others.js page
                            
                            
                        } 
                    });

            $(this).unbind("change");
            return false;
       }
   }

   $('body').on('keypress.autocomplete', '.productSelection', function() {
       $(this).autocomplete(options);
   });

}

</script>
<script  type="text/javascript" charset="utf-8">
    function addService(t) {
    var row = $("#serviceInvoice tbody tr").length;
    var count = row + 1;
    var limits = 500;
    var taxnumber = $("#sertxfieldnum").val();
    var tbfild ='';
    for(var i=0;i<taxnumber;i++){
        var taxincrefield = '<input id="total_service_tax'+i+'_'+count+'" class="total_service_tax'+i+'_'+count+'" type="hidden"><input id="all_servicetax'+i+'_'+count+'" class="total_service_tax'+i+'" type="hidden" name="stax[]">';
         tbfild +=taxincrefield;
    }
    if (count == limits)
        alert("You have reached the limit of adding " + count + " inputs");
    else {
        var a = "service_name" + count,
                tabindex = count * 5,
                e = document.createElement("tr");
        //e.setAttribute("id", count);
        tab1 = tabindex + 1;
        tab2 = tabindex + 2;
        tab3 = tabindex + 3;
        tab4 = tabindex + 4;
        tab5 = tabindex + 5;
        tab6 = tabindex + 6;
        e.innerHTML = "<td><input type='text' name='service_name' onkeypress='invoice_serviceList(" + count + ");' class='form-control serviceSelection common_product' placeholder='Service Name' id='" + a + "'  tabindex='" + tab1 + "'><input type='hidden' class='common_product autocomplete_hidden_value  service_id_" + count + "' name='service_id[]' id='SchoolHiddenId'/></td><td> <input type='text' name='service_quantity[]'  onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='total_service_qty_" + count + "' class='common_qnt total_service_qty_" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab2 + "'/></td><td><input type='text' name='service_rate[]' onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='service_rate_" + count + "' class='common_rate service_rate" + count + " form-control text-right'  placeholder='0.00' min='0' tabindex='" + tab3 + "'/></td><td><input type='text' name='sdiscount[]' onkeyup='serviceCAlculation(" + count + ");' onchange='serviceCAlculation(" + count + ");' id='sdiscount_" + count + "' class='form-control text-right common_servicediscount' placeholder='0.00' min='0' tabindex='" + tab4 + "' /><input type='hidden' value='' name='discount_type' id='sdiscount_type_" + count + "'></td><td class='text-right'><input class='common_total_service_amount total_serviceprice form-control text-right' type='text' name='total_service_amount[]' id='total_service_amount_" + count + "' value='0.00' readonly='readonly'/></td><td>"+tbfild+"<input type='hidden'  id='totalServiceDicount_" + count + "' class='totalServiceDicount_" + count + "' /><input type='hidden' id='all_service_discount_" + count + "' class='totalServiceDicount' name='sdiscount_amount[]'/><button tabindex='" + tab5 + "' style='text-align: right;' class='btn btn-danger' type='button' value='Delete' onclick='deleteServicraw(this)'><i class='fa fa-close'></i></button></td>",
                document.getElementById(t).appendChild(e),
                document.getElementById(a).focus(),
                document.getElementById("add_service_item").setAttribute("tabindex", tab6);
        count++
    }
}
//Quantity calculat
function serviceCAlculation(item) {
    var quantity = $("#total_service_qty_" + item).val();
    var service_rate = $("#service_rate_" + item).val();
    var service_discount = $("#service_discount").val();
    var discount = $("#sdiscount_" + item).val();
    var taxnumber = $("#sertxfieldnum").val();
    var totalServiceDicount = $("#totalServiceDicount_" + item).val();
    var dis_type = $("#sdiscount_type_" + item).val();


    //alert(dis_type);
    if (quantity > 0 || discount > 0) {
        if (dis_type == 1) {
            var price = quantity * service_rate;
            var dis = +(price * discount / 100);
 

            $("#all_service_discount_" + item).val(dis);
            //$("#service_discount").val();

            //Total price calculate per product
            var temp = price - dis;
            var ttletax = 0;
            $("#total_service_amount_" + item).val(price);
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_service_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_servicetax"+i+"_" + item).val(tax);
    }

          
        } else if (dis_type == 2) {
            var price = quantity * service_rate;

            // Discount cal per product
            var dis = (discount * quantity);

            $("#all_service_discount_" + item).val(dis);

            //Total price calculate per product
            var temp = price - dis;
            $("#total_service_amount_" + item).val(price);

            var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (temp-ttletax) * $("#total_service_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_servicetax"+i+"_" + item).val(tax);
    }
        } else if (dis_type == 3) {
            var total_service_amount = quantity * service_rate;
            
            // Discount cal per product
            $("#all_service_discount_" + item).val(discount);
            //Total price calculate per product
            var price = (total_service_amount - discount);
            $("#total_service_amount_" + item).val(total_service_amount);

             var ttletax = 0;
             for(var i=0;i<taxnumber;i++){
           var tax = (price-ttletax) * $("#total_service_tax"+i+"_" + item).val();
           ttletax += Number(tax);
            $("#all_servicetax"+i+"_" + item).val(tax);
    }
        }
    } else {
        var n = quantity * service_rate;
        var c = quantity * service_rate * total_service_tax;
        $("#total_service_amount_" + item).val(n),
        $("#all_servicetax_" + item).val(c)
    }
    ServiceCalculation();
   
}
//Calculate Sum
function ServiceCalculation() {
  var taxnumber = $("#sertxfieldnum").val();
    
          var t = 0,          
            a = 0,
            e = 0,
            o = 0,
            p = 0,
            f = 0;
        
  //Total Tax
for(var i=0;i<taxnumber;i++){
      
var j = 0;
    $(".total_service_tax"+i).each(function () {
        isNaN(this.value) || 0 == this.value.length || (j += parseFloat(this.value))
    });
            $("#total_service_tax_amount"+i).val(j.toFixed(2, 2));
             
    }
 
        //Discount part
         $(".totalServiceDicount").each(function () {
        isNaN(this.value) || 0 == this.value.length || (p += parseFloat(this.value))
    }),
            $("#total_service_discount").val(p.toFixed(2, 2)),

    $(".totalServiceTax").each(function () {
        isNaN(this.value) || 0 == this.value.length || (f += parseFloat(this.value))
    }),
            $("#total_service_tax").val(f.toFixed(2, 2)),
         
            //Total Price
            $(".total_serviceprice").each(function () {
        isNaN(this.value) || 0 == this.value.length || (t += parseFloat(this.value))
    }),
            o = f.toFixed(2, 2),
            e = t.toFixed(2, 2);
    f = p.toFixed(2, 2);

    var test = +o + +e + -f;
    $("#serviceGrandTotal").val(test.toFixed(2, 2));
 
    var gt = $("#serviceGrandTotal").val();
    var invdis = $("#service_discount").val();
    var total_service_discount = $("#total_service_discount").val();
    var ttl_discount = +total_service_discount + +invdis;
    $("#total_service_discount").val(ttl_discount.toFixed(2, 2));
    var grnt_totals = gt;
    $("#serviceGrandTotal").val(grnt_totals);

}


//Delete a row of table
function deleteServicraw(t) {
    var a = $("#serviceInvoice > tbody > tr").length;
//    alert(a);
    if (1 == a)
        alert("There only one row you can't delete.");
    else {
        var e = t.parentNode.parentNode;
        e.parentNode.removeChild(e),
                ServiceCalculation();
        var current = 1;
        $("#serviceInvoice > tbody > tr td input.productSelection").each(function () {
            current++;
            $(this).attr('id', 'product_name' + current);
        });
        var common_qnt = 1;
        $("#serviceInvoice > tbody > tr td input.common_qnt").each(function () {
            common_qnt++;
            $(this).attr('id', 'total_service_qty_' + common_qnt);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_rate = 1;
        $("#serviceInvoice > tbody > tr td input.common_rate").each(function () {
            common_rate++;
            $(this).attr('id', 'service_rate_' + common_rate);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_servicediscount = 1;
        $("#serviceInvoice > tbody > tr td input.common_servicediscount").each(function () {
            common_servicediscount++;
            $(this).attr('id', 'sdiscount_' + common_servicediscount);
            $(this).attr('onkeyup', 'serviceCAlculation('+common_qnt+');');
            $(this).attr('onchange', 'serviceCAlculation('+common_qnt+');');
        });
        var common_total_service_amount = 1;
        $("#serviceInvoice > tbody > tr td input.common_total_service_amount").each(function () {
            common_total_serviceprice++;
            $(this).attr('id', 'total_serviceprice_' + common_total_price);
        });




    }
}
var count = 2,
        limits = 500;
</script>
