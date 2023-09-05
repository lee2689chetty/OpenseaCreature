<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title> VPay | Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo  base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url();?>assets/pages/css/login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url();?>assets/pages/css/about.css" rel="stylesheet" type="text/css" />

<body>
<!-- BEGIN LOGIN -->
<div class="row login">
    <div class="col-sm-12">
        <div class="content">
            <div class="row">
                <div class="col-sm-12">
                    <form class="login-form" action="../auth/login" method="post">
                        <div class="form-title" style="text-align: center;">
                            <h1 class="font-yellow-gold">LOG IN</h1>
                        </div>
                        <?php if($error == true):?>
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span> Invalid authentication </span>
                            </div>
                        <?php endif;?>

                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span> Enter any username and password. </span>
                        </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Email or Username</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email or Username" name="username" /> </div>
                        <div class="form-group">
                            <label class="control-label visible-ie8 visible-ie9">Password</label>
                            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                        <div class="form-actions">
                            <button type="submit" class="btn yellow-gold btn-block uppercase">Login</button>
                        </div>
                        <div class="form-actions">
                            <div class="pull-right forget-password-block">
                                <a href="javascript:;" id="forget-password" class="forget-password">Forget Your Password?</a>
                            </div>
                        </div>

                        <div class="create-account">
                            <p>
                                <a href="<?php echo base_url();?>auth/register" class="btn-primary btn" id="register-btn">Create an account</a>
                            </p>
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
<script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/login.js" type="text/javascript"></script>
</body>

</html>