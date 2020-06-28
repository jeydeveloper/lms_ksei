<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:28
         compiled from user/account.html */ ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $this->_tpl_vars['account_header']; ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tables</a></li>
      <li class="active">Simple</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tr>
                <td width="200px"><?php echo $this->_tpl_vars['lnpk']; ?>
</td>
                <td width="80px">:</td>
                <td><b><?php echo $this->_tpl_vars['user']['user_npk']; ?>
</b></td>
              </tr>
              <tr>
                <td><?php echo $this->_tpl_vars['name']; ?>
</td>
                <td>:</td>
                <td><b><?php echo $this->_tpl_vars['user']['user_first_name']; ?>
 <?php echo $this->_tpl_vars['user']['user_last_name']; ?>
</b></td>
              </tr>
              <tr>
                <td><?php echo $this->_tpl_vars['jabatan']; ?>
</td>
                <td>:</td>
                <td><b><?php echo $this->_tpl_vars['user']['jabatan_name']; ?>
</b></td>
              </tr>
              <?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
              <tr>
                <td><?php echo $this->_tpl_vars['level']->level_name; ?>
</td>
                <td>:</td>
                <td><b><?php echo $this->_tpl_vars['level']->group; ?>
</b></td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>
              <tr>
                <td><?php echo $this->_tpl_vars['city']; ?>
</td>
                <td>:</td>
                <td><b><?php if ($this->_tpl_vars['user']['user_city']): ?><?php echo $this->_tpl_vars['user']['user_city']; ?>
<?php else: ?><?php echo $this->_tpl_vars['user']['lokasi_alamat']; ?>
 <?php echo $this->_tpl_vars['user']['lokasi_kota']; ?>
<?php endif; ?></b> </td>
              </tr>
              <tr>
                <td><?php echo $this->_tpl_vars['last_login']; ?>
</td>
                <td>:</td>
                <td><b><?php echo $this->_tpl_vars['user']['user_lastlogin_datetime']; ?>
</b></td>
              </tr>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>