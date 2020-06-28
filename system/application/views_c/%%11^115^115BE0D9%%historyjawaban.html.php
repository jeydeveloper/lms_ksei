<?php /* Smarty version 2.6.26, created on 2019-01-17 11:24:32
         compiled from training/historyjawaban.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/historyjawaban.html', 15, false),)), $this); ?>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
				<div id="message"></div>
			</div>
			<div class="box">
				<div class="box-body table-responsive">
					<h2><?php echo $this->_tpl_vars['ltraining']; ?>
 &quot;<?php echo $this->_tpl_vars['row']->training_name; ?>
&quot;</h2>
					<br />&nbsp;
					<h3><?php echo $this->_tpl_vars['ldate']; ?>
 : <?php echo $this->_tpl_vars['row']->history_exam_datetime; ?>
</h3>
					<h3><?php echo $this->_tpl_vars['lscore']; ?>
 : <?php echo $this->_tpl_vars['row']->history_exam_score_fmt; ?>
</h3>
					<br />&nbsp;
					<form id="frmexam" name="frmexam" style="text-align: left;">
						<?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

						<?php $_from = $this->_tpl_vars['quests']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['quest']):
?>
						<?php echo $this->_tpl_vars['no']; ?>
. <?php echo $this->_tpl_vars['quest']->banksoal_question_quest; ?>

						<br />
						<?php $_from = $this->_tpl_vars['quest']->choices; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['choice']):
?>
						<input type="radio" value="<?php echo $this->_tpl_vars['choice']->banksoal_answer_id; ?>
" name="answer<?php echo $this->_tpl_vars['quest']->history_answer_id; ?>
" id="answer<?php echo $this->_tpl_vars['quest']->history_answer_id; ?>
" <?php if ($this->_tpl_vars['quest']->history_answer_answer == $this->_tpl_vars['choice']->banksoal_answer_id): ?>checked<?php endif; ?> /><?php echo $this->_tpl_vars['choice']->banksoal_answer_order_str; ?>
. <?php echo $this->_tpl_vars['choice']->banksoal_answer_text; ?>

						<br />
						<?php endforeach; endif; unset($_from); ?>
						<br />
						<?php echo smarty_function_counter(array(), $this);?>

						<?php endforeach; endif; unset($_from); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>