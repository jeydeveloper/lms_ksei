<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:39
         compiled from user/list_news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'user/list_news.html', 86, false),)), $this); ?>
<?php if (! $_POST['dialog']): ?>
      <script>
      	function chagestatus(id, status)
      	{
      		f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/user/changestatuscmsnews/" + id + "/" + status, "frmtemp", "status"+id, "Updating...",
      			function(data)
      			{
      				document.frmtemp.submit();
      			}
      		);
      	}

     	function search_onsubmit()
      	{
      		$("#keyword").val($("#_keyword").val());
      		$("#searchby").val($("#_searchby").val());

      		document.frmtemp.submit();
          return false;
      	}
      </script>
<?php endif; ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $this->_tpl_vars['ladmin_news_list']; ?>
</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Admin News</a></li>
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
                        <p><?php echo $this->_tpl_vars['lheader_list_news_list']; ?>
</p>
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('news_title', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'news_title'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</a><?php if ($this->_tpl_vars['sessmodules']['master'] && $this->_tpl_vars['sess']['asadmin']): ?> | <a href="#" onclick="javascript:sortby('news_entrydate', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'news_entrydate'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['news_entrydate']; ?>
</a> | <a href="#" onclick="javascript:sortby('news_void', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'news_void'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/formadminnews"><?php echo $this->_tpl_vars['date_added']; ?>
</a><?php endif; ?>
                        </div>
                        <div class="mg-btm-10">
                            <form method="post" onsubmit="javascript: return search_onsubmit(this);">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="news_title"><?php echo $this->_tpl_vars['name']; ?>
</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <input class="form-control" type='text' name="_keyword" id="_keyword" class='formdefault' value="<?php echo $_POST['keyword']; ?>
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
                                <th width="5%"><input type="checkbox" name="catjaball" id="catjaball" value="" onclick="javascript:catjaball_onclick(this)" /> </th>
                                <?php endif; ?>
                                <th width="70%"><a href="#" onclick="javascript:sortby('news_title', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_news_title']; ?>
 "><?php echo $this->_tpl_vars['news_title']; ?>
</a></th>
                                <th width="70%"><a href="#" onclick="javascript:sortby('news_entrydate', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_news_entrydate']; ?>
 "><?php echo $this->_tpl_vars['news_entrydate']; ?>
</a></th>
                                <?php if (! $_POST['dialog']): ?>
                                <?php if ($this->_tpl_vars['sessmodules']['topic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <th><div class="listmain"><a href="#" onclick="javascript:chagestatus('news_void', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</a></div></th>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
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
/user/formadminnews/<?php echo $this->_tpl_vars['row']->news_id; ?>
"><?php echo $this->_tpl_vars['row']->news_title; ?>
</a></td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->tanggal; ?>
</td>
                            <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->news_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->news_id; ?>
,<?php echo $this->_tpl_vars['row']->news_void; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->news_void == 0): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->news_void_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->news_void_desc; ?>
" /></a></div></td>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/deletecmsnews/<?php echo $this->_tpl_vars['row']->news_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
                            <?php else: ?>
                            <td colspan="2" class="odd">empty</td>
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
/user/admin_news">
	<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
	<input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
	<input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
	<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
	<input type="hidden" id="keyword" name="keyword" value="<?php echo $_POST['keyword']; ?>
" />
	<input type="hidden" id="searchby" name="searchby" value="<?php echo $_POST['searchby']; ?>
" />
</form>