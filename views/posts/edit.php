<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<section class="content mt-5">
    <div class="container-fluid">
        <div class="card-header mb-5">
            <h4>Post Edit
                <a href="<?=vendor_app_util::url(array('ctl'=>'posts', 'act'=>'profile/'.$_SESSION['user']['id'])); ?>"
                    class="btn btn-outline-secondary
                                float-end">BACK</a>
            </h4>
        </div>
        <?php include_once 'views/'.$app['ctl'].'/_form.php';?>
    </div>
</section>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>