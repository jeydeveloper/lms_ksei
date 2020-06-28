<?php /* Smarty version 2.6.26, created on 2018-12-12 15:12:40
         compiled from training/praexam.html */ ?>
<!--<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete/jquery.autocomplete.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete/jquery.autocomplete.js"></script>-->

<link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete3/easy-autocomplete.min.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/autocomplete3/jquery.easy-autocomplete.min.js"></script>
	
	<script>
		$(document).ready(
			function()
			{	
				<?php if ($this->_tpl_vars['praexam_banksoal_checked']): ?>
					document.frmtraining.praexam.checked = true;
					$("#dvpraexam").show();
					$("#dvpramax").show();
					$("#dvpraexampass").show();					
					$("#dvprajmlsoal").show();
					$("#praAllDuration").show();
					$("#praEachDuration").show();
				<?php endif; ?>
				
				<?php if ($this->_tpl_vars['exam_banksoal_checked']): ?>
					document.frmtraining.exam.checked = true;
					$("#dvexam").show();
					$("#dvmax").show();
					$("#dvexampass").show();
					$("#dvjmlsoal").show();
					$("#allDuration").show();
					$("#eachDuration").show();
				<?php endif; ?>

                    var options = {

                        url: function(phrase) {
                            return "<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/getlist";
                        },

                        getValue: function(element) {
                            return element.name;
                        },

                        ajaxSettings: {
                            dataType: "json",
                            method: "POST",
                            data: {
                                type: 1
                            }
                        },

                        preparePostData: function(data) {
                            data.phrase = $("#example-ajax-post").val();
                            return data;
                        },

                        requestDelay: 200
                    };

                    $("#_praexam").easyAutocomplete(options);
                    $("#_exam").easyAutocomplete(options);

				
			    	/*$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/getlist", {type: 1},
			    		function (data)
			    		{
			    			var datas = data.split("\1");
			    			
			    			$("#_praexam").autocomplete(datas);
			    			$("#_exam").autocomplete(datas);
			    		}
			    	);*/
			}
		);
		
		function praexam_onclick()
		{
			if (document.frmtraining.praexam.checked)
			{
				$("#dvpraexam").show();	
				$("#dvpramax").show();
				$("#dvpraexampass").show();				
				$("#dvprajmlsoal").show();
				$("#praAllDuration").show();
				$("#praEachDuration").show();
			}
			else
			{
				$("#dvpraexam").hide();
				$("#dvpramax").hide();
				$("#dvpraexampass").hide();
				$("#dvprajmlsoal").hide();
				$("#praAllDuration").hide();
				$("#praEachDuration").hide();
			}
		}
		
		function exam_onclick()
		{
			if (document.frmtraining.exam.checked)
			{
				$("#dvexam").show();	
				$("#dvmax").show();
				$("#dvexampass").show();
				$("#dvjmlsoal").show();
				$("#allDuration").show();
				$("#eachDuration").show();
			}
			else
			{
				$("#dvexam").hide();
				$("#dvmax").hide();
				$("#dvexampass").hide();
				$("#dvjmlsoal").hide();
				$("#allDuration").hide();
				$("#eachDuration").hide();
			}
		}		

		function saveBankSoal()
		{
			$('#topic').attr('disabled', false);
			$('#name').attr('disabled', false);
			f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/training/savebanksoal", "frmtraining", "messagex", "Saving...",
				function(data)
				{
				    console.log('test');
					$("#messagex").html("<?php echo $this->_tpl_vars['ok_update_banksoal']; ?>
");
					
				}
			);	
			
			return false;			
		}

	</script>


<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-body table-responsive">
				<table id="tbltrainingtime" class="table">
					<tr>
						<td width="15%">&nbsp;</td>
						<td><input type="checkbox" name="praexam" id="praexam" value="1" onclick="javascript:praexam_onclick()" /> <?php echo $this->_tpl_vars['lpraexam']; ?>
</td>
					</tr>
					<tr id="dvpraexam" style="display: none;">
						<td><?php echo $this->_tpl_vars['lbank_soal']; ?>
</td>
						<td><input type='text' name="_praexam" id="_praexam" value="<?php echo $this->_tpl_vars['praexam_banksoal_name']; ?>
" class='formdefault' value="" style="width: 90%" /></td>
					</tr>
					<tr id="dvprajmlsoal" style="display: none;">
						<td><?php echo $this->_tpl_vars['ljumlah_soal']; ?>
</td>
						<td><input type='text' name="_prajmlsoal" id="_prajmlsoal" value="<?php echo $this->_tpl_vars['exam_prajmlsoal']; ?>
" class='formnumber' value="" ></td>
					</tr>

					<tr id="dvpramax" style="display: none;">
						<td><?php echo $this->_tpl_vars['ltraining_max']; ?>
</td>
						<td><input type='text' name="_pramax" id="_pramax" value="<?php echo $this->_tpl_vars['exam_pramax']; ?>
" class='formnumber' value="" >&nbsp;&nbsp; *<?php echo $this->_tpl_vars['lunlimit']; ?>
</td>
					</tr>
					<tr id="dvpraexampass" style="display: none;">
						<td><?php echo $this->_tpl_vars['ltraining_pass']; ?>
</td>
						<td><input type='text' name="_prapass" id="_prapass" value="<?php echo $this->_tpl_vars['exam_prapass']; ?>
" class='formnumber' value="" ></td>
					</tr>
					<tr id="praAllDuration" style="display: none;">
						<td>Durasi</td>
						<td><input type='text' name="_praAllDurationHour" id="_praAllDurationHour" value="<?php echo $this->_tpl_vars['exam_praalldurationhour']; ?>
" class='formnumber' value="" > Hour <input type='text' name="_praAllDurationMinute" id="_praAllDurationMinute" value="<?php echo $this->_tpl_vars['exam_praalldurationminute']; ?>
" class='formnumber' value="" > Minute</td>
					</tr>
					<tr id="praEachDuration" style="display: none;">
						<td>Durasi Per Soal</td>
						<td><input type='text' name="_praEachDuration" id="_praEachDuration" value="<?php echo $this->_tpl_vars['exam_praeachduration']; ?>
" class='formnumber' value="" > Second</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="checkbox" name="exam" id="exam" value="2" onclick="javascript:exam_onclick()" /> <?php echo $this->_tpl_vars['lexam']; ?>
</td>
					</tr>
					<tr id="dvexam" style="display: none;">
						<td><?php echo $this->_tpl_vars['lbank_soal']; ?>
</td>
						<td><input type='text' name="_exam" id="_exam" value="<?php echo $this->_tpl_vars['exam_banksoal_name']; ?>
" class='formdefault' value="" style="width: 90%" /></td>
					</tr>
					<tr id="dvjmlsoal" style="display: none;">
						<td><?php echo $this->_tpl_vars['ljumlah_soal']; ?>
</td>
						<td><input type='text' name="_jmlsoal" id="_jmlsoal" value="<?php echo $this->_tpl_vars['exam_jmlsoal']; ?>
" class='formnumber' value="" ></td>
					</tr>

					<tr id="dvmax" style="display: none;">
						<td><?php echo $this->_tpl_vars['ltraining_max']; ?>
</td>
						<td><input type='text' name="_max" id="_max" value="<?php echo $this->_tpl_vars['exam_max']; ?>
" class='formnumber' value="" >&nbsp;&nbsp; *<?php echo $this->_tpl_vars['lunlimit']; ?>
</td>
					</tr>
					<tr id="dvexampass" style="display: none;">
						<td><?php echo $this->_tpl_vars['ltraining_pass']; ?>
</td>
						<td><input type='text' name="_pass" id="_pass" value="<?php echo $this->_tpl_vars['exam_pass']; ?>
" class='formnumber' value="" ></td>
					</tr>
					<tr id="allDuration" style="display: none;">
						<td>Durasi</td>
						<td><input type='text' name="_allDurationHour" id="_allDurationHour" value="<?php echo $this->_tpl_vars['exam_alldurationhour']; ?>
" class='formnumber' value="" > Hour <input type='text' name="_allDurationMinute" id="_allDurationMinute" value="<?php echo $this->_tpl_vars['exam_alldurationminute']; ?>
" class='formnumber' value="" > Minute</td>
					</tr>
					<tr id="eachDuration" style="display: none;">
						<td>Durasi Per Soal</td>
						<td><input type='text' name="_eachDuration" id="_eachDuration" value="<?php echo $this->_tpl_vars['exam_eachduration']; ?>
" class='formnumber' value="" > Second</td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top"><div id="messagex"></div><input type="button" value=" Save " onclick="javascript:saveBankSoal()" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>