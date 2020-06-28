<?php /* Smarty version 2.6.26, created on 2020-05-04 09:33:52
         compiled from classroom/menu.html */ ?>
<ul class="treeview-menu">
    <li class="<?php if ($this->_tpl_vars['page'] == 'classroom' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'historynpk' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'form' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/showlist"><i class="fa fa-tasks"></i> <span><?php echo $this->_tpl_vars['llist']; ?>
</span></a>
    </li>
    <li class="<?php if ($this->_tpl_vars['page'] == 'classroom' && $this->_tpl_vars['subpage'] == 'import'): ?>
    active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/import"><i class="fa fa-upload"></i> <span><?php echo $this->_tpl_vars['limport']; ?>
</span></a></li>
</ul>