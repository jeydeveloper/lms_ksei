<?php /* Smarty version 2.6.26, created on 2018-11-05 10:29:55
         compiled from errmessage.html */ ?>
<div class="flash error">
<?php $_from = $this->_tpl_vars['errs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?>
<font color='#ffffff'><?php echo $this->_tpl_vars['err']; ?>
</font>
<br />
<?php endforeach; endif; unset($_from); ?>
</div>