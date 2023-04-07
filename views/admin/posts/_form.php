<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo ucwords($app['act'].' '.$app['ctl']); ?></h3>
    </div>
    <?php if($app['act'] != 'view') { ?>
    <form id="form-adduser"
        action="<?php echo vendor_app_util::url(["ctl"=>"users", "act"=>$app['act'] == 'edit'?$app['act']."/".$this->record['id']:$app['act']]); ?>"
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

            <div class="form-group row">
                <!-- ID -->
                <label class="control-label col-md-3" for="id">ID</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="id" name="user[id]"
                        placeholder="" class="form-control"
                        value="<?php if(isset($this->record['id'])) echo $this->record['id']; ?>">
                    <?php if( isset($this->errors['id'])) { ?>
                    <p class="text-danger"><?=$this->errors['id']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- User ID -->
                <label class="control-label col-md-3" for="user_id">User ID</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="user_id"
                        name="user[user_id]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['user_id'])) echo($this->record['user_id']); ?>">
                    <?php if( isset($this->errors['user_id'])) { ?>
                    <p class="text-danger"><?=$this->errors['user_id']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Title -->
                <label class="control-label col-md-3" for="title">Title</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="title" name="user[title]"
                        placeholder="" class="form-control"
                        value="<?php if(isset($this->record['title'])) echo($this->record['title']); ?>">
                    <?php if( isset($this->errors['title'])) { ?>
                    <p class="text-danger"><?=$this->errors['title']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Content -->
                <label class="control-label col-md-3" for="content">Content</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="content"
                        name="user[content]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['content'])) echo($this->record['content']); ?>">
                    <?php if( isset($this->errors['content'])) { ?>
                    <p class="text-danger"><?=$this->errors['content']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Number of Like-->
                <label class="control-label col-md-3" for="number_like">Number of Like</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="number_like"
                        name="user[number_like]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['number_like'])) echo($this->record['number_like']); ?>">
                    <?php if( isset($this->errors['number_like'])) { ?>
                    <p class="text-danger"><?=$this->errors['number_like']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Image -->
                <label class="control-label col-md-3" for="image">Image</label>
                <div class="controls col-md-7">
                    <?php if($app['act'] !='add'){ ?>
                    <?php if(isset($this->record)) { ?>
                    <img src="<?php echo UploadURI.$app['ctl'].'/'.$this->record['image']; ?>">
                    <?php } ?>
                    <?php } ?>
                    <?php if($app['act'] !='view'){ ?>
                    <input type="file" id="image" name="image" placeholder="" class="form-control">
                    <?php } ?>
                    <?php if( isset($this->errors['image'])) { ?>
                    <p class="text-danger"><?=$this->errors['image']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Created At -->
                <label class="control-label col-md-3" for="created_at">Created At</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="created_at"
                        name="user[created_at]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['created_at'])) echo($this->record['created_at']); ?>">
                    <?php if( isset($this->errors['created_at'])) { ?>
                    <p class="text-danger"><?=$this->errors['created_at']; ?></p>
                    <?php } ?>
                </div>
            </div>

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