<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:40
         compiled from training/selecttrainingperiode.html */ ?>
<select name="training_periode" id="training_periode" class="formdefault">
	<option value="">--- Periode List ---</option>
	<?php $_from = $this->_tpl_vars['trainingperiodes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['trainingperiode']):
?>
	<option value="<?php echo $this->_tpl_vars['trainingperiode']->training_time_id; ?>
" <?php if ($this->_tpl_vars['training_npk_time_id'] == $this->_tpl_vars['trainingperiode']->training_time_id): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['trainingperiode']->date_1; ?>
 s/d <?php echo $this->_tpl_vars['trainingperiode']->date_2; ?>
</option>
	<?php endforeach; endif; unset($_from); ?>
</select>