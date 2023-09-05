<?php echo $header;?>
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">

<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption caption-md">
                                <i class="icon-user-follow font-yellow-gold"></i>
                                <span class="caption-subject font-yellow-gold bold uppercase">Contacts</span>
                            </div>
                            <div class="actions">
                                <a href="<?php echo base_url();?>message/new_message" class="btn yellow-gold">
                                    <i class="fa fa-plus"></i> New
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body" id="msgContainer">
                            <div class="scroller" style="height: 480px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                <div class="general-item-list">
                                    <?php foreach ($contacts as $contactItem):?>
                                    <div class="item btn btn-block" data-value="<?php echo $contactItem['thread_id'];?>">
                                        <div class="item-head">
                                            <div class="item-details">
                                                <img class="item-pic" src="<?php echo base_url();?>assets/layouts/img/placeholder.png">
                                                <a href="javascript:;" class="item-name primary-link"><?php echo $contactItem['partner_name'];?></a>
                                                <span class="item-label" style=" display: inline-flex; width: 240px;overflow: hidden; text-overflow: ellipsis">
                                                    <?php echo $contactItem['thread_title'];?>
                                                </span>
                                            </div>
                                            <span class="item-status">
                                                <?php if(intval($contactItem['unread_count']) > 0):?>
                                                    <span class="badge badge-danger"> <?php echo $contactItem['unread_count'];?> </span>
                                                <?php endif;?>
                                            </span>
                                        </div>
                                        <div class="item-body" style="text-align: left;">
                                            <?php echo $contactItem['last_desc'];?>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bubble font-yellow-gold"></i>
                                <span class="caption-subject font-yellow-gold bold uppercase"> Histories </span>
                            </div>
                        </div>
                        <div class="portlet-body" id="chats">
                            <div class="scroller" style="height: 350px;" data-always-visible="1" data-rail-visible1="1">
                                <ul class="chats" id="containerChat">
                                </ul>
                            </div>
                            <div class="chat-form">
                                <div class="input-cont">
                                    <textarea class="form-control" id="txtMessageContent" placeholder="Type a message here..." rows="5"></textarea> </div>
                                <div class="btn-cont">
                                    <button type="button" id="btSend" class="btn blue icn-only">
                                         Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/pages/scripts/client_message_view.js" type="text/javascript"></script>
</body>
</html>
