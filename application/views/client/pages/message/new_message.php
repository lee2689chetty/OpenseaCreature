<?php echo $header;?>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">

            <div class="portlet box yellow-gold">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-envelope"></i>
                        Send new message
                    </div>
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <?php
                    $resultValid = validation_errors();
                    if($resultValid != null && $resultValid != ""): ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> <?php echo $resultValid;?> </span>
                        </div>
                    <?php endif; ?>

                    <?php if($error):?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> Fail to send message </span>
                        </div>
                    <?php endif;?>

                    <form class="form" method="post" id="formNewMessage" action="<?php echo base_url();?>message/new_message">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Send To: <span class="font-red"> * </span></label>
                                        <div class="col-sm-8">
                                            <select required class="bs-select form-control" name="toUser">
                                                <option value="0"> Select User </option>
                                                <?php
                                                    foreach ($users as $userItem){
                                                        echo ("<option value=\"".$userItem['ID']."\">".$userItem['NAME']." ( ".$userItem['FULL_NAME']." ) </option>");
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" class="btn yellow-gold" value="Send">
                                            <a href="<?php echo base_url();?>message/view" class="btn btn-outline yellow-gold">Discard</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Subject:<span class="font-red"> * </span></label>  </label>
                                        <div class="col-sm-8">
                                            <input name="subject" required class="form-control" placeholder="Subject">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin-top: 20px;">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"> Message Content<span class="font-red"> * </span></label> </label>
                                        <div class="col-sm-8">
                                            <textarea name="msgContent" required class="form-control" placeholder="Description" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-bootstrap-select.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/client_message_new.js" type="text/javascript"></script>
</body>
</html>
