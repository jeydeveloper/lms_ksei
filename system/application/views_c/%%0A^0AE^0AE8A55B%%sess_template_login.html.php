<?php /* Smarty version 2.6.26, created on 2018-10-23 08:50:51
         compiled from sess_template_login.html */ ?>
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
    <link rel="stylesheet"
          href="<?php echo $this->_tpl_vars['base_url']; ?>
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
        <?php if ($this->_tpl_vars['pageloginimage'] != ''): ?>
        #fullimage{
            background: url('<?php echo $this->_tpl_vars['base_url']; ?>
uploads/<?php echo $this->_tpl_vars['pageloginimage']; ?>
') no-repeat;
            background-size: 100%;
            margin-left: -15px;
            margin-right: -15px;
            padding-bottom: 170px;
            padding-top: 50px;
            margin-bottom: 200px;
            position: relative;
        }
        <?php else: ?>
        #fullimage{
            background: url('<?php echo $this->_tpl_vars['base_url']; ?>
assets/img/fullimage.png') no-repeat;
            background-size: 100%;
            margin-left: -15px;
            margin-right: -15px;
            padding-bottom: 170px;
            padding-top: 50px;
            margin-bottom: 200px;
            position: relative;
        }
        <?php endif; ?>
        h1,h2,h3{
            margin: 0;
            color: #ffffff;
            line-height: 60px;
        }
        h1{
            font-size: 45px;
        }
        #formLogin{
            position: absolute;
            background-color: #ffffff;
            width: 400px;
            height: 250px;
            top:50%;
            left: 50%;
            margin-left: -200px;
            margin-top: 50px;
            border: solid 1px #EAEDF0;
        }
        .form-control {
            height: 44px;
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
    </style>

    <script>
        $(document).ready( function() {
            $("#pass").val('');
        });

        function frmlogin_onsubmit()
        {
            $("#msg-content").hide();
            $.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/login/", $("#frmlogin").serialize(),
                function(data)
                {
                    $("#msg").html("");

                    var datas = data.split("\1");
                    if (parseInt(datas[0]) > 0)
                    {
                        $("#msg-content").show();
                        $("#msg").html(datas[1]);
                        return false;
                    }

                    if (datas[1] == 1)
                    {
                        alert("<?php echo $this->_tpl_vars['lexpired_password']; ?>
");
                        location = "<?php echo $this->_tpl_vars['site_url']; ?>
/user/changepass";
                    }
                    else
                    if ("<?php echo $this->_tpl_vars['site_url']; ?>
/user/login" ==  "<?php echo $this->_tpl_vars['referrer']; ?>
")
                    {
                        location = "<?php echo $this->_tpl_vars['base_url']; ?>
";
                    }
                    else
                    {
                        location = "<?php echo $this->_tpl_vars['referrer']; ?>
";
                    }
                }
            );

            return false;
        }
    </script>

    <style>
        #msg font{color: #fff !important;}
    </style>

    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
css/custom.css">
    <style>
        .wrapper {
            margin-top: 0 !important;
        }
    </style>
</head>
<body>

<div class="wrapper" id="login-page">

    <div class="row header-login" style="height: 50px;">
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
" class="logo" style="text-align: left;color: #000000 !important;">
                    <img style="width: 230px;height: 50px;" src="<?php echo $this->_tpl_vars['website_logo']; ?>
"> <!--<span style="font-size: 16px;"><?php echo $this->_tpl_vars['website_title']; ?>
</span>-->
                </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-8">
            <div style="padding: 15px 10px 0px;" class="text-right section-lang">
                <span style="display: inline-block;margin-right: 20px;">LANGUAGE</span>
                <div style="display: inline-block;margin-right: 20px;">
                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_id.gif" alt="" style="margin-right: 5px;">
                    <label for="ckIna" onclick="javascript:setlang('<?php echo $this->_tpl_vars['site_url']; ?>
/home/setlang', '<?php echo $this->_tpl_vars['base_url']; ?>
', 'id')">IND <input type="checkbox" name="ckIna" id="ckIna" <?php if ($this->_tpl_vars['lang'] == 'id' || $this->_tpl_vars['lang'] == ''): ?>checked<?php endif; ?>></label>
                </div>
                <div style="display: inline-block;margin-right: 20px;">
                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_en.gif" alt="" style="margin-right: 5px;">
                    <label for="ckEng" onclick="javascript:setlang('<?php echo $this->_tpl_vars['site_url']; ?>
/home/setlang', '<?php echo $this->_tpl_vars['base_url']; ?>
', 'en')">ENG <input type="checkbox" name="ckEng" id="ckEng" <?php if ($this->_tpl_vars['lang'] == 'en'): ?>checked<?php endif; ?>></label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="fullimage" class="text-center" style="margin-bottom: 150px;">
                <h1><?php if ($this->_tpl_vars['websiteloginword1'] != ''): ?><?php echo $this->_tpl_vars['websiteloginword1']; ?>
<?php else: ?>&nbsp;<?php endif; ?></h1>
                <h3><?php if ($this->_tpl_vars['websiteloginword2'] != ''): ?><?php echo $this->_tpl_vars['websiteloginword2']; ?>
<?php else: ?>&nbsp;<?php endif; ?></h3>
                <div id="formLogin" style="height: 200px;">
                    <div class="row" style="border-bottom: 0;">
                        <div class="col-xs-12">
                            <div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;    margin-top: 10px;margin-bottom: 0;">
                                <div id="msg"></div>
                            </div>
                    <form id="frmlogin" onsubmit="javascript:return frmlogin_onsubmit()" style="padding-top: 15px;">
                        <?php if ($this->_tpl_vars['loginbyemail']): ?>
                        <div class="form-group has-feedback">
                            <input type='text' name="email" id="email" class="form-control" placeholder="<?php echo $this->_tpl_vars['login_email']; ?>
">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <?php else: ?>
                        <div class="form-group has-feedback">
                            <input type='text' name="npk" id="npk" class="form-control" placeholder="<?php echo $this->_tpl_vars['login_nik']; ?>
">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <?php endif; ?>
                        <div class="form-group has-feedback">
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="<?php echo $this->_tpl_vars['login_password']; ?>
">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <button type="submit" class="btn btn-lg btn-primary btn-block btn-flat"><?php echo $this->_tpl_vars['login_button_login']; ?>
</button>
                        </div>
                        <!--<div class="form-group has-feedback text-center" style="padding-top: 10px;">
                            <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/home/forgotpass">Forgot your password?</a>
                        </div>-->
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $_from = $this->_tpl_vars['splitList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['row']):
?>
    <?php if (( $this->_tpl_vars['k'] % 2 ) == 1): ?>
    <div class="row">
        <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row2']):
?>
        <div class="col-md-3">
            <div class="box-me">
                <div class="row">
                    <div class="col-xs-12" style="padding: 25px;">
                        <p style="color: #A8B4BF;">BY ADMIN | <?php echo $this->_tpl_vars['row2']->entrydate; ?>
</p>
                        <p style="color: #2D475C;font-weight: bold;font-size: 16px;"><?php echo $this->_tpl_vars['row2']->news_desc; ?>
</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box-me">
                <img class="responsive" src="<?php echo $this->_tpl_vars['row2']->url_image; ?>
" alt="">
                <div class="arrow-right"></div>
            </div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
    <?php else: ?>
    <div class="row">
        <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row2']):
?>
        <div class="col-md-3">
            <div class="box-me">
                <img class="responsive" src="<?php echo $this->_tpl_vars['row2']->url_image; ?>
" alt="">
                <div class="arrow-left"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box-me">
                <div class="row">
                    <div class="col-xs-12" style="padding: 25px;">
                        <p style="color: #A8B4BF;">BY ADMIN | <?php echo $this->_tpl_vars['row2']->entrydate; ?>
</p>
                        <p style="color: #2D475C;font-weight: bold;font-size: 16px;"><?php echo $this->_tpl_vars['row2']->news_desc; ?>
</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>

    <div class="row section-footer">
        <div class="col-md-12">
            <p class="text-center footer-word" style="margin: 50px;color: #DFDFDF;">Powered by NCC Rev 2.75 &copy; 2010 -2016 Netpolitan. All Right Reserved.</p>
        </div>
    </div>

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