<?php /* Smarty version 2.6.26, created on 2020-05-05 11:30:58
         compiled from report/certification.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'report/certification.html', 181, false),)), $this); ?>
<link type="text/css" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/css/smoothness/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/css/smoothness/ui.datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.datepicker.js"></script> 
    <script>
	$(document).ready(
		function()
		{
			category_onchange();
			
			//$("#period1").datePicker({startDate: '01/01/1900'});
			//$("#period2").datePicker({startDate: '01/01/1900'});			
			$("#period1").datepicker({startDate: '01/01/1900', changeMonth: true, changeYear: true});
				$("#period2").datepicker({startDate: '01/01/1900', changeMonth: true, changeYear: true});
				
				$('#btnSearch').click(function(e){
					e.preventDefault();
					$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/report/reportcertificationvalidation", $("#frmsearch").serialize(),
						function(r)
						{
							if (r.error)
							{
								alert(r.message);
								return false;
							}
							
							$("#isexport").val(0);
							$("#frmsearch").submit();
						}
						, "json"
					);
				});
				
				$('#btnExport').click(function(e){
					e.preventDefault();
					$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/report/reportcertificationvalidation", $("#frmsearch").serialize(),
						function(r)
						{
							if (r.error)
							{
								alert(r.message);
								return false;
							}
							
							$("#isexport").val(1);
							$("#frmsearch").submit();
						}
						, "json"
					);
				});
		}
	);
    
	function category_onchange()
	{
		$("#topic_div").html("Loading...");
		
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/getparent", {cat: $("#category").val(), isshowroot: 'yes', selectname: 'topic', parent: '', lroot:'--- <?php echo $this->_tpl_vars['lalltopic']; ?>
 ---'},
			function (data)
			{
				$("#topic_div").html(data);
			}
		);
	}    
	
	function search()
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/report/reportcertificationvalidation", $("#frmsearch").serialize(),
			function(r)
			{
				if (r.error)
				{
					alert(r.message);
					return false;
				}
				
				$("#isexport").val(0);
				$("#frmsearch").submit();
			}
			, "json"
		);
	
		return false;
	}
	
	function _export()
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/report/reportcertificationvalidation", $("#frmsearch").serialize(),
			function(r)
			{
				if (r.error)
				{
					alert(r.message);
					return false;
				}
				
				$("#isexport").val(1);
				$("#frmsearch").submit();
			}
			, "json"
		);
	
		return false;		
	}
	
    </script>


<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $this->_tpl_vars['lcertification_list']; ?>

		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Report</a></li>
			<li class="active">Certification</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body table-responsive">
						<form name="frmsearch" id="frmsearch" action="<?php echo $this->_tpl_vars['site_url']; ?>
/report/certification" method="post">
							<input type="hidden" name="isexport" id="isexport" value="" />
							<p><?php echo $this->_tpl_vars['lsearch_by']; ?>

							<table class="table">
								<tr>
									<td width="10%" class="odd"><?php echo $this->_tpl_vars['lcategory']; ?>
</td>
									<td class="odd">
										<select name="category" id="category" onchange="javascript:category_onchange()">
											<option value="">--- <?php echo $this->_tpl_vars['lallcategory']; ?>
 ---</option>
											<?php echo $this->_tpl_vars['category_tree']; ?>

										</select>
									</td>
								</tr>
								<tr>
									<td class="odd"><?php echo $this->_tpl_vars['ltopic']; ?>
</td>
									<td class="odd">
										<span id="topic_div"></span>
									</td>
								</tr>
								<tr>
									<td class="odd"><?php echo $this->_tpl_vars['lperiod']; ?>
</td>
									<td class="odd">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td><input type='text' name="period1" id="period1"  class="date-pick" value="<?php echo $_POST['period1']; ?>
"  maxlength='10'></td>
												<td><?php echo $this->_tpl_vars['luntil']; ?>
</td>
												<td><input type='text' name="period2" id="period2"  class="date-pick" value="<?php echo $_POST['period2']; ?>
"  maxlength='10'></td>
											</tr>
										</table>
									</td>
								</tr>

							</table>
							<p>
								<input id="btnSearch" type='submit' value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 ">
								<input id="btnExport" type='button' value=" <?php echo $this->_tpl_vars['lexport']; ?>
 ">
							</p>
						</form>
						<br />
						<table class="table table-hover table-striped">
							<thead>
							<tr>
								<th width="3%">No</th>
								<th width="11%"><?php echo $this->_tpl_vars['ldate']; ?>
</th>
								<th width="18%"><?php echo $this->_tpl_vars['lcertificate_no']; ?>
</th>
								<th width="8%"><?php echo $this->_tpl_vars['lnpk']; ?>
</th>
								<th width="21%"><?php echo $this->_tpl_vars['lname']; ?>
</th>
								<th width="7%"><?php echo $this->_tpl_vars['ltopic_code']; ?>
</th>
								<th width="14%"><?php echo $this->_tpl_vars['ltopic']; ?>
</th>
								<th align="center"><?php echo $this->_tpl_vars['ltraining_name']; ?>
<br />/<br /><?php echo $this->_tpl_vars['lcertificate_name']; ?>
</th>
							</tr>
							</thead>
							<tbody>
							<?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

							<?php $_from = $this->_tpl_vars['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
							<tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
							<td class="odd"><?php echo $this->_tpl_vars['no']+$this->_tpl_vars['offset']; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->history_exam_date_fmt; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->history_exam_no_fmt; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->user_npk; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->user_first_name; ?>
 <?php echo $this->_tpl_vars['row']->user_last_name; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->category_code; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->category_name; ?>
 </td>
							<td class="odd"><?php echo $this->_tpl_vars['row']->training_name; ?>
 </td>
							</tr>
							<?php echo smarty_function_counter(array(), $this);?>

							<?php endforeach; endif; unset($_from); ?>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="8"><?php echo $this->_tpl_vars['paging']; ?>
</td>
							</tr>
							</tfoot>
						</table>
						<br />
						<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/report/certification">
							<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
							<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
							<input type="hidden" id="category" name="category" value="<?php echo $this->_tpl_vars['category']; ?>
" />
							<input type="hidden" id="topic" name="topic" value="<?php echo $this->_tpl_vars['topic']; ?>
" />
							<input type="hidden" id="period1" name="period1" value="<?php echo $this->_tpl_vars['period1']; ?>
" />
							<input type="hidden" id="period2" name="period2" value="<?php echo $this->_tpl_vars['period2']; ?>
" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>