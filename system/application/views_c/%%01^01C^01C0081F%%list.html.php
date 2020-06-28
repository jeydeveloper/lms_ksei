<?php /* Smarty version 2.6.26, created on 2020-05-30 19:40:11
         compiled from training/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'training/list.html', 128, false),)), $this); ?>
<script>
    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
            function (data) {
                document.frmtemp.submit();
            }
        );
    }

    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());

        document.frmtemp.submit();
    }

    function historynpk(trainingid) {
        m_trainingid = trainingid;
        $('#modal-default').modal('show');
    }

    function dohistorynpk() {
        var val_checked = $('input[name=exporttype]:checked', '#frmexportype').val();
        location = "<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historynpk/0/0/" + m_trainingid + "/export/1/1/" + val_checked;
        $("#exportdialog").dialog("close");
    }

    $(document).ready(
        function () {
            $("#exportdialog").dialog(
                {
                    autoOpen: false
                    , modal: true
                    , width: 550
                }
            )

            <?php if ($_POST['searchby']): ?>
            $("#_searchby").val('<?php echo $_POST['searchby']; ?>
');
            <?php endif; ?>
            }
        );

    var m_trainingid = 0;
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo $this->_tpl_vars['learning_topics_list']; ?>
 <?php if ($this->_tpl_vars['topicid']): ?>&quot;<?php echo $this->_tpl_vars['topiccurr']->category_name; ?>
&quot;<?php endif; ?></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Training</a></li>
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
 <a href="#" onclick="javascript:sortby('training_code', 'asc')" <?php if ($this->_tpl_vars['sortby'] == 'training_code'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lcode']; ?>
</a> |
                            <a href="#" onclick="javascript:sortby('training_name', 'asc')" <?php if ($this->_tpl_vars['sortby'] == 'training_name'): ?>class="lite"<?php endif; ?>><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate_name']; ?>
<?php endif; ?></a> <?php if (( $this->_tpl_vars['sessmodules']['training'] || $this->_tpl_vars['sessmodules']['certificate'] ) && $this->_tpl_vars['sess']['asadmin']): ?> | <a
                                href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/form/0/<?php echo $this->_tpl_vars['topicid']; ?>
"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a
                                href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['controller']; ?>
/export"><?php echo $this->_tpl_vars['lexport']; ?>
</a> | <a
                                href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['controller']; ?>
/exporthistory"><?php echo $this->_tpl_vars['lexport_history']; ?>
</a> <?php endif; ?>
                        </div>
                        <div class="mg-btm-10">
                            <form onsubmit="javascript:search(); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="training_code"><?php echo $this->_tpl_vars['lcode']; ?>
</option>
                                            <option value="training_name"><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate_name']; ?>
<?php endif; ?>
                                            </option>
                                            <?php if (! $this->_tpl_vars['topicid']): ?>
                                            <option value="category_name"><?php echo $this->_tpl_vars['ltopic']; ?>
</option>
                                            <?php endif; ?>
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
                                <th width="12%"><a href="#" onclick="javascript:sortby('training_code', 'asc')"
                                                   class="thead" title="<?php echo $this->_tpl_vars['lsort_by_code']; ?>
"><?php echo $this->_tpl_vars['lcode']; ?>
</a></th>
                                <th width="20%"><a href="#" onclick="javascript:sortby('training_name', 'asc')"
                                                   class="thead" title="<?php echo $this->_tpl_vars['lsort_by_name']; ?>
"><?php if ($this->_tpl_vars['pageid'] == 'training'): ?><?php echo $this->_tpl_vars['ltraining_column']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lcertificate_name_column']; ?>
<?php endif; ?></a></th>
                                <?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
                                <th width="24%"><?php echo $this->_tpl_vars['lperiod']; ?>
</th>
                                <?php else: ?>
                                <th width="10%"><?php echo $this->_tpl_vars['ltopic']; ?>
</th>
                                <th width="6%"><a href="#" onclick="javascript:sortby('training_created_date', 'asc')"
                                                   class="thead" title="created date">Created</a></th>
                                <th>&nbsp;</th>
                                <th width="13%"><?php echo $this->_tpl_vars['lparticipant']; ?>
</th>
                                <th width="13%">&nbsp;</th>
                                <th width="3%"><?php echo $this->_tpl_vars['lstatus']; ?>
</th>
                                <th width="3%">&nbsp;</th>
                                <?php endif; ?>

                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr>
                                <?php if ($this->_tpl_vars['sessmodules']['trainee'] && ! $this->_tpl_vars['sess']['asadmin']): ?>
                                <?php if ($this->_tpl_vars['row']->inperiod || $this->_tpl_vars['row']->allperiod): ?>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/examintro/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['row']->training_code; ?>
</a></td>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/examintro/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['row']->training_name; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->training_code; ?>
</td>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->training_name; ?>
</td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['row']->inperiod): ?>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/examintro/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php if ($this->_tpl_vars['row']->period->training_time_date1_str): ?><?php echo $this->_tpl_vars['row']->period->training_time_date1_str; ?>

                                    <?php echo $this->_tpl_vars['luntil']; ?>
 <?php echo $this->_tpl_vars['row']->period->training_time_date2_str; ?>
<?php else: ?>&nbsp;<?php endif; ?></a></td>
                                <?php elseif ($this->_tpl_vars['row']->allperiod): ?>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/examintro/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['lall_period']; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd"><?php if ($this->_tpl_vars['row']->period->training_time_date1_str): ?><?php echo $this->_tpl_vars['row']->period->training_time_date1_str; ?>
 <?php echo $this->_tpl_vars['luntil']; ?>
 <?php echo $this->_tpl_vars['row']->period->training_time_date2_str; ?>
<?php else: ?>&nbsp;<?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <?php else: ?>
                                <?php if ($this->_tpl_vars['sess']['user_id'] == $this->_tpl_vars['row']->training_creator || $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['row']->delegetion): ?>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/form/<?php echo $this->_tpl_vars['row']->training_id; ?>
/<?php echo $this->_tpl_vars['topicid']; ?>
"><?php echo $this->_tpl_vars['row']->training_code; ?>
</a></td>
                                <?php else: ?>
                                <td class="odd"><?php echo $this->_tpl_vars['row']->training_code; ?>
</td>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['sess']['user_id'] == $this->_tpl_vars['row']->training_creator || $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['row']->delegetion): ?>
                                <td class="odd"><a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
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
                                <td class="odd"><?php echo $this->_tpl_vars['row']->training_created_date; ?>
</td>
                                <td class="odd">
                                    <?php if ($this->_tpl_vars['sess']['user_id'] == $this->_tpl_vars['row']->training_creator || $this->_tpl_vars['sess']['user_type'] == 0 || $this->_tpl_vars['row']->delegetion): ?>
                                    <?php if ($this->_tpl_vars['pageid'] == 'certificate'): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/setting/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                       title="<?php echo $this->_tpl_vars['lsetting']; ?>
">
                                        <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/general_settings.png" alt="" width="16"
                                             height="16" border="0">
                                    </a>
                                    |
                                    <?php endif; ?>

                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/participant/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                       title="<?php echo $this->_tpl_vars['lparticipant']; ?>
">
                                        <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/participants.png" alt="" width="16"
                                             height="16" border="0">
                                    </a>
                                    | <a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/prequisite/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                        title="<?php echo $this->_tpl_vars['lprequisite']; ?>
">
                                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/proreq.png" alt="" width="16" height="16"
                                         border="0">
                                </a>
                                    | <a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/postrequisite/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                        title="<?php echo $this->_tpl_vars['lpostrequisite']; ?>
">
                                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/postreq.png" alt="" width="16" height="16"
                                         border="0">
                                </a>
                                    <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                    | <a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/praexam/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                        title="<?php echo $this->_tpl_vars['lpraexam_lexam']; ?>
">
                                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/pra-exam.png" alt="" width="16" height="16"
                                         border="0">

                                </a>
                                    <?php if ($this->_tpl_vars['pageid'] == 'training'): ?>
                                    <?php if ($this->_tpl_vars['row']->training_material_type == 1): ?>
                                    | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/training/download/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><img
                                        src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/backup.png" alt="download" border="0"/></a>
                                    <?php else: ?>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <?php endif; ?>

                                    | <a
                                        href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/delegetion/<?php if ($this->_tpl_vars['topicid']): ?><?php echo $this->_tpl_vars['topicid']; ?>
<?php else: ?>0<?php endif; ?>/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                        title="<?php echo $this->_tpl_vars['ldelegetion']; ?>
">
                                    <img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/participants.png" alt="" width="16" height="16"
                                         border="0">
                                </a>

                                </td>
                                <td class="old">
                                    <?php if ($this->_tpl_vars['row']->taked): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historyexam/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['row']->taked; ?>
 | <?php echo $this->_tpl_vars['row']->percentpeserta; ?>
%</a>
                                    <?php if ($this->_tpl_vars['pageid'] != 'training'): ?>
                                    | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/certificate/resetter/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                         onclick="javascript: return confirm('<?php echo $this->_tpl_vars['lconfirm_reset_all_npk']; ?>
')"><?php echo $this->_tpl_vars['lreset']; ?>
</a>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    &nbsp;
                                    <?php endif; ?>
                                </td>
                                <td class="odd">
                                    <?php if ($this->_tpl_vars['row']->taked): ?>
                                    <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/historynpk/0/0/<?php echo $this->_tpl_vars['row']->training_id; ?>
"><?php echo $this->_tpl_vars['lshow_all']; ?>
</a>
                                    |
                                    <a href="javascript: historynpk(<?php echo $this->_tpl_vars['row']->training_id; ?>
)"><?php echo $this->_tpl_vars['lexport']; ?>
</a>
                                    <?php else: ?>
                                    &nbsp;
                                    <?php endif; ?>
                                </td>
                                <td class="odd">
                                    <div id="status<?php echo $this->_tpl_vars['row']->training_id; ?>
"><a href="#"
                                                                               onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->training_id; ?>
,<?php echo $this->_tpl_vars['row']->training_status; ?>
)"><img
                                            src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->training_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>"
                                            border="0" alt="<?php echo $this->_tpl_vars['row']->training_status_desc; ?>
"
                                            title="<?php echo $this->_tpl_vars['row']->training_status_desc; ?>
"/></a></div>
                                </td>
                                <?php if ($this->_tpl_vars['row']->used): ?>
                                <td class="odd">&nbsp;</td>
                                <?php else: ?>
                                <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/<?php echo $this->_tpl_vars['pageid']; ?>
/remove/<?php echo $this->_tpl_vars['row']->training_id; ?>
"
                                                   onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img
                                        src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0"
                                        title="<?php echo $this->_tpl_vars['ldelete']; ?>
"/></a></td>
                                <?php endif; ?>
                                <?php else: ?>
                                <td class="odd">&nbsp;</td>
                                <td class="odd">&nbsp;</td>
                                <td class="odd">&nbsp;</td>
                                <td class="odd">&nbsp;</td>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmexportype">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">History NPK</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-info alert-dismissible">
                        <?php echo $this->_tpl_vars['lexport_type']; ?>

                    </div>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="1">
                                <?php echo $this->_tpl_vars['lmax_score']; ?>

                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="2" checked>
                                <?php echo $this->_tpl_vars['llast_lulus']; ?>

                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="exporttype" value="3">
                                <?php echo $this->_tpl_vars['llast_score']; ?>

                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <input class="btn btn-primary" type="button" onclick="javascript:dohistorynpk()"
                           value="<?php echo $this->_tpl_vars['lexport']; ?>
"/>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->