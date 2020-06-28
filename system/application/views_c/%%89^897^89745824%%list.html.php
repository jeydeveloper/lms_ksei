<?php /* Smarty version 2.6.26, created on 2018-11-13 14:31:17
         compiled from trainingreport/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'trainingreport/list.html', 155, false),)), $this); ?>
	<script>
			$(document).ready(
				function()
				{
					$("#linkexport").click(
						function()
						{
							$("#isexport").val(1);
							$("#frmsearch").submit();
                            $("#isexport").val(0);
						}
					);

					$("#btnsearch").click(
						function()
						{
							$("#isexport").val(0);
							$("#frmsearch").submit();
						}
					);
					
					
					$("a[id=linksortby]").click(
						function()
						{
							var ref = $(this).attr("href").substring(1);
							
							$("#sortby").val(ref)
							if (ref != $("#sortby").val())
							{								
								$("#orderby").val("asc");
							}
							else
							if ($("#orderby").val() == "desc")
							{
								$("#orderby").val("asc");
							}
							else
							{
								$("#orderby").val("desc");
							}
							
							$("#frmsearch").submit();
						}
					);					
				}
			);
		
			function changelimit(elmt)
			{
				$("#limit").val(elmt.value)
				$("#frmsearch").submit();
			}

			function page(n)
			{
				if (! n) n = 0;

				$("#offset").val(n);
				$("#frmsearch").submit();
			}
	</script>

	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1><?php echo $this->_tpl_vars['learning_topics_list']; ?>
</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="#">Training Report</a></li>
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
 <a href="#training_code" id="linksortby" <?php if ($this->_tpl_vars['sortby'] == 'training_code'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lcode']; ?>
</a> | <a href="#training_name" id="linksortby" <?php if ($this->_tpl_vars['sortby'] == 'training_name'): ?>class="lite"<?php endif; ?>><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate']; ?>
<?php endif; ?></a> | <a href="#" id="linkexport"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
							</div>
							<div class="mg-btm-10">
                                <form name="frmtemp" id="frmsearch" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport">
                                    <input type="hidden" name="limit" id="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
                                    <input type="hidden" name="offset" id="offset" value="0" />
                                    <input type="hidden" name="sortby" id="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
                                    <input type="hidden" name="orderby" id="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
                                    <input type="hidden" name="isexport" id="isexport" value="" />
									<div class="row">
										<div class="col-xs-3">
											<?php echo $this->_tpl_vars['lsearch_by']; ?>

										</div>
										<div class="col-xs-3">
                                            <select class="form-control" name="searchby" id="searchby">
                                                <option value="training_code"<?php if ($this->_tpl_vars['searchby'] == 'training_code'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lcode']; ?>
</option>
                                                <option value="training_name"<?php if ($this->_tpl_vars['searchby'] == 'training_name'): ?> selected<?php endif; ?>><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate']; ?>
<?php endif; ?></option>
                                            </select>
										</div>
										<div class="col-xs-3">
                                            <input class="form-control" type='text' name="keyword" id="keyword" class='formdefault' value="<?php echo $this->_tpl_vars['keyword']; ?>
">
										</div>
										<div class="col-xs-3">
											<input id="btnsearch" class="btn btn-primary" type='submit' value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 ">
										</div>
									</div>
								</form>
							</div>
							<hr>
							<table class="table table-hover table-striped">
								<thead>
                                <tr>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>5<?php else: ?>10<?php endif; ?>%" valign="top">
                                    <a href="#training_code" id="linksortby" class="thead">
                                        <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                        <?php echo $this->_tpl_vars['ltraining_code']; ?>

                                        <?php else: ?>
                                        <?php echo $this->_tpl_vars['lcertificate_code']; ?>

                                        <?php endif; ?>
                                    </a></th>
                                    <th valign="top">
                                        <a href="#training_name" id="linksortby" class="thead">
                                            <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                            <?php echo $this->_tpl_vars['ltraining_name']; ?>

                                            <?php else: ?>
                                            <?php echo $this->_tpl_vars['lcertificate_name']; ?>

                                            <?php endif; ?>
                                        </a>
                                    </th>
                                    <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lpraexam_participant_accessed']; ?>
</th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lpraexam_participant_accessed_percent']; ?>
</th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lpraexam_participant_not_accessed_percent']; ?>
</th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lmaterial_participant_accessed']; ?>
</th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lmaterial_participant_accessed_percent']; ?>
</th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lmaterial_participant_not_accessed_percent']; ?>
</th>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lexam_participant_accessed']; ?>
</th>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lexam_participant_accessed_percent']; ?>
</th>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lexam_participant_not_accessed_percent']; ?>
</th>
                                    <?php else: ?>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lcertification_participant_accessed']; ?>
</th>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lcertification_participant_accessed_percent']; ?>
</th>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lcertification_participant_not_accessed']; ?>
</th>
                                    <th width="<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>8<?php else: ?>20<?php endif; ?>%" valign="top"><?php echo $this->_tpl_vars['lcertification_participant_not_accessed_percent']; ?>
</th>
                                    <?php endif; ?>
                                </tr>
								</thead>
								<tbody>
                                <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                                <?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                                <tr>
                                    <td class="odd"><?php echo $this->_tpl_vars['row']->training_code; ?>
</td>
                                    <td class="odd"><?php echo $this->_tpl_vars['row']->training_name; ?>
</td>
                                    <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->npraexam; ?>
</td>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/praexam/<?php echo $this->_tpl_vars['row']->training_id; ?>
/<?php echo $this->_tpl_vars['status']; ?>
"><?php echo $this->_tpl_vars['row']->pctpraexam; ?>
</a></td>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/nopraexam/<?php echo $this->_tpl_vars['row']->training_id; ?>
/-1"><?php echo $this->_tpl_vars['row']->pctnopraexam; ?>
</a></td>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->nmaterial; ?>
</td>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/material/<?php echo $this->_tpl_vars['row']->training_id; ?>
/-1"><?php echo $this->_tpl_vars['row']->pctmaterial; ?>
</a></td>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/nomaterial/<?php echo $this->_tpl_vars['row']->training_id; ?>
/-1"><?php echo $this->_tpl_vars['row']->pctnomaterial; ?>
</a></td>
                                    <?php endif; ?>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->nexam; ?>
</td>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/exam/<?php echo $this->_tpl_vars['row']->training_id; ?>
/<?php echo $this->_tpl_vars['status']; ?>
"><?php echo $this->_tpl_vars['row']->pctexam; ?>
</a></td>
                                    <?php if ($this->_tpl_vars['pageid'] != 'training'): ?>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->nnoexam; ?>
</td>
                                    <?php endif; ?>
                                    <td class="odd" style="text-align: right"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/noexam/<?php echo $this->_tpl_vars['row']->training_id; ?>
/-1"><?php echo $this->_tpl_vars['row']->pctnoexam; ?>
</a></td>
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