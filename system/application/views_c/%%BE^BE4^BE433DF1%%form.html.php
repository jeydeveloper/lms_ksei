<?php /* Smarty version 2.6.26, created on 2020-05-15 00:11:43
         compiled from user/form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'upper', 'user/form.html', 253, false),array('function', 'counter', 'user/form.html', 288, false),)), $this); ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/css/smoothness/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/css/smoothness/ui.datepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/jquery-ui-1.7.2.custom/development-bundle/ui/ui.datepicker.js"></script>
<script>	
	var mygroups = new Array();
	
	  $(document).ready(
	  	function()
	  	{
			<?php $_from = $this->_tpl_vars['mygroups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mygroup']):
?>
				mygroups.push(<?php echo $this->_tpl_vars['mygroup']->level_group_id; ?>
);
			<?php endforeach; endif; unset($_from); ?>
			
	  		<?php if ($this->_tpl_vars['edit']): ?>	  
	  			$('#joindate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true}).val('<?php echo $this->_tpl_vars['user']['user_join_date_fmt']; ?>
').trigger('change');
	  			$('#birthdate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true, yearRange: "1940:2000"}).val('<?php echo $this->_tpl_vars['user']['user_birthdate_fmt']; ?>
').trigger('change');	  			
	  			$('#lastlogindate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true}).val('<?php echo $this->_tpl_vars['user']['user_lastlogin_date_fmt']; ?>
').trigger('change');
	  				  				  			
	  			city_onchange(<?php echo $this->_tpl_vars['user']['user_location']; ?>
);
	  			$("#atasan").val('<?php echo $this->_tpl_vars['user']['user_npk_atasan']; ?>
');
	  			$("#nama_atasan").val('<?php echo $this->_tpl_vars['user']['nama_atasan']; ?>
');
	  			$("#grade").val('<?php echo $this->_tpl_vars['user']['user_grade_code']; ?>
');	  				  			
	  		<?php else: ?>
	  			$('#joindate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true});
	  			$('#birthdate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true, yearRange: "1940:2000"});
	  			$('#lastlogindate').datepicker({dateFormat: 'dd/mm/yy',startDate: '01/01/1900', changeMonth: true, changeYear: true});
	  			
	  			
	  			city_onchange(0);
	  		<?php endif; ?>	  			  		
	  		loadgroup(0, 1, true);
	  	}
	  );
	
	
	function loadgroup(parent, level, isinit)
	{
		if (parent.length == 0)
		{
			<?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
				if (<?php echo $this->_tpl_vars['level']->level_nth; ?>
 > level)
				{
					$("#level<?php echo $this->_tpl_vars['level']->level_nth; ?>
 option[value!='']").remove();
				}
			<?php endforeach; endif; unset($_from); ?>
			return;
		}		
		
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/group/"+parent, {},
			function(r)
			{				
				for(var i=0; i < r.groups.length; i++)
				{
					if (i == 0)
					{
						<?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
							if (<?php echo $this->_tpl_vars['level']->level_nth; ?>
 >= r.groups[i].level_group_nth)
							{
								$("#level<?php echo $this->_tpl_vars['level']->level_nth; ?>
 option[value!='']").remove();
							}
						<?php endforeach; endif; unset($_from); ?>					
					}
					$("#level"+r.groups[i].level_group_nth).append($('<option></option>').val(r.groups[i].level_group_id).html(r.groups[i].level_group_name));
				}
				
				if (! isinit) return;
				
				if ((r.groups.length > 0) && (mygroups.length > 0))
				{
					if (r.groups[0].level_group_nth <= mygroups.length)
					{
						$("#level"+r.groups[0].level_group_nth).val(mygroups[r.groups[0].level_group_nth-1]);
						loadgroup(mygroups[r.groups[0].level_group_nth-1], r.groups[0].level_group_nth+1, isinit);
					}
					else
					{
						loadjabatan(mygroups[mygroups.length-1]);
					}					
				}
				else
				if (mygroups.length > 0)
				{
					loadjabatan(mygroups[mygroups.length-1]);
				}
			}
			, "json"
		);
	}
	
	function frmuser_onsubmit()
	{
		return f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/user/save/<?php echo $this->_tpl_vars['edit']; ?>
", "frmuser", "message", "Updating...",
			function(data)
			{
				<?php if ($this->_tpl_vars['edit']): ?>
					$("#message").html("<?php echo $this->_tpl_vars['ok_update_user']; ?>
");
					<?php if ($this->_tpl_vars['fromlist']): ?>
					setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
					<?php endif; ?>				
				<?php else: ?>
				$("#message").html("<?php echo $this->_tpl_vars['ok_add_user']; ?>
");
				setTimeout('location = "<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlist"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
				<?php endif; ?>
			}
		);		
	}
	
	function city_onchange(id)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/showlokasi", {city: $("#city").val(), def: id},
			function(data)
			{
				$("#dvlokasi").html(data);
			}
		);
	}	
	
	function level_onchange(level)
	{
		var parent = $("#level"+level).val();
		loadgroup(parent, level, false);
		loadjabatan(parent);
	}  	  
	
	function loadjabatan(groupid)
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/jabatan/"+groupid, {},
			function(r)
			{
				$("#jabatan option[value!='']").remove();
				for(var i=0; i < r.jabatans.length; i++)
				{
					$("#jabatan").append($('<option></option>').val(r.jabatans[i].jabatan_id).html(r.jabatans[i].jabatan_name));
				}
				
				$("#jabatan").val(<?php echo $this->_tpl_vars['user']['user_jabatan']; ?>
);
				//loadfunction();
			}
			, "json"
		);
	}

	function loadfunction()
	{
		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/func/"+$("#jabatan").val(), {},
			function(r)
			{
				$("#function option[value!='']").remove();
				for(var i=0; i < r.functions.length; i++)
				{
					$("#function").append($('<option></option>').val(r.functions[i].function_id).html(r.functions[i].function_desc));
				}
				
				$("#function").val(<?php echo $this->_tpl_vars['user']['user_function']; ?>
);
			}
			, "json"
		);
	}
	
</script>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['edit_profile']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User</a></li>
            <li class="active">Form</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <form name="frmuser" id="frmuser" onsubmit="javascript: return frmuser_onsubmit()">
                            <table class="table">
                                <?php if (! $this->_tpl_vars['edit']): ?>
                                <tr>
                                    <td>
                                        <table class="table">
                                            <tr>
                                                <td width="200">
                                                    * <?php echo $this->_tpl_vars['lnpk']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="npk" id="npk" class='formshort' value="" maxlength='10'></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['password']; ?>
</td>
                                                <td width="1">:</td>
                                                <td><input type='password' name="password" id="password" class='formshort' value="" maxlength='100'></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['confirm_password']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='password' name="cpassword" id="cpassword" class='formshort' value="" maxlength='100'></td>
                                            </tr>
                                            <?php else: ?>
                                            <tr>
                                                <td width="200">
                                                    * <?php echo $this->_tpl_vars['lnpk']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="npk" id="npk" class='formshort' value="<?php echo $this->_tpl_vars['user']['user_npk']; ?>
" maxlength='10'></td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['email']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="email" id="email" class='formdefault' value="<?php echo $this->_tpl_vars['user']['user_email']; ?>
" maxlength='100'></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php if (! $this->_tpl_vars['hide_famaly_field']): ?><?php echo $this->_tpl_vars['first_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lname']; ?>
<?php endif; ?></td>
                                                <td width="1">:</td>
                                                <td><input type='text' name="firstname" id="firstname" class='formdefault' value="<?php echo $this->_tpl_vars['user']['user_first_name']; ?>
" maxlength='100'></td>
                                            </tr>
                                            <?php if (! $this->_tpl_vars['hide_famaly_field']): ?>
                                            <tr>
                                                <td>&nbsp;&nbsp; <?php echo $this->_tpl_vars['last_name']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="lastname" id="lastname" class='formdefault' value="<?php echo $this->_tpl_vars['user']['user_last_name']; ?>
" maxlength='100'></td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['join_date']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="joindate" id="joindate" value="" maxlength='10' class="formshort date-pick"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['birthdate']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="birthdate" id="birthdate" class='formshort date-pick' value="" maxlength='10'/>
                                            </tr>
                                            <tr valign='top'>
                                                <td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['description']; ?>
</td>
                                                <td>:</td>
                                                <td><textarea name="description" id="description"  class='textareadefault'><?php echo $this->_tpl_vars['user']['user_description']; ?>
</textarea></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['city']; ?>
</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="city" id="city" class='formdefault' onchange="javascript:city_onchange(0)">
                                                        <option value="">--- <?php echo $this->_tpl_vars['city']; ?>
 ---</option>
                                                        <?php $_from = $this->_tpl_vars['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['city']):
?>
                                                        <option value="<?php echo $this->_tpl_vars['city']->lokasi_kota; ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['user']['lokasi_kota'])) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['city']->lokasi_kota)) ? $this->_run_mod_handler('upper', true, $_tmp) : smarty_modifier_upper($_tmp))): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['city']->lokasi_kota; ?>
</option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['location']; ?>
</td>
                                                <td>:</td>
                                                <td><div id="dvlokasi"></div></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['user_type']; ?>
</td>
                                                <td>:</td>
                                                <td><select name="type" id="type" class='selectmedium'>
                                                    <?php $_from = $this->_tpl_vars['usertypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['type']):
?>
                                                    <option value="<?php echo $this->_tpl_vars['type']->right_id; ?>
" <?php if ($this->_tpl_vars['type']->right_id == $this->_tpl_vars['user']['user_type']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['type']->right_name; ?>
</option>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                </select></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['employee_type']; ?>
</td>
                                                <td>:</td>
                                                <td><select name="emp" id="emp" class='selectmedium'>

                                                    <?php $_from = $this->_tpl_vars['workstatuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['workstatus']):
?>

                                                    <option value="<?php echo $this->_tpl_vars['idx']; ?>
" <?php if ($this->_tpl_vars['user']['user_emp'] == $this->_tpl_vars['idx']): ?>selected<?php endif; ?>>
                                                    <?php echo $this->_tpl_vars['workstatus']; ?>

                                                    </option>

                                                    <?php endforeach; endif; unset($_from); ?>

                                                </select>
                                                </td>
                                            </tr>
                                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                                            <?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
                                            <tr>
                                                <td>
                                                    <?php if ($this->_tpl_vars['level']->level_nth == '1'): ?>
                                                    *&nbsp;
                                                    <?php else: ?>
                                                    &nbsp;&nbsp;
                                                    <?php endif; ?>
                                                    <?php echo $this->_tpl_vars['level']->level_name; ?>
</td>
                                                <td width="1">:</td>
                                                <td>
                                                    <select name="levelgroup[]" id="level<?php echo $this->_tpl_vars['level']->level_nth; ?>
" onchange="javascript:level_onchange(<?php echo $this->_tpl_vars['level']->level_nth; ?>
)" class='selectlong'>
                                                        <option value="">--- <?php echo $this->_tpl_vars['level']->level_name; ?>
 ---</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php echo smarty_function_counter(array(), $this);?>

                                            <?php endforeach; endif; unset($_from); ?>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['jabatan']; ?>
</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="jabatan" id="jabatan" class='selectlong'>
                                                        <option value="">--- <?php echo $this->_tpl_vars['jabatan']; ?>
 ---</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="display: none">
                                                <td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['function']; ?>
</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="function" id="function" class='selectlong'>
                                                        <option value="">--- <?php echo $this->_tpl_vars['function']; ?>
 ---</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $this->_tpl_vars['lgrade']; ?>
</td>
                                                <td>:</td>
                                                <td>
                                                    <select name="grade" id="grade" class='selectshort'>
                                                        <option value="">--- <?php echo $this->_tpl_vars['lgrade']; ?>
 ---</option>
                                                        <?php $_from = $this->_tpl_vars['grades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['grade']):
?>
                                                        <option value="<?php echo $this->_tpl_vars['grade']->grade_code; ?>
"><?php if ($this->_tpl_vars['grade']->grade_description): ?><?php echo $this->_tpl_vars['grade']->grade_description; ?>
<?php else: ?><?php echo $this->_tpl_vars['grade']->grade_code; ?>
<?php endif; ?></option>"></option>
                                                        <?php endforeach; endif; unset($_from); ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $this->_tpl_vars['lnama_atasan']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="nama_atasan" id="nama_atasan" class='formshort' value="" maxlength='10' disabled></td>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $this->_tpl_vars['latasan']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="atasan" id="atasan" class='formshort' value="" maxlength='10'></td>
                                            </tr>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['status']; ?>
</td>
                                                <td>:</td>
                                                <td><select name="status" id="status" class='selectshort'>
                                                    <option value="1" <?php if ($this->_tpl_vars['user']['user_status'] == 1): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['active']; ?>
</option>
                                                    <option value="2" <?php if ($this->_tpl_vars['user']['user_status'] == 2): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['inactive']; ?>
</option>
                                                </select></td>
                                            </tr>
                                            <?php if ($this->_tpl_vars['edit']): ?>
                                            <tr>
                                                <td>* <?php echo $this->_tpl_vars['llast_login']; ?>
</td>
                                                <td>:</td>
                                                <td><input type='text' name="lastlogindate" id="lastlogindate" value="" maxlength='10' class="formshort date-pick"></td>
                                            </tr>
                                            <?php endif; ?>
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
                                        </table></td>
                                </tr>
                            </table>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>