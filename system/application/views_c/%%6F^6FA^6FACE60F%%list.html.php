<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:38
         compiled from user/list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'user/list.html', 264, false),)), $this); ?>
<?php 
if (isset($_POST['dialog'])) {

} else {
$_POST['dialog'] = '';
}


if (isset($_POST['searchby'])) {

} else {
$_POST['searchby'] = '';
}


if (isset($_POST['keyword'])) {

} else {
$_POST['keyword'] = '';
}


if (isset($_POST['delegetion'])) {

} else {
$_POST['delegetion'] = '';
}


if (isset($_POST['status'])) {

} else {
$_POST['status'] = '';
}


if (isset($_POST['notadmin'])) {

} else {
$_POST['notadmin'] = '';
}


 ?>

<script>
    $(document).ready(
        function () {
            $("a[id=linksession]").each(
                function () {
                    $(this).click(
                        function () {
                            var id = $(this).attr("tag");
                            $.post("<?php echo $this->_tpl_vars['site_url']; ?>
/user/deletesession", {userid: id},
                                function () {
                                    alert("<?php echo $this->_tpl_vars['ldelete_session_successfully']; ?>
");
                                    search();
                                }
                            );
                        }
                    );
                }
            );

            $("#_searchby").change(
                function () {
                    switch ($(this).val()) {
                        case "user_status":
                            $("#_keyword").hide();
                            $("#_user_status").show();
                            break;
                        default:
                            $("#_keyword").show();
                            $("#_user_status").hide();
                    }
                }
            );

            <?php if ($_POST['searchby']): ?>
            $("#_searchby").val('<?php echo $_POST['searchby']; ?>
');
            $("#_user_status").val('<?php echo $_POST['status']; ?>
');
            <?php endif; ?>

                $("#_searchby").change();
            }

        );

    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/user/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
            function (data) {
                document.frmtemp.submit();
            }
        );
    }


    <?php if (! $_POST['dialog']): ?>

    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());
        //$("#status").val($("#_user_status").val());
        $("#status").val($("select#_user_status option:selected").val());
        $("#_status").val($("select#_user_status option:selected").val());
        $('select.foo').val();
        $("#showtype").val("");
        $("#offset").val(0);

        document.frmtemp.submit();
    }

    function _export() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());
        //$("#status").val($("#_user_status").val());
        $("#status").val($("select#_user_status option:selected").val());

        $("#showtype").val("export");

        document.frmtemp.submit();
    }

    function page(n) {
        if (!n) n = 0;
        $("#offset").val(n);
        $("#showtype").val("");
        document.frmtemp.submit();
    }

    <?php else: ?>

    function search() {
        $("#keyword").val($("#_keyword").val());
        $("#searchby").val($("#_searchby").val());
//     		$("#status").val($("#_user_status").val());
        $("#status").val($("select#_user_status option:selected").val());

        searchnpk(<?php echo $_POST['jabatan']; ?>
,
        $("#sortby").val(), $("#orderby").val(), $("#_searchby").val(), $("#_keyword").val(), $("#status").val()
    )
        ;
    }

    <?php endif; ?>

</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <?php if ($this->_tpl_vars['referer'] == 'activities'): ?>
        <h1><?php echo $this->_tpl_vars['luser_activities']; ?>
<?php if ($this->_tpl_vars['jabatan']): ?>( <?php echo $this->_tpl_vars['jabatan']->jabatan_name; ?>
 )<?php endif; ?></h1>
        <?php else: ?>
        <h1><?php echo $this->_tpl_vars['user_list']; ?>
<?php if ($this->_tpl_vars['jabatan']): ?>( <?php echo $this->_tpl_vars['jabatan']->jabatan_name; ?>
 )<?php endif; ?></h1>
        <?php endif; ?>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">User</a></li>
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
                        <p><?php echo $this->_tpl_vars['header_list_user']; ?>
</p>
                        <?php if (! $_POST['dialog']): ?>
                        <?php if ($this->_tpl_vars['sess']['asadmin']): ?>
                        <p>
                            <a title='<?php echo $this->_tpl_vars['lreset_datelogin_tooltips']; ?>
'
                               href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/resetdatelogin_forall"><?php echo $this->_tpl_vars['lreset_datelogin']; ?>
</a>
                            |
                            <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/reseterrlogin_forall"><?php echo $this->_tpl_vars['lreset_errorlogin']; ?>
</a>
                        </p>
                        <?php endif; ?>
                        <?php endif; ?>
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>

                            <?php if ($_POST['dialog']): ?>
                            <a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 , 'user_npk', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_npk'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lnpk']; ?>
</a>
                            <?php else: ?>
                            <a href="#" onclick="javascript:sortby('user_npk', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_npk'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['lnpk']; ?>
</a>
                            <?php endif; ?>
                            <?php if ($_POST['dialog']): ?>
                            | <a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 ,'user_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</a>
                            <?php else: ?>
                            | <a href="#" onclick="javascript:sortby('user_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['name']; ?>
</a>
                            <?php endif; ?>
                            <?php if ($_POST['dialog']): ?>
                            | <a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 , 'user_email', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_email'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['email']; ?>
</a>
                            <?php else: ?>
                            | <a href="#" onclick="javascript:sortby('user_email', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_email'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['email']; ?>
</a>
                            <?php endif; ?>
                            <?php if (! $_POST['dialog']): ?> | <a href="#" onclick="javascript:sortby('jabatan_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'jabatan_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['ljabatan']; ?>
</a> | <a href="#" onclick="javascript:sortby('user_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'user_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> <?php if ($this->_tpl_vars['referer'] != 'activities'): ?>| <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/form"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a href="javascript:_export()"><?php echo $this->_tpl_vars['lexport']; ?>
</a> <?php endif; ?><?php endif; ?>
                        </div>
                        <div class="mg-btm-10">
                            <form onsubmit="javascript:search(); return false;">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <?php echo $this->_tpl_vars['lsearch_by']; ?>

                                    </div>
                                    <div class="col-xs-3">
                                        <select class="form-control" name="_searchby" id="_searchby">
                                            <option value="user_npk"><?php echo $this->_tpl_vars['lnpk']; ?>
</option>
                                            <option value="user_name"><?php echo $this->_tpl_vars['lname']; ?>
</option>
                                            <?php $_from = $this->_tpl_vars['levels']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['level']):
?>
                                            <option value="level<?php echo $this->_tpl_vars['level']->level_nth; ?>
"><?php echo $this->_tpl_vars['level']->level_name; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                            <option value="jabatan_name"><?php echo $this->_tpl_vars['ljabatan1']; ?>
</option>
                                            <option value="user_status"><?php echo $this->_tpl_vars['lstatus']; ?>
</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3" id="_user_status">
                                        <select class="form-control" name="_user_status">
                                            <option value=""><?php echo $this->_tpl_vars['lall_status']; ?>
</option>
                                            <option value="1"><?php echo $this->_tpl_vars['lactive']; ?>
</option>
                                            <option value="2"><?php echo $this->_tpl_vars['linactive']; ?>
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
                                <?php if ($_POST['dialog']): ?>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
                                <?php if ($_POST['dialog']): ?>
                                <th width="18%"><a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 ,'user_npk', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_npk']; ?>
"><?php echo $this->_tpl_vars['lnpk']; ?>
</a></th>
                                <th width="18%"><a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 ,'user_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_name']; ?>
"><?php echo $this->_tpl_vars['name']; ?>
</a></th>
                                <th><a href="javascript:shownpkorder(<?php echo $_POST['jabatan']; ?>
 ,'user_email', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a></th>
                                <?php else: ?>
                                <th width="18%"><a href="#" onclick="javascript:sortby('user_npk', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_npk']; ?>
"><?php echo $this->_tpl_vars['lnpk']; ?>
</a></th>
                                <th width="18%"><a href="#" onclick="javascript:sortby('user_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_name']; ?>
"><?php echo $this->_tpl_vars['name']; ?>
</a></th>
                                <th width="18%"><a href="#" onclick="javascript:sortby('user_email', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_email']; ?>
"><?php echo $this->_tpl_vars['email']; ?>
</a></th>
                                <?php endif; ?>
                                <?php if (( ! $_POST['dialog'] )): ?>
                                <th width="18%"><a href="#" onclick="javascript:sortby('jabatan_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_position']; ?>
"><?php echo $this->_tpl_vars['ljabatan']; ?>
</a></th>
                                <?php if ($this->_tpl_vars['referer'] != 'activities'): ?>
                                <th><div class="listmain"><a href="#" onclick="javascript:sortby('user_status', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</a></div></th>
                                <th>&nbsp;</th>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo smarty_function_counter(array('start' => 1,'print' => false,'assign' => 'no'), $this);?>

                            <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                            <tr<?php if ($this->_tpl_vars['no']%2 == 1): ?> class="odd"<?php endif; ?>>
                            <?php if ($_POST['dialog']): ?>
                            <td class="odd"><input type="checkbox" name="_npk[]" id="_npk[]" value="<?php echo $this->_tpl_vars['row']->user_id; ?>
"<?php if ($_POST['ischecked'] == 'true'): ?>checked<?php endif; ?>  /></td>
                            <?php endif; ?>
                            <?php if (! $_POST['dialog']): ?>
                            <?php if ($this->_tpl_vars['row']->user_type > 0): ?>
                            <?php if ($this->_tpl_vars['referer'] == 'activities'): ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/activities/detail/<?php echo $this->_tpl_vars['row']->user_id; ?>
"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</a></td>
                            <?php else: ?>
                            <td class="odd"><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/form/<?php echo $this->_tpl_vars['row']->user_id; ?>
"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</a></td>
                            <?php endif; ?>
                            <?php else: ?>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</td>
                            <?php endif; ?>
                            <?php else: ?>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->user_npk; ?>
</td>
                            <?php endif; ?>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->user_name; ?>
</td>
                            <td class="odd"><?php echo $this->_tpl_vars['row']->user_email; ?>
</td>
                            <?php if (! $_POST['dialog']): ?>
                            <td class="odd"><?php if ($this->_tpl_vars['referer'] != 'activities'): ?><a href="<?php echo $this->_tpl_vars['site_url']; ?>
/jabatan/form/<?php echo $this->_tpl_vars['row']->user_jabatan; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['row']->jabatan_name; ?>
<?php if ($this->_tpl_vars['referer'] != 'activities'): ?></a><?php endif; ?></td>
                            <?php if ($this->_tpl_vars['referer'] != 'activities'): ?>
                            <?php if ($this->_tpl_vars['row']->user_type != 0): ?>
                            <td class="odd"><div id="status<?php echo $this->_tpl_vars['row']->user_id; ?>
"><a href="#" onclick="javascript:chagestatus(<?php echo $this->_tpl_vars['row']->user_id; ?>
,<?php echo $this->_tpl_vars['row']->user_status; ?>
)"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/<?php if ($this->_tpl_vars['row']->user_status == 2): ?>inactive.png<?php else: ?>active.png<?php endif; ?>" border="0" alt="<?php echo $this->_tpl_vars['row']->user_status_desc; ?>
" title="<?php echo $this->_tpl_vars['row']->user_status_desc; ?>
" /></a></div></td>
                            <?php if ($this->_tpl_vars['row']->user_loginerror || $this->_tpl_vars['row']->isinactive): ?>
                            <td class="odd">
                                <?php if ($this->_tpl_vars['row']->user_loginerror): ?>
                                <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/reseterrlogin/<?php echo $this->_tpl_vars['row']->user_id; ?>
"><?php echo $this->_tpl_vars['lreset_errorlogin']; ?>
 (<?php echo $this->_tpl_vars['row']->user_loginerror; ?>
)</a>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['row']->isinactive): ?>
                                <?php if ($this->_tpl_vars['row']->user_loginerror): ?>
                                <br/>
                                <?php endif; ?>
                                <a title='<?php echo $this->_tpl_vars['lreset_datelogin_tooltips']; ?>
'href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/resetdatelogin/<?php echo $this->_tpl_vars['row']->user_id; ?>
"><?php echo $this->_tpl_vars['lreset_datelogin']; ?>
 (<?php echo $this->_tpl_vars['row']->inactive_day; ?>
)</a>
                                <?php endif; ?>
                            </td>
                            <?php else: ?>
                            <td class="odd">&nbsp;</td>
                            <?php endif; ?>
                            <td>
                                <?php if (! $this->_tpl_vars['row']->userUsed): ?>
                                <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/user/remove/<?php echo $this->_tpl_vars['row']->user_id; ?>
" onclick="javascript: return confirm('<?php echo $this->_tpl_vars['confirm_delete']; ?>
');"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/b_del.gif" width="12" height="12" border="0" title="<?php echo $this->_tpl_vars['ldelete']; ?>
"/></a>
                                <?php endif; ?>

                                <?php if ($this->_tpl_vars['row']->logged): ?>
                                &nbsp;&nbsp;<a href="#" id="linksession" tag="<?php echo $this->_tpl_vars['row']->user_id; ?>
"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/participants.png" border="0" title="<?php echo $this->_tpl_vars['ldelete_session']; ?>
"/></a>
                                <?php endif; ?>
                            </td>
                            <?php else: ?>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <?php if ($this->_tpl_vars['row']->logged): ?>
                                <a href="#" id="linksession" tag="<?php echo $this->_tpl_vars['row']->user_id; ?>
"><img src="<?php echo $this->_tpl_vars['base_url']; ?>
images/16/participants.png" border="0" title="<?php echo $this->_tpl_vars['ldelete_session']; ?>
"/></a>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
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
                    <div class="box-footer clearfix">
                        <?php if ($_POST['dialog']): ?>
                        <?php if ($_POST['delegetion']): ?>
                        <input type="button" value=" Add " onclick="javascript: adduser2delegetion()" />
                        <?php else: ?>
                        <input type="button" value=" Save " onclick="javascript: adduser2participant()" />
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php if ($_POST['delegetion']): ?>
<form id="frmtempdialog" name="frmtempdialog" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
<?php if ($this->_tpl_vars['referer'] == 'activities'): ?>/user/activities<?php else: ?>/user/showlist<?php endif; ?>">
<?php else: ?>
<form id="frmtemp" name="frmtemp" method="post" action="<?php echo $this->_tpl_vars['site_url']; ?>
<?php if ($this->_tpl_vars['referer'] == 'activities'): ?>/user/activities<?php else: ?>/user/showlist<?php endif; ?>">
<?php endif; ?>
<?php if ($_POST['dialog']): ?>
<input type="hidden" id="dialog" name="dialog" value="1"/>
<?php endif; ?>
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
<input type="hidden" id="status" name="status" value="<?php echo $_POST['status']; ?>
"/>
<input type="hidden" id="_status" name="_status" value="<?php echo $_POST['status']; ?>
"/>
<input type="hidden" id="showtype" name="showtype" value=""/>
<input type="hidden" id="notadmin" name="notadmin" value="<?php echo $_POST['notadmin']; ?>
"/>
<?php if ($_POST['delegetion']): ?>
<input type="hidden" id="delegetion" name="delegetion" value="1"/>
<input type="hidden" id="pageid" name="pageid" value="<?php echo $_POST['pageid']; ?>
"/>
<input type="hidden" id="ischecked" name="ischecked" value="<?php echo $_POST['ischecked']; ?>
"/>
<input type="hidden" id="ischecked" name="ischecked" value="<?php echo $_POST['ischecked']; ?>
"/>
<input type="hidden" id="noheader" name="noheader" value="<?php echo $_POST['noheader']; ?>
"/>
<input type="hidden" id="funcpage" name="funcpage" value="<?php echo $_POST['funcpage']; ?>
"/>
<input type="hidden" id="deltraining" name="deltraining" value="<?php echo $_POST['deltraining']; ?>
"/>
<input type="hidden" id="deltopic" name="deltopic" value="<?php echo $_POST['deltopic']; ?>
"/>
<input type="hidden" id="jabatan" name="jabatan" value="<?php echo $_POST['jabatan']; ?>
"/>


<?php endif; ?>
</form>