<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>
<div class="error-page">
    <h2 class="headline text-red">500</h2>

    <div class="error-content">
      <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>

      <p>
      	The view file <strong class="text-red">"<?php echo $this->viewfile; ?>"</strong> is missing!<br>
        We will work on fixing that right away.
        Meanwhile, you may  <a href="<?php echo RootURL ?>admin/dashboard"> return to dashboard</a> or try using the search form.
      </p>
    </div>
 </div>
<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>
