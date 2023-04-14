<form
    action="<?php echo vendor_app_util::url(["ctl"=>"posts", "act"=>$app['act'] == 'edit'?$app['act']."/".$this->record['id']:$app['act']]); ?>"
    method="post" enctype="multipart/form-data" class="form-horizontal">

    <div class="form-group row mb-3 d-none">
        <!-- User -->
        <label class="control-label col-md-3" for="topic">User</label>
        <div class="controls col-md-9">
            <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="user" name="post[user_id]"
                placeholder="" class="form-control" value="<?php echo $_SESSION['user']['id'] ?>">
        </div>
    </div>

    <div class="form-group row mb-3">
        <!-- Topic -->
        <label class="control-label col-md-3" for="topic">Topic</label>
        <div class="controls col-md-7">
            <select id="Topic" placeholder="Topic" class="form-select" aria-label="Default select example"
                name="post[topic_id]">
                <?php if($this->topics) {?>
                <?php while($row = mysqli_fetch_array($this->topics)) : ?>
                <option
                    <?php echo'value = '.$row['id']; if(isset($this->record['topic_id']) && $row['id'] == $this->record['topic_id']) echo ' selected';?>>
                    <?php echo $row['name'] ?></option>
                <?php endwhile; ?>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <!-- Title -->
        <label class="control-label col-md-3" for="title">Title</label>
        <div class="controls col-md-9">
            <input <?php if($app['act']=='view') echo "disabled"; ?> type="text" id="title" name="post[title]"
                placeholder="" class="form-control"
                value="<?php if(isset($this->record['title'])) echo $this->record['title']; ?>">
        </div>
    </div>

    <div class="form-group row mb-3">
        <!-- Content -->
        <label class="control-label col-md-3" for="content">Content</label>
        <div class="controls col-md-9">
            <textarea name="post[content]" id="content" rows="100" cols="80">
                <?php if(isset($this->record['content'])) echo $this->record['content']; ?>
            </textarea>
        </div>
    </div>

    <div class="image-upload form-group row mb-3">
        <!-- Image -->
        <label class="control-label col-md-3" for="image">Image</label>
        <div class="controls col-md-7">
            <?php if($app['act'] !='add'){ ?>
            <?php if(isset($this->record)) { ?>
            <img class="img-thumbnail mx-auto" src="<?php echo UploadURI.$app['ctl'].'/'.$this->record['image']; ?>">
            <?php } ?>
            <?php } ?>
            <?php if($app['act'] !='view'){ ?>
            <input type="file" id="image" name="image" placeholder="image" class="form-control">
            <?php } ?>
            <?php if( isset($this->errors['image'])) { ?>
            <p class="text-danger"><?=$this->errors['image']; ?></p>
            <?php } ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="controls offset-md-3 col-md-9">
            <input class="btn btn-success pull-right" type="submit" name="btn_submit" value="Post Now !!">
        </div>
    </div>
</form>

<script>
window.onload = () => {
    CKEDITOR.replace('content');
    CKEDITOR.editorConfig = function(config) {
        config.height = '800px';
    };
}
</script>

<?php
    global $mediaFiles;
    array_push($mediaFiles['js'], RootREL.'media/js/form.js');
?>