<?php /* Smarty version 2.6.26, created on 2020-05-04 09:33:52
         compiled from classroom/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'classroom/list.html', 69, false),)), $this); ?>
<script>
    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());

        document.frmtemp.submit();
    }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h2><?php echo $this->_tpl_vars['learning_topics_list']; ?>
 <?php if ($this->_tpl_vars['topicid']): ?>&quot;<?php echo $this->_tpl_vars['topiccurr']->category_name; ?>
&quot;<?php endif; ?></h2>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Classroom</a></li>
            <li class="active">Showlist</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div id="msg-content" class="alert alert-danger alert-dismissible" style="display: none;">
                    <div id="message"></div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <p><?php echo $this->_tpl_vars['header_list_topic']; ?>
</p>
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('training_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'training_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lclassroom_name']; ?>
</a>
                        </div>
                        <div class="mg-btm-10">
                            <form onsubmit="javascript:search(); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="training_name"><?php echo $this->_tpl_vars['lclassroom_name']; ?>
</option>
                                            <option value="category_name"><?php echo $this->_tpl_vars['ltopic']; ?>
</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <input class="form-control" type='text' name="_keyword" id="_keyword"
                                               class='formdefault' value="<?php echo $_POST['keyword']; ?>
">
                                    </div>
                                    <div class="col-xs-3">
                                        <input class="btn btn-primary" type='submit' value=" <?php echo $this->_tpl_vars['lsearch']; ?>
 ">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <hr>
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th><a href="#" onclick="javascript:sortby('training_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_name_column']; ?>
">
                                    <?php echo $this->_tpl_vars['lname_column']; ?>

                                </a></th>
                                <th width="30%"><?php echo $this->_tpl_vars['topic_column']; ?>
</th>
                                <th width="13%"><?php echo $this->_tpl_vars['lparticipant']; ?>
</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr>
                                <?php if ($this->_tpl_vars['sess']['user_id'] == $this->_tpl_vars['row']->training_creator || $this->_tpl_vars['sess']['user_type'] == 0): ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/form/<?php echo $this->_tpl_vars['row']->training_id; ?>
/<?php echo $this->_tpl_vars['topicid']; ?>
"><?php echo $this->_tpl_vars['row']->training_name; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->training_name; ?>
</td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['sess']['user_id'] == $this->_tpl_vars['row']->category_creator): ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formtopic/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->category_name; ?>
</td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['row']->taked): ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/classroom/historynpk/0/0/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['row']->taked; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd">0</td>
                                <?php endif; ?>
                            </tr>
                            <?php echo smarty_function_counter(array(), $this);?>

                            <?php endforeach; endif; unset($_from); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class="content-paging"><?php echo $this->_tpl_vars['paging']; ?>
</div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/showlist/<?php echo $this->_tpl_vars['topicid']; ?>
">
    <input type="hidden" id="limit" name="limit" value="<?php echo $this->_tpl_vars['limit']; ?>
"/>
    <input type="hidden" id="sortby" name="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
"/>
    <input type="hidden" id="orderby" name="orderby" value="<?php echo $this->_tpl_vars['orderby']; ?>
"/>
    <input type="hidden" id="offset" name="offset" value="<?php echo $this->_tpl_vars['offset']; ?>
"/>
    <input type="hidden" id="keyword" name="keyword" value="<?php echo $_POST['keyword']; ?>
"/>
    <input type="hidden" id="searchby" name="searchby" value="<?php echo $_POST['searchby']; ?>
"/>
</form>