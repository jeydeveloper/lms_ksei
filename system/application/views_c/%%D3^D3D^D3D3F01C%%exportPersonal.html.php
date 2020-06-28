<?php /* Smarty version 2.6.26, created on 2019-01-17 11:23:51
         compiled from certificate/exportPersonal.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'certificate/exportPersonal.html', 42, false),)), $this); ?>
<?php $this->assign('z', $this->_tpl_vars['maxJawaban']+7); ?>
<?php $this->assign('xx', $this->_tpl_vars['maxJawaban']+2); ?>
<?php $this->assign('yy', $this->_tpl_vars['maxJawaban']+4); ?>
<table width="100%" cellpadding="3" border="1">
  <thead>
    <tr>
      <td colspan="<?php echo $this->_tpl_vars['z']; ?>
">Unit Pembuat Soal:</td>
    </tr>
    <tr>
      <td>Soal</td>
      <td colspan="2"><?php echo $this->_tpl_vars['unitSoal']; ?>
</td>
      <td>NIK</td>
      <td><?php echo $this->_tpl_vars['nik']; ?>
</td>
      <td colspan="<?php echo $this->_tpl_vars['xx']; ?>
">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td>Nama</td>
      <td><?php echo $this->_tpl_vars['nama']; ?>
</td>
      <td colspan="<?php echo $this->_tpl_vars['xx']; ?>
">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="<?php echo $this->_tpl_vars['z']; ?>
">&nbsp;</td>
    </tr>
    <tr>
      <th rowspan="2" width="80px">No</th>
      <th rowspan="2" width="180px">Tipe Paket</th>
      <th rowspan="2" width="180px">Soal</th>
      <th rowspan="2" width="180px">Kunci Jawaban</th>
      <th colspan="<?php echo $this->_tpl_vars['maxJawaban']; ?>
">Pilihan Jawaban</th>
      <th rowspan="2" width="180px">Bobot</th>
      <th rowspan="2" width="180px">Jawaban</th>
      <th rowspan="2" width="180px">T/F</th>
    </tr>
    <tr>
      <?php $_from = $this->_tpl_vars['urutanJawaban']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
      <th width="180px"><?php echo $this->_tpl_vars['arrOpt'][$this->_tpl_vars['row']]; ?>
</th>
      <?php endforeach; endif; unset($_from); ?>
    </tr>
  </thead>
  <tbody>
    <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

    <?php $_from = $this->_tpl_vars['rowSoal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
    <?php $this->assign('x', $this->_tpl_vars['row']['urutanJawaban'][$this->_tpl_vars['row']['kunciJawaban']]); ?>
    <?php $this->assign('y', $this->_tpl_vars['row']['urutanJawaban'][$this->_tpl_vars['row']['jawaban']]); ?>
    <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
      <td class="odd"><?php echo $this->_tpl_vars['no']; ?>
</td>
      <td class="odd"><?php echo $this->_tpl_vars['row']['paketSoal']; ?>
</td>
      <td class="odd"><?php echo $this->_tpl_vars['row']['soal']; ?>
</td>
      <td class="odd"><?php echo $this->_tpl_vars['arrOpt'][$this->_tpl_vars['x']]; ?>
</td>

      <?php $_from = $this->_tpl_vars['row']['pilihanJawaban']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['jawaban']):
?>
      <td class="odd"><?php echo $this->_tpl_vars['jawaban']; ?>
</td>
      <?php endforeach; endif; unset($_from); ?>

      <td class="odd"><?php echo $this->_tpl_vars['row']['bobotSoal']; ?>
</td>
      <td class="odd"><?php echo $this->_tpl_vars['arrOpt'][$this->_tpl_vars['y']]; ?>
</td>
      <td class="odd"><?php echo $this->_tpl_vars['row']['statusJawaban']; ?>
</td>
    </tr>
    <?php echo smarty_function_counter(array(), $this);?>

    <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td colspan="<?php echo $this->_tpl_vars['yy']; ?>
">&nbsp;</td>
      <td>Score</td>
      <td><?php echo $this->_tpl_vars['score']; ?>
</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="<?php echo $this->_tpl_vars['yy']; ?>
">&nbsp;</td>
      <td>Status</td>
      <td><?php echo $this->_tpl_vars['arrStatus'][$this->_tpl_vars['status']]; ?>
</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>