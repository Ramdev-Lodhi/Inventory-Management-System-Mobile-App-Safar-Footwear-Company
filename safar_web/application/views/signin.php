<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>User Signin</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="<?php echo base_url('images/logo/SafarLogo1.png'); ?>" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css')?>" />
      <!-- site css -->
      <link rel="stylesheet" href="<?= base_url('css/style.css')?>" />
      <!-- responsive css -->
      <link rel="stylesheet" href="<?= base_url('css/responsive.css')?>" />
      <!-- color css -->
      <!-- <link rel="stylesheet" href="<?= base_url('css/colors.css')?>" /> -->
      <!-- select bootstrap -->
      <link rel="stylesheet" href="<?= base_url('css/bootstrap-select.css')?>" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="<?= base_url('css/perfect-scrollbar.css')?>" />
      <!-- custom css -->
      <link rel="stylesheet" href="<?= base_url('css/custom.css')?>" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="<?= base_url('css/semantic.min.css')?>" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <img width="210"  src="<?= base_url('images/logo/SafarLogo1.png')?>" alt="#" />
                     </div>
                     <h4 align="center" >SAFAR FOOTWEAR</h4>
                  </div>
                  <div class="login_form">
				  <?php echo form_open('Signin',['name'=>'userregistration','autocomplete'=>'off']);?>

<div class="form-group">
<!--error message -->
<?php if($this->session->flashdata('error')){?>
<p style="color:red"><?php  echo $this->session->flashdata('error');?></p>	
<?php } ?>

<?php echo form_input(['name'=>'emailid','class'=>'form-control','value'=>set_value('emailid'),'placeholder'=>'Enter your Email id']);?>
<?php echo form_error('emailid',"<div style='color:red'>","</div>");?>       	
</div>
<div class="form-group">
<?php echo form_password(['name'=>'password','class'=>'form-control','value'=>set_value('password'),'placeholder'=>'Password']);?>
<?php echo form_error('password',"<div style='color:red'>","</div>");?>  


</div>


<div class="form-group">
<?php echo form_submit(['name'=>'insert','value'=>'Submit','class'=>'main_bt btn-lg btn-block']);?>
</div>
</form>
<?php echo form_close();?>
<!-- <div class="text-center">Not Registered Yet? <a href="<?php echo site_url('Signup');?>">Sign up here</a></div> -->
</div>
                          
               </div>
            </div>
         </div>
      </div>
      <!-- jQuery -->
      <!-- <script src=" js/jquery.min.js"></script> -->
      <!-- <script src=" js/popper.min.js"></script> -->
      <!-- <script src=" js/bootstrap.min.js"></script> -->
      <!-- wow animation -->
      <!-- <script src=" js/animate.js"></script> -->
      <!-- select country -->
      <!-- <script src=" js/bootstrap-select.js"></script> -->
     
   </body>
</html>