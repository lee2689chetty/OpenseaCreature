<?php echo $header;?>
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/datatables.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url();?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/layouts/css/custom.css" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-content-white ">


<?php echo $topbar;?>
<div class="clearfix"> </div>
<div class="page-container">
    <?php echo $sidebar;?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-yellow-gold">
                                Add Restricted Country
                            </div>
                            <div class="actions">

                            </div>
                        </div>

                        <div class="portlet-body">
                            <form id="addCountry" role="form" method="post" action="<?php echo base_url();?>admin/aml/add_restrict_countries">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="col-sm-3 col-md-3 control-label text-align-reverse"> Country <span class="font-red"> * </span></label>
                                            <div class="col-sm-9 col-md-6">
                                                <select required class="form-control select2 select2-allow-clear" id="countryItem" name="countryItem">
                                                    <option value=""> Select Country </option>
                                                    <?php foreach ($countries as $countryItem){?>
                                                        <option value="<?php echo $countryItem['ID'];?>"> <?php echo $countryItem['DESCRIPTION'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 col-md-3">
                                                <button type="submit" class="btn btn-block yellow-gold">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="portlet light bordered">

                        <div class="portlet-title">
                            <div class="caption font-red-flamingo">
                                Restricted Regions
                            </div>
                            <div class="actions">
                            </div>
                        </div>

                        <div class="portlet-body">
                            <table class="table table-striped table-hover" id="tbFileList" >
                                <thead>
                                    <tr>
                                        <th class="font-yellow-gold"> # </th>
                                        <th class="font-yellow-gold"> Name </th>
                                        <th class="font-grey-salsa"> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0 ; $i < count($restrictCountries); $i++){?>
                                        <tr>
                                            <td class="input-large"> <?php echo $i+1;?></td>
                                            <td class="input-large"> <?php echo $restrictCountries[$i]['COUNTRY_DESC'];?></td>
                                            <td class="input-large"> <a href="<?php echo base_url();?>admin/aml/remove_restrict_countries/<?php echo $restrictCountries[$i]['ID'];?>" class="btn btn-danger"> Remove </a> </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer;?>
<script src="<?php echo base_url();?>assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/datatables.all.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/pages/scripts/components-select2.js" type="text/javascript"></script>
</body>
</html>