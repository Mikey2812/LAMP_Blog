<div class="card card-info">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title"><?php echo ucwords($app['act'].' '.$app['ctl']); ?></h3>
    </div>

    <?php if($app['act'] != 'view') { ?>
    <form id="form-adduser"
        action="<?php echo vendor_app_util::url(["ctl"=>"topics", "act"=>$app['act'] == 'edit'?$app['act']."/".$this->record['id']:$app['act']]); ?>"
        method="post" enctype="multipart/form-data" class="form-horizontal">
        <?php } ?>
        <div class="card-body">
            <?php //if(property_exists(get_class($this),'errors')) { ?>
            <?php if(isset(($this->errors['database']))) { ?>
            <div class="alert alert-danger  alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
                <h4>Oh snap! You got an error!</h4>
                <p><?=$this->errors['database'];?></p>
            </div>
            <?php } ?>

            <?php if($app['act'] !='add'){ ?>
            <div class="form-group row">
                <!-- ID -->
                <label class="control-label col-md-3" for="id">ID</label>
                <div class="controls col-md-7">
                    <input <?php if ($app['act']=='view') {
                        echo "disabled";
                    } ?> type="text" id="id" name="topic[id]" placeholder="" class="form-control" value="<?php if (isset($this->record['id'])) {
                            echo $this->record['id'];
                        } ?>">
                    <?php if (isset($this->errors['id'])) { ?>
                    <p class="text-danger"><?=$this->errors['id']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <div class="form-group row">
                <!-- Topic Name -->
                <label class="control-label col-md-3" for="name">Topic Name</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="name" name="topic[name]"
                        placeholder="" class="form-control"
                        value="<?php if(isset($this->record['name'])) echo $this->record['name']; ?>">
                    <?php if( isset($this->errors['name'])) { ?>
                    <p class="text-danger"><?=$this->errors['name']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <?php if($app['act'] =='view'){ ?>
            <div class="form-group row">
                <!-- Created_at -->
                <label class="control-label col-md-3" for="created_at">Created_at</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="created_at"
                        created_at="topic[created_at]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['created_at'])) echo $this->record['created_at']; ?>">
                    <?php if( isset($this->errors['created_at'])) { ?>
                    <p class="text-danger"><?=$this->errors['created_at']; ?></p>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <?php if($app['act'] !='view'){ ?>
            <div class="form-group row">
                <div class="controls offset-md-3 col-md-9">
                    <input class="btn btn-success pull-right" type="submit" name="btn_submit"
                        value="<?php echo ucfirst($app['act']) ?>">
                </div>
            </div>
            <?php } ?>
        </div>
        <?php if($app['act'] != 'view') { ?>
    </form>
    <?php } ?>
</div>