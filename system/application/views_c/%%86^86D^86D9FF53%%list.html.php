<?php /* Smarty version 2.6.26, created on 2018-10-23 10:27:37
         compiled from topic/list.html */ ?>
<script>
    function chagestatus(id, status) {
        f_onsubmit("<?php echo $this->_tpl_vars['site_url']; ?>
/topic/changestatus/" + id + "/" + status, "frmtemp", "status" + id, "Updating...",
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
            <?php echo $this->_tpl_vars['category_list']; ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Topic</a></li>
            <li class="active"><?php echo $this->_tpl_vars['category_list']; ?>
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
                        <p><?php echo $this->_tpl_vars['header_list_category']; ?>
</p>
                        <div class="mg-btm-10">
                            <?php echo $this->_tpl_vars['sort_list_by']; ?>
 <a href="#" onclick="javascript:sortby('category_name', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'category_name'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['category_name']; ?>
</a><?php if ($this->_tpl_vars['sessmodules']['topic'] && $this->_tpl_vars['sess']['asadmin']): ?> <!-- | <a href="#" onclick="javascript:sortby('category_status', 'asc')"<?php if ($this->_tpl_vars['sortby'] == 'category_status'): ?>class="lite"<?php endif; ?>><?php echo $this->_tpl_vars['status']; ?>
</a> -->| <a href="<?php echo $this->_tpl_vars['site_url']; ?>
/topic/formcategory"><?php echo $this->_tpl_vars['date_added']; ?>
</a> | <a href="<?php echo $this->_tpl_vars['site_url']; ?>
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
                                            <option value="category_name"><?php echo $this->_tpl_vars['category_name']; ?>
</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        <input class="form-control" type='text' name="_keyword" id="_keyword" class='formdefault' value="<?php echo $_POST['keyword']; ?>
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
                                <th width="70%"><a href="#" onclick="javascript:sortby('category_name', 'asc')" class="thead" title="<?php echo $this->_tpl_vars['lsort_by_category_name']; ?>
"><?php echo $this->_tpl_vars['category_name']; ?>
</a></th>
                                <?php if ($this->_tpl_vars['sessmodules']['topic'] && $this->_tpl_vars['sess']['asadmin']): ?>
                                <th><div class="listmain"><?php echo $this->_tpl_vars['status']; ?>
</div></th>
                                <th width="10%">&nbsp;</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $this->_tpl_vars['tree_html']; ?>

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
/topic/category">
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