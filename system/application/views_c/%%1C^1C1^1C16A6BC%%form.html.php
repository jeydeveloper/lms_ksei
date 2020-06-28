<?php /* Smarty version 2.6.26, created on 2018-12-18 06:00:51
         compiled from lokasi/form.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/datetimepicker.js"></script>
<script>
	function frmtraining_onchange()
	{
		return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/save/<?php echo $this->_tpl_vars['edit']; ?>
", "frmtraining", "message", "Saving...",
			function(data)
			{
				$("#message").html("<?php echo $this->_tpl_vars['lok_save_lokasi']; ?>
");
				setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
			}
		);				
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
      <li><a href="#">Lokasi</a></li>
      <li class="active">Form</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive">
            <form name="frmtraining" id="frmtraining" onsubmit="javascript: return frmtraining_onchange()">
	            <?php if ($this->_tpl_vars['right']): ?>
	            <input type="hidden" name="lokasi_id" id="lokasi_id" value="<?php echo $this->_tpl_vars['lokasi']->lokasi_id; ?>
" />
	            <?php endif; ?>
              <table class="table">
                <tr>
      <td>
      <?php if ($this->_tpl_vars['edit']): ?>
          <tr>
            <td width="100">
&nbsp;&nbsp;ID</td>
            <td>:</td>
            <td><?php echo $this->_tpl_vars['lokasi']->lokasi_id; ?>
 </td>
          </tr>
<?php endif; ?>        
          <tr>
            <td>* <?php echo $this->_tpl_vars['lcity']; ?>
</td>
            <td width="1">:</td>
            <td><input type='text' name="city" id="city" class='formdefault' value="<?php echo $this->_tpl_vars['lokasi']->lokasi_kota; ?>
" maxlength='100' style="width: 100%;"></td>
          </tr>
          <tr>
            <td>* <?php echo $this->_tpl_vars['llocation']; ?>
</td>
            <td width="1">:</td>
            <td><input type='text' name="location" id="location" class='formdefault' value="<?php echo $this->_tpl_vars['lokasi']->lokasi_alamat; ?>
" maxlength='100' style="width: 100%;"></td>
          </tr>          
          <tr>
            <td width="100">* <?php echo $this->_tpl_vars['status']; ?>
</td>
            <td>:</td>
            <td><select name="status" id="status">
              <option value="1" <?php if ($this->_tpl_vars['lokasi']->lokasi_status == 1): ?>selected<?php endif; ?>>
              <?php echo $this->_tpl_vars['active']; ?>

              </option>
              <option value="2" <?php if ($this->_tpl_vars['lokasi']->lokasi_status == 2): ?>selected<?php endif; ?>>
              <?php echo $this->_tpl_vars['inactive']; ?>

              </option>
            </select></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div id="message"></div></td>
          </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="submit" value=" Submit " />
<input type="reset" value=" Reset " /></td>
      </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>