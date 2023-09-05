
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="index.html">
                <img src="<?php echo base_url();?>assets/layouts/img/logo-light.png" alt="logo" style="display: block;" class="logo-default" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu pull-right">
            <ul class="nav navbar-nav pull-right">
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?php echo base_url();?>assets/layouts/img/avatar.png" />
                        <span class="username username-hide-on-mobile"> <?php echo $adminName;?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?php echo base_url();?>admin/supers/edit/<?php echo $this->session->userdata['me']['ID'];?>">
                                <i class="icon-user"></i> Profile </a>
                        </li>
                        <li>
<!--                             href="--><?php //echo base_url();?><!--profile/setting">-->
                            <a href="<?php echo base_url();?>admin/supers/password/<?php echo $this->session->userdata['me']['ID'];?>">
                                <i class="icon-settings"></i> Change Password </a>
                        </li>
<!--                        <li>-->
<!--                            <a href="#">-->
<!--                                <i class="icon-lock"></i> Lock Screen </a>-->
<!--                        </li>-->
                        <li>
                            <a href="<?php echo base_url();?>admin/auth/logout">
                                <i class="icon-key"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
                <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-logout"></i>
                    </a>
                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>


<!-- END HEADER -->