<?php /* Smarty version 2.6.26, created on 2018-11-05 11:08:16
         compiled from topic/form.html */ ?>
<script>
    function frmcategory_onchange() {
        return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/save/<?php echo $this->_tpl_vars['edit']; ?>
", "frmcategory", "message", "Saving...",
            function (data) {
                $("#message").html("<?php echo $this->_tpl_vars['ok_save_category']; ?>
");
                setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/topic/category"', "<?php echo $this->_tpl_vars['flashtime']; ?>
")
                ;
            }
        );
    }

</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['ltitle_form']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Topic</a></li>
            <li class="active"><?php echo $this->_tpl_vars['ltitle_form']; ?>
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
                        <form class="form-horizontal" name="frmcategory" id="frmcategory"
                              onsubmit="javascript: return frmcategory_onchange()">
                            <input type='hidden' name="type" id="type" value="<?php echo $this->_tpl_vars['type']; ?>
">
                            <div class="box-body">
                                <?php if ($this->_tpl_vars['edit']): ?>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ID</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="<?php echo $this->_tpl_vars['catedit']['category_id']; ?>
" disabled="">
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="parent" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['lparent']; ?>
</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="parent" id="parent">
                                            <option value="0"><?php echo $this->_tpl_vars['lroot']; ?>
</option>
                                            <?php echo $this->_tpl_vars['tree']; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['category_name']; ?>
</label>

                                    <div class="col-sm-10">
                                        <input name="name" id="name" class="form-control"
                                               value="<?php echo $this->_tpl_vars['catedit']['category_name']; ?>
" placeholder="<?php echo $this->_tpl_vars['category_name']; ?>
">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['category_desc']; ?>
</label>

                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="desc" id="desc"><?php echo $this->_tpl_vars['catedit']['category_desc']; ?>
</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-sm-2 control-label"><?php echo $this->_tpl_vars['status']; ?>
</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" <?php if ($this->_tpl_vars['catedit']['category_status'] == 1): ?>selected<?php endif; ?>>
                                            <?php echo $this->_tpl_vars['active']; ?>

                                            </option>
                                            <option value="2" <?php if ($this->_tpl_vars['catedit']['category_status'] == 2): ?>selected<?php endif; ?>>
                                            <?php echo $this->_tpl_vars['inactive']; ?>

                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="btn-group pull-right">
                                    <button name="reset" type="reset" class="btn btn-default">Reset</button>
                                    <button name="submit" type="submit" class="btn btn-info">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
    </section>
    <!-- /.content -->
</div>