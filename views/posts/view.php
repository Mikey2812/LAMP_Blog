<?php
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL.'media/css/posts.css');
    array_push($mediaFiles['css'], LibsURI.'Admin_LTE/plugins/toastr/toastr.min.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<?php require 'controllers/config_controller.php'; ?>
<div class="content mt-5">
    <?php if (isset($this->likes)) {
        $arrayID = filterCommentID($this->likes['data']);
        var_dump($arrayID);
    } ?>
    <div class="row">
        <h1><?php echo ($this->record['title']); ?></h1>
        <p><?php echo ($this->record['content']); ?></p>
    </div>
    <hr class="featurette-divider">
    <div class="comment_content">
        <div class="col-12">
            <div class="container mt-5 mb-5">
                <div class="row height d-flex justify-content-center align-items-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="p-3">
                                <h4>Comment (
                                    <p class="number-comment d-inline m-0"><?php echo $this->record['number_comment'] ?>
                                    </p>
                                    )
                                </h4>
                            </div>
                            <?php if(isset($_SESSION['user'])) { ?>
                            <div class=" mt-3 d-flex flex-row align-items-center p-3 form-color">
                                <img src="<?php echo user_model::getAvatarUrl();?>" width="60" height="60"
                                    class="comment-avatar rounded-circle me-3"
                                    alt="<?php echo $_SESSION['user']['firstname'].' '.$_SESSION['user']['lastname']?>"
                                    style="min-width:60px">
                                <form class="d-flex w-100 align-items-center"
                                    action="<?php echo vendor_app_util::url(["ctl"=>"comments", "act"=>"add"]); ?>"
                                    method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <input type="text" id="user_id" class="input-user form-control d-none"
                                        name="comment[user_id]" value="<?php echo $_SESSION['user']['id'] ?>">
                                    <input type=" text" id="post_id" class="input-post form-control d-none"
                                        name="comment[post_id]" value="<?php echo ($this->record['id']); ?>">
                                    <input type="text" id="content" class="input-content form-control w-100 p-3"
                                        placeholder="Enter your comment..." name="comment[content]">
                                    <a class="btn-comments btn btn-outline-primary h-75 ms-3" type="submit"
                                        name="add_comments"
                                        href="<?php echo vendor_app_util::url(["ctl"=>"comments", "act"=>"add"]); ?>">Add</a>
                                </form>
                            </div>
                            <div class="list-comments mt-2">
                                <?php if(isset($this->comments)) { ?>
                                <?php foreach ($this->comments['data'] as $comment) { 
                                    $commentCSS =substr_count($comment['path'], '.')?>
                                <div class="comment-items d-flex flex-row" <?php if ($commentCSS > 1) { ?>
                                    style="padding-left:<?php echo (($commentCSS - 1) * 3 + 1);?>rem" <?php } ?>>
                                    <img src="
                                    <?=UploadURI.'users/'.(($comment['users_avatar'])? $comment['users_avatar']: 'no_picture.png'); ?>"
                                        width="60" height="60" class="rounded-circle me-3">
                                    <div class="w-100">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-row align-items-center">
                                                <h6 class="mr-2">
                                                    <?php echo $comment['users_firstname'].' '.$comment['users_lastname'];?>
                                                </h6>
                                            </div>
                                            <small><?php echo timeago($comment['updated_at'])?></small>
                                        </div>
                                        <p class="text-justify comment-text mb-0"><?php echo $comment['content'];?></p>
                                        <div class="d-flex flex-row user-feed mt-2">
                                            <!-- <span class="btn-like me-3"><i
                                                    class="icon-like fa-solid fa-thumbs-up me-1"></i>Like</span>
                                            <span class="likes-info me-3">
                                                <i class="fa-regular fa-thumbs-up me-1"></i>
                                                <span class="number-like"><?php echo $comment['number_like'];?></span>
                                            </span> -->
                                            <span class="btn-like me-3
                                                <?php if(isset($_SESSION['user']['id']) && in_array($comment['id'], $arrayID)){
                                                    echo ' active';
                                                } ?>" alt="<?php echo $comment['id']?>" data-type="1">
                                                <i class="icon-like fa-solid fa-thumbs-up me-1">
                                                </i>
                                                <span class="number-like"><?php echo $comment['number_like'];?>
                                                </span>
                                            </span>
                                            <button class="btn-reply border-0"
                                                data-comment-path="<?php echo $comment['path']; ?>">
                                                <i class="fa fa-comments-o me-1"></i>
                                                <span class="reply">Reply</span>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } else { ?>
                            <div class="alert alert-warning d-flex justify-content-center align-items-center"
                                role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16"
                                    role="img" aria-label="Warning:" style="max-width: 1rem;">
                                    <path
                                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                                <div>
                                    You must log in to perform this function !!
                                    <a href="<?php echo vendor_app_util::url(['ctl'=>'login']); ?>">Login Now ?</a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
    global $mediaFiles;
    array_push($mediaFiles['js'], RootREL.'media/js/posts.js');
    array_push($mediaFiles['js'], LibsURI.'Admin_LTE/plugins/toastr/toastr.min.js');
?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>