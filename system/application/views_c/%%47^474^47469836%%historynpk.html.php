<?php /* Smarty version 2.6.26, created on 2018-11-13 14:26:53
         compiled from certificate/historynpk.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'certificate/historynpk.html', 67, false),)), $this); ?>
          <script>
          	function search()
          	{
          		$("#offset").val(0);
          		$("#searchby").val($("#_searchby").val());
          		$("#keyword").val($("#_keyword").val());
          		
          		document.frmtemp.submit();
          		return false;
          	}
          </script>

          <div class="content-wrapper">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>
                      <?php echo $this->_tpl_vars['lhistory']; ?>
 &quot;<?php echo $this->_tpl_vars['hist']->training_name; ?>
&quot;
                  </h1>
                  <ol class="breadcrumb">
                      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                      <li><a href="#">Training</a></li>
                      <li class="active">History NPK</li>
                  </ol>
              </section>

              <!-- Main content -->
              <section class="content">
                  <div class="row">
                      <div class="col-xs-12">
                          <div class="box">
                              <div class="box-body table-responsive">
                                  <?php $this->assign('total', 0); ?>
                                  <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row1']):
?>
                                  <?php $this->assign('total', $this->_tpl_vars['total']+1); ?>
                                  <?php endforeach; endif; unset($_from); ?>
                                  <?php if ($this->_tpl_vars['hist']->training_time_date1_fmt): ?>
                                  <h3><?php echo $this->_tpl_vars['lperiod']; ?>
: <?php echo $this->_tpl_vars['hist']->training_time_date1_fmt; ?>
 <?php echo $this->_tpl_vars['luntil']; ?>
 <?php echo $this->_tpl_vars['hist']->training_time_date2_fmt; ?>
</h3>
                                  <br />
                                  <?php endif; ?>
                                  <?php if ($this->_tpl_vars['jabatan']): ?>
                                  <h3><?php echo $this->_tpl_vars['ljabatan']; ?>
: <?php echo $this->_tpl_vars['jabatan']->jabatan_name; ?>
</h3>
                                  <br />
                                  <?php endif; ?>
                                  <form onsubmit="javascript:return search()" method="post" action="">
                                      <p><?php echo $this->_tpl_vars['lsearch_by']; ?>

                                          <select name="_searchby" id="_searchby">
                                              <option value="user_npk"><?php echo $this->_tpl_vars['lnpk']; ?>
</option>
                                              <option value="user_name"><?php echo $this->_tpl_vars['lname']; ?>
</option>
                                          </select>
                                          <input type='text' name="_keyword" id="_keyword" class='formdefault' value="<?php echo $_POST['keyword']; ?>
">
                                          <input type='submit' value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 ">
                                      </p>
                                  </form>
                                  <b><?php echo $this->_tpl_vars['ltotal']; ?>
</b>: <?php echo $this->_tpl_vars['total_rows']; ?>

                                  <table class="table table-hover table-striped">
                                      <thead>
                                      <tr>
                                          <th width="20%"><?php echo $this->_tpl_vars['lnpk']; ?>
</th>
                                          <th width="30%"><?php echo $this->_tpl_vars['lname']; ?>
</th>
                                          <th style="text-align: right"><?php echo $this->_tpl_vars['ltimetakes']; ?>
</th>
                                          <?php if ($this->_tpl_vars['pageid'] == 'certificate' || $this->_tpl_vars['pageid'] == 'training'): ?>
                                          <th width="14%">&nbsp;</th>
                                          <?php endif; ?>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                                      <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                      <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                                      <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historydetail/<?php echo $this->_tpl_vars['hist']->training_id; ?>
/<?php echo $this->_tpl_vars['row']->user_id; ?>
"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</a></td>
                                      <td class="odd"><?php echo $this->_tpl_vars['row']->user->user_first_name; ?>
 <?php echo $this->_tpl_vars['row']->user->user_last_name; ?>
</td>
                                      <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->total; ?>
</td>
                                      <?php if ($this->_tpl_vars['pageid'] == 'certificate' || $this->_tpl_vars['pageid'] == 'training'): ?>
                                      <td class="odd" style="text-align: center;"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/exportPersonal/<?php echo $this->_tpl_vars['hist']->training_id; ?>
/<?php echo $this->_tpl_vars['row']->user_id; ?>
">export</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/resetter/<?php if ($this->_tpl_vars['hist']->training_time_training): ?><?php echo $this->_tpl_vars['hist']->training_time_training; ?>
<?php else: ?>0<?php endif; ?>/<?php if ($this->_tpl_vars['hist']->training_time_id): ?><?php echo $this->_tpl_vars['hist']->training_time_id; ?>
<?php else: ?>0<?php endif; ?>/<?php if ($this->_tpl_vars['hist']->user_jabatan): ?><?php echo $this->_tpl_vars['hist']->user_jabatan; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->user_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['lreset_per_npk']; ?>
')"><?php echo $this->_tpl_vars['lreset']; ?>
</a></td>
                                      <?php endif; ?>
                                      </tr>
                                      <?php echo smarty_function_counter(array(), $this);?>

                                      <?php endforeach; endif; unset($_from); ?>
                                      </tbody>
                                      <tfoot>
                                      <tr>
                                          <td colspan="4"><?php echo $this->_tpl_vars['paging']; ?>
</td>
                                      </tr>
                                      </tfoot>
                                  </table>
                                  <br />
                                  <form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['url']; ?>
">
                                      <input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
                                      <input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
                                      <input type="hidden" id="searchby" name="searchby" value="<?php echo $_POST['searchby']; ?>
" />
                                      <input type="hidden" id="keyword" name="keyword" value="<?php echo $_POST['keyword']; ?>
" />
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </section>
          </div>