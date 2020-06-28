<?php /* Smarty version 2.6.26, created on 2019-07-04 09:45:29
         compiled from report/menu.html */ ?>
<aside class="main-sidebar" style="background-color: #243d56;">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['report']): ?>
			<li class="<?php if ($this->_tpl_vars['page'] == 'report' && ( $this->_tpl_vars['subpage'] == "" )): ?> active<?php endif; ?>">
			<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/report/">
				<i class="fa fa-user-circle-o"></i> <span><?php echo $this->_tpl_vars['lgeneral_report']; ?>
</span>
			</a>
			</li>
			<li class="<?php if ($this->_tpl_vars['page'] == 'report' && ( $this->_tpl_vars['subpage'] == 'certification' )): ?> active<?php endif; ?>">
			<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/report/certification">
				<i class="fa fa-user-circle-o"></i> <span><?php echo $this->_tpl_vars['lcertification_list']; ?>
</span>
			</a>
			</li>
			<?php endif; ?>
		</ul>
	</section>
</aside>