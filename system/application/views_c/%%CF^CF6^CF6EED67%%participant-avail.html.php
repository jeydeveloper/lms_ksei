<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:40
         compiled from training/participant-avail.html */ ?>
<script>
	$(document).ready(
		function()
		{
			$("#own_paging a").each(
				function()
				{
					$(this).click(
						function(e)
						{
							e.preventDefault();
							var ref = $(this).attr("href");
							$.post(ref, {}, 
								function(r)
								{
									$("#availparticipant").html(r);
									$("#training_periode").attr("disabled", true);
								}
							);
							//return false;
						}
					);
				}
			);
			
			$("#checkallavail").click(
				function()
				{
					$("input[id=checkavail]").attr("checked", $(this).attr("checked"));					
				}
			);


	$("input[name='checkavail[]']").click(function(e) {
	if ($(e.target).attr('checked')) {
              	    
	} else {
	   $("#checkallavail").attr('checked', false);
	}
	});

	                
			
			$("#btnsaveavail").click(
				function()
				{
					$("#training_periode").removeAttr("disabled");
					var training_periode = $('#training_periode').val() || 0;
					$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/updateavailparticipant/<?php echo $this->_tpl_vars['trainingid']; ?>
/"+training_periode, $("#frmtraining").serialize(), 
						function(r)
						{    
							var t=setTimeout("refresh()",500);
						}
						
					)
				}
			);

			$("#btnremoveall").click(
					function()
					{
						if (confirm('<?php echo $this->_tpl_vars['lremove_confirmation']; ?>
')){
							$("#training_periode").removeAttr("disabled");
							var training_periode = $('#training_periode').val() || 0;
							$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/removeallavailparticipant/<?php echo $this->_tpl_vars['trainingid']; ?>
/"+training_periode, $("#frmtraining").serialize(), 
								function(r)
								{
									var t=setTimeout("refresh()",500);
								}
							)
						}
					}
			);			
			
		}
	);
	
</script>
<table class="table" id="tbltrainingimport">
	<tr>
		<td><?php echo $this->_tpl_vars['lavailable_participant']; ?>
</td>
	</tr>
	<tr>
		<td>
			<table class="table" id="tbltrainingimport">
				<tr style="background: #eeeeee;">
					<th width="3%"><input type="checkbox" id="checkallavail" name="checkallavail" value="1" checked/></th>
					<th width="9%"><?php echo $this->_tpl_vars['lnpk']; ?>
</th>
					<th><?php echo $this->_tpl_vars['lname']; ?>
</th>
				</tr>
				<?php $_from = $this->_tpl_vars['npks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['npk']):
?>
				<tr>
					<td><input type="checkbox" name="checkavail[]" class="checkavail" value="<?php echo $this->_tpl_vars['npk']->user_id; ?>
" checked /></td>
					<td><?php echo $this->_tpl_vars['npk']->user_npk; ?>
</td>
					<td><?php echo $this->_tpl_vars['npk']->user_first_name; ?>
 <?php echo $this->_tpl_vars['npk']->user_last_name; ?>
</td>
				</tr>
				<input type="hidden" name="hidecheckavail[]" value="<?php echo $this->_tpl_vars['npk']->user_id; ?>
" />
				<?php endforeach; endif; unset($_from); ?>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<div id="own_paging">
				<?php echo $this->_tpl_vars['paging']; ?>

			</div>
		</td>	
	</tr>
	<?php if ($this->_tpl_vars['npks']): ?>
	<tr>
		<td><input type="button" id="btnsaveavail" value=" <?php echo $this->_tpl_vars['lsave']; ?>
 " /> <input type="button" id="btnremoveall" value=" <?php echo $this->_tpl_vars['lremove_all']; ?>
 " /></td>
	</tr>
	<?php endif; ?>
</table>