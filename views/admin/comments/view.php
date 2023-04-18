<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>

<?php vendor_html_helper::contentheader('Comments <small>management</small>', [
    [
      'title' =>  'Comments',
      'urlp'=>['ctl'=>$app['ctl']]],
    [
      'title' =>  'Detail of comment ID '.$this->record['id'],
      'urlp'  =>  ['ctl'=>$app['ctl'], 'act'=>$app['act']]
    ]
]); ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><?php echo ucwords($app['act'].' '.$app['ctl']); ?></h3>
            </div>
            <div class="card-body">
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
                        <input disabled type="text" id="id" name="comment[id]" placeholder="" class="form-control"
                            value="<?php if(isset($this->record['id'])) echo $this->record['id']; ?>">
                        <?php if( isset($this->errors['id'])) { ?>
                        <p class="text-danger"><?=$this->errors['id']; ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <!-- Content -->
                    <label class="control-label col-md-3" for="content">Content</label>
                    <div class="controls col-md-7">
                        <input disabled type="text" id="content" name="comment[content]" placeholder=""
                            class="form-control"
                            value="<?php if(isset($this->record['content'])) echo($this->record['content']); ?>">
                        <?php if( isset($this->errors['content'])) { ?>
                        <p class="text-danger"><?=$this->errors['content']; ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <!-- Number Like -->
                    <label class="control-label col-md-3" for="number_like">Number Like</label>
                    <div class="controls col-md-7">
                        <input disabled type="text" id="number_like" name="comment[number_like]" placeholder=""
                            class="form-control"
                            value="<?php if(isset($this->record['number_like'])) echo($this->record['number_like']); ?>">
                        <?php if( isset($this->errors['number_like'])) { ?>
                        <p class="text-danger"><?=$this->errors['number_like']; ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <!-- Status -->
                    <label class="control-label col-md-3" for="status">Status</label>
                    <div class="controls col-md-7">
                        <span data-id="<?php echo $this->record['id']?>"
                            data-src="<?=vendor_app_util::url(array('ctl'=>'comments'.'/changetype')); ?>"
                            class="btn-status-cmt <?php echo $this->record['status'] == 1?'badge badge-success':'badge badge-danger'?>"><?php echo $app['status'][$this->record['status']]; ?></span>
                        <?php if( isset($this->errors['status'])) { ?>
                        <p class="text-danger"><?=$this->errors['status']; ?></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group row">
                    <!-- Type -->
                    <label class="control-label col-md-3" for="type">Type</label>
                    <div class="controls col-md-7">
                        <input disabled type="text" id="number_like" name="comment[number_like]" placeholder=""
                            class="form-control" value="<?php echo ($this->record['type']==0)?'Comments':'Reply'; ?>">
                        <?php if( isset($this->errors['type'])) { ?>
                        <p class="text-danger"><?=$this->errors['type']; ?></p>
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
        </div>
    </div>
</section>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>
<?php exit(); ?>