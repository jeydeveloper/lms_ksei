<?php /* Smarty version 2.6.26, created on 2019-10-01 23:58:27
         compiled from user/formadminnews.html */ ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
js/tiny_mce/tiny_mce.js"></script>

<script>
  function checking_form() {
    var news_title = $("#news_title").val();
    var news_desc = $("#news_desc").val();
    var ret = true;

    if(news_title == '' || news_desc == '') $("#message").empty();

    if(news_title == '') {
      $("#message").append('<div class="flash error"><font color="#ff0000">Please type news title!</font><br></div>');
      ret = false;
    }

    /*
    if(news_desc == '') {
      $("#message").append('<div class="flash error"><font color="#ff0000">Please type description!</font><br></div>');
      ret = false;
    }
    */

    return ret;
  }

	function frmcmsnews_onsubmit()
	{
		$("#message").html("Saving...");
    return checking_form();
	}
	
</script>

<script type="text/javascript">
function setupEditor() 
    {
      tinyMCE.init(
        {
          mode : "textareas",
          theme : "advanced",
          plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
          theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
          theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
          //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
          //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
          theme_advanced_toolbar_location : "top",
          theme_advanced_toolbar_align : "left",
          theme_advanced_statusbar_location : "bottom",
          theme_advanced_resizing : true
        }
      );    
    }

    setupEditor();
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['ltitle_form']; ?>

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
                <form method="post" name="frmcmsnews" id="frmcmsnews" action="<?php echo $this->_tpl_vars['site_url']; ?>
/user/savecmsnews/<?php echo $this->_tpl_vars['edit']; ?>
" enctype="multipart/form-data" onsubmit="javascript: return frmcmsnews_onsubmit()">
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <div class="box-body">
                                <table class="table">
                                    <?php if ($this->_tpl_vars['edit']): ?>
                                    <tr>
                                        <td>
                                            &nbsp;&nbsp; ID</td>
                                        <td>:</td>
                                        <td><?php echo $this->_tpl_vars['cmsnewsedit']['news_id']; ?>
</td>
                                    </tr>
                                    <?php endif; ?>
                                    <input type="hidden" name="parent" id="parent" value="0" />

                                    <tr>
                                        <td width="200">* <?php echo $this->_tpl_vars['news_title']; ?>
</td>
                                        <td width="1">:</td>
                                        <td><input type='text' name="news_title" id="news_title" class='formdefault' value="<?php echo $this->_tpl_vars['cmsnewsedit']['news_title']; ?>
" maxlength='100'></td>
                                    </tr>
                                    <tr>
                                        <td width="200">* <?php echo $this->_tpl_vars['news_desc']; ?>
</td>
                                        <td width="1">:</td>
                                        <td><textarea rows="20" name="news_desc" id="news_desc" class='formdefault'><?php echo $this->_tpl_vars['cmsnewsedit']['news_desc']; ?>
</textarea></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->_tpl_vars['news_image']; ?>
</td>
                                        <td width="1">:</td>
                                        <td><input type='file' name="news_image" id="news_image" class='formdefault' value=""></td>
                                    </tr>

                                    <?php if ($this->_tpl_vars['cmsnewsedit']['news_image']): ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="1">:</td>
                                        <td colspan="2"><div style="width:360px;"><?php echo $this->_tpl_vars['cmsnewsedit']['news_image']; ?>
</div></td>
                                    </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <td>&nbsp;&nbsp; <?php echo $this->_tpl_vars['status']; ?>
</td>
                                        <td>:</td>
                                        <td><select name="news_void" id="news_void">
                                            <option value="1" <?php if ($this->_tpl_vars['cmsnewsedit']['news_void'] == 1): ?>selected<?php endif; ?>>
                                            <?php echo $this->_tpl_vars['active']; ?>

                                            </option>
                                            <option value="0" <?php if ($this->_tpl_vars['cmsnewsedit']['news_void'] == 0): ?>selected<?php endif; ?>>
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
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>