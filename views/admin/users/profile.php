<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>

<?php vendor_html_helper::contentheader('Users <small>management</small>', [
    [
      'title' =>  'Users',
      'urlp'=>['ctl'=>$app['ctl']]],
    [
      'title' =>  'Detail of '.$this->record['firstname']." ".$this->record['lastname'],
      'urlp'  =>  ['ctl'=>$app['ctl'], 'act'=>$app['act']]
    ]
]); ?>
<?php $id = $_SESSION['user']['id']; ?>

<section class="content">
	<div class="container-fluid">
		<div class="card card-info">
		  <div class="card-header">
      	<div class="row">
				  <div class="col-sm-8 col-xs-6">
			    	<h3 class="card-title"><?php echo ucwords($app['act'].' '.$app['ctl']); ?></h3>
	  			</div>

	  			<div class="col-sm-4 col-xs-6">
	  				<a href="<?php echo (vendor_app_util::url(["ctl"=>"users", "act"=>"edit/".$id])) ?>" id="<?php echo("edit".$id);?>" type="button" class="btn btn-primary float-right">
	        		<i class="fa fa-edit"></i>
	        	</a>
	  			</div>
		  	</div>
		  </div>
			<div class="card-body">
	    	<table class="table table-bordered">
    			<tr>
    				<td class="title">Full name :</td>
    				<td><?php echo $this->record['firstname']; ?> <?php echo $this->record['lastname']; ?></td>
    			</tr>
    			<tr>
    				<td class="title">Avata :</td>
    				<td><img src="<?php echo UploadURI.$app['ctl'].'/'.$this->record['avata']; ?>"></td>
    			</tr>
    			<tr>
    				<td class="title">Email :</td>
    				<td><?php echo $this->record['email']; ?></td>
    			</tr>
    			<tr>
    				<td class="title">Password :</td>
    				<td><input disabled type="Password" name="password" value="<?php echo $this->record['password']; ?>" ></td>
    			</tr>
    			<tr>
    				<td class="title">Phone :</td>
    				<td><?php echo $this->record['phone']; ?></td>
    			</tr>
    			<tr>
    				<td class="title">Address :</td>
    				<td><?php echo $this->record['address']; ?></td>
    			</tr>
    			<tr>
    				<td class="title">Date Of Birth :</td>
    				<td><?php echo $this->record['datebirth']; ?></td>
    			</tr>
    		</table>
			</div>
		</div>
	</div>
</section>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>