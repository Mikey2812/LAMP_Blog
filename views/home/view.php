
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="content">
    <div class="row">
        <h3><?php echo ($this->record['title']); ?></h3>
        <img src="<?=UploadURI.'posts/'.(($this->record['image'])? $this->record['image']: 'no_picture.png'); ?>"
            alt="">
        <p><?php echo ($this->record['content']); ?></p>
    </div>
</div>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>