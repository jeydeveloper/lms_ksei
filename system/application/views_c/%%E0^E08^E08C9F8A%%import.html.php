<?php /* Smarty version 2.6.26, created on 2020-05-04 09:34:02
         compiled from classroom/import.html */ ?>
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
		$("#messageimport").html("");	
		$("#"+id).html(msg);
	}	
	
	function category_onchange()
	{
		$("#topic_div").html("Loading...");
		
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/getparent", {cat: $("#cat").val(), isshowroot: 'no', selectname: 'topic', parent: '<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_topic; ?>
<?php else: ?><?php echo $_POST['topic']; ?>
<?php endif; ?>'},
			function (data)
			{
				$("#topic_div").html(data);								
			}
		);
	}	
	
	$(document).ready(
		function()
		{	
			category_onchange();
		}
	);
</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $this->_tpl_vars['limport_classroom']; ?>

		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li>Classroom</li>
			<li class="active">Import</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<form action="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/saveimport" method="post" enctype="multipart/form-data" onsubmit="javascript: return import_onsubmit('messageimport')" target="iframe_import">
					<div class="box">
						<div class="box-body table-responsive no-padding">
							<div class="box-body">
								<table class="table">
									<tbody>
									<tr>
										<td>* <?php echo $this->_tpl_vars['lcategory_name']; ?>
</td>
										<td>
											<select name="cat" id="cat" style="width: 320px;" onchange="javascript: category_onchange()">
												<?php echo $this->_tpl_vars['tree']; ?>

											</select>
										</td>
									</tr>
									<tr>
										<td>* <?php echo $this->_tpl_vars['ltopic_code']; ?>
</td>
										<td>
			<span id="topic_div">
				<select name="topic" id="topic" style="width: 320px;">
					<option value="0">-- <?php echo $this->_tpl_vars['topic']; ?>
 --</option>
				</select>
			</span>
										</td>
									</tr>
									<tr class="odd">
										<td class="odd" width="15%"><?php echo $this->_tpl_vars['lclassroom_file']; ?>
</td>
										<td class="odd"><input type="file" name="userfile" value="" /> <br/> <a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/format_import_classroom.xls" target="_blank">(Download format import classroom)</a> </td>
									</tr>
									<tr class="odd">
										<td class="odd">&nbsp;</td>
										<td class="odd"><input type="submit" value="Import" /> </td>
									</tr>
									<tr class="odd">
										<td class="odd">&nbsp;</td>
										<td class="odd"><div id="messageimport"></div></td>
									</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>

<iframe id="iframe_import" name="iframe_import" src="" style="display:none;width:500px;height:500px;border:1px solid #000000;"></iframe>