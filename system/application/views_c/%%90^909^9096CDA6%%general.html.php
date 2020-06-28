<?php /* Smarty version 2.6.26, created on 2019-07-04 09:45:29
         compiled from report/general.html */ ?>
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
				$("#from").datepicker({startDate: '01/01/1900', changeMonth: true, changeYear: true});
				$("#to").datepicker({startDate: '01/01/1900', changeMonth: true, changeYear: true});			
		}
	);	
	
	function frmreport_onsubmit()
	{				
		var rpttype = $("#reprottype").val();
		
		if (rpttype != "")
		{
			report(rpttype);
			return false;
		}
				
		reportAll();
		return false;
	}
	
	function report(rpttype, isall)
	{
		$("#message").html("generating..." + rpttype);
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/"+rpttype+"/rod", $("#frmreport").serialize(), 
			function(r)
			{								
				if (r.error)
				{
					$("#message").html("");
					alert(r.message);
					return false;
				}
				
				
				if (isall)
				{
					
					gReportDownloadLink += r.message + "<br />";
					gReportTypeIdx++;
					if (gReportTypeIdx >= gReportType.length)
					{
						$("#message").html(gReportDownloadLink);
						return;
					}										
					
					report(gReportType[gReportTypeIdx], true);
					return;
				}
				
				$("#message").html(r.message);
				return false;
			}
			,"json"
		);		
	}
	
	function reportAll()
	{
		gReportTypeIdx = 0;
		gReportDownloadLink = "";
		
		report(gReportType[gReportTypeIdx], true);
	}
	
	var gReportType = ["sapbankwide", "sapbydir", "sapbygroup", "sapbydept", "sapbyunit", "sapcoursecode"];
	var gReportTypeIdx;
	var gReportDownloadLink;
</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo $this->_tpl_vars['lgeneral_report']; ?>

		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Report</a></li>
			<li class="active">General</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body table-responsive">
						<form name="frmreport" method="post" id="frmreport" onsubmit="javascript: return frmreport_onsubmit()">
							<table class="table">
								<tr>
									<td width="15%">&nbsp;&nbsp;<?php echo $this->_tpl_vars['lreport_type']; ?>
</td>
									<td>
				<span id="topic_div">
					<select name="reprottype" id="reprottype" style="width: 320px;">
						<option value="">All</option>
						<option value="sapbankwide">By Bankwide</option>
						<option value="sapbydir">By Directorate</option>
						<option value="sapbygroup">By Group</option>
						<option value="sapbydept">By Department</option>
						<option value="sapbyunit">By Unit</option>
						<option value="sapcoursecode">By Course Code</option>
					</select>
				</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['lperiod']; ?>
</td>
									<td>
										<table>
											<tr>
												<td>
													<input type='text' name="from" id="from"  class="date-pick" value=""  maxlength='10'>
												</td>
												<td>
													<?php echo $this->_tpl_vars['luntil']; ?>

												</td>
												<td>
													<input type='text' name="to" id="to" class='date-pick' value="" maxlength='10'>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td valign="top" colspan="2"><div id="message"></div></td>
								</tr>
								<tr>
									<td valign="top">&nbsp;</td>
									<td valign="top"><input type="submit" value="Generate" /></td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>