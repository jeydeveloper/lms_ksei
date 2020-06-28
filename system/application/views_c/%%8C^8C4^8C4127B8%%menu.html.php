<?php /* Smarty version 2.6.26, created on 2018-10-23 12:26:49
         compiled from training/menu.html */ ?>
<ul class="treeview-menu">
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' || $this->_tpl_vars['subpage'] == 'historyexam' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'historyparticipant' || $this->_tpl_vars['subpage'] == 'historynpk' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/showlist"><i class="fa fa-tasks"></i> <span><?php echo $this->_tpl_vars['llist']; ?>
</span></a></li>
	<?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['certificate'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
	<?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'setting'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/setting"><i class="fa fa-th"></i> <span><?php echo $this->_tpl_vars['lsetting']; ?>
</span></a></li>
	<?php endif; ?>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'participant'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/participant"><i class="fa fa-id-badge"></i> <span><?php echo $this->_tpl_vars['lparticipant']; ?>
</span></a></li>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'prequisite'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/prequisite"><i class="fa fa-arrow-circle-right"></i> <span><?php echo $this->_tpl_vars['lprequisite']; ?>
</span></a></li>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'postrequisite'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/postrequisite"><i class="fa fa-arrow-circle-left"></i> <span><?php echo $this->_tpl_vars['lpostrequisite']; ?>
</span></a></li>
	<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'praexam'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/praexam"><i class="fa fa-pencil-square-o"></i> <span><?php echo $this->_tpl_vars['lpraexam_lexam']; ?>
</span></a></li>
	<?php endif; ?>
	<li class="<?php if ($this->_tpl_vars['page'] == 'banksoal'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/<?php echo $this->_tpl_vars['pageid']; ?>
"><i class="fa fa-file-text-o"></i> <span><?php echo $this->_tpl_vars['lbank_soal_training']; ?>
</span></a></li>
	<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'material'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/material"><i class="fa fa-book"></i> <span><?php echo $this->_tpl_vars['lmateri']; ?>
</span></a></li>
	<?php endif; ?>
	<li class="<?php if ($this->_tpl_vars['page'] == $this->_tpl_vars['pageid'] && $this->_tpl_vars['subpage'] == 'summaryreport'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport"><i class="fa fa-bar-chart"></i> <span><?php echo $this->_tpl_vars['lreport']; ?>
</span></a></li>
	<?php endif; ?>
</ul>