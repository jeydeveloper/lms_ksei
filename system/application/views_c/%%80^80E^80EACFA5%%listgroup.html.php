<?php /* Smarty version 2.6.26, created on 2020-06-26 09:14:17
         compiled from level/listgroup.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'level/listgroup.html', 77, false),)), $this); ?>
<script>
    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/level/groupchangestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
            function (data) {
                document.frmtemp.submit();
            }
        );
    }

    function search_onsubmit(frm) {
        $("#keyword").val(frm._keyword.value);
        document.frmtemp.submit();
        return false;
    }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $this->_tpl_vars['mylevel']->level_name; ?>
</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Level Group</a></li>
            <li class="active">Showlist</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
                    <div id="message"></div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('level_group_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'level_group_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lname']; ?>
</a> | <a href="#" onclick="javascript:sortby('level_group_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'level_group_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lstatus']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/groupform/<?php echo $this->_tpl_vars['mylevel']->level_id; ?>
"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/exportgroup"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
                        </div>
                        <div class="mg-btm-10">
                            <form method="post" onsubmit="javascript: return search_onsubmit(this)">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch']; ?>
 <?php echo $this->_tpl_vars['mylevel']->level_name; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <input class="form-control" type='text' name="_keyword" id="_keyword"
                                               class='formdefault' value="<?php echo $_POST['keyword']; ?>
">
                                    </div>
                                    <div class="col-xs-3">
                                        <input class="btn btn-primary" type='submit' value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 ">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <?php if ($_POST['dialog'] && $this->_tpl_vars['list']): ?>
                                <th width='5%'><input type="checkbox" name="groupall" value="" onclick="javascript:groupall_onclick(this)" />&nbsp;</th>
                                <?php endif; ?>
                                <th><a href="#" onclick="javascript:sortby('level_group_name', 'asc')" class="thead" title="sort topics by code"><?php echo $this->_tpl_vars['mylevel']->level_name; ?>
</a></th>
                                <?php $_from = $this->_tpl_vars['parentlevels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
                                <th><?php echo $this->_tpl_vars['level']->level_name; ?>
</th>
                                <?php endforeach; endif; unset($_from); ?>
                                <?php if (! $_POST['dialog']): ?>
                                <th width="10%"><?php echo $this->_tpl_vars['luser']; ?>
</th>
                                <th width="10%"><div class="listmain"><a href="#" onclick="javascript:sortby('level_group_status', 'asc')" class="thead" title="sort by topic STATUS"><?php echo $this->_tpl_vars['lstatus']; ?>
</a></div></th>
                                <th width="10%">&nbsp;</th>
                                <?php else: ?>
                                <!--<th><?php echo $this->_tpl_vars['mylevel']->level_name; ?>
</th>-->
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                            <?php if ($_POST['dialog']): ?>
                            <td class="odd"><input type="checkbox" name="group[]" value="<?php echo $this->_tpl_vars['row']->level_group_id; ?>
" onclick="javascript:group_click(this.checked)"<?php if ($this->_tpl_vars['row']->level_group_checked): ?> checked<?php endif; ?> /></td>
                            <?php endif; ?>
                            <?php if (! $_POST['dialog']): ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/groupform/<?php echo $this->_tpl_vars['mylevel']->level_id; ?>
/<?php echo $this->_tpl_vars['row']->level_group_id; ?>
"><?php echo $this->_tpl_vars['row']->level_group_name; ?>
</a></td>
                            <?php else: ?>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->level_group_name; ?>
</td>
                            <?php endif; ?>
                            <?php $_from = $this->_tpl_vars['row']->parents; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['parent']):
?>
                            <td class="odd"><?php echo $this->_tpl_vars['parent']->level_group_name; ?>
</td>
                            <?php endforeach; endif; unset($_from); ?>
                            <?php if (! $_POST['dialog']): ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist/<?php echo $this->_tpl_vars['row']->level_group_id; ?>
"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/participants.png" border="0" /></a></td>
                            <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->level_group_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->level_group_id; ?>
,<?php echo $this->_tpl_vars['row']->level_group_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->level_group_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->level_group_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->level_group_status_desc; ?>
" /></a></div></td>
                            <?php if ($this->_tpl_vars['row']->used): ?>
                            <td class="odd">&nbsp;</td>
                            <?php else: ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/groupremove/<?php echo $this->_tpl_vars['row']->level_group_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
                            <?php endif; ?>
                            <?php endif; ?>
                            </tr>
                            <?php echo smarty_function_counter(array(), $this);?>

                            <?php endforeach; endif; unset($_from); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="content-paging"><?php echo $this->_tpl_vars['paging']; ?>
</div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/level/group/<?php echo $this->_tpl_vars['mylevel']->level_id; ?>
">
    <input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
"/>
    <input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
"/>
    <input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
"/>
    <input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
"/>
    <input type="hidden" id="keyword" name="keyword" value="<?php echo $_POST['keyword']; ?>
"/>
</form>