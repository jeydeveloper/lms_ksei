<?php /* Smarty version 2.6.26, created on 2018-12-18 05:58:51
         compiled from jabatan/form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'jabatan/form.html', 209, false),)), $this); ?>
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
	var mygroup = new Array();
	<?php if ($this->_tpl_vars['jabatanedit']): ?>
		var iedit = 1;
		
		<?php $_from = $this->_tpl_vars['mygroup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grp']):
?>
		mygroup.push("<?php echo $this->_tpl_vars['grp']; ?>
");
		<?php endforeach; endif; unset($_from); ?>		
	<?php endif; ?>
	
	  $(document).ready(
	  	function()
	  	{
		    	$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/grouplist/1", {},
		    		function (data)
		    		{
		    			/*var datas = data.split("\1");
		    			$("#levelgroup1").autocomplete(datas);*/
		    			
		    			<?php if ($this->_tpl_vars['jabatanedit']): ?>
		    			$("#levelgroup1").val(mygroup[iedit-1]);
		    			group_onchange(iedit);		    			
		    			<?php endif; ?>
		    		}
		    	);

            var options = {

                url: function(phrase) {
                    return "<?php echo $this->_tpl_vars['site_url']; ?>
/level/grouplist/1";
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

            $("#levelgroup1").easyAutocomplete(options);
		    	
		    	loadcat(<?php echo $this->_tpl_vars['jabatanedit']->jabatan_category; ?>
);
	  	}
	  );
	  
	  function group_onchange(nth)
	  {
	  	$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/level/grouplist/"+(nth+1), {parent: $("#levelgroup"+nth).val(), nth: nth},
	  		function (data)
	  		{	  		
	  			/*var dvname = "levelgroup"+(nth+1);
	  			if (data.length > 0)
	  			{
					var datas = data.split("\1");
					$("#"+dvname).autocomplete(datas);										
					
					if (! in_array(datas, $("#"+dvname).val()))
					{
						$("#"+dvname).val("");
					}
					$("#"+dvname).incHasFocus();	  			
	  			}
	  			else
	  			{
					$("#"+dvname).flushCache();
					$("#"+dvname).val("");	  				
	  			}*/
	  			
	  			<?php if ($this->_tpl_vars['jabatanedit']): ?>	  			
	  			if (iedit < mygroup.length)
	  			{
					iedit++;
					$("#levelgroup"+iedit).val(mygroup[iedit-1]);
					group_onchange(iedit);
				}	  			
	  			<?php endif; ?>	
	  		}
	  	);

          var options = {

              url: function(phrase) {
                  return "<?php echo $this->_tpl_vars['site_url']; ?>
/level/grouplist/"+(nth+1);
              },

              getValue: function(element) {
                  return element.name;
              },

              ajaxSettings: {
                  dataType: "json",
                  method: "POST",
                  data: {parent: $("#levelgroup"+nth).val(), nth: nth}
              },

              preparePostData: function(data) {
                  data.phrase = $("#example-ajax-post").val();
                  return data;
              },

              requestDelay: 200
          };

          var dvname = "levelgroup"+(nth+1);
          $("#"+dvname).easyAutocomplete(options);
          $("#"+dvname).incHasFocus();

	  }	  
	  
	  function frmjabatan_submit()
	  {
	  	$("#message").html("submitting...");
	  	$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/save<?php if ($this->_tpl_vars['jabatanedit']): ?>/<?php echo $this->_tpl_vars['jabatanedit']->jabatan_id; ?>
<?php endif; ?>", $("#frmjabatan").serialize(),
	  		function(data)
	  		{
	  			if (data.err > 0)
	  			{
	  				$("#message").html(data.message);
	  				return;
	  			}		

	  			$("#message").html(data.message);
	  			setTimeout('location = "'+data.redirect+'"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
	  		}
	  		, "json"
	  	);
	  	
	  	return false;
	  }
	  
	  function loadcat(cat)
	  {
	  	if (! cat) cat = 0;
	  	
	  	$("#catjab").html("loading...");
	  	$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/categoryselectbox", {def: cat}, 
	  		function(r)
	  		{
	  			$("#catjab").html(r);
	  		}
	  	);
	  }
	  
	  function loadact1()
	  {
	  	loadcat($("#category").val());
	  }
	  
	  function refresh()
	  {
	  	loadcat($('#category').val());
	  }
	  
	  function addcategory()
	  {
	  	window.open("<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/formcategory/0/popup", "catjabatan", "");
	  }
</script>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $this->_tpl_vars['ltitle_jabatan']; ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Jabatan</a></li>
      <li class="active">Form</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive">
            <form name="frmjabatan" id="frmjabatan" onsubmit="javascript: return frmjabatan_submit()">
              <table class="table">
                <?php if ($this->_tpl_vars['edit']): ?>
                <tr>
                  <td width="200">
                    &nbsp;&nbsp;ID</td>
                  <td>:</td>
                  <td><?php echo $this->_tpl_vars['jabatanedit']->jabatan_id; ?>
</td>
                </tr>
                <?php endif; ?>
                <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                <?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
                <tr>
                  <td>* <?php echo $this->_tpl_vars['level']->level_name; ?>
</td>
                  <td width="1">:</td>
                  <td><input type='text' name="levelgroup[]" id="levelgroup<?php echo $this->_tpl_vars['no']; ?>
" class='formdefault' value="" onblur="javascript: group_onchange(<?php echo $this->_tpl_vars['no']; ?>
)" onchange="javascript: group_onchange(<?php echo $this->_tpl_vars['no']; ?>
)" /></td>
                </tr>
                <?php echo smarty_function_counter(array(), $this);?>

                <?php endforeach; endif; unset($_from); ?>
                <tr>
                  <td>&nbsp;&nbsp; <?php echo $this->_tpl_vars['lcategory']; ?>
</td>
                  <td>:</td>
                  <td><div id="catjab"></div>
                    <a href="javascript:addcategory()"><?php echo $this->_tpl_vars['laddcategory']; ?>
</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:refresh()"><?php echo $this->_tpl_vars['lrefresh']; ?>
</a>
                  </td>
                </tr>
                <tr>
                  <td>* <?php echo $this->_tpl_vars['jabatan_name']; ?>
</td>
                  <td>:</td>
                  <td><input type='text' name="name" id="name" class='formdefault' value="<?php echo $this->_tpl_vars['jabatanedit']->jabatan_name; ?>
" maxlength='100'></td>
                </tr>
                <tr>
                  <td>* <?php echo $this->_tpl_vars['status']; ?>
</td>
                  <td>:</td>
                  <td><select name="status" id="status">
                    <option value="1" <?php if ($this->_tpl_vars['jabatanedit']->jabatan_status == 1): ?>selected<?php endif; ?>>
                      <?php echo $this->_tpl_vars['active']; ?>

                    </option>
                    <option value="2" <?php if ($this->_tpl_vars['jabatanedit']->jabatan_status == 2): ?>selected<?php endif; ?>>
                      <?php echo $this->_tpl_vars['inactive']; ?>

                    </option>
                  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><div id="message"></div><input name="submit" type="submit" value=" Submit " />
                    <input name="reset" type="reset" value=" Reset " /></td>
                </tr>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>