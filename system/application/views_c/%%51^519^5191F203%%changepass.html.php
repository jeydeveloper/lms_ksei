<?php /* Smarty version 2.6.26, created on 2018-12-12 13:35:58
         compiled from user/changepass.html */ ?>
<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete3/easy-autocomplete.min.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete3/jquery.easy-autocomplete.min.js"></script>
<script>
    <?php if ($this->_tpl_vars['reset']): ?>
    function frmchangepass_onchange()
    {
        return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/user/doresetpass/<?php echo $this->_tpl_vars['user']->user_forgotpass_confirm; ?>
", "frmchangepass", "message", "Submitting...",
            function(data)
            {
                $("#message").html("<?php echo $this->_tpl_vars['ok_change_pass']; ?>
");
                <?php if ($this->_tpl_vars['reset']): ?>
                location = "<?php echo $this->_tpl_vars['base_url']; ?>
"
                <?php else: ?>
                document.frmchangepass.reset();
                <?php endif; ?>
                }
            );
    }
    <?php else: ?>
    function frmchangepass_onchange()
    {
        return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/user/dochangepass/", "frmchangepass", "message", "Submitting...",
            function(data)
            {
                $("#message").html("<?php echo $this->_tpl_vars['ok_change_pass']; ?>
");
                document.frmchangepass.reset();
            }
        );
    }
    <?php endif; ?>

        <?php if ($this->_tpl_vars['admin']): ?>
        $(document).ready(function(){
            /*$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/getnpk", {},
                function (data)
                {
                    var datas = data.split("\1");
                    $("#npk").autocomplete(datas,
                        {
                            autoFill: true
                        }
                    );
                }
            );*/
            var options = {

                url: function(phrase) {
                    return "<?php echo $this->_tpl_vars['site_url']; ?>
/user/getnpk";
                },

                getValue: function(element) {
                    return element.name;
                },

                ajaxSettings: {
                    dataType: "json",
                    method: "POST",
                    data: {}
                },

                preparePostData: function(data) {
                    data.phrase = $("#example-ajax-post").val();
                    return data;
                },

                requestDelay: 200
            };

            $("#npk").easyAutocomplete(options);
        });
        <?php endif; ?>
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['change_pass']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User</a></li>
            <li class="active"><?php echo $this->_tpl_vars['change_pass']; ?>
</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
                    <div id="message"></div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <form name="frmchangepass" id="frmchangepass"
                              onsubmit="javascript: return frmchangepass_onchange()" class="form-horizontal">
                            <?php if ($this->_tpl_vars['admin']): ?>
                            <input type="hidden" name="isadmin" value="<?php echo $this->_tpl_vars['admin']; ?>
"/>
                            <?php endif; ?>
                            <div class="box-body">
                                <?php if ($this->_tpl_vars['admin']): ?>
                                <div class="form-group">
                                    <label for="npk" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['lnpk']; ?>
</label>

                                    <div class="col-sm-10">
                                        <input name="npk" id="npk" class="form-control" placeholder="<?php echo $this->_tpl_vars['lnpk']; ?>
">
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if (! $this->_tpl_vars['reset'] && ! $this->_tpl_vars['admin']): ?>
                                <div class="form-group">
                                    <label for="oldpass" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['old_password']; ?>
</label>

                                    <div class="col-sm-10">
                                        <input type='password' name="oldpass" id="oldpass" class="form-control"
                                               placeholder="<?php echo $this->_tpl_vars['old_password']; ?>
">
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="newpass" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['new_password']; ?>
</label>

                                    <div class="col-sm-10">
                                        <input type='password' name="newpass" id="newpass" class="form-control"
                                               placeholder="<?php echo $this->_tpl_vars['new_password']; ?>
">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cnewpass" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['confirm_new_password']; ?>
</label>

                                    <div class="col-sm-10">
                                        <input type='password' name="cnewpass" id="cnewpass" class="form-control"
                                               placeholder="<?php echo $this->_tpl_vars['confirm_new_password']; ?>
">
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button name="submit" type="submit" class="btn btn-info pull-right">Sign in</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>