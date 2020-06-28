<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:39
         compiled from generalsetting/form.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/tiny_mce/tiny_mce.js"></script>
<script>
    tinyMCE.init(
        {
            mode: "textareas",
            theme: "advanced",
            plugins: "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
            //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true
        }
    );
</script>

<style type="text/css">
    .search_wrap {
        margin-top: 10px;
    }

    .search_wrap select {
        width: 450px;
        height: 160px;
    }

    .search_wrap_content {
        display: inline-block;
        vertical-align: top;
        min-width: 100px;
        text-align: center;
    }
</style>

<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/datetimepicker.js"></script>
<script>
    function frmsetting_onchange() {

        $("#message").html("Saving...");
        return true;
    }

    function setErrorMessage(err) {
        $("#message").html(err);
    }

    function setSuccess(msg) {
        $("#message").html(msg);
        setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting"', <?php echo $this->_tpl_vars['flashtime']; ?>
)
        ;
    }

    function addresourcetype() {
        $("#resourcetype" + itype).show();
        itype++;
    }

    var itype = <?php echo $this->_tpl_vars['nresourcetype']; ?>

    ;
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['general_settings']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><?php echo $this->_tpl_vars['general_settings']; ?>
</a></li>
            <li class="active">Form</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
                    <div id="message"></div>
                </div>
                <form class="form-horizontal" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/save/"
                      enctype="multipart/form-data" name="frmsetting" id="frmsetting"
                      onsubmit="javascript: return frmsetting_onchange()" target="iframe_setting">
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['general_settings']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td style="border: 0 !important;"><table class="table">
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['ldefaultlanguange']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'>
                                                        <select name="defaultlang" id="defaultlang" class='formshort'>
                                                            <option value="id"<?php if ($this->_tpl_vars['defaultlang'] == 'id'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['lndonesia']; ?>
</option>
                                                            <option value="en"<?php if ($this->_tpl_vars['defaultlang'] == 'en'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['lenglish']; ?>
</option>
                                                        </select>
                                                    </td>
                                                    <td ><?php echo $this->_tpl_vars['ldefaultlanguange_description']; ?>
</td>
                                                </tr>

                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['lenablechangelanguange']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'>
                                                        <input type='radio' name="changelang" id="changelang" value="1" <?php if ($this->_tpl_vars['setting']['changelang'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                        <input type='radio' name="changelang" id="changelang" value="0" <?php if ($this->_tpl_vars['setting']['changelang'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                                    </td>
                                                    <td >&nbsp;</td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lwebsitetitle']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="websitetitle" id="websitetitle" class='formdefault' value="<?php if ($this->_tpl_vars['setting']['websitetitle']): ?><?php echo $this->_tpl_vars['setting']['websitetitle']; ?>
<?php endif; ?>"></td>
                                                    <td ><?php echo $this->_tpl_vars['lwebsitetitle_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lwebsitelogo']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='file' name="websitelogo" id="websitelogo" class='formdefault' value=""></td>
                                                    <td ><?php echo $this->_tpl_vars['lwebsitelogo_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="3">&nbsp;<?php echo $this->_tpl_vars['websitelogo']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td>Login word 1</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="websiteloginword1" id="websiteloginword1" class='formdefault' value="<?php if ($this->_tpl_vars['setting']['websiteloginword1']): ?><?php echo $this->_tpl_vars['setting']['websiteloginword1']; ?>
<?php endif; ?>"></td>
                                                    <td >Login word 1</td>
                                                </tr>
                                                <tr>
                                                    <td>Login word 2</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="websiteloginword2" id="websiteloginword2" class='formdefault' value="<?php if ($this->_tpl_vars['setting']['websiteloginword2']): ?><?php echo $this->_tpl_vars['setting']['websiteloginword2']; ?>
<?php endif; ?>"></td>
                                                    <td >Login word 2</td>
                                                </tr>
                                                <tr>
                                                    <td>Page Login Image</td>
                                                    <td width="1">:</td>
                                                    <td><input type='file' name="pageloginimage" id="pageloginimage" class='formdefault' value=""></td>
                                                    <td >Page login image</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="3">&nbsp;<?php echo $this->_tpl_vars['pageloginimage']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lconcurent_user']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="concurrentuser" id="concurrentuser" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['concurrentuser']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lconcurent_user_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lrecordperpage']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td>
                                                        <select name='recordperpage' id='recordperpage'>
                                                            <option value='10' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 10): ?> selected <?php endif; ?> >10</option>
                                                            <option value='20' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 20): ?> selected <?php endif; ?> >20</option>
                                                            <option value='30' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 30): ?> selected <?php endif; ?> >30</option>
                                                            <option value='40' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 40): ?> selected <?php endif; ?> >40</option>
                                                            <option value='50' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 50): ?> selected <?php endif; ?> >50</option>
                                                            <option value='100' <?php if ($this->_tpl_vars['setting']['recordperpage'] == 100): ?> selected <?php endif; ?>  >100</option>
                                                        </select>
                                                    </td>
                                                    <td ><?php echo $this->_tpl_vars['lrecordperpage_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['lshowildp']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'>
                                                        <input type='radio' name="showildp" id="showildp" value="1" <?php if ($this->_tpl_vars['setting']['showildp'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                        <input type='radio' name="showildp" id="showildp" value="0" <?php if ($this->_tpl_vars['setting']['showildp'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                                    </td>
                                                    <td >&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['llogin_by_email']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'>
                                                        <input type='radio' name="loginbyemail" id="loginbyemail" value="1" <?php if ($this->_tpl_vars['setting']['loginbyemail'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                        <input type='radio' name="loginbyemail" id="loginbyemail" value="0" <?php if ($this->_tpl_vars['setting']['loginbyemail'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                                    </td>
                                                    <td >&nbsp;</td>
                                                </tr>

                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lsession']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td style="border: 0 !important;"><table class="table">
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['lsession_idle_time']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'><input type='text' name="sessiontimeout" id="sessiontimeout" class='formnumber' value="<?php if ($this->_tpl_vars['setting']['sessiontimeout'] >= 0): ?><?php echo $this->_tpl_vars['setting']['sessiontimeout']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sessiontimeout']; ?>
<?php endif; ?>"></td>
                                                    <td ><?php echo $this->_tpl_vars['lsession_idle_time_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td ><?php echo $this->_tpl_vars['linactive_period']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td width="50"><input type='text' name="inactiveperiod" id="inactiveperiod" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['inactiveperiod']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['linactive_period_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td ><?php echo $this->_tpl_vars['lmultiple_login']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td width="50"><input type='radio' name="multiplelogin" id="multiplelogin" value="1"<?php if ($this->_tpl_vars['setting']['multiplelogin'] == "" || $this->_tpl_vars['setting']['multiplelogin'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>
 <input type='radio' name="multiplelogin" id="multiplelogin"  value="2"<?php if ($this->_tpl_vars['setting']['multiplelogin'] == 2): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>
</td>
                                                    <td ><?php echo $this->_tpl_vars['lmultiple_login_description']; ?>
</td>
                                                </tr>

                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lpassword_setting']; ?>
</legend>

                                    <table class="table">
                                        <tr>
                                            <td style="border: 0 !important;"><table class="table">

                                                <tr>
                                                    <td width='25%'><?php echo $this->_tpl_vars['lsetting_expiredpassword']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'><input type='text' name="expiredpassword" id="expiredpassword" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['expiredpassword']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lexpired_password_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lsetting_minpasswordlength']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="minpasslen" id="minpasslen" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['minpasslen']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lsetting_minpasswordlength_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lsetting_maxpasswordlength']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="maxpasslen" id="maxpasslen" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['maxpasslen']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lsetting_maxpasswordlength_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lsetting_passwordchar']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td>
                                                        <input type='radio' name="passchar" id="passchar" value="alphanumeric" <?php if ($this->_tpl_vars['setting']['passchar'] == 'alphanumeric'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lsetting_passchar_alphanumeric']; ?>

                                                        <input type='radio' name="passchar" id="passchar" value="free" <?php if ($this->_tpl_vars['setting']['passchar'] != 'alphanumeric'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lsetting_passchar_free']; ?>

                                                    </td>
                                                    <td ><?php echo $this->_tpl_vars['lsetting_passwordchar_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lmaxchangepassword']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="maxchangepassword" id="maxchangepassword" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['maxchangepassword']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lmaxchangepassworddescription']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lpasschange1st']; ?>
</td>
                                                    <td>:</td>
                                                    <td>
                                                        <input type="radio" name="changepass1st" id="changepass1st" value="1"<?php if ($this->_tpl_vars['setting']['changepass1st'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                        <input type="radio" name="changepass1st" id="changepass1st" value="0"<?php if ($this->_tpl_vars['setting']['changepass1st'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                                    </td>
                                                    <td ><?php echo $this->_tpl_vars['lpasschange1stdescription']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lsetting_errorlogin']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="errorlogin" id="errorlogin" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['errorlogin']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lerror_login_description']; ?>
</td>
                                                </tr>
                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['ltraining_setting']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td width="25%"><?php echo $this->_tpl_vars['lmaximumtaken']; ?>
</td>
                                            <td width="1%">:</td>
                                            <td width='40%'><input type='text' name="maxtaken" id="maxtaken" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['maxtaken']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lmaximumtakendescription']; ?>
</td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->_tpl_vars['lshow_materi_history']; ?>
</td>
                                            <td>:</td>
                                            <td>
                                                <!-- showmaterihist -->
                                                <input type="radio" name="personalreportmateri" id="personalreportmateri" value="1"<?php if ($this->_tpl_vars['setting']['personalreportmateri'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="personalreportmateri" id="personalreportmateri" value="0"<?php if ($this->_tpl_vars['setting']['personalreportmateri'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lshow_materi_history_description']; ?>
</td>
                                        </tr>
                                        <tr>
                                            <td ><?php echo $this->_tpl_vars['ltraining_template_print']; ?>
</td>
                                            <td >:</td>
                                            <td>
                                                <input type='file' name="trainingtpl" id="trainingtpl" class='formnumber' value="">
                                                <?php if ($this->_tpl_vars['setting']['trainingtpl']): ?><br /><a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/tmpl/<?php echo $this->_tpl_vars['setting']['trainingtpl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['setting']['trainingtpl']; ?>
</a><?php endif; ?>
                                            </td>
                                            <td ><?php echo $this->_tpl_vars['ltraining_template_print_desc']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->_tpl_vars['lshow_print_certificate']; ?>
</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showtrainingprint" id="showtrainingprint" value="1"<?php if ($this->_tpl_vars['setting']['showtrainingprint'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showtrainingprint" id="showtrainingprint" value="0"<?php if ($this->_tpl_vars['setting']['showtrainingprint'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lshow_print_certificate_training_desc']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->_tpl_vars['lshow_min_lulus']; ?>
</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showtrainingminlulus" id="showtrainingminlulus" value="1"<?php if ($this->_tpl_vars['setting']['showtrainingminlulus'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showtrainingminlulus" id="showtrainingminlulus" value="0"<?php if ($this->_tpl_vars['setting']['showtrainingminlulus'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lshow_min_lulus_training_desc']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td>Tampilkan Soal satu-satu (single questioner)</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showtrainingquestionall" id="showtrainingquestionall" value="1"<?php if ($this->_tpl_vars['setting']['showtrainingquestionall'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showtrainingquestionall" id="showtrainingquestionall" value="0"<?php if ($this->_tpl_vars['setting']['showtrainingquestionall'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Jika soal belum selesai, tampilkan soal yang belum selesai satu-satu di belakang</td>
                                        </tr>

                                        <tr>
                                            <td>Banyak loop soal</td>
                                            <td>:</td>
                                            <td>
                                                <input type='text' name="totallooptraining" id="totallooptraining" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['totallooptraining']; ?>
">
                                            </td>
                                            <td >Banyak loop soal yang dilakukan pada saat ikut sertifikasi</td>
                                        </tr>

                                        <tr>
                                            <td>Tipe loop soal</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="typelooptraining" id="typelooptraining_1" value="1"<?php if ($this->_tpl_vars['setting']['typelooptraining'] == 1): ?> checked<?php endif; ?>> Semua Soal
                                                <input type="radio" name="typelooptraining" id="typelooptraining_2" value="0"<?php if ($this->_tpl_vars['setting']['typelooptraining'] != 1): ?> checked<?php endif; ?>> Soal yang belum terjawab
                                            </td>
                                            <td >Menentukan soal yang ditampilkan pada saat looping terjadi</td>
                                        </tr>

                                        <tr>
                                            <td>Tampilkan info counter praexam dan materi</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showtrainingcounterpraexammateri" id="showtrainingcounterpraexammateri" value="1"<?php if ($this->_tpl_vars['setting']['showtrainingcounterpraexammateri'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showtrainingcounterpraexammateri" id="showtrainingcounterpraexammateri" value="0"<?php if ($this->_tpl_vars['setting']['showtrainingcounterpraexammateri'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Jika iya, maka akan muncul jumlah counter praexam dan materi</td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lcertification_setting']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td width="25%"><?php echo $this->_tpl_vars['lcertificate_template']; ?>
</td>
                                            <td width="1%">:</td>
                                            <td width='40%'>
                                                <input type='file' name="certtpl" id="certtpl" class='formnumber' value="">
                                                <?php if ($this->_tpl_vars['setting']['certtpl']): ?><br /><a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/tmpl/<?php echo $this->_tpl_vars['setting']['certtpl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['setting']['certtpl']; ?>
</a><?php endif; ?>
                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lcertificate_template_desc']; ?>
</td>
                                        </tr>
                                        <tr>
                                            <td ><?php echo $this->_tpl_vars['lcertificate_sign']; ?>
</td>
                                            <td >:</td>
                                            <td><input type='text' name="certificatesign" id="certificatesign" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['certificatesign']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lcertificate_sign_description']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->_tpl_vars['lshow_print_certificate']; ?>
</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showcertificationprint" id="showcertificationprint" value="1"<?php if ($this->_tpl_vars['setting']['showcertificationprint'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showcertificationprint" id="showcertificationprint" value="0"<?php if ($this->_tpl_vars['setting']['showcertificationprint'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lshow_print_certificate_desc']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->_tpl_vars['lshow_min_lulus']; ?>
</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showcertificationminlulus" id="showcertificationminlulus" value="1"<?php if ($this->_tpl_vars['setting']['showcertificationminlulus'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showcertificationminlulus" id="showcertificationminlulus" value="0"<?php if ($this->_tpl_vars['setting']['showcertificationminlulus'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td ><?php echo $this->_tpl_vars['lshow_min_lulus_certificate_desc']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td>Tampilkan Soal satu-satu (single questioner)</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="showcertificationquestionall" id="showcertificationquestionall" value="1"<?php if ($this->_tpl_vars['setting']['showcertificationquestionall'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type="radio" name="showcertificationquestionall" id="showcertificationquestionall" value="0"<?php if ($this->_tpl_vars['setting']['showcertificationquestionall'] != 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Jika soal belum selesai, tampilkan soal yang belum selesai satu-satu di belakang</td>
                                        </tr>

                                        <tr>
                                            <td>Banyak loop soal</td>
                                            <td>:</td>
                                            <td>
                                                <input type='text' name="totalloopcertification" id="totalloopcertification" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['totalloopcertification']; ?>
">
                                            </td>
                                            <td >Banyak loop soal yang dilakukan pada saat ikut sertifikasi</td>
                                        </tr>

                                        <tr>
                                            <td>Tipe loop soal</td>
                                            <td>:</td>
                                            <td>
                                                <input type="radio" name="typeloopcertification" id="typeloopcertification_1" value="1"<?php if ($this->_tpl_vars['setting']['typeloopcertification'] == 1): ?> checked<?php endif; ?>> Semua Soal
                                                <input type="radio" name="typeloopcertification" id="typeloopcertification_2" value="0"<?php if ($this->_tpl_vars['setting']['typeloopcertification'] != 1): ?> checked<?php endif; ?>> Soal yang belum terjawab
                                            </td>
                                            <td >Menentukan soal yang ditampilkan pada saat looping terjadi</td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lresource_setting']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td width="25%"><?php echo $this->_tpl_vars['lmaximum_size']; ?>
</td>
                                            <td width="1%">:</td>
                                            <td width='40%'><input type='text' name="resourcemaxsize" id="resourcemaxsize" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['resourcemaxsize']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lmaximum_size_description']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td ><?php echo $this->_tpl_vars['lresource_type']; ?>
</td>
                                            <td >:</td>
                                            <td><input type='text' name="resourcetype[]" id="resourcetype[]" class='formnumber' value="<?php if ($this->_tpl_vars['resourcetype']): ?><?php echo $this->_tpl_vars['resourcetype'][0]; ?>
<?php endif; ?>">
                                                <a href="javascript:addresourcetype()"><?php echo $this->_tpl_vars['ladd_recourcetype']; ?>
</a></td>
                                            <td ><?php echo $this->_tpl_vars['lresource_type_description']; ?>
</td>
                                        </tr>
                                        <?php $_from = $this->_tpl_vars['maxresourcetypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tipe']):
?>
                                        <tr id="resourcetype<?php echo $this->_tpl_vars['tipe']['no']; ?>
" <?php if ($this->_tpl_vars['tipe']['value'] == ''): ?>style="display: none;"<?php endif; ?>>
                                        <td >&nbsp;</td>
                                        <td >:</td>
                                        <td colspan='2'><input type='text' name="resourcetype[]" id="resourcetype[]" class='formnumber' value="<?php echo $this->_tpl_vars['tipe']['value']; ?>
"></td>
                                        </tr>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lreminder']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td style="border: 0 !important;"><table class="table">
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['lday_interval']; ?>
</td>
                                                    <td width="1%">:</td>
                                                    <td  width='40%'><input type='text' name="day_interval" id="day_interval" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['day_interval']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lday_interval_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lnotice_per']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="notice_per" id="notice_per" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['notice_per']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lnotice_per_description']; ?>
</td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lremindermailsender']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="remindermailsender" id="remindermailsender" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['remindermailsender']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lremindermailsenderdescription']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lremindermailsendername']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="remindersendername" id="remindersendername" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['remindersendername']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lremindermailsendernamedescription']; ?>
</td>
                                                </tr>

                                                <tr>
                                                    <td><?php echo $this->_tpl_vars['lremindermailsubject']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td><input type='text' name="remindermailsubject" id="remindermailsubject" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['remindermailsubject']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lremindermailsubjectdescription']; ?>
</td>
                                                </tr>
                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend><?php echo $this->_tpl_vars['lsetting_cms_admin']; ?>
</legend>
                                    <table class="table">
                                        <tr>
                                            <td style="border: 0 !important;"><table class="table">
                                                <tr>
                                                    <td  width='25%'><?php echo $this->_tpl_vars['lcms_admin_activity_periodic']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td  width='40%'><input type='text' name="cms_activity_periodic" id="cms_activity_periodic" class='formnumber' value="<?php if ($this->_tpl_vars['setting']['cms_activity_periodic'] >= 0): ?><?php echo $this->_tpl_vars['setting']['cms_activity_periodic']; ?>
<?php else: ?>0<?php endif; ?>"></td>
                                                    <td ><?php echo $this->_tpl_vars['lcms_admin_activity_periodic_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td ><?php echo $this->_tpl_vars['lnews_per_page']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td width="50"><input type='text' name="cms_news_per_page" id="cms_news_per_page" class='formnumber' value="<?php echo $this->_tpl_vars['setting']['cms_news_per_page']; ?>
"></td>
                                                    <td ><?php echo $this->_tpl_vars['lnews_per_page_description']; ?>
</td>
                                                </tr>
                                                <tr>
                                                    <td ><?php echo $this->_tpl_vars['lshow_admin_news']; ?>
</td>
                                                    <td width="1">:</td>
                                                    <td width="50"><input type='radio' name="cms_show_admin_news" id="cms_show_admin_news" value="1"<?php if ($this->_tpl_vars['setting']['cms_show_admin_news'] == 1): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>
 <input type='radio' name="cms_show_admin_news" id="cms_show_admin_news"  value="0"<?php if ($this->_tpl_vars['setting']['cms_show_admin_news'] == 0): ?> checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>
</td>
                                                    <td ><?php echo $this->_tpl_vars['lshow_admin_news_description']; ?>
</td>
                                                </tr>

                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend>Default Approval Request Proposal</legend>
                                    <table class="table">
                                        <tr>
                                            <td>Import File Approval</td>
                                            <td width="1">:</td>
                                            <td><input type='file' name="fileimportapproval" id="fileimportapproval" class='formdefault' value=""><br/><a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/format_import_file_approval.xls" target="_blank">(Download format import file approval)</a></td>
                                            <td>Import file approval</td>
                                        </tr>
                                        <?php if ($this->_tpl_vars['setting']['fileimportapproval']): ?>
                                        <tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td colspan="2">Download last file upload : <a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/general_setting/<?php echo $this->_tpl_vars['setting']['fileimportapproval']; ?>
" download><?php echo $this->_tpl_vars['setting']['fileimportapproval']; ?>
</a></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td  width='25%'>Show Top Running Text Approval</td>
                                            <td width="1">:</td>
                                            <td  width='40%'>
                                                <input type='radio' name="show_running_text_approval" id="show_running_text_approval_1" value="1" <?php if ($this->_tpl_vars['setting']['show_running_text_approval'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type='radio' name="show_running_text_approval" id="show_running_text_approval_2" value="0" <?php if ($this->_tpl_vars['setting']['show_running_text_approval'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Show running text "request need your approval"</td>
                                        </tr>

                                        <tr>
                                            <td  width='25%'>Notification approval by email</td>
                                            <td width="1">:</td>
                                            <td  width='40%'>
                                                <input type='radio' name="notif_email_approval" id="notif_email_approval_1" value="1" <?php if ($this->_tpl_vars['setting']['notif_email_approval'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type='radio' name="notif_email_approval" id="notif_email_approval_2" value="0" <?php if ($this->_tpl_vars['setting']['notif_email_approval'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Send notification approval by email</td>
                                        </tr>
                                        <tr>
                                            <td>Notification Email Sender</td>
                                            <td width="1">:</td>
                                            <td><input type='text' name="notif_email_sender" id="notif_email_sender" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['notif_email_sender']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lremindermailsenderdescription']; ?>
</td>
                                        </tr>
                                        <tr>
                                            <td>Notification Sender Name</td>
                                            <td width="1">:</td>
                                            <td><input type='text' name="notif_email_name" id="notif_email_name" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['notif_email_name']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lremindermailsendernamedescription']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td>Notification Subject</td>
                                            <td width="1">:</td>
                                            <td><input type='text' name="notif_email_subject" id="notif_email_subject" class='formdefault' value="<?php echo $this->_tpl_vars['setting']['notif_email_subject']; ?>
"></td>
                                            <td ><?php echo $this->_tpl_vars['lremindermailsubjectdescription']; ?>
</td>
                                        </tr>

                                        <tr>
                                            <td valign="top">Notification Email Body</td>
                                            <td valign="top">:</td>
                                            <td>&nbsp;</td>
                                            <td valign="top">Notification Email Body</td>
                                        </tr>

                                        <tr>
                                            <td colspan='4'>
       <textarea name="notif_email_body" id="notif_email_body" rows="16" cols="50">
         <?php echo $this->_tpl_vars['setting']['notif_email_body']; ?>

       </textarea>
                                            </td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend>Learning Catalog</legend>
                                    <table class="table">
                                        <tr>
                                            <td>Upload file learning catalog</td>
                                            <td width="1">:</td>
                                            <td><input type='file' name="file_learning_catalog" id="file_learning_catalog" class='formdefault' value=""></td>
                                            <td >Upload file learning catalog</td>
                                        </tr>
                                        <?php if ($this->_tpl_vars['setting']['file_learning_catalog']): ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2">Download file : <a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/learning_catalog/<?php echo $this->_tpl_vars['setting']['file_learning_catalog']; ?>
" download><?php echo $this->_tpl_vars['setting']['file_learning_catalog']; ?>
</a></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td  width='25%'>Show Learning Catalog</td>
                                            <td width="1">:</td>
                                            <td  width='40%'>
                                                <input type='radio' name="show_learning_catalog" id="show_learning_catalog_1" value="1" <?php if ($this->_tpl_vars['setting']['show_learning_catalog'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type='radio' name="show_learning_catalog" id="show_learning_catalog_2" value="0" <?php if ($this->_tpl_vars['setting']['show_learning_catalog'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Show Learning Catalog</td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <fieldset>
                                    <legend>Questionaire</legend>
                                    <table class="table">
                                        <tr>
                                            <td  width='25%'>Anonim Report</td>
                                            <td width="1">:</td>
                                            <td  width='40%'>
                                                <input type='radio' name="questionaire_anonim_user" id="questionaire_anonim_user_1" value="1" <?php if ($this->_tpl_vars['setting']['questionaire_anonim_user'] == 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lyes']; ?>

                                                <input type='radio' name="questionaire_anonim_user" id="questionaire_anonim_user_2" value="0" <?php if ($this->_tpl_vars['setting']['questionaire_anonim_user'] != 1): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lno']; ?>

                                            </td>
                                            <td >Anonim Report</td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <div class="box">
                        <div class="box-footer">
                            <div class="btn-group pull-right">
                                <button name="reset" type="reset" class="btn btn-default">Reset</button>
                                <button name="submit" type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    </section>
    <!-- /.content -->
</div>

<iframe id="iframe_setting" name="iframe_setting" src=""
        style="display: none;width:1000px;height:1000px;border:0px solid #fff; "></iframe>

<script type="text/javascript">
    $(function () {
        $('.delete_approval').on('click', function (e) {
            e.preventDefault();
            var me = $(this).closest('.step_approval');
            me.remove();
            reposition();
        });

        $('.btn_in').on('click', function (e) {
            e.preventDefault();
            var me = $(this).closest('.step_approval');
            var el = me.find('.user_search option:selected');
            me.find('.user_approval_request_training').append(el);
        });

        $('.btn_out').on('click', function (e) {
            e.preventDefault();
            var me = $(this).closest('.step_approval');
            var el = me.find('.user_approval_request_training option:selected');
            me.find('.user_search').append(el);
        });

        $('.btn_search').on('click', function (e) {
            e.preventDefault();
            var me = $(this).closest('.step_approval');
            var extra_option = me.find('.extra_option').val() || '';
            var user_keyword = me.find('.user_keyword').val() || '';

            if (user_keyword == '' && extra_option == '') {
                me.find('.user_search').empty()
                return true;
            }

            $.ajax({
                url: '<?php echo $this->_tpl_vars['site_url']; ?>
/request/do_search_user',
                type: 'POST',
                data: {user_keyword: user_keyword, extra_option: extra_option},
                dataType: 'json',
                success: function (data) {
                    var tmp = '';
                    var detail = data.detail || {};
                    if (Object.keys(detail).length > 0) {
                        $.each(detail, function (idx, val) {
                            tmp += '<option value="' + val.id + '">';
                            tmp += val.label;
                            tmp += '</option>';
                        });
                    }
                    me.find('.user_search').empty().append(tmp);
                }
            });
        });

        $('#frmsetting').submit(function () {
            $('.user_approval_request_training option').attr('selected', true);
        });

        var info_no_urut = function () {
            var lgt = $('.step_approval').length || 1;
            return parseInt(lgt);
        };

        var reposition = function () {
            $('.step_approval').each(function (idx, val) {
                idx += 1;
                $(this).find('.no_urut').text(idx);
                $(this).find('.user_approval_request_training').attr('name', 'user_approval_request_training_' + idx + '[]');
            });
        };

        $('#add_step').click(function (e) {
            e.preventDefault();
            var no_urut = info_no_urut() + 1;
            var cln = $('.step_approval:eq(0)').clone();
            cln.find('.no_urut').text(no_urut);
            cln.find('.user_search').empty();
            cln.find('.user_approval_request_training').empty();
            cln.find('.user_approval_request_training').attr('name', 'user_approval_request_training_' + no_urut + '[]');
            cln.find('.user_keyword').val('');
            cln.find('.extra_option').val('');
            cln.find('.delete_approval').show();
            cln.insertBefore('#add_step');
        });

        $('.delete_approval:not(:eq(0))').show();
        reposition();
    });
</script>