<?php /* Smarty version 2.6.26, created on 2018-12-12 15:12:51
         compiled from banksoal/previewexam.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'banksoal/previewexam.html', 93, false),)), $this); ?>
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
      	function remove(i)
      	{
      		if (! confirm("<?php echo $this->_tpl_vars['confirm_delete']; ?>
"))
      		{
      			return;
      		}
      	
      		$("#rowsoal"+i).hide();
      		getelementnth(document.frmbanksoal, "status[]", i-1, 2);
      		
		<?php if ($this->_tpl_vars['banksoal_id']): ?>
		      	
		f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/removesoal/<?php echo $this->_tpl_vars['banksoal_id']; ?>
_"+i, "frmbanksoal", "messagesoal", "Removing...",
			function(data)
			{
				$("#messagesoal").html("");
				onload();				
			}
		);	
		
		<?php endif; ?>      		
      	}
      	
      	function add()
      	{
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/showdlgaddsoal", {banksoalid: "<?php echo $this->_tpl_vars['banksoal_id']; ?>
" ,istraining: 1},
				function(data)
				{
					$("#dialogquestcontent").html(data);
					
					$("#dialogquest").dialog('option', 'title', '<?php echo $this->_tpl_vars['ladd_soal']; ?>
 ');
					$("#dialogquest").dialog("open");		
				}
			);
      	}
      	
      	function addbyimport()
      	{
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/showdlgaddsoalbyimport", {banksoalid: "<?php echo $this->_tpl_vars['banksoal_id']; ?>
" ,istraining: 1},
				function(data)
				{
							$("#dialogquestcontent").html(data);
							
							$("#dialogquest").dialog('option', 'title', '<?php echo $this->_tpl_vars['ladd_soal']; ?>
 ');
							$("#dialogquest").dialog("open");		
				}
			);
      	}
      	
      	function edit(i)
      	{      		
 			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/showdlgsoal", {banksoalid: i, istraining: 1},
 				function(data)
 				{
 					$("#dialogquestcontent").html(data);
 					$("#dialogquest").dialog('open');
 				}
 			);      				      		      		
      	}
      	
      	function changestatussoal(id)      	
      	{
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/changestatussoal", {id: id},
				function(data)
				{
					$("#status_"+id).html(data);
      				}
      			);
      	}
 
      	$(function()
      	{
		$("#dialogquest").dialog(
			{ 
				autoOpen: false 
				,modal: true
				,width: 550
			}
		)      	
      	});
      	
      	var pEdit = -1;
      </script>
	<input type="hidden" name="_pertanyaan" id="_pertanyaan" />
	<input type="hidden" name="_jawaban" id="_jawaban" />
	<?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

	<?php $_from = $this->_tpl_vars['questcodes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['code']):
?>
		<input type="hidden" name="_pilihan[]" id="_pilihan<?php echo $this->_tpl_vars['no']; ?>
" />
	<?php echo smarty_function_counter(array(), $this);?>

	<?php endforeach; endif; unset($_from); ?>

    <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th width="2%"><?php echo $this->_tpl_vars['lno']; ?>
</th>
            <th width="30%"><?php echo $this->_tpl_vars['lquestion']; ?>
</th>
            <th width="4%"><?php echo $this->_tpl_vars['lanswer']; ?>
</th>
            <?php $_from = $this->_tpl_vars['questcodes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['code']):
?>
            <th><?php echo $this->_tpl_vars['code']; ?>
</th>
            <?php endforeach; endif; unset($_from); ?>      
            <?php if ($this->_tpl_vars['banksoal_id']): ?>
            <th width="10%">&nbsp;</th> 
            <th width="2%">&nbsp;</th>     
            <th width="2%">&nbsp;</th>
            <?php endif; ?>
          </tr>
          </thead>
          <tbody id="bodybanksoal>
          <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

          <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
          <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?> id="rowsoal<?php echo $this->_tpl_vars['no']; ?>
">          	
            <td class="odd"><?php echo $this->_tpl_vars['no']; ?>
</td>
            <td class="odd"><div id="soalke<?php echo $this->_tpl_vars['no']; ?>
"><a href="javascript:edit(<?php echo $this->_tpl_vars['row']['soalid']; ?>
)"><?php echo $this->_tpl_vars['row']['soal']; ?>
</a></div></td>
            <td class="odd"><div id="jawabanke<?php echo $this->_tpl_vars['no']; ?>
"><?php echo $this->_tpl_vars['row']['jawaban']; ?>
</div></td>
            <?php $this->assign('j', '1'); ?>
            <?php $_from = $this->_tpl_vars['row']['pilihan']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pilihan']):
?>
            <td class="odd"><div id="pilihanke<?php echo $this->_tpl_vars['no']; ?>
_<?php echo $this->_tpl_vars['j']; ?>
"><?php echo $this->_tpl_vars['pilihan']; ?>
</div></td>
            <?php $this->assign('j', $this->_tpl_vars['j']+1); ?>
            	<input type="hidden" name="status[]" id="status{$no}" value="1" />
          	<input type="hidden" name="no[]" value="<?php echo $this->_tpl_vars['row']['no']; ?>
" />
          	<input type="hidden" name="soal[]" value="<?php echo $this->_tpl_vars['row']['soal']; ?>
" />
          	<input type="hidden" name="jawaban[]" value="<?php echo $this->_tpl_vars['row']['jawaban']; ?>
" />            
            	<input type="hidden" name="pilihan[]" value="<?php echo $this->_tpl_vars['pilihan']; ?>
" />
            <?php endforeach; endif; unset($_from); ?>
            <?php if ($this->_tpl_vars['banksoal_id']): ?>
            <td class="odd"><a href="javascript:changestatussoal(<?php echo $this->_tpl_vars['row']['soalid']; ?>
)"><span id="status_<?php echo $this->_tpl_vars['row']['soalid']; ?>
"><?php echo $this->_tpl_vars['row']['status_desc']; ?>
</span></a></td>
            	<?php if ($this->_tpl_vars['row']['totexam'] == 0): ?>
            <td class="odd"><a href="javascript:edit(<?php echo $this->_tpl_vars['row']['soalid']; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_edit.gif" width="12" height="12" border="0" title="<?php echo $this->_tpl_vars['ledit']; ?>
"/></a></td>
            <td class="odd"><a href="javascript:remove(<?php echo $this->_tpl_vars['no']; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" title="<?php echo $this->_tpl_vars['ldelete']; ?>
"/></a></td>
            	<?php else: ?>
            <td class="odd">&nbsp;</td>	
            <td class="odd">&nbsp;</td>	
            	<?php endif; ?>
            <?php endif; ?>
          </tr>          	
          	<?php echo smarty_function_counter(array(), $this);?>

          <?php endforeach; endif; unset($_from); ?>  
          <tr>
          	<td colspan="<?php echo $this->_tpl_vars['ncol']+2; ?>
">&nbsp;</td>
          </tr>
          <div id="tbody"></div>                       
        </tbody>
	<?php if (! $this->_tpl_vars['banksoal_id']): ?>
        <tfoot>
          <tr>
            	<td colspan="<?php echo $this->_tpl_vars['ncol']+2; ?>
">
            		<input type="button" value=" Save " onclick="javascript:save()" />
            	</td>
          </tr>
        </tfoot> 
        <?php else: ?>       
        <tfoot>
          <tr>
            	<td colspan="<?php echo $this->_tpl_vars['ncol']+3; ?>
">
            		<input type="button" value=" Add " onclick="javascript:add()" />
            		<input type="button" value=" Import " onclick="javascript:addbyimport()" />
            	</td>
          </tr>
        </tfoot> 
        
        <?php endif; ?>
      </table>