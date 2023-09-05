<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title> VPay | User Register </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/pages/css/login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/pages/css/about.css" rel="stylesheet" type="text/css" />


<body>
<div class="row login">
    <div class="col-sm-12">
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <?php if($error == true):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Invalid authentication </span>
                        </div>
                    <?php endif;?>

                    <form class="register-form" action="<?php echo base_url()."auth/register";?>" method="post">
                        <div class="form-title">
                            <h1 class="text-center font-yellow-gold"> Sign up</h1>
                        </div>
                        <p class="hint"> Enter your personal details below: </p>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">First Name</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="First Name" name="firstname" /> </div>

                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Last Name</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" name="lastname" /> </div>

                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Company Name</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Company Name(if you are company agency)" name="companyname" /> </div>


                        <div class="form-group">
                            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                            <label class="control-label visible-ie8 visible-ie9">Email</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" /> </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Address</label>
                            <input class="form-control placeholder-no-fix" type="text" placeholder="Address" name="address" /> </div>

                        <p class="hint"> Enter your account details below: </p>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Username</label>
                            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                        <div class="form-group margin-top-20 margin-bottom-20">
                            <label class="check">
                                <input type="checkbox" name="tnc" />
                                <span class="loginblue-font">I agree to the </span>
                                <a href="javascript:;" class="loginblue-link">Terms of Service</a>
                                <span class="loginblue-font">and</span>
                                <a href="javascript:;" class="loginblue-link">Privacy Policy </a>
                            </label>
                            <div id="register_tnc_error"> </div>
                        </div>
                        <div class="form-actions">
                            <a style="color: #ffffff !important;" href="<?php echo base_url();?>auth/login" class="btn btn-primary">Back</a>
                            <button type="submit" id="register-submit-btn" class="btn yellow-gold uppercase pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN CARDS -->
    <?php include_once ('auth_components.php');?>
<!-- END CARDS -->
<div class="copyright text-center"> 2018 &copy; Valor Pay Ver.<?php echo $this->config->item('version_code');?> </div>
<!-- END LOGIN -->
<!--[if lt IE 9]>
<script src="<?php echo base_url();?>assets/global/plugins/respond.min.js"></script>
<script src="<?php echo base_url();?>assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/register.js" type="text/javascript"></script>
</body>

</html>