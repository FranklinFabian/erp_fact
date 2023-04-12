<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="<?php echo $this->config->item('author')?>">

    <title><?php echo $this->config->item('title').$title; ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url();?>public/img/favicon.png">
    <!-- Styles-->
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/purecss.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/grids-responsive-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/css/styles.css">
    
    <!-- End Styles-->

    <!-- SRC scripts-->
    <script src="<?php echo base_url();?>public/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>public/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>public/js/parsley.min.js"></script>
    
    <script>
      var base_url = "<?php echo base_url(); ?>";
    </script>
    <!-- End SRC scripts-->

    <!-- CDN-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <!-- FIN CDN-->

    <script>
      //preloader
      $(window).load(function(){
          $('#page-loader').fadeOut(500);
      });
    </script>
  </head>

<body>
<div id="page-loader"><span class="preloader-interior"></span></div>

 <style scoped>
    .button-success,
    .button-error,
    .button-warning,
    .button-black,
    .button-secondary {
        color: white;
        border-radius: 4px;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }
    .button-success {
      color: #C5FFB9;
      background: rgb(28, 184, 65); /* this is a green */
    }
    .button-success:hover {
      color: #FFF;
      opacity: 0.7;
    }
    .button-error {
      color: #FFB6B6;
      background: rgb(202, 60, 60); /* this is a maroon */
    }
    .button-error:hover {
      color: #FFF;
      opacity: 0.7;
    }
    .button-warning {
      color: #FFEF67;
      background: rgb(223, 117, 20); /* this is an orange */
    }
    .button-warning:hover {
      color: #fff;
      opacity: 0.7;
    }
    .button-secondary {
      color: #C1E7FF;
      background: #64b5f6; /* this is a light blue */
    }
    .button-secondary:hover {
      color: #fff;
      opacity: 0.7;
    }
    .button-black {
      color:#DE9D00;
      background: #303030; /* this is a light black */
    }
    .button-black:hover {
      color:#fff;
      opacity: 0.7;
    }
    .button-xsmall {
      font-size: 70%;
    }
    .button-small {
      font-size: 80%;
    }
    .button-large {
      font-size: 110%;
    }
    .button-xlarge {
      font-size: 125%;
    }
table {
  width: 100%;
  border-collapse: collapse;
  margin:50px auto;
  }
tr:nth-of-type(odd) {
  background: #eee;
  }

th {
  color: white;
  font-weight: bold;
  background-color: #666;
  }

td, th {
  padding: 5px;
  border: 1px solid #ccc;
  text-align: left;
  /*font-size: .9em;*/
  font-size: 13px;
  }
@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px){
  #btn_nuevo{width: 100%}
  #btn_editar{width: 100%}
  #btn_bloquear{width: 100%}

  table {
         display: block;
         overflow-x: auto;
       }  
}

  .online, .offline{
    display: inline;
    padding: 0.2rem;
    border-radius: 5px;
  }

  .online{
    
    background-color: green;
    color: white;
  }

  .offline{
    
    background-color: red;
    color: white;
  }
  </style>
  
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

  <div id="menu">
    <div class="pure-menu">
      <a class="pure-menu-heading" href="<?php  echo base_url();?>">
        <?php
          if($this->session->userdata('nivel')!=0)
            echo 'INICIO';
          else
            echo $this->config->item('producto');
        ?>
      </a>
      <ul class="pure-menu-list">
       <?php
          /*echo menu();*/
         ?>
      </ul>
    </div>
  </div>
    <div id="main">