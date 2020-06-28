<?php /* Smarty version 2.6.26, created on 2018-11-13 14:26:51
         compiled from certificate/history.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'certificate/history.html', 78, false),)), $this); ?>
 	<script>
      	$(document).ready(
      		function()
      		{
/*
				$("#exportdialog").dialog(
					{ 
						autoOpen: false 
						,modal: true
						,width: 550
					}
				)  
*/
      		}
      	);
      	
      	function doexport()
      	{
			var val_checked = $('input[name=exporttype]:checked', '#frmexportype').val();
			var url = "<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/historyexamexport/" + $("#training_id").val() + "/" + $("#training_time_id").val() + "/" + val_checked;

// 			$("#exportdialog").dialog("close");
			location = url;
		}
      	
      	function showexporttype(trainingid, trainingtimeid)
      	{
			$("#training_time_id").val(trainingtimeid);
			$("#training_id").val(trainingid);

			$('#modal-default').modal('show');
		}
</script>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo $this->_tpl_vars['lhistory']; ?>
 &quot;<?php echo $this->_tpl_vars['row']->training_name; ?>
&quot;
			</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Training</a></li>
				<li class="active">History</li>
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
							<?php $this->assign('total', $this->_tpl_vars['total']+$this->_tpl_vars['row1']->participant); ?>
							<?php endforeach; endif; unset($_from); ?>
							<b><?php echo $this->_tpl_vars['ltotal']; ?>
</b>:
							<?php if ($this->_tpl_vars['total']): ?>
							<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/historynpk/0/0/<?php echo $this->_tpl_vars['edit']; ?>
"><?php echo $this->_tpl_vars['total']; ?>
</a>
							<?php else: ?>
							<?php echo $this->_tpl_vars['total']; ?>

							<?php endif; ?>
							<table class="table table-hover table-striped">
								<thead>
								<tr>
									<th width="50%"><?php echo $this->_tpl_vars['lperiod']; ?>
</th>
									<th width="20%"><?php echo $this->_tpl_vars['lparticipant']; ?>
</a></th>

									<?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
									<th width="20%">&nbsp;</a></th>
									<?php endif; ?>
									<th>&nbsp;</th>

								</tr>
								</thead>
								<tbody>
								<?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

								<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
								<tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
								<td class="odd"><?php echo $this->_tpl_vars['row']->training_time_date1_fmt; ?>
 <?php if ($this->_tpl_vars['row']->training_time_date2_fmt): ?><?php echo $this->_tpl_vars['luntil']; ?>
 <?php echo $this->_tpl_vars['row']->training_time_date2_fmt; ?>
<?php endif; ?></td>
								<?php if ($this->_tpl_vars['row']->participant): ?>
								<?php if ($this->_tpl_vars['row']->training_time_id): ?>
								<td class="odd">(<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historynpk/<?php echo $this->_tpl_vars['row']->training_time_id; ?>
/0/0/list/1/1/<?php echo $this->_tpl_vars['examtype']; ?>
"><?php echo $this->_tpl_vars['row']->participant; ?>
 / <?php echo $this->_tpl_vars['row']->totparticipant; ?>
</a>)</td>
								<?php else: ?>
								<td class="odd">(<a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historynpk/0/0/<?php echo $this->_tpl_vars['row']->training_id; ?>
/list/1/1/<?php echo $this->_tpl_vars['examtype']; ?>
"><?php echo $this->_tpl_vars['row']->participant; ?>
 / <?php echo $this->_tpl_vars['row']->totparticipant; ?>
</a>)</td>
								<?php endif; ?>

								<?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
								<td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/resetter/<?php echo $this->_tpl_vars['row']->training_time_training; ?>
/<?php echo $this->_tpl_vars['row']->training_time_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['lconfirm_reset_periode']; ?>
')"><?php echo $this->_tpl_vars['lreset']; ?>
</a></td>
								<?php endif; ?>
								<?php if ($this->_tpl_vars['row']->training_time_training): ?>
								<td class="odd"><a href="javascript:showexporttype(<?php echo $this->_tpl_vars['row']->training_time_training; ?>
, <?php echo $this->_tpl_vars['row']->training_time_id; ?>
)"><?php echo $this->_tpl_vars['lexport']; ?>
</a></td>
								<?php else: ?>
								<td class="odd"><a href="javascript:showexporttype(<?php echo $this->_tpl_vars['row']->training_id; ?>
, 0)"><?php echo $this->_tpl_vars['lexport']; ?>
</a></td>
								<?php endif; ?>
								<?php else: ?>
								<td class="odd">0</td>
								<td class="odd">&nbsp;</td>
								<?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
								<td class="odd">&nbsp;</td>
								<?php endif; ?>
								<?php $this->assign('total', $this->_tpl_vars['total']+$this->_tpl_vars['row']->participant); ?>
								<?php endif; ?>
								</tr>
								<?php echo smarty_function_counter(array(), $this);?>

								<?php endforeach; endif; unset($_from); ?>

								</tbody>
								<tfoot>
								<tr>
									<?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
									<td colspan="4">&nbsp;</td>
									<?php else: ?>
									<td colspan="3">&nbsp;</td>
									<?php endif; ?>

								</tr>
								</tfoot>
							</table>
							<br />
							<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/showlist/<?php echo $this->_tpl_vars['topicid']; ?>
">
								<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
								<input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
								<input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
								<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
								<input type="hidden" id="training_id" name="training_id" value="" />
								<input type="hidden" id="training_time_id" name="training_time_id" value="" />
							</form>
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
                    <h4 class="modal-title"><?php echo $this->_tpl_vars['lexport_history']; ?>
</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-info alert-dismissible">
                        Export type
                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="1">
                                <?php echo $this->_tpl_vars['lmax_score']; ?>

                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="2" checked>
                                <?php echo $this->_tpl_vars['llast_lulus']; ?>

                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="3">
                                <?php echo $this->_tpl_vars['llast_score']; ?>

                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="button" onclick="javascript:doexport()"
                           value="<?php echo $this->_tpl_vars['lexport']; ?>
"/>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
