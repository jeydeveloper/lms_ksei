<?php /* Smarty version 2.6.26, created on 2018-11-13 14:26:55
         compiled from training/historydetail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/historydetail.html', 83, false),)), $this); ?>
      <script>
      		<?php if ($this->_tpl_vars['show_print'] == 1): ?>
      		function cetak(id)
      		{
      			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/printcertificate", {id: id, isajax: 1},
      				function (data)
      				{
      					if (data.err > 0)
      					{
      						location = data.redirect;
      						return;
      					}
      					
      					window.open(data.url, 'materiwin2', 'menubar=no, toolbar=no, location=no, status=no,scrollbars=1 ,width=780,height=590"');
      				}
      				, "json"
      			);
      		}
      		<?php endif; ?>
      		
      		function jawaban(id)
      		{
      			/*window.open('<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['page']; ?>
/historyjawaban/'+id, 'jawabanwin'+id, 'menubar=no, toolbar=no, location=no, status=no,scrollbars=1 ,width=780,height=590"');*/
                $.post("<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['page']; ?>
/historyjawaban/"+id, {dialog: 1, noheader: 1},
                    function (data)
                    {
                        console.log('test');
                        $("#dialogcontent").html(data);
                        $('#modal-default').modal('show');
                    }
                );
      		}
      </script>

      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <?php if ($this->_tpl_vars['sess']['asadmin']): ?>
              <h1><?php echo $this->_tpl_vars['lhistory']; ?>
: <?php echo $this->_tpl_vars['mytraining']->training_name; ?>
</h1>
              <?php else: ?>
              <h1><?php echo $this->_tpl_vars['lmypersonal_report']; ?>
: <?php echo $this->_tpl_vars['mytraining']->training_name; ?>
</h1>
              <?php endif; ?>
              <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="#">Training</a></li>
                  <li class="active">History Detail</li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">
              <div class="row">
                  <div class="col-xs-12">
                      <div class="box">
                          <div class="box-body table-responsive">
                              <?php if ($this->_tpl_vars['rowuser']): ?>
                              <h3><?php echo $this->_tpl_vars['lnpk']; ?>
: <?php echo $this->_tpl_vars['rowuser']->user_npk; ?>
</h3>
                              <?php endif; ?>
                              <table class="table table-hover table-striped">
                                  <thead>
                                  <tr>
                                      <?php if ($this->_tpl_vars['hasrefreshment']): ?>
                                      <th width="5%">&nbsp;</th>
                                      <?php endif; ?>
                                      <th width="23%"><?php echo $this->_tpl_vars['ldate']; ?>
</th>
                                      <?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
                                      <th width="20%"><?php echo $this->_tpl_vars['lscore']; ?>
</th>
                                      <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                      <th width="20%"><?php echo $this->_tpl_vars['lactivity']; ?>
</th>
                                      <?php endif; ?>
                                      <th><?php echo $this->_tpl_vars['lstatus']; ?>
</th>
                                      <?php else: ?>
                                      <th><?php echo $this->_tpl_vars['llokasi']; ?>
</th>
                                      <?php endif; ?>
                                      <th>NO NPB</th>
                                      <th>KODE PROG.</th>
                                      <th>DURASI HARI</th>
                                      <th>DURASI JAM</th>
                                      <th width="12%">&nbsp;</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                                  <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                  <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                                  <?php if ($this->_tpl_vars['hasrefreshment']): ?>
                                  <?php if ($this->_tpl_vars['row']->isrefreshment): ?>
                                  <td>R</td>
                                  <?php else: ?>
                                  <td>&nbsp;</td>
                                  <?php endif; ?>
                                  <?php endif; ?>
                                  <td><?php echo $this->_tpl_vars['row']->datetime; ?>
</td>
                                  <?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
                                  <td><a href="javascript:jawaban(<?php echo $this->_tpl_vars['row']->history_exam_id; ?>
)"><?php echo $this->_tpl_vars['row']->score; ?>
</a></td>
                                  <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                  <td><?php echo $this->_tpl_vars['row']->activity; ?>
</td>
                                  <?php endif; ?>
                                  <td><?php echo $this->_tpl_vars['row']->status; ?>
</td>
                                  <?php else: ?>
                                  <td><?php echo $this->_tpl_vars['row']->lokasi_alamat; ?>
, <?php echo $this->_tpl_vars['row']->lokasi_kota; ?>
</td>
                                  <?php endif; ?>
                                  <td><?php echo $this->_tpl_vars['row']->history_exam_nonpb; ?>
</td>
                                  <td><?php echo $this->_tpl_vars['row']->history_exam_kodeprog; ?>
</td>
                                  <td><?php echo $this->_tpl_vars['row']->history_exam_durhari; ?>
</td>
                                  <td><?php echo $this->_tpl_vars['row']->history_exam_durjam; ?>
</td>
                                  <?php if ($this->_tpl_vars['row']->history_exam_status == 1 && ( $this->_tpl_vars['row']->history_exam_type == 2 || $this->_tpl_vars['row']->history_exam_type == 3 )): ?>

                                  <td><?php if ($this->_tpl_vars['show_print'] == 1): ?><a href="javascript:cetak(<?php echo $this->_tpl_vars['row']->history_exam_id; ?>
)"><?php echo $this->_tpl_vars['lcetak']; ?>
<?php else: ?> &nbsp; <?php endif; ?></a>
                                  </td>

                                  <?php else: ?>
                                  <td>&nbsp;</td>
                                  <?php endif; ?>
                                  </tr>
                                  <?php echo smarty_function_counter(array(), $this);?>

                                  <?php endforeach; endif; unset($_from); ?>
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                      <td colspan="9">&nbsp;</td>
                                  </tr>
                                  </tfoot>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
      </div>

      <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form id="frmexportype">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">History NPK</h4>
                      </div>
                      <div class="modal-body text-center">
                          <div id="dialogcontent"></div>
                      </div>
                      <!--<div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      </div>-->
                  </form>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->