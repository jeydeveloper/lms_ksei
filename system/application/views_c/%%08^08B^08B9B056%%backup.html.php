<?php /* Smarty version 2.6.26, created on 2020-05-04 08:40:00
         compiled from generalsetting/backup.html */ ?>
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
		$("#messageimportdump").html("");
	
		$("#"+id).html(msg);
	}	
</script>

<iframe id="iframe_import" name="iframe_import" src="" style="width:0px;height:0px;border:1px solid #000000;"></iframe>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Export Import Data</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Level</a></li>
            <li class="active">Showlist</li>
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
                    <div class="box-body table-responsive">
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/exportalldata" method="post">
                            <h3><?php echo $this->_tpl_vars['lexport_all_data']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="<?php echo $this->_tpl_vars['lexport_all_data']; ?>
" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportorg"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>

                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/importalldata" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportdump')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_alldata']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="20%"><?php echo $this->_tpl_vars['ldump_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportdump"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>