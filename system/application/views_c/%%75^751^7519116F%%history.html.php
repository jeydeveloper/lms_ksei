<?php /* Smarty version 2.6.26, created on 2020-04-14 11:13:54
         compiled from training/history.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/history.html', 57, false),)), $this); ?>
      <script>
      	function user_onchange(elmt)
      	{      		
      		$("#userid").val(elmt.value);
      		document.frmtemp.submit();
      	}
      </script>


      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  <?php echo $this->_tpl_vars['lmypersonal_report']; ?>

              </h1>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="#">Training</a></li>
                  <li class="active">Exam Intro</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="box">
                          <div class="box-body table-responsive">
                              <?php echo $this->_tpl_vars['lsort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('training_code', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'training_code'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lcode']; ?>
</a> | <a href="#" onclick="javascript:sortby('training_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'training_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lname']; ?>
</a>
                              | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/importhistory/"><?php echo $this->_tpl_vars['limport']; ?>
</a>
                              <br />
                              <br />

                              <?php if (( $this->_tpl_vars['sess']['user_type'] == 0 ) && $this->_tpl_vars['sess']['asadmin']): ?>
                              <form>
                                  <?php echo $this->_tpl_vars['luser']; ?>
&nbsp;&nbsp;
                                  <select name="user" class='formdefault' onchange="javascript:user_onchange(this)">
                                      <!--<option value="">-- <?php echo $this->_tpl_vars['lall_user']; ?>
 ---</option>-->
                                      <?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
                                      <option value="<?php echo $this->_tpl_vars['user']->user_id; ?>
"<?php if ($this->_tpl_vars['userid'] == $this->_tpl_vars['user']->user_id): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['user']->user_npk; ?>
 ( <?php echo $this->_tpl_vars['user']->user_first_name; ?>
 <?php echo $this->_tpl_vars['user']->user_last_name; ?>
 )</option>
                                      <?php endforeach; endif; unset($_from); ?>
                                  </select>
                              </form>
                              <br />&nbsp;
                              <?php endif; ?>
                              <table class="table table-hover table-striped">
                                  <thead>
                                  <tr>
                                      <th width="12%"><a href="#" onclick="javascript:sortby('training_code', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_code']; ?>
"><?php echo $this->_tpl_vars['lcode']; ?>
</a></th>
                                      <th><a href="#" onclick="javascript:sortby('training_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_name']; ?>
"><?php echo $this->_tpl_vars['ltraining_column']; ?>
</a></th>
                                      <th width="20%"><?php echo $this->_tpl_vars['ltimetakes']; ?>
</th>
                                      <th width="20%"><?php echo $this->_tpl_vars['llasttake']; ?>
</th>
                                      <?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
                                      <th width="25%"><?php echo $this->_tpl_vars['llastscore']; ?>
</th>
                                      <?php endif; ?>
                                  </tr>
                                  <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                                  <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                  <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                                  <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['page']; ?>
/historydetail/<?php echo $this->_tpl_vars['row']->training_id; ?>
<?php if ($this->_tpl_vars['userid']): ?>/<?php echo $this->_tpl_vars['userid']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['row']->category_code; ?>
</a></td>
                                  <td><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['page']; ?>
/historydetail/<?php echo $this->_tpl_vars['row']->training_id; ?>
<?php if ($this->_tpl_vars['userid']): ?>/<?php echo $this->_tpl_vars['userid']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['row']->training_name; ?>
</a></td>
                                  <td align="right"><?php echo $this->_tpl_vars['row']->nexam_praexam; ?>
</td>
                                  <td align="center"><?php echo $this->_tpl_vars['row']->history_exam_type; ?>
<?php echo $this->_tpl_vars['row']->lasttaken; ?>
</td>
                                  <?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
                                  <td align="center"><?php echo $this->_tpl_vars['row']->lastscoreexam; ?>
 / <?php echo $this->_tpl_vars['row']->bestscoreexam; ?>
</td>
                                  <?php endif; ?>
                                  </tr>
                                  <?php echo smarty_function_counter(array(), $this);?>

                                  <?php endforeach; endif; unset($_from); ?>

                                  </thead>
                                  <tbody>
                                  </tbody>
                                  <tr>
                                      <td colspan="5">&nbsp;</td>
                                  </tr>
                                  <tfoot>
                                  <tr>
                                      <td colspan="5"><?php echo $this->_tpl_vars['paging']; ?>
</td>
                                  </tr>
                                  </tfoot>
                              </table>
                              <br />
                              <form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/history/">
                                  <input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
                                  <input type="hidden" id="sortby" name="sortby" value="<?php echo $_POST['sortby']; ?>
" />
                                  <input type="hidden" id="orderby" name="orderby" value="<?php echo $_POST['orderby']; ?>
" />
                                  <input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
                                  <input type="hidden" id="userid" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
" />
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      </div>