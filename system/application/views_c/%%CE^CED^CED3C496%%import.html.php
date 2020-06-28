<?php /* Smarty version 2.6.26, created on 2019-07-04 09:45:25
         compiled from topic/import.html */ ?>
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
		$("#messageimportcat").html("");
		$("#messageimporttraining").html("");
		$("#messageimportexam").html("");		
	
		$("#"+id).html(msg);
	}	
</script>

<style>
    .box-body h2{margin: 0;}
    .table{margin-bottom: 0;}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Import Data
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['lcreate_course']; ?>
<?php elseif ($this->_tpl_vars['pageid'] == 'certificate'): ?><?php echo $this->_tpl_vars['lcreate_certificate']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lclassroom_update']; ?>
<?php endif; ?></a></li>
            <li class="active">Form</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <div class="box-body">
                            <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savecategory" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportcat')" target="iframe_import">
                                <h2><?php echo $this->_tpl_vars['limport_category_topic']; ?>
</h2>
                                <br />
                                <table class="table">
                                    <tbody>
                                    <tr class="odd">
                                        <td class="odd" width="15%"><?php echo $this->_tpl_vars['lcategory_topic_file']; ?>
</td>
                                        <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><input type="submit" value="Import" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><div id="messageimportcat"></div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="box-body">
                            <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savetraining" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimporttraining')" target="iframe_import">
                                <h2><?php echo $this->_tpl_vars['limport_training']; ?>
</h2>
                                <br />
                                <table class="table">
                                    <tbody>
                                    <tr class="odd">
                                        <td class="odd" width="15%"><?php echo $this->_tpl_vars['ltraining_file']; ?>
</td>
                                        <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><input type="submit" value="Import" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><div id="messageimporttraining"></div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="box-body">
                            <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savehistoryexam" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportexam')" target="iframe_import">
                                <h2><?php echo $this->_tpl_vars['limport_historyexam']; ?>
</h2>
                                <br />
                                <table class="table">
                                    <tbody>
                                    <tr class="odd">
                                        <td class="odd" width="15%"><?php echo $this->_tpl_vars['lhistoryexam_file']; ?>
</td>
                                        <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><input type="submit" value="Import" /> </td>
                                    </tr>
                                    <tr class="odd">
                                        <td class="odd">&nbsp;</td>
                                        <td class="odd"><div id="messageimportexam"></div></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<iframe id="iframe_import" name="iframe_import" src="" style="width:0px;height:0px;border:1px solid #000000;display: none;"></iframe>