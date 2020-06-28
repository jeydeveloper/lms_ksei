<?php /* Smarty version 2.6.26, created on 2019-01-17 11:24:06
         compiled from training/print_certificate.html */ ?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Print Certificate</title>
  <style>
    @media print {
      html,
      body {
        width: 210mm;
        height: 100%;
        overflow: hidden;
        font-size: 30px;
      }
      #main-tbl {
        margin-top: 200px;
      }
      td {
        text-align: center;
      }
      tr.big-space {
        line-height: 3em;
      }
      tr.very-big-space {
        line-height: 5em;
      }
      tr.sm-fnt {
        font-size: 14px;
      }
      tr.md-fnt {
        font-size: 25px;
      }
      tr.bg-fnt {
        font-size: 50px;
      }
      .abs {
        position: absolute;
        right: 95px;
        top: 70px;
      }
      body {
        background-image: url("<?php echo $this->_tpl_vars['base_url']; ?>
<?php echo $this->_tpl_vars['background']; ?>
");
        background-color: #ffffff;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
      }

      @page {
        size: A4;
        margin: 0;
      }

      #footer {
        display: block;
        position: fixed;
        bottom: 65px;
        margin-left: 60px;
        font-size: 18px;
      }

      .crt-for-name {
        text-transform: uppercase;
      }
    }
  </style>
</head>

<body>
  <table id="main-tbl" border="0" width="100%">
    <tbody>
      <tr class="sm-fnt">
        <td width="100%">
          <div class="abs">
            <?php echo $this->_tpl_vars['MM']; ?>
<?php echo $this->_tpl_vars['YYYY']; ?>
-<?php echo $this->_tpl_vars['codeactivated']; ?>
-<?php echo $this->_tpl_vars['nocertificate']; ?>

          </div>
        </td>
      </tr>
      <tr class="big-space bg-fnt">
        <td width="100%">
          <strong>CERTIFICATE</strong>
        </td>
      </tr>
      <tr class="very-big-space">
        <td width="100%">
          This is to certify that,
        </td>
      </tr>
      <tr>
        <td width="100%" class="crt-for-name">
          <strong><?php echo $this->_tpl_vars['exam']->user_first_name; ?>
 <?php echo $this->_tpl_vars['exam']->user_last_name; ?>
</strong>
        </td>
      </tr>
      <tr>
        <td width="100%">
          <strong><?php echo $this->_tpl_vars['exam']->user_npk; ?>
</strong>
        </td>
      </tr>
      <tr class="very-big-space">
        <td width="100%">
          Has successfully completed a training on
        </td>
      </tr>
      <tr>
        <td width="100%">
          <strong><?php echo $this->_tpl_vars['exam']->category_name; ?>
</strong>
        </td>
      </tr>
      <tr class="md-fnt">
        <td width="100%">
          <strong><?php echo $this->_tpl_vars['FF']; ?>
, <?php echo $this->_tpl_vars['DD']; ?>
<sup><?php echo $this->_tpl_vars['SS']; ?>
</sup> <?php echo $this->_tpl_vars['YYYY']; ?>
</strong>
        </td>
      </tr>
      <tr class="very-big-space md-fnt">
        <td width="100%">
          Learning & Development Division
        </td>
      </tr>
    </tbody>
  </table>
  <table id="footer" width="100%">
    <tr class="sm-fnt">
      <td width="100%">
        <strong><em>NOTE: </em></strong><em>This certificate is printed by system and valid without signature</em>
      </td>
    </tr>
  </table>
</body>

</html>