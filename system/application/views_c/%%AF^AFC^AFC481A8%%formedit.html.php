<?php /* Smarty version 2.6.26, created on 2018-12-12 15:12:50
         compiled from banksoal/formedit.html */ ?>
<script>
	  $(document).ready(function(){
		onload();  	  	  	    		
	  });
	  
	function save()
	{
		return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/save/<?php echo $this->_tpl_vars['type']; ?>
/<?php echo $this->_tpl_vars['banksoal']->banksoal_id; ?>
", "frmbanksoal", "message", "Saving...",
			function(data)
			{
				$("#message").html("<?php echo $this->_tpl_vars['ok_save_banksoal']; ?>
");
				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/<?php echo $this->_tpl_vars['type']; ?>
";
			}
		);
	}	  
	
	function onload(isclose)
	{
	    	$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/loadsoal/<?php echo $this->_tpl_vars['banksoal']->banksoal_id; ?>
", $("#frmbanksoal").serialize(),
	    		function (data)
	    		{
	    			$("#preview").html(data);
	    			if (isclose)
	    			{
	    				$("#dialogquest").dialog("close");
	    			}
	    		}
	    	);	
	}
	
	function button_onclick()
	{
		$("#message").html("Updating...");
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/banksoal/update/<?php echo $this->_tpl_vars['banksoal']->banksoal_id; ?>
", $("#frmbanksoal").serialize(),
	    		function (data)
	    		{
	    			if (data.err > 0)
	    			{
	    				$("#message").html(data.message);
	    				return; 
	    			}
	    			
	    			$("#message").html(data.message);
	    		}
	    		, "json"
		);
	}
	
	
</script>

<style>
    input[type="radio"] {
        margin-right: 10px;
    }
    input[type="text"] {
        width: 80%;
    }
</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['lbanksoal_form_training']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Bank Soal</a></li>
            <li class="active">Form Edit</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form name="frmbanksoal" id="frmbanksoal" method="post" onsubmit="javascript: return frmbanksoal_onchange()">
                            <table class="table">
                                <tr>
                                    <td><table class="table">
                                        <tr>
                                            <td width="200">
                                                ID</td>
                                            <td>:</td>
                                            <td><?php echo $this->_tpl_vars['banksoal']->banksoal_id; ?>
 </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php echo $this->_tpl_vars['lbanksoal_name']; ?>
</td>
                                            <td width="1">:</td>
                                            <td><input type='text' name="name" id="name" class='formdefault' value="<?php echo $this->_tpl_vars['banksoal']->banksoal_name; ?>
"></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->_tpl_vars['status']; ?>
</td>
                                            <td>:</td>
                                            <td><select name="_status" id="_status">
                                                <option value="1" <?php if ($this->_tpl_vars['banksoal']->banksoal_status == 1): ?>selected<?php endif; ?>>
                                                    <?php echo $this->_tpl_vars['active']; ?>

                                                </option>
                                                <option value="2" <?php if ($this->_tpl_vars['banksoal']->banksoal_status == 2): ?>selected<?php endif; ?>>
                                                    <?php echo $this->_tpl_vars['inactive']; ?>

                                                </option>
                                            </select></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>
                                                <div id="message"></div>
                                                <input type="button" value=" Update " onclick="javascript: button_onclick()" />
                                                <input type="reset" value=" Reset " />
                                            </td>
                                        </tr>
                                    </table>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <div id="preview"></div>
                        <div id="dialogquest" title="<?php echo $this->_tpl_vars['ledit_soal']; ?>
">
                            <div id="dialogquestcontent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>