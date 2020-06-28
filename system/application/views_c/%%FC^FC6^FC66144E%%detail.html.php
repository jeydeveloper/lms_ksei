<?php /* Smarty version 2.6.26, created on 2020-04-14 11:10:13
         compiled from trainingreport/detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'trainingreport/detail.html', 168, false),)), $this); ?>
 	<link type="text/css" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/themes/base/ui.all.css" rel="stylesheet" /> 
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/external/bgiframe/jquery.bgiframe.js"></script> 
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.core.js"></script> 
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.draggable.js"></script> 
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.resizable.js"></script> 
	<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.dialog.js"></script> 	
	<script>
			$(document).ready(
				function()
				{
					$("#linkexport").click(
						function()
						{
							$("#isexport").val(1);
							$("#frmsearch").submit();
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
							
							$("#isexport").val(0);
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
				$("#isexport").val(0);
				$("#limit").val(elmt.value)
				$("#frmsearch").submit();
			}
			
			function page(n)
			{
				if (! n) n = 0;
				
				$("#isexport").val(0);
				$("#offset").val(n);
				$("#frmsearch").submit();
			}			
	</script>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo $this->_tpl_vars['learning_topics_list']; ?>

            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Training Report</a></li>
                <li class="active">Show list</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body table-responsive">
                            <?php if ($this->_tpl_vars['status'] != -1): ?>
                            <h2><?php echo $this->_tpl_vars['lstatus']; ?>
: <?php if ($this->_tpl_vars['status'] == 1): ?><?php echo $this->_tpl_vars['llulus']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lnolulus']; ?>
<?php endif; ?></h2>
                            <?php endif; ?>
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#user_npk" id="linksortby" <?php if ($this->_tpl_vars['sortby'] == 'user_npk'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lnpk']; ?>
</a> | <a href="#user_name" id="linksortby" <?php if ($this->_tpl_vars['sortby'] == 'user_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lname']; ?>
</a> | <a href="#" id="linkexport"><?php echo $this->_tpl_vars['lexport']; ?>
</a> </p>
                            <form id="frmsearch" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/summaryreport/<?php echo $this->_tpl_vars['subpageex']; ?>
/<?php echo $this->_tpl_vars['id']; ?>
/-1">
                                <table class="table">
                                    <tr>
                                        <td width="8%"><?php echo $this->_tpl_vars['lsearch_by']; ?>
</td>
                                        <td>
                                            <select name="searchby" id="searchby">
                                                <option value="user_npk"<?php if ($this->_tpl_vars['searchby'] == 'user_npk'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lnpk']; ?>
</option>
                                                <option value="user_name"<?php if ($this->_tpl_vars['searchby'] == 'user_name'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lname']; ?>
</option>
                                            </select>
                                            <input type='text' name="keyword" id="keyword" class='formdefault' value="<?php echo $this->_tpl_vars['keyword']; ?>
">
                                        </td>
                                    </tr>
                                    <?php if ($this->_tpl_vars['subpageex'] == 'exam' || $this->_tpl_vars['subpageex'] == 'praexam'): ?>
                                    <tr>
                                        <td><?php echo $this->_tpl_vars['lstatus']; ?>
</td>
                                        <td>
                                            <?php if ($this->_tpl_vars['subpageex'] == 'exam'): ?>
                                            <select id="status" name="status">
                                                <option value="-1"<?php if ($this->_tpl_vars['status'] == ""): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lall']; ?>
</option>
                                                <option value="1"<?php if ($this->_tpl_vars['status'] == '1'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['llulus']; ?>
</option>
                                                <option value="0"<?php if ($this->_tpl_vars['status'] == '0'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lnolulus']; ?>
</option>
                                            </select>
                                            <?php endif; ?>
                                            <select id="status1" name="status1">
                                                <option value=""<?php if ($this->_tpl_vars['status1'] == ""): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lall']; ?>
</option>
                                                <option value="1"<?php if ($this->_tpl_vars['status1'] == '1'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lmax_score']; ?>
</option>
                                                <option value="2"<?php if ($this->_tpl_vars['status1'] == '2'): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['llast_score']; ?>
</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td><input type='button' id="btnsearch" value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 "></td>
                                    </tr>
                                </table>



                                </p>
                                <input type="hidden" name="limit" id="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
                                <input type="hidden" name="offset" id="offset" value="0" />
                                <input type="hidden" name="sortby" id="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
                                <input type="hidden" name="orderby" id="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
                                <input type="hidden" name="isexport" id="isexport" value="" />
                            </form>
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th width="5%" valign="top"><a href="#training_code" id="linksortby" class="thead"><?php echo $this->_tpl_vars['lcode']; ?>
</a></th>
                                    <th width="8%" valign="top"><?php echo $this->_tpl_vars['lnpk']; ?>
</th>
                                    <th width="20%" valign="top"><?php echo $this->_tpl_vars['lname']; ?>
</th>
                                    <?php if ($this->_tpl_vars['type']['0'] == 0): ?>
                                    <th width="12%" valign="top">Material Value</th>
                                    <th width="12%" valign="top">Material Status</th>
                                    <th width="12%" valign="top">Material Date</th>
                                    <?php elseif ($this->_tpl_vars['type']['0'] == 1): ?>
                                    <th width="12%" valign="top">Preexam Value</th>
                                    <th width="12%" valign="top">Preexam Status</th>
                                    <th width="12%" valign="top">Preexam Date</th>
                                    <?php elseif ($this->_tpl_vars['pageid'] == 'certificate'): ?>
                                    <th width="12%" valign="top">Certification Value</th>
                                    <th width="12%" valign="top">Certification Status</th>
                                    <th width="12%" valign="top">Certification Date</th>
                                    <?php else: ?>
                                    <th width="12%" valign="top">Exam Value</th>
                                    <th width="12%" valign="top">Exam Status</th>
                                    <th width="12%" valign="top">Exam Date</th>
                                    <?php endif; ?>
                                    <th width="8%" valign="top">Duration</th>
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
                                    <td class="odd"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</td>
                                    <td class="odd"><?php echo $this->_tpl_vars['row']->user_first_name; ?>
 <?php echo $this->_tpl_vars['row']->user_last_name; ?>
</td>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->history_exam_score; ?>
</td>
                                    <td class="odd"><?php echo $this->_tpl_vars['row']->history_exam_status_str; ?>
</td>
                                    <td class="odd" style="text-align: center"><?php echo $this->_tpl_vars['row']->history_exam_date_fmt; ?>
</td>
                                    <td class="odd" style="text-align: right"><?php echo $this->_tpl_vars['row']->duration; ?>
</td>
                                </tr>
                                <?php echo smarty_function_counter(array(), $this);?>

                                <?php endforeach; endif; unset($_from); ?>
                                </tbody>
                                <tr>
                                    <td colspan="7">&nbsp;</td>
                                </tr>
                                <tfoot>
                                <tr>
                                    <td colspan="7"><?php echo $this->_tpl_vars['paging']; ?>
</td>
                                </tr>
                                </tfoot>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>