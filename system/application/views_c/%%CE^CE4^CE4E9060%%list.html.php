<?php /* Smarty version 2.6.26, created on 2020-04-14 11:10:46
         compiled from resources/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'resources/list.html', 82, false),)), $this); ?>
<script>
    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/resources/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
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
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $this->_tpl_vars['lresources']; ?>
<?php if ($this->_tpl_vars['rowtopic']): ?>: &quot;<?php echo $this->_tpl_vars['rowtopic']->category_name; ?>
&quot;<?php endif; ?></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Resources</a></li>
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
 <a href="#" onclick="javascript:sortby('reference_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'reference_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lname']; ?>
</a> | <a href="#" onclick="javascript:sortby('category_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'category_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['ltopic']; ?>
</a> | <a href="#" onclick="javascript:sortby('category_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'category_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lsize']; ?>
</a><?php if ($this->_tpl_vars['sessmodules']['resources'] && $this->_tpl_vars['sess']['asadmin']): ?> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/form<?php if ($this->_tpl_vars['rowtopic']): ?>/0/<?php echo $this->_tpl_vars['rowtopic']->category_id; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['date_added']; ?>
</a> <?php endif; ?>
                        </div>
                        <div class="mg-btm-10">
                            <form onsubmit="javascript:search(); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="reference_name"><?php echo $this->_tpl_vars['lresources_name']; ?>
</option>
                                            <option value="category_name"><?php echo $this->_tpl_vars['ltopic']; ?>
</option>
                                            <option value="size_lt"><?php echo $this->_tpl_vars['lsize']; ?>
 &lt; (kB)</option>
                                            <option value="size_gt"><?php echo $this->_tpl_vars['lsize']; ?>
 &gt; (kB)</option>
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
                                <th width="20%"><a href="#" onclick="javascript:sortby('reference_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_resource_name']; ?>
"><?php echo $this->_tpl_vars['lresources_name']; ?>
</a></th>
                                <th width="20%"><a href="#" onclick="javascript:sortby('category_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_topic_name']; ?>
"><?php echo $this->_tpl_vars['ltopic']; ?>
</a></th>
                                <th width="20%"><a href="#" onclick="javascript:sortby('reference_filesize', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_size']; ?>
"><?php echo $this->_tpl_vars['lsize']; ?>
</a></th>
                                <th width="20%"><a href="#" onclick="javascript:sortby('reference_filetype', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_filetype']; ?>
"><?php echo $this->_tpl_vars['lresource_type']; ?>
</a></th>
                                <?php if ($this->_tpl_vars['sessmodules']['resources'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <th><?php echo $this->_tpl_vars['lstatus']; ?>
</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr>
                                <?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/download/<?php echo $this->_tpl_vars['row']->reference_id; ?>
"><?php echo $this->_tpl_vars['row']->reference_name; ?>
</a></td>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->category_name; ?>
</td>
                                <?php else: ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/form/<?php echo $this->_tpl_vars['row']->reference_id; ?>
"><?php echo $this->_tpl_vars['row']->reference_name; ?>
</a></td>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formtopic/<?php echo $this->_tpl_vars['row']->reference_topic; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a></td>
                                <?php endif; ?>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->size_fmt; ?>
 kB</td>
                                <td class="odd"><img src='<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php echo $this->_tpl_vars['row']->reference_png; ?>
' alt='<?php echo $this->_tpl_vars['row']->reference_filetype; ?>
' title='<?php echo $this->_tpl_vars['row']->reference_filetype; ?>
' /></td>
                                <?php if ($this->_tpl_vars['sessmodules']['resources'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->reference_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->reference_id; ?>
,<?php echo $this->_tpl_vars['row']->reference_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->reference_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->reference_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->reference_status_desc; ?>
" /></a></div></td>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/participant/<?php echo $this->_tpl_vars['row']->reference_id; ?>
"><?php echo $this->_tpl_vars['lparticipant']; ?>
</a></td>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/remove/<?php echo $this->_tpl_vars['row']->reference_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['lconfirm_delete']; ?>
');"><?php echo $this->_tpl_vars['ldelete']; ?>
</a></td>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/historydetail/<?php echo $this->_tpl_vars['row']->reference_id; ?>
"><?php echo $this->_tpl_vars['lhistory']; ?>
</a></td>
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

<form id="frmtemp" name="frmtemp" method="post"
      action="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/<?php if ($this->_tpl_vars['rowtopic']): ?>index/<?php echo $this->_tpl_vars['rowtopic']->category_id; ?>
<?php endif; ?>">
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