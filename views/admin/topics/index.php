<?php
global $mediaFiles;
array_push($mediaFiles['css'], RootREL.'media/libs/bootstrap-4.6.0/css/dataTables.bootstrap4.min.css');
array_push($mediaFiles['css'], RootREL.'media/libs/bootstrap/css/bootstrap-toggle.min.css');
?>
<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>
<?php 
global $app;
if(isset($app['prs']['status'])) {
	if($app['prs']['status'])
		$checkboxVal = 1;
	else
		$checkboxVal = NULL;
} else 	$checkboxVal = 0;
?>
<script type="text/javascript">
var norecords = parseInt(<?php echo $this->records['norecords']; ?>);
var nocurp = parseInt(<?php echo $this->records['nocurp']; ?>);
var curp = parseInt(<?php echo $this->records['curp']; ?>);
var nopp = parseInt(<?php echo $this->records['nopp']; ?>);

var getDisable = <?php echo (isset($app['prs']['status']) && ($app['prs']['status']==='0'))? 1:0;?>
</script>

<?php vendor_html_helper::contentheader('Topics <small>management</small>', [['urlp'=>['ctl'=>$app['ctl'], 'act'=>$app['act']]]]); ?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- COLOR PALETTE -->
        <div class="card card-default color-palette-box">
            <div class="card-header" id="records-header">
                <div class="row">
                    <div class="col-sm-4 col-xs-4">
                        <h3 class="card-title">
                            <i class="fas fa-tag"></i>
                            Topics
                        </h3>
                    </div>
                    <div class="col-sm-6 col-xs-4 dataTables_wrapper">
                        <form method="get" class="form-horizontal float-right"
                            action="<?php echo (vendor_app_util::url(["ctl"=>"topics", "act"=>"filter"])) ?>">
                            <div class="dataTables_filter">
                                <label class="mb-0">Search:<input type="search" class="form-control form-control-sm"
                                        placeholder="" name="kw"
                                        value="<?php if(isset($app['prs']['kw'])) echo $app['prs']['kw']; ?>"></label>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <button id="delete-records" class="btn btn-danger float-right">
                            <i class="fa fa-trash"></i>
                        </button>
                        <!-- <button id="trash-records" class="btn btn-warning pull-right">
							<i class="fa fa-lock"></i>
						</button> -->
                        <a href="<?php echo vendor_app_util::url(['ctl'=>'topics','act'=>'add']); ?>" id="add-record"
                            type="button" class="btn btn-primary float-right">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table controller="users" class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th id="checAllTop" class="checkAll" style="width: 5%;">
                                            <input type="checkbox" name="">
                                        </th>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 50%;">Topic Name</th>
                                        <th class="tabletShow" style="width: 20%;">Created Time</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-users" class="records">
                                    <?php if(count($this->records['data'])) { ?>
                                    <!-- rowDATA -->
                                    <?php foreach ($this->records['data'] as $record) { ?>
                                    <tr role="row" id="row<?=$record['id'];?>">
                                        <td id="<?php echo("checkbox".$record['id']);?>" class="checkboxRecord">
                                            <input type="checkbox" name="" alt="<?=$record['id'];?>">
                                        </td>

                                        <td id="<?php echo("id".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"topics", "act"=>"view/".$record['id']]));?>"
                                                id="viewUserReport<?=$record['id'];?>">
                                                <?php echo $record['id'];?>
                                            </a>
                                        </td>

                                        <td id="<?php echo("fullname".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"topics", "act"=>"view/".$record['id']])) ?>"
                                                id="viewUser<?=$record['id'];?>">
                                                <?php echo $record['name']; ?>
                                            </a>
                                        </td>

                                        <td id="<?php echo("time".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"topics", "act"=>"view/".$record['id']])) ?>"
                                                id="viewUser<?=$record['id'];?>">
                                                <?php echo $record['created_at']; ?>
                                            </a>
                                        </td>

                                        <td class="btn-act" class="pull-right">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"topics", "act"=>"edit/".$record['id']])) ?>"
                                                id="<?php echo("edit".$record['id']);?>" type="button"
                                                class="btn btn-primary edit-record">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <button id="del<?php echo $record['id']; ?>" type="button"
                                                class="btn btn-danger del-record" alt="<?php echo $record['id']; ?>"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <!-- rowDATA -->
                                    <?php } else { ?>
                                    <tr role="row">
                                        <td colspan="8">
                                            <h3 class="text-danger text-center"> No data </h3>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1" id="checkAllBottom" class="checkAll"
                                            style="width: 10px;">
                                            <input type="checkbox" name="">
                                        </th>
                                        <th>ID</th>
                                        <th>Topic Name</th>
                                        <th class="tabletShow">Creaed_time</th>
                                        <th rowspan="1" colspan="1">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <?php vendor_html_helper::pagination($this->records['norecords'], $this->records['nocurp'], $this->records['curp'], $this->records['nopp']); ?>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php array_push($mediaFiles['js'], RootREL."media/libs/bootstrap/js/bootstrap-toggle.min.js"); ?>
<?php array_push($mediaFiles['js'], RootREL."media/admin/js/records_table.js"); ?>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>