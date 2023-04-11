<?php
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL.'media/css/posts.css');
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="content">
    <div class="d-flex justify-content-between">
        <h1 class="mt-5">List Blog</h1>
        <a href="<?php echo vendor_app_util::url(['ctl'=>'posts', 'act'=>'add']); ?>"
            class="d-flex align-items-center btn btn-outline-info ms-2 mt-5">Add new post</a>
    </div>
    <div class="row mt-5">
        <?php if(count($this->records['data'])) { ?>
        <?php foreach ($this->records['data'] as $record) { ?>
        <div class="post-item col-4 d-flex align-items-stretch flex-column">
            <a class="text-decoration-none"
                href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>">
                <img class="blog-img w-100 rounded-4" style="height:300px"
                    src="<?=UploadURI.'posts/'.(($record['image'])? $record['image']: 'no_picture.png'); ?>">
                <h3 class="blog-title mt-3"><?php echo $record['title']?></h3>
            </a>
            <div class="d-flex justify-content-between">
                <p class="ms-2"><i class="fa-solid fa-user me-2"></i>by
                    <?php echo $record['users_firstname'].' '.$record['users_lastname']?></p>
                <p class="me-2"><i class="fa-regular fa-clock me-2"></i><?php echo $record['created_at'] ?></p>
            </div>
            <div class="d-flex justify-content-end">
                <p class="me-3"><i class="fa-regular fa-eye me-1"></i><?php echo $record['view'] ?></p>
                <p class="me-3 likes"><i
                        class="icon-like fa-solid fa-thumbs-up me-1"></i><?php echo $record['number_like'] ?>
                </p>
                <p class="me-2"><i class="fa-regular fa-comment me-1"></i><?php echo $record['number_comment'] ?></p>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<?php
    global $mediaFiles;
    array_push($mediaFiles['js'], RootREL.'media/js/posts.js');
?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>