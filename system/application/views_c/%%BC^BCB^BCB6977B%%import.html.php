<?php /* Smarty version 2.6.26, created on 2019-01-16 21:24:47
         compiled from user/import.html */ ?>
<script>
	function import_onsubmit(id)
	{
		$("#"+id).html("importing...");
		
		return true;
	}
	
	function setErrorMessage(id, err)
	{
		$("#" + id).html(err);		
	}
	
	function setSuccess(id, msg)
	{
		$("#messageimportnew").html("");
		$("#messageimportold").html("");
	
		$("#"+id).html(msg);
	}	
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            &nbsp;
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Training</a></li>
            <li class="active">Exam Intro</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/user/saveimport" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportnew')" target="iframe_import">
                            <?php if ($this->_tpl_vars['show_old_import']): ?>
                            <h3><?php echo $this->_tpl_vars['limport_user_new_sap']; ?>
</h3>
                            <?php else: ?>
                            <h3><?php echo $this->_tpl_vars['limport_user']; ?>
</h3>
                            <?php endif; ?>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="15%"><?php echo $this->_tpl_vars['luser_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd">(Download format import excel di sini : <a href="<?php echo $this->_tpl_vars['base_url']; ?>
import/user/user.formatted.v2.xls">sample_new.xls</a>)</td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportnew"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <?php if ($this->_tpl_vars['show_old_import']): ?>
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/user/saveimportold" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportold')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_user_old_system']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="15%"><?php echo $this->_tpl_vars['luser_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd">(Download format import excel di sini : <a href="<?php echo $this->_tpl_vars['base_url']; ?>
import/user/User.xls">sample_old.xls</a>)</td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportold"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <?php endif; ?>
                        <iframe id="iframe_import" name="iframe_import" src="" style="width:0px;height:0px;border:1px solid #000000;display: none;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>