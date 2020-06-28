<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:38
         compiled from user/menu_admin.html */ ?>
<aside class="main-sidebar" style="background-color: #243d56;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'level' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/"><i class="fa fa-building-o"></i> <span><?php echo $this->_tpl_vars['lorganisational_structure']; ?>
</span></a></li>
            <?php echo $this->_tpl_vars['level_tree']; ?>

            <li class="<?php if ($this->_tpl_vars['page'] == 'jabatan' && ( $this->_tpl_vars['subpage'] == 'catjabatan' || $this->_tpl_vars['subpage'] == 'formcategory' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/catjabatan/"><i class="fa fa-sitemap"></i> <span><?php echo $this->_tpl_vars['lcatjabatan']; ?>
</span></a></li>
            <li class="<?php if ($this->_tpl_vars['page'] == 'jabatan' && $this->_tpl_vars['subpage'] != 'catjabatan' && $this->_tpl_vars['subpage'] != 'formcategory'): ?> active<?php endif; ?>"><a class="user-jabatan" href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/"><i class="fa fa-id-card-o"></i> <span><?php echo $this->_tpl_vars['jabatan']; ?>
</span></a></li>
            <li class="<?php if ($this->_tpl_vars['page'] == 'func'): ?> active<?php endif; ?>" style="display: none"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/func/"><i class="fa fa-th"></i> <span><?php echo $this->_tpl_vars['function']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['right']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'right'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/right/"><i class="fa fa-id-card-o"></i> <span><?php echo $this->_tpl_vars['luser_rights']; ?>
</span></a></li>
            <?php endif; ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'user' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist"><i class="fa fa-users"></i> <span><?php echo $this->_tpl_vars['user_list']; ?>
</span></a></li>
            <li class="<?php if ($this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'changepass1'): ?>
            active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/changepass1"><i class="fa fa-key"></i> <span><?php echo $this->_tpl_vars['change_pass']; ?>
</span></a></li>
            <li class="<?php if ($this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'import'): ?>
            active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/import"><i class="fa fa-upload"></i> <span><?php echo $this->_tpl_vars['limport']; ?>
</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>