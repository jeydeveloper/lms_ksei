<?php /* Smarty version 2.6.26, created on 2018-10-23 09:55:32
         compiled from topic/menu.html */ ?>
<script>
    $(document).ready(
        function () {
            //getcart();
        }
    );

    function getcart() {
        $.post("<?php echo $this->_tpl_vars['base_url']; ?>
index.php/ildp/getcart", {},
            function (r) {
                if (r.total == 0) {
                    $("#menucartildp").hide();
                }
                else {
                    $("#menucartildp").show();
                    $("#nildpcart").html(r.htmltotal);
                }
            }
            , "json"
        )
    }
</script>

<aside class="main-sidebar" style="background-color: #243d56;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || ( $this->_tpl_vars['sessmodules']['topic'] && $this->_tpl_vars['sess']['asadmin'] )): ?>
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['category']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'topic' && ( $this->_tpl_vars['subpage'] == 'category' || $this->_tpl_vars['subpage'] == 'formcategory' )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/category"><i class="fa fa-sitemap"></i> <span><?php echo $this->_tpl_vars['category']; ?>
</span></a></li>
            <?php endif; ?>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['topic'] || ( $this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] )): ?>
            <li class="<?php if (( $this->_tpl_vars['page'] == 'topic' && ( $this->_tpl_vars['subpage'] == "" || $this->_tpl_vars['subpage'] == 'formtopic' ) ) || ( ( ! $this->_tpl_vars['sess']['asadmin'] ) && ( $this->_tpl_vars['page'] == 'ildp' ) && ( $this->_tpl_vars['subpage'] != 'cart' ) )): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/"><i class="fa fa-newspaper-o"></i> <span><?php echo $this->_tpl_vars['topic']; ?>
</span></a></li>
            <?php if (! $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'topic' && $this->_tpl_vars['subpage'] == 'onlinetraining' || ( ! $this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['page'] == 'training' )): ?>active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/onlinetraining"><i class="fa fa-mobile" style="font-size: 23px;"></i> <span><?php echo $this->_tpl_vars['online_training']; ?>
</span></a>
            <li class="<?php if ($this->_tpl_vars['page'] == 'topic' && $this->_tpl_vars['subpage'] == 'certificate' || ( ! $this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['page'] == 'certificate' )): ?>active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/certificate"><i class="fa fa-university"></i> <span><?php echo $this->_tpl_vars['certification']; ?>
</span></a>
            <li class="<?php if ($this->_tpl_vars['page'] == 'topic' && $this->_tpl_vars['subpage'] == 'resources' || ( ! $this->_tpl_vars['sess']['asadmin'] && $this->_tpl_vars['page'] == 'resources' )): ?>active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/resources"><i class="fa fa-file-text"></i> <span><?php echo $this->_tpl_vars['resources']; ?>
</span></a></li>
            <li class="" id="menucartildp" style="display: none;"><a href='<?php echo $this->_tpl_vars['site_url']; ?>
/ildp/cart'><i class="fa fa-th"></i> <span><?php echo $this->_tpl_vars['lildp_form']; ?>
</span><span id="nildpcart"></span></a></li>
            <?php endif; ?>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['training'] || $this->_tpl_vars['ishavedelegetion'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if (( $this->_tpl_vars['page'] == 'training' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' || $this->_tpl_vars['subpage'] == 'historyexam' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'historyparticipant' || $this->_tpl_vars['subpage'] == 'historynpk' ) ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'setting' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'participant' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'prequisite' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'postrequisite' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'praexam' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'training' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'formedit' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'material' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'summaryreport' )): ?> treeview active<?php endif; ?>">
                <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist"><i class="fa fa-mobile" style="font-size: 23px;"></i> <span><?php echo $this->_tpl_vars['online_training']; ?>
</span><?php if (( $this->_tpl_vars['page'] == 'training' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' || $this->_tpl_vars['subpage'] == 'historyexam' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'historyparticipant' || $this->_tpl_vars['subpage'] == 'historynpk' ) ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'setting' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'participant' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'prequisite' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'postrequisite' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'praexam' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'training' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'material' ) || ( $this->_tpl_vars['page'] == 'training' && $this->_tpl_vars['subpage'] == 'summaryreport' )): ?> <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span><?php endif; ?></a>
            <?php if (( $this->_tpl_vars['page'] == 'training' || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'training' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'historytraining' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'form' && $this->_tpl_vars['type'] == 'training' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'formedit' && $this->_tpl_vars['type'] == 'training' ) ) && ( $this->_tpl_vars['subpage'] != 'history' )): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "training/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
            </li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['classroom'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if (( $this->_tpl_vars['page'] == 'classroom' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'historynpk' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'form' ) ) || ( $this->_tpl_vars['page'] == 'classroom' && $this->_tpl_vars['subpage'] == 'import' )): ?> treeview active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/showlist"><i class="fa fa-university"></i> <span><?php echo $this->_tpl_vars['classroom_training']; ?>
</span><?php if (( $this->_tpl_vars['page'] == 'classroom' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'historynpk' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'form' ) ) || ( $this->_tpl_vars['page'] == 'classroom' && $this->_tpl_vars['subpage'] == 'import' )): ?> <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span><?php endif; ?></a>
                <?php if ($this->_tpl_vars['page'] == 'classroom'): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "classroom/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
            </li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['certificate'] || $this->_tpl_vars['ishavedelegetion'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if (( $this->_tpl_vars['page'] == 'certificate' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' || $this->_tpl_vars['subpage'] == 'historyexam' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'historyparticipant' || $this->_tpl_vars['subpage'] == 'historynpk' ) ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'setting' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'participant' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'prequisite' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'postrequisite' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'praexam' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'certificate' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'material' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'summaryreport' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'form' )): ?> treeview active<?php endif; ?>">
                <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate"><i class="fa fa-pencil-square-o"></i> <span><?php echo $this->_tpl_vars['certification']; ?>
</span><?php if (( $this->_tpl_vars['page'] == 'certificate' && ( $this->_tpl_vars['subpage'] == 'showlist' || $this->_tpl_vars['subpage'] == 'form' || $this->_tpl_vars['subpage'] == 'historyexam' || $this->_tpl_vars['subpage'] == 'historydetail' || $this->_tpl_vars['subpage'] == 'historyparticipant' || $this->_tpl_vars['subpage'] == 'historynpk' ) ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'setting' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'participant' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'prequisite' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'postrequisite' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'praexam' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'certificate' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'material' ) || ( $this->_tpl_vars['page'] == 'certificate' && $this->_tpl_vars['subpage'] == 'summaryreport' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'form' )): ?> <span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span><?php endif; ?></a>
                <?php if (( $this->_tpl_vars['page'] == 'certificate' || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'certificate' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'history' ) || ( $this->_tpl_vars['page'] == 'banksoal' && $this->_tpl_vars['subpage'] == 'form' && $this->_tpl_vars['type'] == 'certificate' ) ) && ( $this->_tpl_vars['subpage'] != 'history' )): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "training/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
            </li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['resources'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'resources'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources"><i class="fa fa-file-text"></i> <span><?php echo $this->_tpl_vars['resources']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['report'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'import'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/import/topic_traning"><i class="fa fa-upload"></i> <span><?php echo $this->_tpl_vars['limport']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['sessmodules']['report'] ) && $this->_tpl_vars['sess']['asadmin']): ?>
            <li class="<?php if ($this->_tpl_vars['page'] == 'user' || $this->_tpl_vars['page'] == 'activities'): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/activities"><i class="fa fa-users"></i> <span><?php echo $this->_tpl_vars['luser_activities']; ?>
</span></a></li>
            <?php endif; ?>
            <?php if (1 == 1): ?>
            <li class="treeview <?php if (( $this->_tpl_vars['page'] == 'questionaire' && $this->_tpl_vars['subpage'] == "" ) || ( $this->_tpl_vars['page'] == 'questionairebanksoal' && $this->_tpl_vars['subpage'] == "" ) || ( $this->_tpl_vars['page'] == 'questionairestart' && $this->_tpl_vars['subpage'] == "" )): ?> active<?php endif; ?>">
                <a href="#questionaire""><i class="fa fa-question-circle"></i> <span>Questionaire</span><span class="pull-right-container">
					  <i class="fa fa-angle-left pull-right"></i>
					</span></a>
                <ul class="treeview-menu">
                    <?php if ($this->_tpl_vars['sess']['asadmin']): ?>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'questionaire' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a name="reminder" href="<?php echo $this->_tpl_vars['site_url']; ?>
/questionaire/"><i class="fa fa-file-text-o"></i> <span><?php echo $this->_tpl_vars['llist']; ?>
</span></a></li>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'questionairebanksoal' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/questionairebanksoal/"><i class="fa fa-book"></i> <span>Bank Soal</span></a></li>
                    <?php endif; ?>
                    <li class="<?php if ($this->_tpl_vars['page'] == 'questionairestart' && $this->_tpl_vars['subpage'] == ""): ?> active<?php endif; ?>"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/questionairestart/"><i class="fa fa-question-circle-o"></i> <span>Start Questionaire</span></a></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>