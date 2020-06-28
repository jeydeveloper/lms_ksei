<?php /* Smarty version 2.6.26, created on 2018-12-18 05:58:48
         compiled from jabatan/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'jabatan/list.html', 91, false),)), $this); ?>
<script>
    <?php if (! $_POST['dialog']): ?>

    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
            function (data) {
                document.frmtemp.submit();
            }
        );
    }

    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());

        document.frmtemp.submit();
    }

    <?php endif; ?>
</script>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Jabatan</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Jabatan</a></li>
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
                        <p><?php echo $this->_tpl_vars['header_list_jabatan']; ?>
</p>
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('jabatan_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'jabatan_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</a> | <a href="#" onclick="javascript:sortby('level_group_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'level_group_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lgroup']; ?>
</a> | <a href="#" onclick="javascript:sortby('jabatan_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'jabatan_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/form"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/export"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
                        </div>
                        <div class="mg-btm-10">
                            <form method="post" onsubmit="javascript: return search(this); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="jabatan_name"><?php echo $this->_tpl_vars['lname']; ?>
</option>
                                            <?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
                                            <option value="level<?php echo $this->_tpl_vars['level']->level_nth; ?>
"><?php echo $this->_tpl_vars['level']->level_name; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
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
                                <?php if ($_POST['dialog']): ?>
                                <?php if ($this->_tpl_vars['list']): ?>
                                <th><input type="checkbox" name="jabatanall" value="" onclick="javascript:jabatanall_onclick(this)" />&nbsp;</th>
                                <?php endif; ?>
                                <th><?php echo $this->_tpl_vars['jabatan_name']; ?>
</th>
                                <th width="30%"><?php echo $this->_tpl_vars['lgroup']; ?>
</th>
                                <?php else: ?>
                                <th><a href="#" onclick="javascript:sortby('jabatan_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_position_name']; ?>
"><?php echo $this->_tpl_vars['jabatan_name']; ?>
</a></th>
                                <th width="25%"><a href="#" onclick="javascript:sortby('catjabatan_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_category_name']; ?>
"><?php echo $this->_tpl_vars['lcategory']; ?>
</a></th>
                                <th width="25%"><a href="#" onclick="javascript:sortby('level_group_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_hierarchy']; ?>
"><?php echo $this->_tpl_vars['lhierarchy']; ?>
</a></th>
                                <th width="13%"><div class="listmain"><a href="#" onclick="javascript:sortby('jabatan_status', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</a></div></th>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                            <?php if (! $_POST['dialog']): ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/form/<?php echo $this->_tpl_vars['row']->jabatan_id; ?>
"><?php echo $this->_tpl_vars['row']->jabatan_name; ?>
</a></td>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/formcategory/<?php echo $this->_tpl_vars['row']->catjabatan_id; ?>
"><?php echo $this->_tpl_vars['row']->catjabatan_name; ?>
</a></td>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/level/groupform/<?php echo $this->_tpl_vars['row']->level; ?>
/<?php echo $this->_tpl_vars['row']->jabatan_level_group; ?>
"><?php echo $this->_tpl_vars['row']->level_group_name; ?>
</a></td>
                            <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->jabatan_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->jabatan_id; ?>
,<?php echo $this->_tpl_vars['row']->jabatan_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->jabatan_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->jabatan_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->jabatan_status_desc; ?>
" /></a></div></td>
                            <?php if ($this->_tpl_vars['row']->used): ?>
                            <td>&nbsp;</td>
                            <?php else: ?>
                            <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/remove/<?php echo $this->_tpl_vars['row']->jabatan_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
                            <?php endif; ?>
                            <?php else: ?>
                            <td class="odd"><input type="checkbox" name="jabatan[]" value="<?php echo $this->_tpl_vars['row']->jabatan_id; ?>
" onclick="javascript:jabatan_click(this.checked)"<?php if ($this->_tpl_vars['row']->jabatan_checked): ?> checked<?php endif; ?> /></td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->jabatan_name; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->level_group_name; ?>
</td>
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
/jabatan/">
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
    <input type="hidden" id="searchby" name="searchby" value="<?php echo $_POST['searchby']; ?>
"/>
</form>