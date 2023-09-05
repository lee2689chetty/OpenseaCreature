<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu page-header-fixed page-sidebar-menu-closed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item <?php if($selectedMenu == 1) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>dash/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Home</span>

                    <?php if($selectedMenu == 1) :?>
                        <span class="selected"></span>
                    <?php endif;?>

                </a>
            </li>
            <li class="nav-item  <?php if($selectedMenu == 2) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>account/view" class="nav-link nav-toggle">
                    <i class="fa fa-bank"></i>
                    <span class="title">Accounts</span>
                    <?php if($selectedMenu == 2) :?>
                        <span class="selected"></span>
                    <?php endif;?>
                </a>
<!--                <ul class="sub-menu">-->
<!--                    <li class="nav-item">-->
<!--                        <a href="javascript:;" class="nav-link nav-toggle">-->
<!--                            <span class="title"> Virtual Accounts </span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="javascript:;" class="nav-link nav-toggle">-->
<!--                            <span class="title"> Card Accounts </span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
            </li>
            <li class="nav-item  <?php if($selectedMenu == 3) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>transfer/view" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title">Transfer</span>
                    <?php if($selectedMenu == 3) :?>
                        <span class="selected"></span>

                    <?php endif;?>



                </a>
            </li>
            <li class="nav-item  <?php if($selectedMenu == 4) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>report/view" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Reports</span>
                    <?php if($selectedMenu == 4) :?>
                        <span class="selected"></span>

                    <?php endif;?>
                </a>
            </li>
            <li class="nav-item  <?php if($selectedMenu == 5) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>message/view" class="nav-link nav-toggle">
                    <i class="icon-calendar"></i>
                    <span class="title"> Messages </span>
                    <?php if($selectedMenu == 5) :?>
                        <span class="selected"></span>

                    <?php endif;?>
                </a>
            </li>
            <li class="nav-item  <?php if($selectedMenu == 6) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>file/view" class="nav-link nav-toggle">
                    <i class="icon-docs"></i>
                    <span class="title"> Files </span>
                    <?php if($selectedMenu == 5) :?>
                        <span class="selected"></span>

                    <?php endif;?>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>