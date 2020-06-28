<?php /* Smarty version 2.6.26, created on 2019-10-10 14:15:25
         compiled from sess_template_news.html */ ?>
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
	</style>

	<style>
		.box-me {
			height: 248px;
			margin-right: -15px;
			margin-left: -15px;
			overflow: hidden;
		}
		.row {
			margin-right: 0;
			margin-left: 0;
			border-bottom: solid 1px #EAEDF0;
		}
		.responsive {
			width: 100%;
		}
		h1,h2,h3{
			margin: 0;
			color: #000000;
			line-height: 33px;
		}
		h1{
			font-size: 45px;
		}
		.arrow-left {
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-bottom: 15px solid transparent;
			border-right: 15px solid #ffffff;
			position: absolute;
			top: 50%;
			right: 0;
			margin-top: -15px;
		}
		.arrow-right {
			width: 0;
			height: 0;
			border-top: 15px solid transparent;
			border-bottom: 15px solid transparent;
			border-left: 15px solid #ffffff;
			position: absolute;
			top: 50%;
			left: 0;
			margin-top: -15px;
		}
		.box-me .row {
			border-bottom: 0;
		}
		.main-header .logo {
			color: #ffffff;
		}
		.content p, .content span {
			font-size: 16px !important;
			line-height: 24px;
		}
	</style>

	<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
css/custom.css">
	<style>
		.wrapper {
			margin-top: 0 !important;
		}
	</style>
</head>
<body class="hold-transition layout-top-nav">

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

<div class="wrapper">
	<div class="row" style="height: 50px;background-color: #ffffff !important;">
		<div class="col-md-4" style="padding-left: 0;">
			<div style="padding: 0;">
				<?php if (! $this->_tpl_vars['website_logo']): ?>
				<a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #1d81d1;text-align: left;">
					<img style="width: 230px;height: 50px;" src="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company.png" srcset="<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@2x.png 2x,
         <?php echo $this->_tpl_vars['base_url']; ?>
assets/img/logo-company@3x.png 3x"> <!-- <span style="font-size: 16px;">NCC LMS</span> -->
				</a>
				<?php else: ?>
				<a href="<?php echo $this->_tpl_vars['base_url']; ?>
" class="logo" style="background-color: #ffffff !important;text-align: left;color: #000000 !important;">
					<img style="width: 230px;height: 50px;" src="<?php echo $this->_tpl_vars['website_logo']; ?>
">
				</a>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-8">
			<div style="padding: 15px 10px 0px;" class="text-right">
				<span style="display: inline-block;margin-right: 20px;">LANGUAGE</span>
				<div style="display: inline-block;margin-right: 20px;">
					<img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_id.gif" alt="" style="margin-right: 5px;">
					<label for="ckIna" onclick="javascript:setlang('<?php echo $this->_tpl_vars['site_url']; ?>
/home/setlang', '<?php echo $this->_tpl_vars['base_url']; ?>
', 'id')">IND <input type="checkbox" name="ckIna" id="ckIna"></label>
				</div>
				<div style="display: inline-block;margin-right: 20px;">
					<img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_en.gif" alt="" style="margin-right: 5px;">
					<label for="ckEng" onclick="javascript:setlang('<?php echo $this->_tpl_vars['site_url']; ?>
/home/setlang', '<?php echo $this->_tpl_vars['base_url']; ?>
', 'en')">ENG <input type="checkbox" name="ckEng" id="ckEng"></label>
				</div>
			</div>
		</div>
	</div>

	<div class="content-wrapper">
		<div class="container">
			<section class="content">
				<div style="width: 500px;float: left;margin-right: 15px;">
					<img class="responsive" src="<?php echo $this->_tpl_vars['rows']->url_image; ?>
" alt="">
				</div>
				<div class="caption">
					<h3><?php echo $this->_tpl_vars['rows']->news_title; ?>
</h3>
					<p style="color: #A8B4BF;">BY ADMIN | <?php echo $this->_tpl_vars['rows']->entrydate; ?>
</p>
					<p><?php echo $this->_tpl_vars['rows']->news_desc; ?>
</p>
					<div style="display: block;text-align: right">
						<a href="<?php echo $this->_tpl_vars['base_url']; ?>
" style="padding: 0;">[back]</a>
					</div>
				</div>
			</section>
		</div>
	</div>



	<footer class="main-footer">
		<div class="pull-right hidden-xs">
			Powered by NCC. Rev. 2.75
		</div>
		&copy; Copyright 2010 - 2017 Netpolitan. All rights reserved.
	</footer>

</div>
<!-- ./wrapper -->

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