<?php /* Smarty version 2.6.26, created on 2018-11-05 10:31:48
         compiled from training/examintro.html */ ?>
<script>
      	
      	function materi(id)
      	{
      		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/training/materi/"+id, {},
      			function(data)
      			{
      				if (data.err > 0)
      				{
      					location = data.url;
      					return;
      				}
      				      	
      				if (data.tipe == 1)
      				{
					var w = 800;
					var h = 600;
					/*if (window.screen) 
					{ 
						w = window.screen.availWidth; 
						h = window.screen.availHeight; 
					}*/
					//data.url = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/showmateri/"+id;
					window.open(data.url, 'materiwin', 'menubar=no, toolbar=no, location=no, status=no, scrollbars=1, resizable=yes,width='+w+',height='+h+'');      				
      				}
      				else
      				{
      					//offline message	
      					MM_openBrWindow("<?php echo $this->_tpl_vars['site_url']; ?>
/training/materioffline/"+id,'Courses','scrollbars=yes,resizable=1,width=500,height=300');
      					//alert(data.message);
      				}	
      			}
      			, "json"
      		);
      	}
      	
      	function preexam(id)
      	{
      		location = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/preexam/"+id;
      	}
      	
      	function exam(id)
      	{
      		location = "<?php echo $this->_tpl_vars['site_url']; ?>
/training/exam/"+id;
      	}
      	
      	function certificate(id)
      	{      		
      		$.post("<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/exam/"+id, {},
      			function(data)
      			{ 
      				if (data.err > 0)
      				{
      					location = data.url;
      					return;
      				}
      			      					      				
      				location = "<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/exam/"+id+"/1";
      			}
      			, "json"
      		);      		
      	}      	
</script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			&nbsp;
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Training</a></li>
			<li class="active">Exam Intro</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-body table-responsive">
						<p>
						<H3><?php echo $this->_tpl_vars['ltopic']; ?>
 &quot;<a href='<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist/<?php echo $this->_tpl_vars['rowtopic']->category_id; ?>
'><?php echo $this->_tpl_vars['rowtopic']->category_name; ?>
</a>&quot;</H3>
						</p>


						<H2><?php echo $this->_tpl_vars['ltraining']; ?>
 &quot;<?php echo $this->_tpl_vars['rowxyz']->training_name; ?>
&quot;</H2>
						<br /><?php echo $this->_tpl_vars['rowxyz']->training_desc; ?>


						<?php if ($this->_tpl_vars['rowxyz']->training_type == 1): ?>
						<br />
						<br />	<?php echo $this->_tpl_vars['lcourse_taken']; ?>
 (Exam) <br />

						<?php if ($this->_tpl_vars['showCounterPraexamMateri'] == 1): ?>
						<br />	<?php echo $this->_tpl_vars['lcourse_taken_praexam']; ?>
 (Praexam) <br />
						<br />	<?php echo $this->_tpl_vars['lcourse_taken_materi']; ?>
 (Materi) <br />
						<?php endif; ?>
						
						<?php endif; ?>
						<br />
						<?php if ($this->_tpl_vars['rowxyz']->training_type == 2): ?>
						<Br />
						<?php if ($this->_tpl_vars['Author']): ?>
						<?php echo $this->_tpl_vars['lcertification_prepared']; ?>
 <b><?php echo $this->_tpl_vars['Author']; ?>
</b>
						<Br />
						<Br />
						<?php endif; ?>

						<input type="button" value=" <?php echo $this->_tpl_vars['lstart']; ?>
 " onclick="javascript:certificate(<?php echo $this->_tpl_vars['rowxyz']->training_id; ?>
)" />
						<?php else: ?>
						<?php if ($this->_tpl_vars['rowxyz']->hasPraExam): ?>
						<input type="button" value=" <?php echo $this->_tpl_vars['lpraexam']; ?>
 " onclick="javascript:preexam(<?php echo $this->_tpl_vars['rowxyz']->training_id; ?>
)" />
						<?php endif; ?>
						<input type="button" value=" <?php echo $this->_tpl_vars['lmateri']; ?>
 " onclick="javascript:materi(<?php echo $this->_tpl_vars['rowxyz']->training_id; ?>
)" />
						<?php if ($this->_tpl_vars['rowxyz']->hasExam): ?>
						<input type="button" value=" <?php echo $this->_tpl_vars['lexam']; ?>
 " onclick="javascript:exam(<?php echo $this->_tpl_vars['rowxyz']->training_id; ?>
)" />
						<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>