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

<?php vendor_html_helper::contentheader('Posts <small>management</small>', [['urlp'=>['ctl'=>$app['ctl'], 'act'=>$app['act']]]]); ?>

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
                            Posts
                        </h3>
                    </div>
                    <div class="col-sm-6 col-xs-4 dataTables_wrapper">
                        <form method="get" class="form-horizontal float-right">
                            <div class="dataTables_filter">
                                <label class="mb-0">Search:<input type="search" class="form-control form-control-sm"
                                        placeholder="" name="kw"
                                        value="<?php if(isset($app['prs']['kw'])) echo $app['prs']['kw']; ?>"></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table controller="post" class="table table-bordered table-striped dataTable" role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th id="checAllTop" class="checkAll" style="width: 2%;">
                                            <input type="checkbox" name="">
                                        </th>
                                        <th style="width: 3%;">ID</th>
                                        <th style="width: 15%;">Author</th>
                                        <th style="width: 10%;">Topic Name</th>
                                        <th class="tabletShow" style="width: 25%;">Title</th>
                                        <th class="tabletShow" style="width: 10%;">Number of like</th>
                                        <th class="tabletShow" style="width: 15%;">Image</th>
                                        <th style="width: 20%;">Updated At</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-post" class="records">
                                    <?php if(count($this->records['data'])) { ?>
                                    <!-- rowDATA -->
                                    <?php foreach ($this->records['data'] as $record) { ?>
                                    <tr role="row" id="row<?=$record['id'];?>">
                                        <td id="<?php echo("checkbox".$record['id']);?>" class="checkboxRecord">
                                            <input type="checkbox" name="" alt="<?=$record['id'];?>">
                                        </td>
                                        <td id="<?php echo("id".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>"
                                                id="viewUser<?=$record['id'];?>">
                                                <?php echo $record['id']; ?>
                                            </a>
                                        </td>
                                        <td id="<?php echo("author".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']]));?>"
                                                id="viewUserReport<?=$record['id'];?>">
                                                <?php echo $record['users_firstname'].' '.$record['users_lastname']  ?>
                                            </a>
                                        </td>
                                        <td id="<?php echo("topic".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']]));?>"
                                                id="viewUserReport<?=$record['id'];?>">
                                                <?php echo $record['topics_name']?>
                                            </a>
                                        </td>
                                        <td class="tabletShow" id="<?php echo("title".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>"
                                                id="viewUserRequest<?=$record['id'];?>">
                                                <?php echo $record['title']; ?>
                                            </a>
                                        </td>
                                        <td id="<?php echo("id".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']]));?>"
                                                id="viewUserReport<?=$record['id'];?>">
                                                <?php echo $record['number_like'] ?>
                                            </a>
                                        </td>
                                        <td class="webShow" id="<?php echo("image".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>"
                                                id="imageViewUser<?=$record['id'];?>">
                                                <img style="width:150px"
                                                    src="<?=UploadURI.$app['ctl'].'/'.(($record['image'])? $record['image']: 'no_picture.png'); ?>">
                                            </a>
                                        </td>
                                        <td class="tabletShow" id="<?php echo("updated_at".$record['id']);?>">
                                            <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>"
                                                id="viewUserRequest<?=$record['id'];?>">
                                                <?php echo $record['updated_at']; ?>
                                            </a>
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
                                        <th style="width: 3%;">ID</th>
                                        <th style="width: 15%;">Author</th>
                                        <th style="width: 10%;">Topic Name</th>
                                        <th class="tabletShow" style="width: 25%;">Title</th>
                                        <th class="tabletShow" style="width: 10%;">Number of like</th>
                                        <th class="tabletShow" style="width: 15%;">Image</th>
                                        <th style="width: 20%;">Updated At</th>
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