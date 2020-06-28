<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:28
         compiled from user/menu.html */ ?>
<script>
    function getcart()
    {
        $.post("<?php echo $this->_tpl_vars['base_url']; ?>
index.php/ildp/getcart", {},
            function(r)
            {
                if (r.total == 0)
                {
                    $("#menucartildp").hide();
                }
                else
                {
                    $("#menucartildp").show();
                    $("#nildpcart").html(r.htmltotal);
                }
            }
            , "json"
        )
    }

    $(document).ready(
        function()
        {
            //getcart();
        }
    );

</script>

<aside class="main-sidebar" style="background-color: #243d56;">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header"><?php echo $this->_tpl_vars['lview_options']; ?>
</li>
			<li class="<?php if ($this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'info'): ?> active<?php endif; ?>">
				<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/info">
					<i class="fa fa-user-circle-o"></i> <span><?php echo $this->_tpl_vars['profile']; ?>
</span>
				</a>
			</li>
			<li class="<?php if ($this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'changepass'): ?> active<?php endif; ?>">
				<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/changepass">
					<i class="fa fa-key"></i> <span><?php echo $this->_tpl_vars['change_pass']; ?>
</span>
				</a>
			</li>
			<?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
			<li class="treeview <?php if (( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'history' ) || ( $this->_tpl_vars['page'] == 'classroom' && $this->_tpl_vars['subpage'] == 'history' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'history' )): ?> active menu-open<?php endif; ?>">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span><?php echo $this->_tpl_vars['llearning_trainee']; ?>
</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ($this->_tpl_vars['page'] == 'training' && ( $this->_tpl_vars['subpage'] == 'history' || $this->_tpl_vars['subpage'] == 'historydetail' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/history"><i class="fa fa-mobile" style="font-size: 23px;"></i> <?php echo $this->_tpl_vars['lonline_training']; ?>
</a></li>
					<li class="<?php if ($this->_tpl_vars['page'] == 'classroom' && ( $this->_tpl_vars['subpage'] == 'history' || $this->_tpl_vars['subpage'] == 'historydetail' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/history"><i class="fa fa-university"></i> <?php echo $this->_tpl_vars['classroom_training']; ?>
</a></li>
					<li class="<?php if ($this->_tpl_vars['page'] == 'certificate' && ( $this->_tpl_vars['subpage'] == 'history' || $this->_tpl_vars['subpage'] == 'historydetail' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/history"><i class="fa fa-pencil-square-o"></i> <?php echo $this->_tpl_vars['lcertification']; ?>
</a></li>
				</ul>
			</li>
			<li class="<?php if (( $this->_tpl_vars['page'] == 'user' && $this->_tpl_vars['subpage'] == 'activities' ) || $this->_tpl_vars['page'] == 'activities'): ?> active<?php endif; ?>">
				<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/activities">
				<i class="fa fa-th"></i> <span><?php echo $this->_tpl_vars['luser_activities']; ?>
</span>
				</a>
			</li>
			<?php if ($this->_tpl_vars['showildp'] == 1): ?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span>ILDP</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="<?php if ($this->_tpl_vars['page'] == 'ildpform' && $this->_tpl_vars['subpage'] != 'approval' && $this->_tpl_vars['subpage'] != 'approvalhist'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildpform"><i class="fa fa-circle-o"></i> <?php echo $this->_tpl_vars['lildp_form']; ?>
</a></li>
					<li class="<?php if ($this->_tpl_vars['page'] == 'ildphist'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildphist"><i class="fa fa-circle-o"></i> <?php echo $this->_tpl_vars['lmy_form']; ?>
</a></li>
					<li class="<?php if ($this->_tpl_vars['page'] == 'ildpapproval' || ( $this->_tpl_vars['page'] == 'ildpform' && $this->_tpl_vars['subpage'] == 'approval' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildpapproval"><i class="fa fa-circle-o"></i> <?php echo $this->_tpl_vars['lpending_approval']; ?>
</a></li>
					<li class="<?php if ($this->_tpl_vars['page'] == 'ildpapprovalhist' || ( $this->_tpl_vars['page'] == 'ildpform' && $this->_tpl_vars['subpage'] == 'approvalhist' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildpapprovalhist"><i class="fa fa-circle-o"></i> <?php echo $this->_tpl_vars['lapproval_history']; ?>
</a></li>
				</ul>
			</li>
			<?php endif; ?>
			<?php endif; ?>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>