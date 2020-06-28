<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:40
         compiled from training/participant-search.html */ ?>
<script>
	function showcatjabatan(cat)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/catjabatan", {searchby: "category_name", keyword: cat, dialog: 1, limit: 0<?php if ($this->_tpl_vars['isresources']): ?>, reference:<?php echo $this->_tpl_vars['row']->reference_id; ?>
<?php else: ?>, training:<?php echo $this->_tpl_vars['training']->training_id; ?>
<?php endif; ?>},
			function (data)
			{			
				$("#dialogcontent").html(data);	
				$("#dialoguser").dialog('option', 'title', '<?php echo $this->_tpl_vars['lcatjabatan']; ?>
');
				$("#dialoguser").dialog("open");
				checkcatjaball();					
			}
		);	
	}
	
	function showjabatan(jabatan)
	{		
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/", {searchby: "jabatan_name", keyword: jabatan, dialog: 1, limit: 0<?php if ($this->_tpl_vars['isresources']): ?>, reference:<?php echo $this->_tpl_vars['row']->reference_id; ?>
<?php else: ?>, training:<?php echo $this->_tpl_vars['training']->training_id; ?>
<?php endif; ?>},
			function (data)
			{			
				$("#dialogcontent").html(data);	
				$("#dialoguser").dialog('option', 'title', '<?php echo $this->_tpl_vars['ljabatan']; ?>
');
				$("#dialoguser").dialog("open");
				jabatan_click(true);								
			}
		);		
	}
	
	function showgroups(level, keyword)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/group", {level: level, keyword: keyword, dialog: 1, limit: 0<?php if ($this->_tpl_vars['isresources']): ?>, reference:<?php echo $this->_tpl_vars['row']->reference_id; ?>
<?php else: ?>, training:<?php echo $this->_tpl_vars['training']->training_id; ?>
<?php endif; ?>},
			function (data)
			{			
				$("#dialogcontent").html(data);	
				$("#dialoguser").dialog('option', 'title', '<?php echo $this->_tpl_vars['lgroup_list']; ?>
');
				$("#dialoguser").dialog("open");
				group_click(true);
			}
		);		
	}
	
	function search()
	{
		var by = $("#searchby").val();
		var kw = $("#keyword").val();
		
		if (by == "catjabatan")
		{
			showcatjabatan(kw);
		}
		else
		if (by == "jabatan")
		{
			showjabatan(kw);
		}
		else
		{
			showgroups(by, kw);
		}
	}

	function catjaball_onclick(elmt)
	{
		$("INPUT[name='catjab[]']").attr("checked", elmt.checked);
	}
	
	function savecatjab()
	{	
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/<?php if ($this->_tpl_vars['isresources']): ?>addparticipantresourcesbycategoryjabatan<?php else: ?>addparticipanttrainingbycategoryjabatan<?php endif; ?>", $("#frmcatjab").serialize(),
			function(r)
			{
				$("#dialoguser").dialog("close");
				alert(r.message);
      				<?php if ($this->_tpl_vars['isresources']): ?>
      				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/resources/participant/<?php echo $this->_tpl_vars['row']->reference_id; ?>
";
      				<?php else: ?>
      				showSubContent();
      				<?php endif; ?> 				
			}
			, "json"
		);
	}
	
	function catjab_onclick(elmt)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/getallchild/"+elmt.value, {},
			function (r)
			{
				for(var i=0; i < r.childs.length; i++)
				{
					$("INPUT[name='catjab[]'][value='"+r.childs[i]+"']").attr("checked", elmt.checked);
				}
				
				if (! elmt.checked)
				{
					$("INPUT[name='catjaball']").attr("checked", false);	
				}
				else
				{
					checkcatjaball();
				}				
			}
			, "json"
		);		

	}
	
	function checkcatjaball()
	{
		for(var i=0; i < document.frmcatjab.elements.length; i++)
		{
			if (document.frmcatjab.elements[i].name == "catjab[]")
			{
				if (! document.frmcatjab.elements[i].checked)
				{
					$("INPUT[name='catjaball']").attr("checked", false);
					return;
				}
			}
		}
		
		$("INPUT[name='catjaball']").attr("checked", true);
	}

      	function jabatanall_onclick(elmt)
      	{
      		$("INPUT[name='jabatan[]']").attr("checked", elmt.checked);
      	}
      	
      	function groupall_onclick(elmt)
      	{
      		$("INPUT[name='group[]']").attr("checked", elmt.checked);
      	}
	
      	function jabatan_click(val)
      	{
      		if (val)
      		{
      			for(var i=0; i < document.frmjabatan.elements.length; i++)
      			{
      				if (document.frmjabatan.elements[i].name == "jabatan[]")
      				{
      					if (! document.frmjabatan.elements[i].checked)
      					{
      						$("INPUT[name='jabatanall']").attr("checked", false);
      						return;
      					}
      				}
      			}
      			
      			$("INPUT[name='jabatanall']").attr("checked", true);
      		}
      		else
      		{
      			$("INPUT[name='jabatanall']").attr("checked", false);
      		}
      	}
      	
      	function group_click(val)
      	{
      		if (val)
      		{
      			for(var i=0; i < document.frmgroup.elements.length; i++)
      			{
      				if (document.frmgroup.elements[i].name == "group[]")
      				{
      					if (! document.frmgroup.elements[i].checked)
      					{
      						$("INPUT[name='groupall']").attr("checked", false);
      						return;
      					}
      				}
      			}
      			
      			$("INPUT[name='groupall']").attr("checked", true);
      		}
      		else
      		{
      			$("INPUT[name='groupall']").attr("checked", false);
      		}
      	}
      	
      	
      	function addparticipantbyjabatan()
      	{
      		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/<?php if ($this->_tpl_vars['isresources']): ?>resources<?php else: ?>training<?php endif; ?>/addparticipantbyjabatan", $("#frmjabatan").serialize(),
      			function(data)
      			{
      				if (data.err > 0)
      				{
      					$("#messageaddparticipant").html(data.errmsg);
      					return;
      				}
      				
      				$("#dialoguser").dialog("close");
      				alert(data.message);
      				<?php if ($this->_tpl_vars['isresources']): ?>
      				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/resources/participant/<?php echo $this->_tpl_vars['row']->reference_id; ?>
";
      				<?php else: ?>
      				showSubContent();
      				<?php endif; ?>      				
      			}  
      			, "json"    			
      		);
      	}
      	
      	function addparticipantbygroup()
      	{
      		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/<?php if ($this->_tpl_vars['isresources']): ?>resources<?php else: ?>training<?php endif; ?>/addparticipantbygroup", $("#frmgroup").serialize(),
      			function(data)
      			{
      				if (data.err > 0)
      				{
      					$("#messageaddparticipant").html(data.errmsg);
      					return;
      				}
      				
      				$("#dialoguser").dialog("close");
      				alert(data.message);
      				<?php if ($this->_tpl_vars['isresources']): ?>
      				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/resources/participant/<?php echo $this->_tpl_vars['row']->reference_id; ?>
";
      				<?php else: ?>
      				showSubContent();
      				<?php endif; ?>      				
      			}  
      			, "json"    			
      		);
      	}      	
</script>
<table class="table" id="tbltrainingimport">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['lsearch_by']; ?>
</td>
		<td>
			<select name="searchby" id="searchby">
			      	<?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
			      	<option value="level<?php echo $this->_tpl_vars['level']->level_nth; ?>
"><?php echo $this->_tpl_vars['level']->level_name; ?>
</option>
			      	<?php endforeach; endif; unset($_from); ?>
			      	<option value="catjabatan"><?php echo $this->_tpl_vars['lcatjabatan']; ?>
</option>
			      	<option value="jabatan"><?php echo $this->_tpl_vars['ljabatan']; ?>
</option>
		      	</select> 
		      	<input type='text' name="keyword" id="keyword" class='formdefault' value="">		
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="button" value=" <?php echo $this->_tpl_vars['lsearch']; ?>
" onclick="javascript:search()" />
	</tr>	
</table>