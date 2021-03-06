<?php /* Smarty version 2.6.26, created on 2018-10-23 09:55:32
         compiled from sess_template.html */ ?>
<?php if (! isset ( $this->_tpl_vars['current_url'] )): ?>
<?php $this->assign('current_url', ''); ?>
<?php endif; ?>

<?php if (! isset ( $this->_tpl_vars['win'] )): ?>
<?php $this->assign('win', ''); ?>
<?php endif; ?>

<?php if (! isset ( $_POST['noheader'] ) || ! $_POST['noheader']): ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NCCLP2</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/css/skins/_all-skins.min.css">

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 3 -->
    <script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        #active a {
            color: #0000ff !important;
            font-weight: bold;
        }
        #message font{color: #fff !important;}
        .skin-blue .sidebar-menu>li.active>a {
            border-left-color: #F7B002;
        }
        .mg-btm-10 {
            margin-bottom: 10px;
        }
        .content-paging form {
            display: inline-block;
        }
        .content-paging {
            padding: 10px;
            background-color: #DCDCDC;
        }
        .skin-blue .main-header .navbar .sidebar-toggle:hover{
            background-color:#1d81d1;
            color: #ffffff !important;
        }
        .main-header .logo{
            padding: 0 15px 0 5px;
        }
        .navbar-toggle .icon-bar {
            background-color: #888;
        }
        .breadcrumb{
            display: none;
        }
        .error {
            background: red;
            padding: 10px;
            color: #ffffff;
        }

        .easy-autocomplete {
            width: 90% !important;
        }
    </style>

    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
css/custom.css">
</head>


<body class="<?php if (! isset ( $_POST['dialog'] ) || ! $_POST['dialog']): ?>hold-transition skin-blue fixed sidebar-mini<?php else: ?>skin-blue layout-top-nav<?php endif; ?>">

<?php endif; ?>

<?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
<?php if (( $this->_tpl_vars['page'] == 'training' || $this->_tpl_vars['page'] == 'certificate' ) && $this->_tpl_vars['subpage'] == 'historydetail'): ?>
<?php $this->assign('isprofile', true); ?>
<?php elseif (( $this->_tpl_vars['page'] == 'user' && ( $this->_tpl_vars['subpage'] == 'info' || $this->_tpl_vars['subpage'] == 'changepass' || $this->_tpl_vars['subpage'] == 'editinfo' ) ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'history' && ! $this->_tpl_vars['sess']['asadmin'] ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'history' && ! $this->_tpl_vars['sess']['asadmin'] ) || ( $this->_tpl_vars['page'] == 'resources' && ( ! $this->_tpl_vars['sess']['asadmin'] && ( $this->_tpl_vars['subpage'] == 'history' || $this->_tpl_vars['subpage'] == 'historydetail' ) ) )): ?>
<?php $this->assign('isprofile', true); ?>
<?php else: ?>
<?php $this->assign('isprofile', false); ?>
<?php endif; ?>
<?php elseif (( $this->_tpl_vars['page'] == 'user' && ( $this->_tpl_vars['subpage'] == 'info' || $this->_tpl_vars['subpage'] == 'changepass' || $this->_tpl_vars['subpage'] == 'editinfo' ) ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'history' && ! $this->_tpl_vars['sess']['asadmin'] ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'history' && ! $this->_tpl_vars['sess']['asadmin'] ) || ( $this->_tpl_vars['page'] == 'resources' && ( ! $this->_tpl_vars['sess']['asadmin'] && ( $this->_tpl_vars['subpage'] == 'history' || $this->_tpl_vars['subpage'] == 'historydetail' ) ) )): ?>
<?php $this->assign('isprofile', true); ?>
<?php else: ?>
<?php $this->assign('isprofile', false); ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
<?php if (( $this->_tpl_vars['page'] == 'training' || $this->_tpl_vars['page'] == 'certificate' ) && $this->_tpl_vars['subpage'] == 'historydetail'): ?>
<?php $this->assign('istraining', false); ?>
<?php elseif (( $this->_tpl_vars['page'] == 'topic' && $this->_tpl_vars['subpage'] != 'category' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] != 'history' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] != 'history' ) || $this->_tpl_vars['page'] == 'banksoal' || ( $this->_tpl_vars['page'] == 'resources' && $this->_tpl_vars['subpage'] != 'history' && $this->_tpl_vars['subpage'] != 'historydetail' )): ?>
<?php $this->assign('istraining', true); ?>
<?php else: ?>
<?php $this->assign('istraining', false); ?>
<?php endif; ?>
<?php elseif ($this->_tpl_vars['page'] == 'topic' || $this->_tpl_vars['page'] == 'training' || $this->_tpl_vars['page'] == 'certificate' || $this->_tpl_vars['page'] == 'banksoal' || $this->_tpl_vars['page'] == 'resources' || $this->_tpl_vars['page'] == 'classroom' || ( $this->_tpl_vars['page'] == 'import' && $this->_tpl_vars['subpage'] == 'topic_traning' ) || ( $this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'activities' ) || ( $this->_tpl_vars['page'] == 'activities' )): ?>
<?php $this->assign('istraining', true); ?>
<?php else: ?>
<?php $this->assign('istraining', false); ?>
<?php endif; ?>

<?php if (! isset ( $_POST['dialog'] ) || ! $_POST['dialog']): ?>
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <?php if (! $this->_tpl_vars['website_logo']): ?>
            <?php if (! $this->_tpl_vars['website_title']): ?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #1d81d1;text-align: left;padding: 0;">
                <img style="height: 50px;width: 100%;vertical-align: initial;" src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company.png" srcset="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@2x.png 2x,
             <?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@3x.png 3x">
            </a>
            <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #1d81d1;text-align: left;">
                <img height="30px" src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company.png" srcset="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@2x.png 2x,
             <?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@3x.png 3x"> <span style="font-size: 16px;">NCC LMS</span>
            </a>
            <?php endif; ?>
        <?php else: ?>
            <?php if (! $this->_tpl_vars['website_title']): ?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #1d81d1;text-align: left;padding: 0;">
                <img style="height: 50px;width: 100%;vertical-align: initial;" src="<?php echo $this->_tpl_vars['website_logo']; ?>
">
            </a>
            <?php else: ?>
            <a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #1d81d1;text-align: left;">
                <img height="30px" src="<?php echo $this->_tpl_vars['website_logo']; ?>
"> <span style="font-size: 16px;"><?php echo $this->_tpl_vars['website_title']; ?>
</span>
            </a>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" style="background-color: #ffffff;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="border-color: #ddd;">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Sidebar toggle button-->
            <!--<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color: #9d9fa2;">-->
            <a href="#" class="sidebar-toggle" role="button" style="color: #9d9fa2;display: none;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style="font-size: 12px;">
                    <?php if ($this->_tpl_vars['sess']): ?>
                    <li><a href="<?php echo $this->_tpl_vars['base_url']; ?>
" id="current" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['home']; ?>
</a></li>
                    <li<?php if ($this->_tpl_vars['isprofile'] || ( ( $this->_tpl_vars['page'] == 'ildpform' && ! $this->_tpl_vars['sess']['asadmin'] ) || $this->_tpl_vars['page'] == 'ildpapproval' || $this->_tpl_vars['page'] == 'ildpapprovalhist' || $this->_tpl_vars['page'] == 'ildphist' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/info" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['your_profile']; ?>
</a></li>
                    <?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
                    <li<?php if ($this->_tpl_vars['page'] == 'topic' && $this->_tpl_vars['subpage'] == 'category'): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/category" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['lcategory1']; ?>
</a></li>
                    <li<?php if ($this->_tpl_vars['istraining'] || ( $this->_tpl_vars['page'] == 'ildp' && ( $this->_tpl_vars['subpage'] != 'myform' && $this->_tpl_vars['subpage'] != 'approval' ) )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_topics']; ?>
</a></li>
                    <!--<li<?php if (( $this->_tpl_vars['page'] == 'request' && ( $this->_tpl_vars['subpage'] == 'training' || $this->_tpl_vars['subpage'] == 'formtraining' || $this->_tpl_vars['subpage'] == 'approval' ) )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/request/training" style="color: #9d9fa2;text-transform: uppercase;">Request Training</a></li>-->
                    <?php else: ?>
                    <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['category'] || $this->_tpl_vars['sessmodules']['topic'] || $this->_tpl_vars['sessmodules']['training'] || $this->_tpl_vars['sessmodules']['certificate'] || $this->_tpl_vars['sessmodules']['classroom'] || $this->_tpl_vars['sessmodules']['resources'] || $this->_tpl_vars['ishavedelegetion']): ?>
                    <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['category']): ?>
                    <li<?php if ($this->_tpl_vars['istraining'] || ( $this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'activities' ) || ( $this->_tpl_vars['page'] == 'activities' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/category" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php elseif ($this->_tpl_vars['sessmodules']['topic']): ?>
                    <li<?php if ($this->_tpl_vars['istraining']): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php elseif ($this->_tpl_vars['sessmodules']['training'] || $this->_tpl_vars['ishavedelegetion']): ?>
                    <li<?php if ($this->_tpl_vars['istraining']): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php elseif ($this->_tpl_vars['sessmodules']['certificate']): ?>
                    <li<?php if ($this->_tpl_vars['istraining']): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php elseif ($this->_tpl_vars['sessmodules']['classroom']): ?>
                    <li<?php if ($this->_tpl_vars['istraining']): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php elseif ($this->_tpl_vars['sessmodules']['resources']): ?>
                    <li<?php if ($this->_tpl_vars['istraining']): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['llearning_admin']; ?>
</a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sessmodules']['ildpadmin'] && $this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['showildp'] == 1): ?>
                    <li<?php if ($this->_tpl_vars['page'] == 'ildp' || $this->_tpl_vars['page'] == 'ildpcatalog' || $this->_tpl_vars['page'] == 'ildpmethod' || $this->_tpl_vars['page'] == 'hrrm' || $this->_tpl_vars['page'] == 'hrld' || $this->_tpl_vars['page'] == 'ildpcategory' || $this->_tpl_vars['page'] == 'ildpregperiod' || $this->_tpl_vars['page'] == 'ildpreport' || $this->_tpl_vars['page'] == 'ildpqueue' || ( $this->_tpl_vars['page'] == 'ildpform' && $this->_tpl_vars['sess']['asadmin'] ) || ( $this->_tpl_vars['page'] == 'ildpformimport' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildpcatalog/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['lildp_admin']; ?>
</a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sess']['asadmin']): ?>
                    <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['user'] || $this->_tpl_vars['sessmodules']['right']): ?>
                    <li<?php if (( $this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'showlist' ) || $this->_tpl_vars['page'] == 'reminder' || $this->_tpl_vars['page'] == 'level' || $this->_tpl_vars['page'] == 'jabatan' || $this->_tpl_vars['page'] == 'func' || $this->_tpl_vars['page'] == 'right'): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['luser_admin']; ?>
</a></li>

                    <li<?php if (( $this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'admin_news' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/admin_news/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['ladmin_news']; ?>
</a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master'] || $this->_tpl_vars['sessmodules']['right']): ?>
                    <?php if ($this->_tpl_vars['sessmodules']['master']): ?>
                    <li<?php if ($this->_tpl_vars['page'] == 'reminder' || $this->_tpl_vars['page'] == 'generalsetting' || $this->_tpl_vars['page'] == 'lokasi' || ( $this->_tpl_vars['page'] == 'import' && $this->_tpl_vars['subpage'] == 'masterdata' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['lsettings']; ?>
</a></li>
                    <?php else: ?>
                    <li<?php if ($this->_tpl_vars['page'] == 'reminder' || $this->_tpl_vars['page'] == 'generalsetting' || $this->_tpl_vars['page'] == 'lokasi' || ( $this->_tpl_vars['page'] == 'import' && $this->_tpl_vars['subpage'] == 'masterdata' )): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['lsettings']; ?>
</a></li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['sessmodules']['trainee']): ?>
                    <li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/astrainee" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['ltrainee_menu']; ?>
</a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['sessmodulesadmin']): ?>
                    <li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/asadmin" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['ladmin_menu']; ?>
</a></li>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['sessmodules']['report']): ?>
                    <li<?php if ($this->_tpl_vars['page'] == 'report'): ?> id="active"<?php endif; ?>><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/report/" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['lreport']; ?>
</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/logout" style="color: #9d9fa2;text-transform: uppercase;"><?php echo $this->_tpl_vars['logout']; ?>
</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main sidebar. Left side column. contains the logo and sidebar -->
    <?php if ($this->_tpl_vars['left_content']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['left_content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
    <!-- /.main-sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <?php if ($this->_tpl_vars['main_content']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['main_content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            Powered by NCC. Rev. 2.75
        </div>
        &copy; Copyright 2010 - 2018 Netpolitan. All rights reserved.
    </footer>

</div>
<!-- ./wrapper -->
<?php else: ?>
<style>
    .fixed .content-wrapper, .fixed .right-side {
        padding-top: 0;
    }
    .modal-dialog {
        width: 800px !important;
    }
</style>
<div class="skin-blue layout-top-nav">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <?php if ($this->_tpl_vars['main_content']): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['main_content'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
        <!-- /.content-wrapper -->
    </div>
</div>
<?php endif; ?>

<?php if (! isset ( $_POST['noheader'] ) || ! $_POST['noheader']): ?>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/js/adminlte.min.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script>
    $.fn.datepicker.defaults.autoclose = true;
</script>
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/js/demo.js"></script>
<script src="<?php echo $this->_tpl_vars['base_url']; ?>
js/common.js"></script>
</body>
</html>
<?php endif; ?>