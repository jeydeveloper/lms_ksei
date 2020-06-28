<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:39
         compiled from training/edit.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/tiny_mce/tiny_mce.js"></script>
<script>
	function form1()
	{
		document.frmtraining.action = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/form";
		document.frmtraining.submit();
	}
	
	function showfunctions(id)
	{
		showhide("#div_func" + id);
	}
		
	$(document).ready(
		function()
		{		
			changeParticipant();
			category_onchange('<?php echo $this->_tpl_vars['training_name']; ?>
');
		}	
	);
	
	function category_onchange(trndef)
	{
		var parent;
		
		if (! trndef)
		{
			trndef = "";
		}
		
		<?php if ($this->_tpl_vars['topicid']): ?>
		parent = <?php echo $this->_tpl_vars['topicid']; ?>
;
		<?php else: ?>
		parent = $("#topic").val();
		<?php endif; ?>
		
		if (! parent) parent = 0;
		
		$("#topic_div").html("Loading...");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/getparent", {cat: $("#cat").val(), isshowroot: 'no', selectname: 'topic', onchange: 'topic_onchange()', parent: parent, disabled: <?php if ($this->_tpl_vars['training_name']): ?>1<?php else: ?>0<?php endif; ?>},
			function(data)
			{
				$("#topic_div").html(data);
				var t = $("#topic").val();
				if (t)
				{					
					loadtraining($("#cat").val(), t, trndef);
				}
				else
				{				
					loadtraining($("#cat").val(), 0, trndef);
				}				
			}
		);
	}
	
	function topic_onchange()
	{
		loadtraining(0, $("#topic").val());
	}
	
	function loadtraining(category, topic, trndef)
	{
		if (! topic) return;
		
		if (! trndef) trndef = "";
	
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/getselectbox", {category: category, topic: topic<?php if ($this->_tpl_vars['pageid']): ?>, pageid: '<?php echo $this->_tpl_vars['pageid']; ?>
'<?php endif; ?>, checkcreator: 1, def: trndef<?php if ($this->_tpl_vars['material']): ?>, ismaterial: 1 <?php endif; ?>},
			function(data)
			{
				$("#trainingselectbox").html(data);
				<?php if ($this->_tpl_vars['training_name']): ?>
					$("#name").attr("disabled", true);
					//showSubContent();
				<?php endif; ?>
				training_onchange();
			}
		);
	}

	function training_onchange() {
		var topic_id = $("#topic").val();
		var training_name = $("#name").val();

		var training_npk_time_id = <?php if ($this->_tpl_vars['training_npk_time_id']): ?><?php echo $this->_tpl_vars['training_npk_time_id']; ?>
<?php else: ?>0<?php endif; ?> ;
		
		//$("#trainingperiode").html("Loading...");

		$("#training_periode").removeAttr("disabled");

		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/getperiode", {topic_id: topic_id, training_name: training_name, training_npk_time_id: training_npk_time_id},
			function(data)
			{
				$("#trainingperiode").html(data);
				<?php if (( $this->_tpl_vars['training_npk_time_id'] || $this->_tpl_vars['trainingid'] || $this->_tpl_vars['training_delegationx'] )): ?>
					showSubContent();
					$("#training_periode").attr("disabled", true);
				<?php endif; ?>
			}
		);
	}
	
	function showSubContent(showtype)
	{
		$("#subcontent").html("loading...");		
		
		$("#dvwait").show();
		$("#showsubcontentbutton").hide();

		$("#training_periode").removeAttr("disabled");
		$("#name").removeAttr("disabled");
		$("#topic").removeAttr("disabled");

		$.post("<?php echo $this->_tpl_vars['url']; ?>
", $("#frmtraining").serialize(),
			function(data)
			{				
				$("#dvwait").hide();
				$("#showsubcontentbutton").show();
				$("#subcontent").html(data);

				//$("#cat").attr("disabled", true);
				//$("#topic").attr("disabled", true);
				//$("#name").attr("disabled", true);
				//$("#training_periode").attr("disabled", true);				
				//$("#showsubcontentbutton").attr("disabled", true);
				
				if (showtype == "participant")
				{	
					$("#showreloadbutton").show();
				}
			}
		);
	}
	
	function changeParticipant()
	{
		$("#cat").removeAttr("disabled");   
		$("#topic").removeAttr("disabled");   
		$("#name").removeAttr("disabled");
		$("#training_periode").removeAttr("disabled");
		$("#showsubcontentbutton").removeAttr("disabled");		
		$("#subcontent").html("");
		
		$("#showreloadbutton").hide();
	}
</script>	
	<script>
		function setupEditor() 
		{
			tinyMCE.init(
				{
					mode : "textareas",
					theme : "advanced",
					plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
					theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
					theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
					//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
					//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
					theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
					theme_advanced_resizing : true
				}
			);		
		}
		
		function toggleEditor(id) 
		{			
			if (! tinyMCE.getInstanceById(id))
			{
				alert("ka");
				tinyMCE.execCommand('mceAddControl', false, id);
			}
			else
			{
				tinyMCE.execCommand('mceRemoveControl', false, id);
			}
		}
		
	<?php if ($this->_tpl_vars['material']): ?>
		function frmtraining_onsubmit()
		{
			$("#importmessage").html("importing...");
			return true;
		}
		
		function setErrorMessage(err)
		{
			$("#importmessage").html(err);
		}
		
		function setSuccess(msg, loc)
		{
			$("#importmessage").html(msg);
			//setTimeout('location = "' + loc + '"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
		}		
	<?php endif; ?>
	</script>

<?php if ($this->_tpl_vars['material']): ?>
<iframe id="iframe_training" name="iframe_training" src="" style="width:0px;height:0px;border:1px solid #000000;"></iframe>
<?php endif; ?>

<!--<div id="dialoguser" title="<?php echo $this->_tpl_vars['lnpk']; ?>
(s)" style="display: none;">
	<div id="dialogcontent"></div>
</div>-->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $this->_tpl_vars['ledit_header']; ?>

		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Training</a></li>
			<li class="active">Peserta</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<!--<div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
					<div id="message"></div>
				</div>-->

				<form name="frmtraining" id="frmtraining" method="post" onsubmit="javascript: return frmtraining_onsubmit()"<?php if ($this->_tpl_vars['material']): ?> action="<?php echo $this->_tpl_vars['site_url']; ?>
/training/importmaterial" target="iframe_training"<?php endif; ?> enctype="multipart/form-data">
				<?php if ($this->_tpl_vars['training_name']): ?>
				<input type='hidden' name="_cat" id="_cat" value="<?php echo $this->_tpl_vars['category_name']; ?>
">
				<input type='hidden' name="_topic" id="_topic" value="<?php echo $this->_tpl_vars['topicid']; ?>
">
				<input type='hidden' name="_name" id="_name" value="<?php echo $this->_tpl_vars['training_name']; ?>
">
				<?php endif; ?>
				<div class="box">
					<div class="box-body table-responsive no-padding">
						<div class="box-body">
				<table id="tbltrainingtime" class="table">
					<tr>
						<td width="15%"><?php echo $this->_tpl_vars['category']; ?>
</td>
						<td>
							<select name="cat" id="cat" style="width: 320px;" onchange="javascript: category_onchange()"<?php if ($this->_tpl_vars['training_name']): ?>disabled<?php endif; ?>>
							<?php echo $this->_tpl_vars['tree']; ?>

							</select>
						</td>
					</tr>
					<tr>
						<td><?php echo $this->_tpl_vars['topic']; ?>
</td>
						<td>
				<span id="topic_div">
					<select name="topic" id="topic" onchange="javascript:topic_onchange()"<?php if ($this->_tpl_vars['training_name']): ?>disabled<?php endif; ?>>
						<option value="0">-- <?php echo $this->_tpl_vars['topic']; ?>
 --</option>
					</select>
				</span>
						</td>
					</tr>
					<tr>
						<td><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate_name']; ?>
<?php endif; ?></td>
						<td>
							<div id="trainingselectbox">
								<select name="name" id="name" class="formdefault" onchange="javascript:training_onchange()"<?php if ($this->_tpl_vars['training_name']): ?>disabled<?php endif; ?>>
								<option value="">--- <?php echo $this->_tpl_vars['lselect_training']; ?>
 ---</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td>Periode</td>
						<td>
				<span id="trainingperiode">
					<select name="training_periode" id="training_periode" class="formdefault">
						<option value="0">--- Periode List ---</option>
					</select>
				</span>
						</td>
					</tr>
					<?php if (! $this->_tpl_vars['training_name']): ?>

					<?php if ($this->_tpl_vars['setting']): ?>
					<tr>
						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Setting "  onclick="javascript:showSubContent()"/></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['participant']): ?>
					<tr>
						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Participant "  onclick="javascript:showSubContent('participant')"/>
							<input id="showreloadbutton" type="button" value=" Change Training "  onclick="javascript:changeParticipant()" style="display: none;" /></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['prequisite']): ?>
					<tr>

						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Prequisite "  onclick="javascript:showSubContent()"/></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['postrequisite']): ?>
					<tr>
						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Postrequisite "  onclick="javascript:showSubContent()"/></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['praexam']): ?>
					<tr>
						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Pra Exam / Exam "  onclick="javascript:showSubContent()"/></td>
					</tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['material']): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['lmaterial_file']; ?>
</td>
						<td><input type="file" name="materionline" value="" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><div id="importmessage"></div><input type="submit" value=" Import Material " /></td>
					</tr>
					<?php endif; ?>

					<?php if ($this->_tpl_vars['delegetion']): ?>
					<tr>
						<td>&nbsp;</td>
						<td><div id="dvwait" style="display: none;"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/anim_wait.gif" /></div><input id="showsubcontentbutton" type="button" value=" Show Delegetion "  onclick="javascript:showSubContent()"/></td>
					</tr>
					<?php endif; ?>

					<?php endif; ?>
					<tr>
						<td colspan="2"><div id="subcontent"></div></td>
					</tr>
				</table>
						</div>
					</div>
				</div>
				</form>
			</div>
	</section>
	<!-- /.content -->
</div>