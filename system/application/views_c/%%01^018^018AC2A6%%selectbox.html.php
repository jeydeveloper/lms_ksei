<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:39
         compiled from training/selectbox.html */ ?>
<select name="name" id="name" class="formdefault" onchange="javascript:training_onchange()">
	<option value="">--- <?php echo $this->_tpl_vars['lselect_training']; ?>
 ---</option>
	<?php $_from = $this->_tpl_vars['trainings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['training']):
?>
	<option value="<?php echo $this->_tpl_vars['training']->training_name; ?>
"<?php if ($this->_tpl_vars['def'] == $this->_tpl_vars['training']->training_name): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['training']->training_name; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
</select>