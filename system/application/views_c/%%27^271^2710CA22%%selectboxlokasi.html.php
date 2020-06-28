<?php /* Smarty version 2.6.26, created on 2019-02-11 12:09:15
         compiled from user/selectboxlokasi.html */ ?>
        	<select name="location" id="location" class='formdefault'>
        		<option value="">--- <?php echo $this->_tpl_vars['location']; ?>
 ---</option>
        		<?php $_from = $this->_tpl_vars['lokasies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lokasi']):
?>
        		<option value="<?php echo $this->_tpl_vars['lokasi']->lokasi_id; ?>
"<?php if ($this->_tpl_vars['def'] == $this->_tpl_vars['lokasi']->lokasi_id): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lokasi']->lokasi_alamat; ?>
</option>
        		<?php endforeach; endif; unset($_from); ?>
        	</select>        	