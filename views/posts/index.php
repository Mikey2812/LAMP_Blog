<?php
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL.'media/css/posts.css');
    array_push($mediaFiles['css'], LibsURI.'Admin_LTE/plugins/toastr/toastr.min.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<?php require 'controllers/config_controller.php'; ?>
<div class="content">
    <?php if (isset($this->likes)) {
        $arrayID = filterPostID($this->likes['data']);
    } ?>
    <div class="d-flex justify-content-between">
        <h1 class="mt-5">
            <?php   
                if ($app['ctl'] == 'home'){
                    echo 'Most Viewer';
                }
                else {
                    if ($app['act'] != 'profile') {
                            echo 'List Blog';
                    } else {
                            echo 'My Blog';
                    }
                }
            ?>
        </h1>
        <a href="<?php echo vendor_app_util::url(['ctl'=>'posts', 'act'=>'add']); ?>"
            class="d-flex align-items-center btn btn-outline-info ms-2 mt-5">Add new post</a>
    </div>
    <div class="list-blog row mt-5">
        <?php if(count($this->records['data'])) { ?>
        <?php foreach ($this->records['data'] as $record) { ?>
        <div class="col-4 d-flex align-items-stretch flex-column p-3">
            <div class="post-item overflow-hidden">
                <a class="text-decoration-none"
                    href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>">
                    <img class="blog-img w-100" style="height:300px"
                        src="<?=UploadURI.'posts/'.(($record['image'])? $record['image']: 'no_picture.png'); ?>">
                    <h3 class="blog-title text-center mt-3 p-3"><?php echo $record['title']?></h3>
                </a>
                <div class="d-flex justify-content-between p-2">
                    <p class="ms-2"><i class="fa-solid fa-user me-2"></i>by
                        <?php echo $record['users_firstname'].' '.$record['users_lastname']?></p>
                    <p class="me-2"><i class="fa-regular fa-clock me-2"></i><?php echo timeago($record['created_at'])?>
                    </p>
                </div>
                <div class="posts-information d-flex justify-content-between p-3">
                    <div class="posts-action">
                        <?php if($app['act'] =='profile'){ ?>
                        <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"edit/".$record['id']])) ?>"
                            id="edit" type="button" class="btn btn-primary edit-record">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"del/".$record['id']])) ?>"
                            id="edit" type="button" class="btn btn-danger del-record">
                            <i class="fa fa-trash"></i>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="posts-info d-flex">
                        <p class="posts-view me-3"><i class="fa-regular fa-eye me-1"></i><?php echo $record['view'] ?>
                        </p>
                        <span class="btn-like me-3<?php if(isset($_SESSION['user']['id']) 
                                    && in_array($record['id'], $arrayID)){
                                        echo ' active';
                                    } ?>" alt="<?php echo $record['id']?>" data-type="0">
                            <i class="icon-like fa-solid fa-thumbs-up me-1">
                            </i>
                            <span class="number-like"><?php echo $record['number_like'];?>
                            </span>
                        </span>
                        <p class="btn-direct_comment me-2" alt="<?php echo $record['id']?>">
                            <i class="fa-regular fa-comment me-1"></i><?php echo $record['number_comment'] ?>
                        </p>
                    </div>

                    <!-- Button trigger modal
                    <span class="btn-like me-3<?/*php if(isset($_SESSION['user']['id']) 
                                    && in_array($record['id'], $arrayID)){
                                        echo ' active';
                                    } */?>" alt="<?//php echo $record['id']?>" data-type="0" type="button"
                        class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="icon-like fa-solid fa-thumbs-up me-1"></i>
                        <span class="number-like"><//?php echo $record['number_like'];?></span>
                    </span> -->
                </div>
            </div>

        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<?php
    global $mediaFiles;
    array_push($mediaFiles['js'], LibsURI.'Admin_LTE/plugins/toastr/toastr.min.js');
    array_push($mediaFiles['js'], RootREL.'media/js/posts.js');
?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>