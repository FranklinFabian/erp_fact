<style type="text/css">
/*
     .small-box {
  border-radius: 2px;
  position: relative;
  display: block;
  margin-bottom: 20px;
  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}
.small-box > .inner {
  padding: 10px;
}
.small-box > .small-box-footer {
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
.small-box > .small-box-footer:hover {
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
  color:#fff;
}

.small-box p > small {
  display: block;
  font-size: 13px;
  margin-top: 5px;
  color:#fff;
}
.small-box h3,
.small-box p {
  z-index: 5;
  color:#fff;
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

}*/
</style>

<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <section class="content-header">
      <div class="header-icon">
         <i class="pe-7s-world"></i>
      </div>
      <div class="header-title">
         <h1><?php echo "Plan de Cuentas"; display('dashboard') ?></h1>
         <small><?php echo display('home') ?></small>
         <ol class="breadcrumb">
            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
            <li class="active"><?php echo display('dashboard') ?></li>
         </ol>
      </div>
   </section>

   <section class="content">
      <!-- Alert Message -->
      <?php $message = $this->session->userdata('message');
      if (isset($message)){ ?>
         <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>
         </div>
         <?php $this->session->unset_userdata('message');
      }
      $error_message = $this->session->userdata('error_message');
      if (isset($error_message)) { ?>
         <div class="alert alert-danger alert-dismissable">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <?php echo $error_message ?>
         </div>
         <?php $this->session->unset_userdata('error_message');
      }
      ?>
      <div class="row">
         <div class="col-sm-12">
            <div class="column">
               <?php if($this->permission1->method('manage_invoice','read')->access()){ ?>
                  <a href="<?php echo base_url('Cinvoice/manage_invoice') ?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_invoice') ?> </a>
               <?php }?>
               <?php if($this->permission1->method('pos_invoice','create')->access()){ ?>
                  <a href="<?php echo base_url('Cinvoice/pos_invoice') ?>" class="btn btn-primary m-b-5 m-r-2"><i class="ti-align-justify"> </i>  <?php echo display('pos_invoice') ?> </a>
               <?php }?>
            </div>
         </div>
      </div>

      <!--Add Invoice -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-bd lobidrag">
                  
               <div class="panel-heading">
                  <div class="panel-title">
                     <h4><?php echo display('new_invoice') ?></h4>
                  </div>
               </div>
                  
               <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-8" id="payment_from_1">
                     </div>
                  </div>
                  
                  <div class="table-responsive" style="margin-top: 10px">
                  </div>
               </div>
            </div>
         </div>
      </div>

   </section>
   <!-- Admin Home end -->
</div>

<!-- ChartJs JavaScript -->
<script src="<?php echo base_url() ?>assets/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/js/canvasjs.min.js" type="text/javascript"></script>

<script type="text/javascript">

</script>