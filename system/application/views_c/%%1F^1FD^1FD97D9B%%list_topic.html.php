<?php /* Smarty version 2.6.26, created on 2018-10-23 09:55:32
         compiled from topic/list_topic.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'topic/list_topic.html', 128, false),)), $this); ?>
<script>
    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
            function (data) {
                document.frmtemp.submit();
            }
        );
    }

    function desc(id) {
        if ($("#desc" + id).css("display") == "none") {
            $("#desc" + id).show();
            $("#expand" + id).html("-");
        }
        else {
            $("#desc" + id).hide();
            $("#expand" + id).html("+");
        }
    }

    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());

        document.frmtemp.submit();
    }

    $(document).ready(
        function () {
            <?php if ($_POST['searchby']): ?>
            $("#_searchby").val('<?php echo $_POST['searchby']; ?>
');
            <?php endif; ?>
            }
        );
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $this->_tpl_vars['learning_topics_list']; ?>

            <?php if ($this->_tpl_vars['rowcatid']): ?>
            &quot;<?php echo $this->_tpl_vars['rowcatid']->category_name; ?>
&quot;
            <?php endif; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Topic</a></li>
            <li class="active"><?php echo $this->_tpl_vars['learning_topics_list']; ?>

                <?php if ($this->_tpl_vars['rowcatid']): ?>
                &quot;<?php echo $this->_tpl_vars['rowcatid']->category_name; ?>
&quot;
                <?php endif; ?>
            </li>
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
 <a href="#" onclick="javascript:sortby('category_code', 'asc')" <?php if ($this->_tpl_vars['sortby'] == 'category_code'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['topic_code1']; ?>
</a> | <a href="#" onclick="javascript:sortby('category_name', 'asc')" <?php if ($this->_tpl_vars['sortby'] == 'category_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['topic']; ?>
</a> <?php if ($this->_tpl_vars['hasrighttopic'] && $this->_tpl_vars['sess']['asadmin']): ?> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formtopic"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a
                                href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/export"><?php echo $this->_tpl_vars['lexport']; ?>
</a><?php endif; ?>
                        </div>
                        <div class="mg-btm-10">
                            <form onsubmit="javascript:search(); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="category_code"><?php echo $this->_tpl_vars['topic_code1']; ?>
</option>
                                            <option value="category_name"><?php echo $this->_tpl_vars['topic']; ?>
</option>
                                            <option value="category_parent"><?php echo $this->_tpl_vars['category']; ?>
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
                                <th width="3%">&nbsp;</th>
                                <th width="15%"><a href="#" onclick="javascript:sortby('category_code', 'asc')"
                                                   class="thead" title="<?php echo $this->_tpl_vars['lsort_by_topic_code']; ?>
"><?php echo $this->_tpl_vars['topic_code']; ?>
</a></th>
                                <th><a href="#" onclick="javascript:sortby('category_name', 'asc')" class="thead"
                                       title="<?php echo $this->_tpl_vars['lsort_by_topic_name']; ?>
"><?php echo $this->_tpl_vars['topic']; ?>
</a></th>
                                <th width="20%"><?php echo $this->_tpl_vars['category']; ?>
</th>
                                <?php if ($this->_tpl_vars['trainingtype'] == -1): ?>
                                <th width="25">OL
                                </td>
                                <th width="25">OC
                                </td>
                                <th width="25">RES
                                </td>
                                <th width="25">CR
                                </td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['hasrighttopic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <th width="10%">
                                    <div class="listmain"><a href="#"
                                                             onclick="javascript:sortby('category_status', 'asc')"
                                                             class="thead" title="sort by topic STATUS"><?php echo $this->_tpl_vars['status']; ?>
</a></div>
                                </th>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr>
                                <?php if ($this->_tpl_vars['row']->category_desc): ?>
                                <td class="odd"><a href="javascript:desc(<?php echo $this->_tpl_vars['row']->category_id; ?>
)">
                                    <div id="expand<?php echo $this->_tpl_vars['row']->category_id; ?>
">+</div>
                                </a></td>
                                <?php else: ?>
                                <td class="odd">&nbsp;</td>
                                <?php endif; ?>

                                <td class="odd">
                                    <?php if ($this->_tpl_vars['hasrighttopic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formtopic/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_code; ?>
</a>
                                    <?php elseif (! $this->_tpl_vars['sess']['asadmin']): ?>
                                    <?php if ($this->_tpl_vars['trainingtype'] == 1): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_code; ?>
</a>
                                    <?php elseif ($this->_tpl_vars['trainingtype'] == 2): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_code; ?>
</a>
                                    <?php elseif ($this->_tpl_vars['trainingtype'] == 4): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/index/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_code; ?>
</a>
                                    <?php else: ?>
                                    <?php echo $this->_tpl_vars['row']->category_code; ?>

                                    <?php endif; ?>
                                    <?php else: ?>
                                    <?php echo $this->_tpl_vars['row']->category_code; ?>

                                    <?php endif; ?>
                                </td>
                                <td class="odd">
                                    <?php if ($this->_tpl_vars['hasrighttopic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formtopic/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a>
                                    <?php elseif (! $this->_tpl_vars['sess']['asadmin']): ?>
                                    <?php if ($this->_tpl_vars['trainingtype'] == 1): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a>
                                    <?php elseif ($this->_tpl_vars['trainingtype'] == 2): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a>
                                    <?php elseif ($this->_tpl_vars['trainingtype'] == 4): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/index/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a>
                                    <?php elseif ($this->_tpl_vars['trainingtype'] == 3): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildp/topic/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category_name; ?>
</a>
                                    <?php else: ?>
                                    <?php echo $this->_tpl_vars['row']->category_name; ?>

                                    <?php endif; ?>
                                    <?php else: ?>
                                    <?php echo $this->_tpl_vars['row']->category_name; ?>

                                    <?php endif; ?>
                                    <div style="display: none;" id="desc<?php echo $this->_tpl_vars['row']->category_id; ?>
">
                                        <?php echo $this->_tpl_vars['row']->category_desc; ?>

                                    </div>
                                </td>
                                <td class="odd">
                                    <?php if ($this->_tpl_vars['hasrightcategory'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formcategory/<?php echo $this->_tpl_vars['row']->category->category_id; ?>
"><?php echo $this->_tpl_vars['row']->category->category_name; ?>
</a>
                                    <?php else: ?>
                                    <?php echo $this->_tpl_vars['row']->topcategory->category_name; ?>

                                    <?php endif; ?>
                                </td>
                                <?php if ($this->_tpl_vars['trainingtype'] == -1): ?>
                                <td class="odd">
                                    <?php if (( $this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] ) && $this->_tpl_vars['row']->hastraining): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/online_training.png" width="16" height="16"
                                            border="0" title="<?php echo $this->_tpl_vars['online_training']; ?>
"/></a>
                                    <?php endif; ?>
                                    &nbsp;
                                </td>
                                <td class="odd">
                                    <?php if (( $this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] ) && $this->_tpl_vars['row']->hascertificate): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/showlist/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/certification.png" width="16" height="16"
                                            border="0" title="<?php echo $this->_tpl_vars['lcertificate']; ?>
"/></a>
                                    <?php endif; ?>
                                    &nbsp;
                                </td>
                                <td class="odd">
                                    <?php if (( $this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] ) && $this->_tpl_vars['row']->hasresources): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/resources/index/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/resources.png" width="16" height="16"
                                            border="0" title="<?php echo $this->_tpl_vars['resources']; ?>
"/> </a>
                                    <?php endif; ?>
                                    &nbsp;
                                </td>
                                <td class="odd">
                                    <?php if (( $this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin'] ) && $this->_tpl_vars['row']->hascatalogs): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/ildp/topic/<?php echo $this->_tpl_vars['row']->category_id; ?>
"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/classroom.png" width="16" height="16"
                                            border="0" title="<?php echo $this->_tpl_vars['lclassroom']; ?>
"/> </a>
                                    <?php endif; ?>
                                    &nbsp;
                                </td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['hasrighttopic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <td class="odd">
                                    <div id="status<?php echo $this->_tpl_vars['row']->category_id; ?>
"><a href="#"
                                                                               onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->category_id; ?>
,<?php echo $this->_tpl_vars['row']->category_status; ?>
)"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->category_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>"
                                            border="0" alt="<?php echo $this->_tpl_vars['row']->category_status_desc; ?>
"
                                            title="<?php echo $this->_tpl_vars['row']->category_status_desc; ?>
"/></a></div>
                                </td>
                                <?php if ($this->_tpl_vars['row']->used): ?>
                                <td class="odd">&nbsp;</td>
                                <?php else: ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/remove/<?php echo $this->_tpl_vars['row']->category_id; ?>
"
                                                   onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img
                                        src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0"/></a>
                                </td>
                                <?php endif; ?>
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
                        <?php if ($this->_tpl_vars['trainingtype'] == -1): ?>
                        <br/>
                        <p>* Notes :<br/>
                            OL : Online Training<br/>
                            OC : Online Certification<br/>
                            RES : Resources<br/>
                            CR : Classroom
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['currenturl']; ?>
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