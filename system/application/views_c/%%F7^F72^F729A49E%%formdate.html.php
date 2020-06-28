<?php /* Smarty version 2.6.26, created on 2018-11-05 10:31:28
         compiled from training/formdate.html */ ?>
			<td valign="top"><?php echo $this->_tpl_vars['ldate']; ?>
</td>
			<td>
				<table>
					<tr>
						<td>
							<input type='text' name="trainingdate<?php echo $this->_tpl_vars['lastid']; ?>
_1" id="trainingdate<?php echo $this->_tpl_vars['lastid']; ?>
_1"   class="formshort date-pick" value="<?php echo $_POST['trainingdate1']; ?>
"  maxlength='10'>
						</td>
						<td>
							<?php echo $this->_tpl_vars['luntil']; ?>

						</td>
						<td>
							<input type='text' name="trainingdate<?php echo $this->_tpl_vars['lastid']; ?>
_2" id="trainingdate<?php echo $this->_tpl_vars['lastid']; ?>
_2"  class="formshort date-pick" value="<?php echo $_POST['trainingdate2']; ?>
" maxlength='10'> 
						</td>
						<td>
							<?php if ($this->_tpl_vars['lastid']): ?><input type="checkbox" name="trainingrefresment<?php echo $this->_tpl_vars['lastid']; ?>
" id="trainingrefresment<?php echo $this->_tpl_vars['lastid']; ?>
" value="1"<?php if ($_POST['parentid']): ?> checked<?php endif; ?> /> <?php echo $this->_tpl_vars['lrefreshment']; ?>
<?php else: ?>&nbsp;<?php endif; ?>
						</td>
				<input type="hidden" name="period[]" value="0" />
					</tr>				
				</table>
			</td>