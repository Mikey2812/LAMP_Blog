<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?php echo $title; ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo vendor_app_util::url(['ctl'=>'dashboard']); ?>">Dashboard</a></li>
			<?php 
			$c = count($breadcrumb);	$j = 0;
			foreach ($breadcrumb as $v) { 
			$j++;
			?>
			<li class="breadcrumb-item <?=($c==$j)? 'active':'';?>">
				<?php if($c!=$j) { ?> <a href="<?php echo vendor_app_util::url($v['urlp']); ?>"> <?php } ?>
					<?php echo (isset($v['title']))? $v['title']: ucwords($v['urlp']['act']);?>
				<?php if($c!=$j) { ?> </a> <?php } ?>
			</li>
			<?php } ?>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
