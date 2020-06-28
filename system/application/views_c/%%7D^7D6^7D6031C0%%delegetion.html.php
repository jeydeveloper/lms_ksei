<?php /* Smarty version 2.6.26, created on 2019-02-08 13:40:40
         compiled from training/delegetion.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/delegetion.html', 147, false),)), $this); ?>
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
	function shownpkorder(jabatan, sortby, orderby)
	{	
		searchby = $("#_searchby").val();
		keyword = $("#_keyword").val();
		
		searchnpk(jabatan, sortby, orderby, searchby, keyword, 0);
	}
	      
      	function pagedelegetion(n)
      	{
		if (! n) n = 0;
		
		searchnpk(0, $("#sortby").val(), $("#orderby").val(), $("#_searchby").val(), $("#_keyword").val(), n);
      	}
      	
      	function page(n)
      	{
		if (! n) n = 0;
		
		$("#offset").val(n);		
		var data = $("#frmtemp").serialize();
		
		$("#subcontent").html("loading...");		
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/getdelegetion/", data,
			function(data)
			{				
				$("#subcontent").html(data);
			}
		);		
      		
      	}
      	
      	function removedelegetion(id)
      	{
      		if (! confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
')) return;
      		
      		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/removedelegetion/", {id: id},
      			function(r)
      			{
      				page(0);
      			}
      		);      		      		
      	}
      	      	
      	function shownpk()
      	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist", {pageid: '<?php echo $this->_tpl_vars['pageid']; ?>
', delegetion: 1, notadmin: 1, jabatan: -1, dialog: 1, ischecked: 0, noheader: 1, funcpage: 'pagedelegetion', deltraining: $("#_name").val(), deltopic: $("#_topic").val()},
			function (data)
			{			
				$("#dialogcontent").html(data);	
				$("#dialoguser").dialog("open");								
			}
		);	      	
      	}
      	
	function searchnpk(jabatan, sortby, orderby, searchby, keyword, offset)
	{	
		if (! offset) offset = 0;
		
		$("#offset").val(offset);

		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist", $("#frmtempdialog").serialize(),
			function (data)
			{							
				$("#dialogcontent").html(data);	
				$("#dialoguser").dialog("open");								
			}
		);		
	}
	
	function adduser2delegetion()
	{		
		var found = false;
		var html = "";
	
		$("input[id='_npk[]']").each( 
		    function() 
		    { 
		    	
			var ischecked = $("input[id='_npk[]'][value='"+$(this).val()+"']").attr("checked");			
			if (ischecked) 
			{				
				html += "<input type='hidden' name='userids[]' value='" + $(this).val() + "' />";
				found = true;
			}
		    } 
		);		
		
		if (! found)
		{
			alert("<?php echo $this->_tpl_vars['lplease_select_user']; ?>
");
			return;
		}
		
		$("#dvuseridshidden").html(html);

		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/adddelegetion", $("#frmtemp").serialize(),
			function(r)
			{	
				if (r.error)
				{
					location = "<?php echo $this->_tpl_vars['base_url']; ?>
";
					return;
				}
				
				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/delegetion/0/"+r.trainingid;
				//showSubContent();
				//$("#dialoguser").dialog("close");
			}
			, "json"
		);
		
	}
	
	$(document).ready(
		function()
		{
			$("#dialoguser").dialog(
				{ 
					autoOpen: false 
					,modal: true
					,width: 850
					,height: 450
				}
			);			
		}
	);	
      	
      </script>
      <a href="javascript:shownpk()"><?php echo $this->_tpl_vars['date_added']; ?>
</a>
      <table width="100%" cellpadding="3" class="tablelist">
        <thead>
          <tr>
          	<th width="4%">No.</th>
            <th width="30%"><?php echo $this->_tpl_vars['lnpk']; ?>
</th>
            <th><?php echo $this->_tpl_vars['lname']; ?>
</th>
            <th width="30%"><?php echo $this->_tpl_vars['ldate']; ?>
</th>
            <th width="10%">&nbsp;</th>
          </tr>
          <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

          <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
          <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
          	<td class="odd"><?php echo $this->_tpl_vars['no']+$this->_tpl_vars['offset']; ?>
</td>
            <td class="odd"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</td>
            <td class="odd"><?php echo $this->_tpl_vars['row']->user_first_name; ?>
 <?php echo $this->_tpl_vars['row']->user_last_name; ?>
</td>
            <td class="odd"><?php echo $this->_tpl_vars['row']->delegetion_created_fmt; ?>
</td>
            <td><a href="javascript: removedelegetion(<?php echo $this->_tpl_vars['row']->delegetion_id; ?>
);"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" /></a></td>
          </tr>          	
          	<?php echo smarty_function_counter(array(), $this);?>

          <?php endforeach; endif; unset($_from); ?>
          
        </thead>
        <tbody>
        </tbody>
        <tfoot>
          <tr>
            	<td colspan="5"><?php echo $this->_tpl_vars['paging']; ?>
</td>
          </tr>
        </tfoot>        
      </table>
<br />
<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/training/getdelegetion/">
	<div id="dvuseridshidden"></div>
	<input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
" />
	<input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
" />
	<input type="hidden" id="_topic" name="_topic" value="<?php echo $_POST['_topic']; ?>
" />
	<input type="hidden" id="_name" name="_name" value="<?php echo $_POST['_name']; ?>
" />
</form>