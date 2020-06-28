<?php /* Smarty version 2.6.26, created on 2018-11-05 10:31:26
         compiled from training/form.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/form.html', 31, false),array('modifier', 'strtoupper', 'training/form.html', 287, false),)), $this); ?>
<script>
	function frmtraining_onsubmit()
	{
        $("#msg-content").removeClass('alert-danger').removeClass('alert-success').hide();
		$("#message").html("saving...");
		return true;
	}

	function category_onchange()
	{
		$("#topic_div").html("Loading...");

		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/getparent", {cat: $("#cat").val(), isshowroot: 'no', selectname: 'topic', parent: '<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_topic; ?>
<?php else: ?><?php echo $_POST['topic']; ?>
<?php endif; ?>'},
			function (data)
			{
				$("#topic_div").html(data);
			}
		);
	}

	$(document).ready(function(){
		category_onchange();

		<?php if ($this->_tpl_vars['training']): ?>
			<?php if ($this->_tpl_vars['extdata']): ?>
			$("#lastdate").val(<?php echo $this->_tpl_vars['extdata']->lastdate; ?>
);
			<?php endif; ?>

		matery_type_onclick(<?php echo $this->_tpl_vars['training']->training_material_type; ?>
);
		id_training_date = 0;
		<?php echo smarty_function_counter(array('start' => 0,'print' => false,'assign' => 'no'), $this);?>

		<?php $_from = $this->_tpl_vars['training']->time; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
		<?php if ($this->_tpl_vars['data']->training_time_parent): ?>
		addTrainingTime('<?php echo $this->_tpl_vars['data']->training_time_date1_fmt; ?>
', '<?php echo $this->_tpl_vars['data']->training_time_date2_fmt; ?>
', '<?php echo $this->_tpl_vars['data']->training_time_period; ?>
', <?php echo $this->_tpl_vars['no']; ?>
, <?php echo $this->_tpl_vars['data']->training_time_parent; ?>
);
		<?php else: ?>
		addTrainingTime('<?php echo $this->_tpl_vars['data']->training_time_date1_fmt; ?>
', '<?php echo $this->_tpl_vars['data']->training_time_date2_fmt; ?>
', '<?php echo $this->_tpl_vars['data']->training_time_period; ?>
', <?php echo $this->_tpl_vars['no']; ?>
, 0);
		id_training_date++;
		<?php endif; ?>
		<?php echo smarty_function_counter(array(), $this);?>

		<?php endforeach; endif; unset($_from); ?>
		<?php else: ?>
		matery_type_onclick(1);
		addTrainingTime("", "", "", id_training_date);
		<?php endif; ?>

		<?php $_from = $this->_tpl_vars['lokasitrainings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lokasitraining']):
?>
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/addressselectbox", {city: '<?php echo $this->_tpl_vars['lokasitraining']->lokasi_kota; ?>
', address: '<?php echo $this->_tpl_vars['lokasitraining']->lokasi_alamat; ?>
'},
				function(data)
				{
					$("#lokasi<?php echo $this->_tpl_vars['lokasitraining']->training_lokasi_id; ?>
").html(data);
				}
			);
		<?php endforeach; endif; unset($_from); ?>

	});

	function matery_type_onclick(val)
	{
		if (val == 1)
		{
			$("#lokasi_materionline_div").show();
			$("#lokasi_materioffline_div").hide();
		}
		else
		{
			$("#lokasi_materionline_div").hide();
			$("#lokasi_materioffline_div").show();
		}

	}
	function addTrainingTime(t1, t2, p, lastid, parentid)
	{
		if (! t1) t1 = "";
		if (! t2) t2 = "";
		if (! p) p = "";

		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/formdate", {lastid: lastid, trainingdate1: t1, trainingdate2: t2, period: p, parentid: parentid},
			function(data)
			{
				var newtr = $('<tr>'+data+'</tr>');
				newtr.attr("id", "trainingdate_"+lastid);
				if (lastid == 0)
				{
					$("#_trainingdate").after(newtr)
				}
				else
				{
					$("#trainingdate_"+(lastid-1)).after(newtr);
				}

				id_training_date = lastid + 1;

				$("#trainingdate"+lastid+"_1").datepicker({format: 'dd/mm/yyyy',startDate: '01/01/1900', changeMonth: true, changeYear: true});
				$("#trainingdate"+lastid+"_2").datepicker({format: 'dd/mm/yyyy',startDate: '01/01/1900', changeMonth: true, changeYear: true});
			}
		);
	}

	function setErrorMessage(err)
	{
		$("#message").html(err);
        $("#msg-content").addClass('alert-danger').show();
	}

	function setSuccess(msg, loc)
	{
		alert(msg);
		$("#message").html(msg);
		setTimeout('location = "' + loc + '"', <?php echo $this->_tpl_vars['flashtime']; ?>
);
        $("#msg-content").addClass('alert-success').show();
	}

	function lokasi_onchange(elmt, id)
	{
			$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/lokasi/addressselectbox", {city: elmt.value, address: ''},
				function(data)
				{
					$("#lokasi"+id).html(data);
				}
			);
	}

	function openmaterial(materi)
	{
		window.open("<?php echo $this->_tpl_vars['base_url']; ?>
material/"+materi+"/", "win<?php echo $this->_tpl_vars['unique']; ?>
", "width=800; height=600");
	}

	var id_training_date = 0;
</script><div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
            <?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['lcreate_course']; ?>
<?php elseif ($this->_tpl_vars['pageid'] == 'certificate'): ?><?php echo $this->_tpl_vars['lcreate_certificate']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lclassroom_update']; ?>
<?php endif; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#"><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['lcreate_course']; ?>
<?php elseif ($this->_tpl_vars['pageid'] == 'certificate'): ?><?php echo $this->_tpl_vars['lcreate_certificate']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lclassroom_update']; ?>
<?php endif; ?></a></li>
			<li class="active">Form</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
                <form name="frmtraining" method="post" id="frmtraining" enctype="multipart/form-data" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/save/<?php echo $this->_tpl_vars['training']->training_id; ?>
" target="iframe_training" onsubmit="javascript: return frmtraining_onsubmit()">
					<div class="box">
						<div class="box-body table-responsive no-padding">
							<div class="box-body">
                                <table class="table">
									<tr>
										<td width="15%">&nbsp;&nbsp;<?php echo $this->_tpl_vars['category']; ?>
</td>
										<td>
											<select name="cat" id="cat" style="width: 320px;" onchange="javascript: category_onchange()">
												<?php echo $this->_tpl_vars['tree']; ?>

											</select>
										</td>
									</tr>
									<tr>
										<td>&nbsp;&nbsp;<?php echo $this->_tpl_vars['topic']; ?>
</td>
										<td>
				<span id="topic_div">
					<select name="topic" id="topic" style="width: 320px;">
						<option value="0">-- <?php echo $this->_tpl_vars['topic']; ?>
 --</option>
					</select>
				</span>
										</td>
									</tr>
									<?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
									<tr>
										<td>* <?php echo $this->_tpl_vars['ltraining_code']; ?>
</td>
										<td><input type='text' name="code" id="code" class='formshort' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_code; ?>
<?php else: ?><?php echo $_POST['code']; ?>
<?php endif; ?>" maxlength='100' <?php if ($this->_tpl_vars['training']): ?>readonly<?php endif; ?>> </td>
									</tr>
									<?php endif; ?>
									<tr>
										<td>* <?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['training_name']; ?>
<?php elseif ($this->_tpl_vars['pageid'] == 'certificate'): ?><?php echo $this->_tpl_vars['certificate_name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lclassroom']; ?>
<?php endif; ?></td>
										<td><input type='text' name="name" id="name" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_name; ?>
<?php else: ?><?php echo $_POST['name']; ?>
<?php endif; ?>" maxlength='100'> </td>
									</tr>
									<?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
									<tr valign='top'>
										<td valign="top">&nbsp;&nbsp;<?php echo $this->_tpl_vars['description']; ?>
</td>
										<td><textarea name="desc" id="desc" class='textareadefault'><?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_desc; ?>
<?php else: ?><?php echo $_POST['desc']; ?>
<?php endif; ?></textarea></td>
									</tr>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['pageid'] != 'certificate'): ?>
									<tr>
										<td width="13%">&nbsp;&nbsp; <?php echo $this->_tpl_vars['lduration']; ?>
</td>
										<td>
											<input type='text' name="dhour" id="dhour" value="<?php if ($this->_tpl_vars['training']->training_duration_hour): ?><?php echo $this->_tpl_vars['training']->training_duration_hour; ?>
<?php endif; ?>" class='formnumber' > <?php echo $this->_tpl_vars['lhour']; ?>
 :
											<input type='text' name="dminute" id="dminute" value="<?php if ($this->_tpl_vars['training']->training_duration_minute): ?><?php echo $this->_tpl_vars['training']->training_duration_minute; ?>
<?php endif; ?>" class='formnumber' > <?php echo $this->_tpl_vars['lminute']; ?>

										</td>
									</tr>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['pageid'] == 'classroom'): ?>
									<tr>
										<td width="13%">&nbsp;&nbsp; <?php echo $this->_tpl_vars['lbatch']; ?>
</td>
										<td>
											<input type='text' name="batch" id="batch" value="<?php if ($this->_tpl_vars['training']->training_banksoal): ?><?php echo $this->_tpl_vars['training']->training_banksoal; ?>
<?php endif; ?>" class='formnumber' >
										</td>
									</tr>
									<tr>
										<td width="13%">&nbsp;&nbsp; <?php echo $this->_tpl_vars['ltraining_type']; ?>
</td>
										<td>
											<input type='text' name="authorname2" id="authorname2" value="<?php echo $this->_tpl_vars['training']->training_author_lastname; ?>
" class='formdefault' >
										</td>
									</tr>
									<?php endif; ?>
									<tr>
										<td>&nbsp;&nbsp; <?php echo $this->_tpl_vars['lcost']; ?>
</td>
										<td><input type='text' name="cost" id="cost" class='formshort' value="<?php if ($this->_tpl_vars['training'] && $this->_tpl_vars['training']->training_cost > 0): ?><?php echo $this->_tpl_vars['training']->training_cost; ?>
<?php else: ?><?php echo $_POST['cost']; ?>
<?php endif; ?>" maxlength='12'> </td>
									</tr>

									<?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
									<tr>
										<td valign="top">* <?php echo $this->_tpl_vars['materi_location']; ?>
</td>
										<td>
											<input type="radio" name="materi_type" value="1" onclick='javascript:matery_type_onclick(1)' <?php if ($this->_tpl_vars['training']->training_material_type != 2): ?>checked<?php endif; ?>>&nbsp;Online
											<input type="radio" name="materi_type" value="2" onclick='javascript:matery_type_onclick(2)'<?php if ($this->_tpl_vars['training']->training_material_type == 2): ?>checked<?php endif; ?>>&nbsp;Offline
											<div id='lokasi_materionline_div' style="display: none;">
												<input type='file' name="materionline" id="materionline" class='formdefault' value="">
												<?php if ($this->_tpl_vars['training']->training_material_type == 1 && $this->_tpl_vars['training']->training_material): ?>
												<br /><a href="javascript:openmaterial('<?php echo $this->_tpl_vars['training']->training_material; ?>
')"><?php echo $this->_tpl_vars['training']->training_material; ?>
</a>
												<?php endif; ?>
											</div>
											<div id='lokasi_materioffline_div' style="display: none;"><input type='text' name="materioffline" id="materioffline" class='formdefault' value="<?php if ($this->_tpl_vars['training']->training_material): ?><?php echo $this->_tpl_vars['training']->training_material; ?>
<?php endif; ?>"> ex. '/MATERIAL/TRN-00001' </div>
										</td>
									</tr>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['lcertificate_template']; ?>
</td>
										<td>
											<input type="file" name="certtpl" value="" class='formdefault' />
											<?php if ($this->_tpl_vars['training']->training_cert_tpl): ?>
											<br /><a href="<?php echo $this->_tpl_vars['base_url']; ?>
uploads/tmpl/<?php echo $this->_tpl_vars['training']->training_id; ?>
/<?php echo $this->_tpl_vars['training']->training_cert_tpl; ?>
" target="_blank"><?php echo $this->_tpl_vars['training']->training_cert_tpl; ?>
</a>
											<?php endif; ?>
										</td>
									</tr>
									<tr>
										<td valign="top" colspan="2"><b><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['training_time']; ?>
<?php else: ?> * <?php echo $this->_tpl_vars['lcertificate_time']; ?>
<?php endif; ?></b></td>
									</tr>
									<?php endif; ?>
									<tr id="_trainingdate" style="display: none;"></tr>
									<?php if ($this->_tpl_vars['pageid'] != 'classroom'): ?>
									<tr>
										<td valign="top">&nbsp;</td>
										<td valign="top"><input type="button" value=" <?php echo $this->_tpl_vars['ladd_training_time']; ?>
 " onclick="javascript:addTrainingTime('', '', '', id_training_date, 0)" /></td>
									</tr>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['lrefreshment']; ?>
</td>
										<td>
											<input maxlength='2' type='text' name="refreshment" id="refreshment" class='formshort' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_refreshment; ?>
<?php elseif ($_POST['refreshment']): ?><?php echo $_POST['refreshment']; ?>
<?php endif; ?>" > <?php echo $this->_tpl_vars['lmonth']; ?>

										</td>
									</tr>
									<tr>
										<td valign="top" colspan="2"><b><?php echo $this->_tpl_vars['author']; ?>
</b></td>
									</tr>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['first_name']; ?>
</td>
										<td><input maxlength='100' type='text' name="authorname1" id="authorname1" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_author_firstname; ?>
<?php elseif ($_POST['authorname1']): ?><?php echo $_POST['authorname1']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sess']['user_first_name']; ?>
<?php endif; ?>" ></td>
									</tr>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['last_name']; ?>
</td>
										<td><input maxlength='100' type='text' name="authorname2" id="authorname2" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_author_lastname; ?>
<?php elseif ($_POST['authorname2']): ?><?php echo $_POST['authorname2']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sess']['user_last_name']; ?>
<?php endif; ?>" > </td>
									</tr>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['initial']; ?>
</td>
										<td><input maxlength='100' type='text' name="initial" id="initial" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_author_inital; ?>
<?php else: ?><?php echo $_POST['initial']; ?>
<?php endif; ?>" ></td>
									</tr>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['email']; ?>
</td>
										<td><input maxlength='100' type='text' name="email" id="email" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_author_email; ?>
<?php elseif ($_POST['email']): ?><?php echo $_POST['email']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sess']['user_email']; ?>
<?php endif; ?>" ></td>
									</tr>
									<?php else: ?>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['lvendor_name']; ?>
</td>
										<td><input maxlength='100' type='text' name="authorname1" id="authorname1" class='formdefault' value="<?php if ($this->_tpl_vars['training']): ?><?php echo $this->_tpl_vars['training']->training_author_firstname; ?>
<?php elseif ($_POST['authorname1']): ?><?php echo $_POST['authorname1']; ?>
<?php else: ?><?php echo $this->_tpl_vars['sess']['user_first_name']; ?>
<?php endif; ?>" ></td>
									</tr>
									<?php endif; ?>
									<?php if ($this->_tpl_vars['pageid'] == 'classroom'): ?>
									<tr>
										<td valign="top"><?php echo $this->_tpl_vars['llokasi']; ?>
</td>
										<td>
											<?php $_from = $this->_tpl_vars['lokasitrainings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lokasitraining']):
?>
											<select name="city[]"  class='formshort' onchange="javascript: lokasi_onchange(this, <?php echo $this->_tpl_vars['lokasitraining']->training_lokasi_id; ?>
)">
												<?php $_from = $this->_tpl_vars['rowlokasies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lokasi']):
?>
												<option value="<?php echo $this->_tpl_vars['lokasi']->lokasi_kota; ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['lokasi']->lokasi_kota)) ? $this->_run_mod_handler('strtoupper', true, $_tmp) : strtoupper($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['lokasitraining']->lokasi_kota)) ? $this->_run_mod_handler('strtoupper', true, $_tmp) : strtoupper($_tmp))): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['lokasi']->lokasi_kota; ?>
</option>
												<?php endforeach; endif; unset($_from); ?>
											</select>
											<span id="lokasi<?php echo $this->_tpl_vars['lokasitraining']->training_lokasi_id; ?>
"></span>
											<?php endforeach; endif; unset($_from); ?>
										</td>
									</tr>
									<?php endif; ?>
									<tr>
										<td valign="top">&nbsp;</td>
										<td valign="top"><input type="submit" value=" Save " /></td>
									</tr>
									<tr>
										<td valign="top" colspan="2">
											<div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
												<div id="message"></div>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<!-- /.box -->
					</div>
				</form>
			</div>
	</section>
	<!-- /.content -->
</div>
<iframe id="iframe_training" name="iframe_training" src="" style="display: none;width:600px;height:500px;border:1px solid #000000;"></iframe>