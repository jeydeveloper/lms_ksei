<?php /* Smarty version 2.6.26, created on 2020-05-04 08:37:24
         compiled from level/import.html */ ?>
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
		$("#messageimportorg").html("");
		$("#messageimportgroup").html("");
		$("#messageimportjabatan").html("");	
		$("#messageimportlokasi").html("");		
	
		$("#"+id).html(msg);
	}	
</script>


<iframe id="iframe_import" name="iframe_import" src="" style="width:0px;height:0px;border:1px solid #000000;"></iframe>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
            <h1>Import Data</h1>
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
                    <!--<div id="message"></div>-->
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/saveorg" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportorg')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_org']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="20%"><?php echo $this->_tpl_vars['lorg_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportorg"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savegroup" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportgroup')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_hirarchy_group']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="20%"><?php echo $this->_tpl_vars['lhirarchy_group_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportgroup"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savejabatan" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportjabatan')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_jabatan']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="20%"><?php echo $this->_tpl_vars['ljabatan_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportjabatan"></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                        <form action="<?php echo $this->_tpl_vars['site_url']; ?>
/import/savelokasi" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimportlokasi')" target="iframe_import">
                            <h3><?php echo $this->_tpl_vars['limport_lokasi']; ?>
</h3>
                            <br />
                            <table class="table">
                                <tbody>
                                <tr class="odd">
                                    <td class="odd" width="20%"><?php echo $this->_tpl_vars['llokasi_file']; ?>
</td>
                                    <td class="odd"><input type="file" name="userfile" value="" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><input type="submit" value="Import" /> </td>
                                </tr>
                                <tr class="odd">
                                    <td class="odd">&nbsp;</td>
                                    <td class="odd"><div id="messageimportlokasi"></div></td>
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