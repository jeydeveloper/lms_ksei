<?php /* Smarty version 2.6.26, created on 2018-12-18 05:48:01
         compiled from lokasi/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'lokasi/list.html', 54, false),)), $this); ?>
      <script>
      	function chagestatus(id, status)
      	{
      		f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/changestatus/" + id + "/" + status, "frmtemp", "status"+id, "Updating...", 
      			function(data)
      			{      		
      				document.frmtemp.submit();
      			}
      		);      			
      	}
      </script>
<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/">
	<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
	<input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
	<input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
	<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
</form>

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php echo $this->_tpl_vars['llokasi_list']; ?>
</h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Level</a></li>
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
                  <p><?php echo $this->_tpl_vars['lheader_list_lokasi']; ?>
</p>
                  <div class="mg-btm-10">
                    <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('lokasi_kota', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'lokasi_kota'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lcity']; ?>
</a> | <a href="#" onclick="javascript:sortby('lokasi_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'lokasi_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/form"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/export"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
                  </div>
                  <hr>
                  <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                      <th width="30%"><a href="#" onclick="javascript:sortby('lokasi_kota', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_city']; ?>
"><?php echo $this->_tpl_vars['lcity']; ?>
</a></th>
                      <th width="50%"><a href="#" onclick="javascript:sortby('lokasi_alamat', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_location']; ?>
"><?php echo $this->_tpl_vars['llocation']; ?>
</a></th>
                      <th><div class="listmain"><a href="#" onclick="javascript:sortby('lokasi_status', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</a></div></th>
                      <th width="10%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                    <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                    <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                    <td class="odd"><?php echo $this->_tpl_vars['row']->lokasi_kota; ?>
</td>
                    <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/form/<?php echo $this->_tpl_vars['row']->lokasi_id; ?>
"><?php echo $this->_tpl_vars['row']->lokasi_alamat; ?>
</a></td>
                    <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->lokasi_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->lokasi_id; ?>
,<?php echo $this->_tpl_vars['row']->lokasi_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->lokasi_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->lokasi_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->lokasi_status_desc; ?>
" /></a></div></td>
                    <?php if ($this->_tpl_vars['row']->used): ?>
                    <td>&nbsp;</td>
                    <?php else: ?>
                    <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/remove/<?php echo $this->_tpl_vars['row']->lokasi_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
                    <?php endif; ?>
                    </tr>
                    <?php echo smarty_function_counter(array(), $this);?>

                    <?php endforeach; endif; unset($_from); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <td colspan="5"><?php echo $this->_tpl_vars['paging']; ?>
</td>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>