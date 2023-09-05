<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar navbar-collapse">
        <ul class="page-sidebar-menu page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item <?php if($selectedMenu == MENU_HOME) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>admin/dash/home" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title"> Home </span>

                    <?php if($selectedMenu == 1) :?>
                        <span class="selected"></span>
                    <?php endif;?>

                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase"> User Manage </h3>
            </li>
            <li class="nav-item  <?php if($selectedMenu == MENU_REQUEST_TRANSFER || $selectedMenu == MENU_REQUEST_REGISTER) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon icon-envelope-open"></i>
                    <span class="title"> Requests </span>
                    <?php if($selectedMenu == MENU_REQUEST_TRANSFER || $selectedMenu == MENU_REQUEST_REGISTER) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  <?php if($selectedMenu == MENU_REQUEST_TRANSFER) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/request/transfer_view" class="nav-link nav-toggle">
                            <span class="title"> Transfer Request </span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($selectedMenu == MENU_REQUEST_REGISTER) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/request/register_view" class="nav-link nav-toggle">
                            <span class="title"> Register Request </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  <?php if($selectedMenu == MENU_ACCOUNT_CARD || $selectedMenu == MENU_ACCOUNT_REVENUE || $selectedMenu == MENU_ACCOUNT_VIRTUAL) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon icon-users"></i>
                    <span class="title"> Accounts </span>
                    <?php if($selectedMenu == MENU_ACCOUNT_CARD || $selectedMenu == MENU_ACCOUNT_REVENUE || $selectedMenu == MENU_ACCOUNT_VIRTUAL) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if($selectedMenu == MENU_ACCOUNT_VIRTUAL) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/account/bank_view" class="nav-link nav-toggle">
                            <span class="title"> Virtual Accounts </span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($selectedMenu == MENU_ACCOUNT_CARD) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/account/card_view" class="nav-link nav-toggle">
                            <span class="title"> Card Accounts </span>
                        </a>
                    </li>

                    <li class="nav-item <?php if($selectedMenu == MENU_ACCOUNT_REVENUE) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/account/revenue_view" class="nav-link nav-toggle">
                            <span class="title"> Revenue Accounts </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item  <?php if($selectedMenu == MENU_PROFILE_FEE || $selectedMenu == MENU_PROFILE_USER) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon icon-user-following"></i>
                    <span class="title"> Profiles </span>
                    <?php if($selectedMenu == MENU_PROFILE_FEE || $selectedMenu == MENU_PROFILE_USER) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if($selectedMenu == MENU_PROFILE_USER) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/profile/user_view" class="nav-link nav-toggle">
                            <span class="title"> User Profiles </span>
                        </a>
                    </li>
                    <li class="nav-item <?php if($selectedMenu == MENU_PROFILE_FEE) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/profile/fee_view" class="nav-link nav-toggle">
                            <span class="title"> Fee Profiles </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="heading">
                <h3 class="uppercase"> Utilities </h3>
            </li>
            <li class="nav-item  <?php if($selectedMenu == MENU_TRANSFER) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>admin/transfer/view" class="nav-link nav-toggle">
                    <i class="icon icon-wallet"></i>
                    <span class="title"> Transfer </span>
                    <?php if($selectedMenu == MENU_TRANSFER) :?>
                        <span class="selected"></span>
                    <?php endif;?>
                </a>
            </li>
            <li class="nav-item  <?php if($selectedMenu == MENU_MESSAGES) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>admin/messages/view" class="nav-link nav-toggle">
                    <i class="icon icon-speech"></i>
                    <span class="title"> Messages </span>
                    <?php if($selectedMenu == MENU_MESSAGES) :?>
                        <span class="selected"></span>
                    <?php endif;?>
                </a>
            </li>
            <li class="nav-item <?php if($selectedMenu  == MENU_CURRENCY_PAIR) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-dollar"></i>
                    <span class="title"> Currencies </span>
                    <?php if($selectedMenu == MENU_CURRENCY_PAIR) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if($selectedMenu == MENU_CURRENCY_PAIR) {echo 'active open';}?>">
                        <a href="<?php echo base_url();?>admin/currency/currencypair_view" class="nav-link nav-toggle">
                            <span class="title"> Currency Pair </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="heading">
                <h3 class="uppercase"> System </h3>
            </li>

            <li class="nav-item  <?php if($selectedMenu > (MENU_REPORT_SPECIFIC_ACCOUNT - 1) && $selectedMenu < (MENU_ADMIN_MANAGE)) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon icon-calendar"></i>
                    <span class="title"> Reports </span>
                    <?php if($selectedMenu > (MENU_REPORT_SPECIFIC_ACCOUNT - 1) && $selectedMenu < (MENU_ADMIN_MANAGE)) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                    <ul class="sub-menu">
                        <li class="nav-item  <?php if($selectedMenu > (MENU_REPORT_SPECIFIC_ACCOUNT) - 1 && $selectedMenu < MENU_REPORT_GENERAL_ALL) {echo 'active open';}?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <span class="title"> Specific Account  </span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_SPECIFIC_ACCOUNT) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/specific_account" class="nav-link nav-toggle">
                                        <span class="title"> Specific Account Report </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_SPECIFIC_ALLTRANS) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/specific_all_transaction" class="nav-link nav-toggle">
                                        <span class="title"> All Transaction Report </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_SPECIFIC_BALANCE) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/specific_balance_report" class="nav-link nav-toggle">
                                        <span class="title"> Balance Report </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  <?php if($selectedMenu > MENU_REPORT_SPECIFIC_BALANCE && $selectedMenu < MENU_ADMIN_MANAGE ) {echo 'active open';}?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <span class="title"> General System Reports </span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_ALL) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_alltrans" class="nav-link nav-toggle">
                                        <span class="title"> All Transactions </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_BALANCES) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_balance" class="nav-link nav-toggle">
                                        <span class="title"> Balances </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_OUTGOING) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_outgoing" class="nav-link nav-toggle">
                                        <span class="title"> Outgoing Wire Transfer </span>
                                    </a>
                                </li>

                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_ALLCARDS) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_cards" class="nav-link nav-toggle">
                                        <span class="title"> All Cards </span>
                                    </a>
                                </li>

                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_MANUALTRANS) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_manual" class="nav-link nav-toggle">
                                        <span class="title"> Manual Transactions </span>
                                    </a>
                                </li>

                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_REVENUE) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_revenue" class="nav-link nav-toggle">
                                        <span class="title"> Revenue </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_ACCESSLOG) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/view/system_access" class="nav-link nav-toggle">
                                        <span class="title"> Access Log </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($selectedMenu == MENU_REPORT_GENERAL_OVERVIEW) {echo 'active open';}?>">
                                    <a href="<?php echo base_url();?>admin/report/system_overview" class="nav-link nav-toggle">
                                        <span class="title"> System Overview </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </a>
            </li>

            <?php if($this->session->userdata['me']['LEVEL'] == '1'):?>
            <li class="nav-item  <?php if($selectedMenu == MENU_ADMIN_MANAGE) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>admin/supers/view" class="nav-link nav-toggle">
                    <i class="icon icon-support"></i>
                    <span class="title"> Administrator </span>
                    <?php if($selectedMenu == MENU_ADMIN_MANAGE ) :?>
                        <span class="selected"></span>
                    <?php endif;?>
                </a>
            </li>
            <?php endif;?>

            <?php if($this->session->userdata['me']['LEVEL'] != '4'):?>
                <li class="nav-item  <?php if($selectedMenu == MENU_KYC_MANAGE) {echo 'active open';}?>">
                    <a href="<?php echo base_url();?>admin/kyc/view" class="nav-link nav-toggle">
                        <i class="icon icon-rocket"></i>
                        <span class="title"> KYC  </span>
                        <?php if($selectedMenu == MENU_KYC_MANAGE ) :?>
                            <span class="selected"></span>
                        <?php endif;?>
                    </a>
                </li>
            <?php endif;?>

            <li class="nav-item  <?php if($selectedMenu == MENU_FILE_MANAGE) {echo 'active open';}?>">
                <a href="<?php echo base_url();?>admin/file/view" class="nav-link nav-toggle">
                    <i class="icon icon-docs"></i>
                    <span class="title"> Files  </span>
                    <?php if($selectedMenu == MENU_FILE_MANAGE ) :?>
                        <span class="selected"></span>
                    <?php endif;?>
                </a>
            </li>

            <li class="nav-item  <?php if($selectedMenu > (MENU_AML_COUNTRIES - 1) && $selectedMenu < (MENU_AML_TRANS + 1)) {echo 'active open';}?>">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon icon-tag"></i>
                    <span class="title"> AML </span>
                    <?php if($selectedMenu > (MENU_AML_COUNTRIES - 1) && $selectedMenu < (MENU_AML_TRANS + 1)) :?>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    <?php else:?>
                        <span class="arrow"></span>
                    <?php endif;?>
                    <ul class="sub-menu">
                        <li class="nav-item  <?php if($selectedMenu == MENU_AML_COUNTRIES) {echo 'active open';}?>">
                            <a href="<?php echo base_url();?>admin/aml/restrict_countries" class="nav-link nav-toggle">

                                <span class="title"> Risk Region  </span>
                                <?php if($selectedMenu == MENU_AML_COUNTRIES ) :?>
                                    <span class="selected"></span>
                                <?php endif;?>
                            </a>
                        </li>

                        <li class="nav-item  <?php if($selectedMenu == MENU_AML_THRESHOLD) {echo 'active open';}?>">
                            <a href="<?php echo base_url();?>admin/aml/view_threshold" class="nav-link nav-toggle">

                                <span class="title"> Country Threshold  </span>
                                <?php if($selectedMenu == MENU_AML_THRESHOLD ) :?>
                                    <span class="selected"></span>
                                <?php endif;?>
                            </a>
                        </li>

                        <li class="nav-item  <?php if($selectedMenu == MENU_AML_TRANS) {echo 'active open';}?>">
                            <a href="<?php echo base_url();?>admin/aml/view_trans_list" class="nav-link nav-toggle">
                                <span class="title"> Suspend Transfer  </span>
                                <?php if($selectedMenu == MENU_AML_TRANS ) :?>
                                    <span class="selected"></span>
                                <?php endif;?>

                            </a>
                        </li>
                    </ul>
                </a>
            </li>

        </ul>
    </div>
</div>