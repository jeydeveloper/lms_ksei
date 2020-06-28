<?php /* Smarty version 2.6.26, created on 2020-05-30 17:06:23
         compiled from banksoal/unitsoal/dlgsoal1.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'banksoal/unitsoal/dlgsoal1.html', 49, false),)), $this); ?>
<script>
	function setErrorMessage(err)
	{
		$("#messageunitsoalquest").html(err);
		
	}
	
	function setSuccess(msg)
	{
		$("#messageunitsoalquest").html(msg);
		setTimeout("tutup()", 1000);
	}
	
	function tutup()
	{		
		<?php if (! $_POST['istraining']): ?>
			loadunitsoaldetailquest($("#jabatan").val(), $("#unitid").val(), true);
		<?php else: ?>
			onload(true);			
		<?php endif; ?>		
	}
	
</script>

<style>
	input[type="radio"] {
		margin-right: 10px;
	}
	input[type="text"] {
		width: 80%;
	}
</style>
<form id="frmdlgsoal" action="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/savesoal/<?php echo $this->_tpl_vars['rows'][0]->banksoal_question_id; ?>
" method="post" target="savesoalframe">
	<input type="hidden" name="istraining" id="unitid" value="<?php echo $_POST['istraining']; ?>
" />
	<input type="hidden" name="unitid" id="unitid" value="<?php echo $_POST['unitid']; ?>
" />
	<input type="hidden" name="jabatanid" id="jabatanid" value="<?php echo $_POST['jabatan']; ?>
" />
	<input type="hidden" name="banksoalid" id="banksoalid" value="<?php echo $_POST['banksoalid']; ?>
" />
	<table class="table">
		<tr>
			<td width="20%"><?php echo $this->_tpl_vars['lquestion']; ?>
</td>
			<td><input type='text' name="inpertanyaan" id="inpertanyaan" class='formdefault' value="<?php echo $this->_tpl_vars['rows'][0]->banksoal_question_quest; ?>
"></td>
		</tr>
		<?php if (! $_POST['istraining']): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lpacket']; ?>
</td>
			<td align='left'><input type='text' name="inpacket" id="inpacket" class='formnumber' value="<?php echo $this->_tpl_vars['rows'][0]->banksoal_question_packet; ?>
"></td>
		</tr>
		<?php endif; ?>
		<?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

		<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
		<tr>
			<td align="right"><input type="radio" name="injawaban" id="injawaban" value="<?php echo $this->_tpl_vars['row']->banksoal_answer_id; ?>
"<?php if ($this->_tpl_vars['rows'][0]->banksoal_question_answer == $this->_tpl_vars['row']->banksoal_answer_id): ?> checked<?php endif; ?> /> <?php echo $this->_tpl_vars['row']->code; ?>
</td>			
			<td><input type='text' name="inpilihan[]" id="inpilihan[]" class='formdefault' value="<?php echo $this->_tpl_vars['row']->banksoal_answer_text; ?>
"></td>
		</tr>		
		<?php echo smarty_function_counter(array(), $this);?>

		<?php endforeach; endif; unset($_from); ?>		
		
		<?php if (! $_POST['istraining']): ?>
		 <tr>
			<td><?php echo $this->_tpl_vars['lbobot']; ?>
</td>
			<td align='left'>
				<select name="inbobot" id="inbobot">
					<option value="Mudah"<?php if ($this->_tpl_vars['rows'][0]->banksoal_question_bobot == 'Mudah'): ?> selected<?php endif; ?> ><?php echo $this->_tpl_vars['lmudah']; ?>
</option>
					<option value="Sedang"<?php if ($this->_tpl_vars['rows'][0]->banksoal_question_bobot == 'Sedang'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lsedang']; ?>
</option>
					<option value="Sulit"<?php if ($this->_tpl_vars['rows'][0]->banksoal_question_bobot == 'Sulit'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lsulit']; ?>
</option>
				</select>
			</td>
		</tr>
		<?php endif; ?>
		<tfoot>		
		<tr>
			<td colspan="2"><div id="messageunitsoalquest"></div><input type="submit" value=" Save " /></td>
		</tr>
		</tfoot>
	</table>
</form>
<iframe id="savesoalframe" name="savesoalframe" src="" style="width:0px;height:0px;border:0px solid #fff;"></iframe>