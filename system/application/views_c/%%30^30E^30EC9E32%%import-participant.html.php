<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:40
         compiled from training/import-participant.html */ ?>
<table class="table" id="tbltrainingimport">
	<tr>
		<td width="10%"><?php echo $this->_tpl_vars['limport_npk']; ?>
</td>
		<td><input type="file" name="filenpk" value="" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="Import" />
	</tr>
	<tr id="rowimportnpkmessage" style="display: none;">
		<td>&nbsp;</td>
		<td><div id="importnpkmessage"></div></td>
	</tr>	
</table>