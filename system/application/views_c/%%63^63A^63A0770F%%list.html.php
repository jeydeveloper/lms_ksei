<?php /* Smarty version 2.6.26, created on 2018-12-12 15:12:48
         compiled from banksoal/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'banksoal/list.html', 48, false),)), $this); ?>
      <script>
      	function chagestatus(id, status)
      	{
      		f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/changestatus/" + id + "/" + status + "/<?php echo $this->_tpl_vars['pageid']; ?>
", "frmtemp", "status"+id, "Updating...", 
      			function(data)
      			{      				
      				document.frmtemp.submit();
      			}
      		);      			
      	}
      </script>

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php echo $this->_tpl_vars['lbanksoal_list_training']; ?>
</h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bank Soal</a></li>
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
 <a href="#" onclick="javascript:sortby('banksoal_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'banksoal_name'): ?>class="lite"<?php endif; ?>>NAME</a> | <a href="#" onclick="javascript:sortby('banksoal_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'banksoal_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/form/<?php echo $this->_tpl_vars['banksoal_type']; ?>
"><?php echo $this->_tpl_vars['date_added']; ?>
</a>
                  </div>
                  <hr>
                  <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                      <th width="60%"><a href="#" onclick="javascript:sortby('banksoal_name', 'asc')" class="thead" title="sort topics by code"><?php echo $this->_tpl_vars['lbank_soal1']; ?>
</a></th>
                      <!--<th width="20%"><?php echo $this->_tpl_vars['ljumlah_soal']; ?>
</th>-->
                      <th><div class="listmain"><a href="#" onclick="javascript:sortby('directorat_status', 'asc')" class="thead" title="sort by topic STATUS"><?php echo $this->_tpl_vars['status']; ?>
</a></div></th>
                      <th width="10%">&nbsp;</th>
                      <th width="10%">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                    <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                    <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                    <?php if ($this->_tpl_vars['banksoal_type'] == 'training'): ?>
                    <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/formedit/<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
"><?php echo $this->_tpl_vars['row']->banksoal_name; ?>
</a></td>
                    <?php else: ?>
                    <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/form/certificate/<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
"><?php echo $this->_tpl_vars['row']->banksoal_name; ?>
</a></td>
                    <?php endif; ?>
                    <!--<td class="odd"><?php echo $this->_tpl_vars['row']->jumlahsoal; ?>
</td>-->
                    <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
,<?php echo $this->_tpl_vars['row']->banksoal_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->banksoal_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->banksoal_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->banksoal_status_desc; ?>
" /></a></div></td>
                    <?php if ($this->_tpl_vars['row']->used): ?>
                    <td>&nbsp;</td>
                    <?php else: ?>
                    <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/remove/<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
/<?php echo $this->_tpl_vars['banksoal_type']; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['row']->banksoal_type == 2): ?>
                    <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/history/<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
"><?php echo $this->_tpl_vars['lhistory']; ?>
</a></td>
                    <?php else: ?>
                    <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/historytraining/<?php echo $this->_tpl_vars['row']->banksoal_id; ?>
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

<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/<?php echo $this->_tpl_vars['banksoal_type']; ?>
">
	<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
	<input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
	<input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
	<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
</form>