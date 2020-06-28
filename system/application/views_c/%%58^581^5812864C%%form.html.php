<?php /* Smarty version 2.6.26, created on 2020-05-30 17:09:01
         compiled from right/form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'right/form.html', 108, false),)), $this); ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/datetimepicker.js"></script>
<script>
	function frmtraining_onchange()
	{
		return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/right/save/<?php echo $this->_tpl_vars['edit']; ?>
", "frmtraining", "message", "Saving...",
			function(data)
			{
				$("#message").html("<?php echo $this->_tpl_vars['lok_save_right']; ?>
");
				setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/right"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
			}
		);				
	}	
	
	function checkall_onclick(elmt)
	{
			for(var i=0; i < document.frmtraining.elements.length; i++)
			{
					if (document.frmtraining.elements[i].name == "module[]")
					{
						document.frmtraining.elements[i].checked = elmt.checked;
					}
			}
	}
	
	function module_onclick(elmt)
	{
		if (! elmt.checked)
		{
				document.frmtraining.checkall.checked = false;
		}
		else
			{
				document.frmtraining.checkall.checked = ischeckall("module[]");
			}
	}
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['ltitle_form']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Topic</a></li>
            <li class="active"><?php echo $this->_tpl_vars['ltitle_form']; ?>
</li>
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
                  <div class="box-body table-responsive no-padding">
                    <form name="frmtraining" id="frmtraining" onsubmit="javascript: return frmtraining_onchange()">
<?php if ($this->_tpl_vars['right']): ?>
<input type="hidden" name="right_id" id="right_id" value="<?php echo $this->_tpl_vars['right']->right_id; ?>
" />
<?php endif; ?>
  <table width="100%">
    <tr>
      <td><table class="table table-hover table-striped">
          <tr>
            <td width="100"><?php if ($this->_tpl_vars['edit']): ?>
&nbsp;&nbsp;ID</td>
            <td>:</td>
            <td><?php echo $this->_tpl_vars['right']->right_id; ?>
 </td>
          </tr>
          <tr>
            <td><?php endif; ?>
* <?php echo $this->_tpl_vars['lright']; ?>
</td>
            <td width="1">:</td>
            <td><input type='text' name="name" id="name" class='formdefault' value="<?php echo $this->_tpl_vars['right']->right_name; ?>
" maxlength='100'></td>
          </tr>
          <tr>
            <td width="100">* <?php echo $this->_tpl_vars['status']; ?>
</td>
            <td>:</td>
            <td><select name="status" id="status">
              <option value="1" <?php if ($this->_tpl_vars['right']->right_status == 1): ?>selected<?php endif; ?>>
              <?php echo $this->_tpl_vars['active']; ?>

              </option>
              <option value="2" <?php if ($this->_tpl_vars['right']->right_status == 2): ?>selected<?php endif; ?>>
              <?php echo $this->_tpl_vars['inactive']; ?>

              </option>
            </select></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div id="message"></div></td>
          </tr>
      </table></td>
    </tr>
  </table>
     <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th width="10%"><input type="checkbox" name="checkall" value="" onclick="javascript:checkall_onclick(this)" /></th>
            <th><?php echo $this->_tpl_vars['lright_module']; ?>
</th>
          </tr>
         </thead>
         <tbody>
          <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

          <?php $_from = $this->_tpl_vars['modules']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
          <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
            <td class="odd"><input type="checkbox" name="module[]" value="<?php echo $this->_tpl_vars['row']->module_id; ?>
" onclick="javascript:module_onclick(this)" <?php if ($this->_tpl_vars['row']->checked): ?>checked<?php endif; ?> /></td>
            <td class="odd"><?php echo $this->_tpl_vars['row']->module_desc; ?>
</td>            
          </tr>           
            <?php echo smarty_function_counter(array(), $this);?>

          <?php endforeach; endif; unset($_from); ?>
                          
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2">
                <input type="submit" value=" Submit " />
                <input type="reset" value=" Reset " /></td>
          </tr>
          
        </tfoot>
      </table>                    
</form>
                  </div>
                </div>
              </div>
            </div>
          </section>