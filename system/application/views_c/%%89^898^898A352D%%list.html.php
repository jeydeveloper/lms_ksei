<?php /* Smarty version 2.6.26, created on 2018-11-13 14:31:27
         compiled from activities/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'activities/list.html', 116, false),)), $this); ?>
<script>
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
	
	$(document).ready(
		function()
		{
			$("a[id=linksort]").each(
				function()
				{
					$(this).click(
						function()
						{
							var ref = $(this).attr("href").substring(1);							
							if ($("#sortby").val() == ref)
							{
								if ($("#orderby").val() == "desc")
								{
									$("#orderby").val("asc");
								}
								else
								{
									$("#orderby").val("desc");
								}
							}
							else
							{
								$("#orderby").val("asc");;
								$("#sortby").val(ref);
							}
							
							$("#isexport").val(0);
							
							document.frmtemp.submit();
							return false;
						}
					)
					
					$("#linkexport").click(
						function()
						{
							$("#isexport").val(1);
							document.frmtemp.submit();							
							return false;
						}
					);
				}
			)
		}
	);
	
	function page(n)
	{
		if (! n) n = 0;
		
		$("#isexport").val(0);
		$("#offset").val(n);
		document.frmtemp.submit();
	}       	
	
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $this->_tpl_vars['luser_activities']; ?>
: <?php echo $this->_tpl_vars['user']->user_first_name; ?>
 <?php echo $this->_tpl_vars['user']->user_last_name; ?>
(<?php echo $this->_tpl_vars['user']->user_npk; ?>
)</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Activities</a></li>
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
                        <p><?php echo $this->_tpl_vars['lheader_list_level']; ?>
</p>
                        <div class="mg-btm-10">
                            <a href="#" id="linkexport"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
                        </div>
                        <hr>
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th width="25%"><a id="linksort" href="#history_exam_date|history_exam_time" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_date']; ?>
"><?php echo $this->_tpl_vars['ldate']; ?>
</a></th>
                                <th width="12%"><?php echo $this->_tpl_vars['lcode']; ?>
</th>
                                <th><a id="linksort" href="#training_name" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_training_name']; ?>
"><?php echo $this->_tpl_vars['ltraingname']; ?>
</a></th>
                                <th width="10%"><?php echo $this->_tpl_vars['ltype']; ?>
</th>
                                <th width="8%"><?php echo $this->_tpl_vars['lactivity']; ?>
</th>
                                <th width="5%"><a id="linksort" href="#history_exam_score|history_exam_date|history_exam_time" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_score']; ?>
"><?php echo $this->_tpl_vars['lscore']; ?>
</a></th>
                                <th width="10%"><?php echo $this->_tpl_vars['lstatus']; ?>
</th>
                                <th> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['histories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                            <td class="odd" style="text-align: left;">
                                <!-- <?php echo $this->_tpl_vars['row']->history_exam_datetime_str; ?>
 s/d <?php echo $this->_tpl_vars['row']->history_exam_startdatetime_str; ?>
-->
                                <?php echo $this->_tpl_vars['row']->exam_date; ?>

                            </td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->training_code; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->training_name; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->history_exam_type_desc; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->activity; ?>
</td>
                            <td class="odd" style="text-align: right;"><?php echo $this->_tpl_vars['row']->history_exam_score_fmt; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->history_exam_status_str; ?>
</td>
                            <td>
                                <?php if ($this->_tpl_vars['row']->history_exam_status == 1 && ( $this->_tpl_vars['row']->history_exam_type == 2 || $this->_tpl_vars['row']->history_exam_type == 3 )): ?>
                                <a href="javascript:cetak(<?php echo $this->_tpl_vars['row']->history_exam_id; ?>
)"><?php echo $this->_tpl_vars['lcetak']; ?>
</a>
                                <?php endif; ?>
                            </td>
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
/activities/detail/<?php echo $this->_tpl_vars['user']->user_id; ?>
">
	<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
	<input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
" />
	<input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
" />
	<input type="hidden" id="offset" name="offset" value="0" />
	<input type="hidden" id="isexport" name="isexport" value="" />
</form>