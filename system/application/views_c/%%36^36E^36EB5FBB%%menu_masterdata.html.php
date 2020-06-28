<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:39
         compiled from menu_masterdata.html */ ?>
<aside class="main-sidebar" style="background-color: #243d56;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'generalsetting' && $this->_tpl_vars['subpage'] != 'backup'): ?>
            active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/"><i class="fa fa-cog"></i> <span><?php echo $this->_tpl_vars['lgeneralsetting']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'lokasi'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/"><i class="fa fa-building-o"></i> <span><?php echo $this->_tpl_vars['llokasi_fisik']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'import'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/import/masterdata"><i class="fa fa-upload"></i> <span><?php echo $this->_tpl_vars['limport']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'generalsetting' && $this->_tpl_vars['subpage'] == 'backup'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/generalsetting/backup"><i class="fa fa-cloud-download"></i> <span><?php echo $this->_tpl_vars['lbackup']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['master'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="treeview<?php if ($this->_tpl_vars['page'] == 'reminder'): ?> active<?php endif; ?>">
                <a href="#reminder""><i class="fa fa-bell"></i> <span><?php echo $this->_tpl_vars['lreminder_new_joiner']; ?>
</span><span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span></a>
                <ul class="treeview-menu" id="actionlist">
                    <li class="<?php if ($this->_tpl_vars['page'] == 'reminder' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a name="reminder" href="<?php echo $this->_tpl_vars['site_url']; ?>
/reminder/"><i class="fa fa-tasks"></i> <span><?php echo $this->_tpl_vars['llist']; ?>
</span></a></li>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'reminder' && $this->_tpl_vars['subpage'] == 'import'): ?>
                    active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/reminder/import"><i class="fa fa-plus-square-o"></i> <span><?php echo $this->_tpl_vars['ladd_reminder']; ?>
</span></a></li>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'reminder' && $this->_tpl_vars['subpage'] == 'phistory'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/reminder/phistory"><i class="fa fa-history"></i> <span><?php echo $this->_tpl_vars['lhistory']; ?>
</span></a></li>
                </ul>
            </li>
            <li class="treeview<?php if ($this->_tpl_vars['page'] == 'refreshment'): ?> active<?php endif; ?>">
                <a href="#refreshment""><i class="fa fa-hourglass-half"></i> <span><?php echo $this->_tpl_vars['lreminder_refreshment']; ?>
</span><span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span></a>
                <ul class="treeview-menu" id="actionlist">
                    <li class="<?php if ($this->_tpl_vars['page'] == 'refreshment' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a name="refreshment" href="<?php echo $this->_tpl_vars['site_url']; ?>
/refreshment/"><i class="fa fa-tasks"></i> <span><?php echo $this->_tpl_vars['llist']; ?>
</span></a>
                    </li>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'refreshment' && $this->_tpl_vars['subpage'] == 'import'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/refreshment/import"><i class="fa fa-plus-square-o"></i> <span><?php echo $this->_tpl_vars['ladd_refreshment']; ?>
</span></a></li>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'refreshment' && $this->_tpl_vars['subpage'] == 'phistory'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/refreshment/phistory"><i class="fa fa-history"></i> <span><?php echo $this->_tpl_vars['lhistory']; ?>
</span></a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>