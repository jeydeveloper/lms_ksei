<?php /* Smarty version 2.6.26, created on 2018-11-05 11:12:40
         compiled from training/participant.html */ ?>
<script>
	var loaddvs = new Array();
	var n_npk = <?php echo $this->_tpl_vars['totalnpk']; ?>
;
	var lastjabatan = 0;			
	
	function showLevelGroup(parent, dv)
	{
		if ($(dv).css("display") != "none")
		{
			$(dv).hide();
		}
		else
		{
			if (hasLoad(dv))
			{
				$(dv).show();
			}
			else
			{					
				if (parent > 0)
				{
					//ischecked = $("INPUT[name='levelgroup[]'][value='"+parent+"']").attr("checked");
					ischecked = $("INPUT[name='levelgroup[]'][value='"+parent+"']").is(":checked");
				}
				else
				{
					//ischecked = $("INPUT[name='allemp']").attr("checked")
					ischecked = $("INPUT[name='allemp']").is(":checked")
				}
				
				$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/showgroup/", {parent: parent, ischecked: ischecked, trainingid: <?php echo $this->_tpl_vars['training']->training_id; ?>
},
					function(data)
					{
						$(dv).html(data);
						$(dv).show();
					}
				);
				
				loaddvs.push(dv);
			}
		}
	}
	
	function showJabatan(id, dv)
	{	
		if ($(dv).css("display") != "none")
		{
			$(dv).hide();
		}
		else
		{
			if (hasLoad(dv))
			{
				$(dv).show();
			}
			else
			{		
				if (id > 0)
				{
					//ischecked = $("INPUT[name='jabatan[]'][value='"+id+"']").attr("checked");
					ischecked = $("INPUT[name='jabatan[]'][value='"+id+"']").is(":checked");
				}
				else
				{
					//ischecked = $("INPUT[name='allemp']").attr("checked")
					ischecked = $("INPUT[name='allemp']").is(":checked")
				}
							
				$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/show/", {id: id, ischecked: ischecked, trainingid: <?php echo $this->_tpl_vars['training']->training_id; ?>
},
					function(data)						
					{
						$(dv).html(data);
						$(dv).show();
					}
				);
				
				loaddvs.push(dv);
			}
		}
	}	
	
	function hasLoad(dv)
	{
		for(var i=0; i < loaddvs.length; i++)
		{
			if (loaddvs[i] == dv)
			{
				return true;
			}
		}
		
		return false;
	}
	
	function jabatan_onclick(id, ischecked)
	{
				
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/getfunctions", {id: id},
			function (data)
			{							
				for(var i=0; i < data.length; i++)
				{
					$("INPUT[name='function[]'][value='"+data[i]+"']").attr("checked", ischecked);
				}
				
				$("INPUT[name='allnpk"+id+"']").attr("checked", ischecked);
			}
			, "json"
		);		
		
		
		if (! ischecked)
		{
			uncheckjabatan(id);
		}		
	}
	
	function levelgroup_onclick(elmt)
	{
		checklevelgroup(elmt.value, elmt.checked);
		checkjabatan(elmt.value, elmt.checked);
	}
	
	function checklevelgroup(id, ischecked)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/getgroups", {id: id},
			function (data)
			{				
				for(var i=0; i < data.length; i++)
				{
					$("INPUT[name='levelgroup[]'][value='"+data[i]['id']+"']").attr("checked", ischecked);	
					if (data[i]['ishavejabatan'])
					{
						for(var j=0; j < data[i]['jabatan'].length; j++)
						{
							$("INPUT[name='jabatan[]'][value='"+data[i]['jabatan'][j]+"']").attr("checked", ischecked);
							//checkjabatan(data[i], ischecked, true);
						}
					}
				}
			}
			, "json"
		);
		
		if (! ischecked)
		{
			uncheckallparents(id);
		}
	}
	
	function uncheckallparents(id)	
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/getparents", {id: id},
			function (data)
			{	
				for(var i=0; i < data.length; i++)
				{
					$("INPUT[name='levelgroup[]'][value='"+data[i]+"']").attr("checked", false);	
				}
			}
			, "json"
		);	
		
		$("INPUT[name='allemp']").attr("checked", false)
	}
	
	function checkjabatan(id, ischecked, notonclick)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/getjabatans", {id: id},
			function (data)
			{
				for(var i=0; i < data.length; i++)
				{
					$("INPUT[name='jabatan[]'][value='"+data[i]+"']").attr("checked", ischecked);	
					if (! notonclick)
					{
						jabatan_onclick(data[i], ischecked);				
					}
				}
			}
			, "json"
		);	
	}
	
	function uncheckjabatan(id)
	{		
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/getjabatanparents", {id: id},
			function (data)
			{	
				for(var i=0; i < data.length; i++)
				{
					$("INPUT[name='levelgroup[]'][value='"+data[i]+"']").attr("checked", false);	
				}
			}
			, "json"
		);
		
		$("INPUT[name='allemp']").attr("checked", false)
	}
	
	function allnpk_onclick(elmt, id)
	{
		if (! elmt.checked)
		{
			$("INPUT[name='jabatan[]'][value='"+id+"']").attr("checked", false);
			uncheckjabatan(id);
		}
	}
	
	function allemp_onclick(elmt)
	{
		checklevelgroup(0, elmt.checked);	
	}
	
	function saveparticipant()
	{
		// dipaksa, jika tidak id, tidak akan error
		
		$("#cat").removeAttr("disabled");   
		$("#topic").removeAttr("disabled");   
		$("#name").removeAttr("disabled");
		$("#training_periode").removeAttr("disabled");
		$("#showsubcontentbutton").removeAttr("disabled");		
		
		
		$("#message").html("updating...");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/saveparticipant", $("#frmtraining").serialize(),
			function(data)
			{
				$("#cat").attr("disabled", true);
				$("#topic").attr("disabled", true);
				$("#name").attr("disabled", true);				
				$("#training_periode").attr("disabled", true);
				$("#showsubcontentbutton").attr("disabled", true);
				
				$("#showreloadbutton").show();
				
				if (data.err > 0)
				{					
					$("#message").html(data.message);
					return;
				}
				
				$("#message").html(data.message);
				var t=setTimeout("refresh()",500);
			}
			, "json"
		);
	}
	
	function shownpk(jabatan)
	{
		$("#training_periode").removeAttr("disabled");
		var training_periode = $("#training_periode").val() || 0;
		//var ischecked = $("INPUT[name='allnpk"+jabatan+"']").attr("checked");
		var ischecked = $("INPUT[name='allnpk"+jabatan+"']").is(":checked");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist", {jabatan: jabatan, dialog: 1, ischecked: ischecked, noheader: 1, training_npk_time_id: training_periode},
			function (data)
			{
			    console.log('test');
				$("#dialogcontent").html(data);	
				//$("#dialoguser").dialog("open");
                $('#modal-default').modal('show');

				$("#training_periode").attr("disabled", true);
			}
		);	
		
		lastjabatan = jabatan;	
	}

	function shownpkorder(jabatan, sortby, orderby)
	{	
		$("#training_periode").removeAttr("disabled");
		var training_periode = $("#training_periode").val() || 0;
		//var ischecked = $("INPUT[name='allnpk"+jabatan+"']").attr("checked");
		var ischecked = $("INPUT[name='allnpk"+jabatan+"']").is(":checked");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist", {jabatan: jabatan, dialog: 1, ischecked: ischecked, noheader: 1, sortby: sortby, orderby: orderby, training_npk_time_id: training_periode},
			function (data)
			{							
				$("#dialogcontent").html(data);	
				//$("#dialoguser").dialog("open");
                $('#modal-default').modal('show');

				$("#training_periode").attr("disabled", true);
			}
		);	
		
		lastjabatan = jabatan;	
	}
	
	function searchnpk(jabatan, sortby, orderby, searchby, keyword,_status)
	{	
		$("#training_periode").removeAttr("disabled");
		var training_periode = $("#training_periode").val() || 0;
		//var ischecked = $("INPUT[name='allnpk"+jabatan+"']").attr("checked");
		var ischecked = $("INPUT[name='allnpk"+jabatan+"']").is(":checked");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist", {jabatan: jabatan, dialog: 1, ischecked: ischecked, noheader: 1, sortby: sortby, orderby: orderby, searchby: searchby, keyword: keyword,_status:_status, training_npk_time_id: training_periode},
			function (data)
			{							
				$("#dialogcontent").html(data);	
				//$("#dialoguser").dialog("open");
                $('#modal-default').modal('show');

				$("#training_periode").attr("disabled", true);
			}
		);	
		
		lastjabatan = jabatan;	
	}	
	
	$(document).ready(
		function()
		{
			/*$("#dialoguser").dialog(
				{ 
					autoOpen: false 
					,modal: true
					,width: 850
					,height: 450
					,open: function()
					{
						if (n_npk > 0)
						{
							$("input[id='npk[]']").each( 
							    function() 
							    { 
								$("input[id='_npk[]'][value='"+$(this).val()+"']").attr("checked", true);
							    } 
							);
						}					
					}
				}
			);*/

            if (n_npk > 0)
            {
                $("input[id='npk[]']").each(
                    function()
                    {
                        $("input[id='_npk[]'][value='"+$(this).val()+"']").attr("checked", true);
                    }
                );
            }
			
			<?php if ($this->_tpl_vars['isopenroot']): ?>
				showLevelGroup(0, "#div_emp");
			<?php endif; ?>
			
			$("#training_periode").removeAttr("disabled");
			var training_periode = $('#training_periode').val() || 0;

			document.frmtraining.action = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/importnpk/<?php echo $this->_tpl_vars['training']->training_id; ?>
/"+training_periode;
			//document.frmtraining.enctype = "multipart/form-data";
			document.frmtraining.target = "iframe_participant";

			$("#training_periode").removeAttr("disabled");
			var training_npk_time_id = $("#training_periode").val() || 0;
			
			showAvailableParticipant(training_npk_time_id);
		}
	);
	
	function showAvailableParticipant(training_npk_time_id)
	{
		if (! training_npk_time_id) training_npk_time_id = 0;
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/getavailparticipant/<?php echo $this->_tpl_vars['training']->training_id; ?>
/"+training_npk_time_id, {}, 
			function(r)
			{
				$("#availparticipant").html(r);
				$("#training_periode").attr("disabled", true);
			}
		);
	}
	
	function adduser2participant()
	{
		var s = "";
		$("input[id='_npk[]']").each(
		    function()
		    {
		    	var n = ($("input[id='npk[]'][value='"+$(this).val()+"']").length);		    	
		    	if (n == 0)
		    	{
		    		//var ischecked = $(this).attr("checked");
                    var ischecked = $(this).is(":checked");
		    		if (ischecked)
		    		{
			    		s += "<input type='hidden' name='npk[]' id='npk[]' value='" + $(this).val() + "' />";
			    		n_npk++;
			    	}
			    	else
			    	{
			    		$("INPUT[name='allnpk"+lastjabatan+"']").attr("checked", false);

					$("INPUT[name='jabatan[]'][value='"+lastjabatan+"']").attr("checked", false);
					uncheckjabatan(lastjabatan);

			    	}
                    //console.log('ya');
		    	}
		    	else
		    	{
		    	    //console.log('yo');
		    		//var ischecked = $(this).attr("checked");
                    var ischecked = $(this).is(":checked");
		    		if (! ischecked)
		    		{
		    			$("input[id='npk[]'][value='"+$(this).val()+"']").val(0);
		    			n_npk--;
		    			
		    			$("INPUT[name='allnpk"+lastjabatan+"']").attr("checked", false);

					$("INPUT[name='jabatan[]'][value='"+lastjabatan+"']").attr("checked", false);
					uncheckjabatan(lastjabatan);
		    		}
		    	}		    	   		    	   
		    } 
		);
		
		var ori = $("#listnpk").html();
		$("#listnpk").html(ori+s)
		//$("#dialoguser").dialog("close");
	}
	
	function setErrorMessage(err)
	{
		$("#rowimportnpkmessage").show();
		$("#importnpkmessage").html(err);		
	}
	
	function setSuccess(msg)
	{
		$("#rowimportnpkmessage").show();
		$("#importnpkmessage").html(msg);
		setTimeout('showSubContent()', <?php echo $this->_tpl_vars['flashtime']; ?>
+1000);
	}
			
	function refresh()
	{
		$("#training_periode").removeAttr("disabled");
		var training_npk_time_id = $("#training_periode").val() || 0;
		location = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/participant/0/<?php echo $this->_tpl_vars['training']->training_id; ?>
/"+training_npk_time_id+"/";
	}			
</script>

<span id="availparticipant"></span>
<br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "training/import-participant.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "training/participant-search.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br />
<table class="table" id="tbltrainingimport">
<tr>
	<td>
		<input type="checkbox" id="allemp" name="allemp" value="1" onclick="javascript:allemp_onclick(this)" <?php if ($this->_tpl_vars['training']->training_all_staff): ?>checked<?php endif; ?> > <a href="javascript:showLevelGroup(0, '#div_emp')"><?php echo $this->_tpl_vars['lall_staff']; ?>
</a>
		<div id="div_emp" style="display: none;"></div>
		<div id="message"></div><input type="button" value=" Save " onclick="javascript:saveparticipant()" />
	</td>
</tr>
</table>
<div id="listnpk">
<?php $_from = $this->_tpl_vars['npks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['npk']):
?>
<input type="hidden" id="npk[]" name="npk[]" value="<?php echo $this->_tpl_vars['npk']->training_npk_npk; ?>
" />
<?php endforeach; endif; unset($_from); ?>
</div>
<iframe id="iframe_participant" name="iframe_participant" src="" style="width:0px;height:0px;border:0px solid #000000;"></iframe>

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