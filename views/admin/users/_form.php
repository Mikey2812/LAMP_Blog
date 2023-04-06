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
                <!-- First Name -->
                <label class="control-label col-md-3" for="firstname">First Name</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="firstname"
                        name="user[firstname]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['firstname'])) echo $this->record['firstname']; ?>">
                    <?php if( isset($this->errors['firstname'])) { ?>
                    <p class="text-danger"><?=$this->errors['firstname']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Last Name -->
                <label class="control-label col-md-3" for="lastname">Last Name</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="lastname"
                        name="user[lastname]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['lastname'])) echo($this->record['lastname']); ?>">
                    <?php if( isset($this->errors['lastname'])) { ?>
                    <p class="text-danger"><?=$this->errors['lastname']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- E-mail -->
                <label class="control-label col-md-3" for="email">E-mail</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="email" name="user[email]"
                        placeholder="" class="form-control"
                        value="<?php if(isset($this->record['email'])) echo($this->record['email']); ?>">
                    <?php if( isset($this->errors['email'])) { ?>
                    <p class="text-danger"><?=$this->errors['email']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Phone -->
                <label class="control-label col-md-3" for="phone">Phone</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="number" id="phone" name="user[phone]"
                        placeholder="" class="form-control"
                        value="<?php if(isset($this->record['phone'])) echo($this->record['phone']); ?>">
                    <?php if( isset($this->errors['phone'])) { ?>
                    <p class="text-danger"><?=$this->errors['phone']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <?php if($app['act'] !='view'){ ?>
            <div class="form-group row">
                <!-- Password-->
                <label class="control-label col-md-3" for="password">Password</label>
                <div class="controls col-md-7">
                    <input type="password" id="password" name="user[password]" placeholder="" class="form-control">
                    <?php if( isset($this->errors['password'])) { ?>
                    <p class="text-danger"><?=$this->errors['password']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Password -->
                <label class="control-label col-md-3" for="password_confirm">Password (Confirm)</label>
                <div class="controls col-md-7">
                    <input type="password" id="password_confirm" name="password_confirm" placeholder=""
                        class="form-control"
                        value="<?php if(isset($this->record['password_confirm'])) echo($this->record['password_confirm']); ?>">
                    <p class="text-danger"></p>
                </div>
            </div>

            <?php } ?>

            <div class="form-group row">
                <!-- Address -->
                <label class="control-label col-md-3" for="address">Address</label>
                <div class="controls col-md-7">
                    <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="address"
                        name="user[address]" placeholder="" class="form-control"
                        value="<?php if(isset($this->record['address'])) echo($this->record['address']); ?>">
                    <?php if( isset($this->errors['address'])) { ?>
                    <p class="text-danger"><?=$this->errors['address']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <label for="unitPrice" class="col-md-3 control-label">Date Birth</label>
                <div class="col-md-7">
                    <input name="user[datebirth]" type="date" class="form-control" id="datebirth" required
                        <?php echo (isset($this->record))? "value='".$this->record['datebirth']."'":""; ?>>
                    <?php if( isset($this->errors['datebirth'])) { ?>
                    <p class="text-danger"><?=$this->errors['datebirth']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Avatar -->
                <label class="control-label col-md-3" for="avatar">Avatar</label>
                <div class="controls col-md-7">
                    <?php if($app['act'] !='add'){ ?>
                    <?php if(isset($this->record['avatar'])) { ?>
                    <img src="<?php echo UploadURI.$app['ctl'].'/'.$this->record['avatar']; ?>">
                    <?php } ?>
                    <?php } ?>
                    <?php if($app['act'] !='view'){ ?>
                    <input type="file" id="avatar" name="image" placeholder="" class="form-control">
                    <?php } ?>
                    <?php if( isset($this->errors['avatar'])) { ?>
                    <p class="text-danger"><?=$this->errors['avatar']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Status -->
                <label class="control-label col-md-3" for="role">Role</label>
                <div class="controls col-md-7">
                    <?php if($app['act'] !='view'){ ?>
                    <select name="user[role]" id="input-role" class="form-control">
                        <?php foreach ($app['roles'] as $k => $v) { ?>
                        <option value="<?=$k;?>"
                            <?=(isset($this->record['role']) && $this->record['role']==$k)? 'selected="selected"':'';?>>
                            <?=$v;?></option>
                        <?php } ?>
                    </select>
                    <?php } else { ?>
                    <input disabled type="text" id="role" name="user[role]" class="form-control"
                        value="<?php if(isset($this->record['role'])) echo $app['roles'][$this->record['role']]; ?>">
                    <?php } ?>
                    <?php if( isset($this->errors['role'])) { ?>
                    <p class="text-danger"><?=$this->errors['role']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <!-- Status -->
                <label class="control-label col-md-3" for="status">Status</label>
                <div class="controls col-md-7">
                    <?php if($app['act'] !='view'){ ?>
                    <select name="user[status]" id="input-status" class="form-control">
                        <?php foreach (user_model::$status as $k => $v) { ?>
                        <option value="<?=$k;?>"
                            <?=(isset($this->record['status']) && $this->record['status']==$k)? 'selected="selected"':'';?>>
                            <?=$v;?></option>
                        <?php } ?>
                    </select>
                    <?php } else { ?>
                    <input disabled type="text" id="status" name="user[status]" class="form-control"
                        value="<?php if(isset($this->record['status'])) echo user_model::$status[$this->record['status']]; ?>">
                    <?php } ?>
                    <?php if( isset($this->errors['status'])) { ?>
                    <p class="text-danger"><?=$this->errors['status']; ?></p>
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