<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PSCD Admin Template | Log in</title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Pacificsoftdev">
    <meta name="author" content="pacificsoftdev@gmail.com">

    <!--link rel="stylesheet" href="<?php echo LibsURI; ?>bootstrap/css/bootstrap.min.css"-->
    <link rel="stylesheet" href="<?php echo LibsURI; ?>bootstrap/plugins/icheck-bootstrap.min.css">
  	<link rel="stylesheet" href="<?php echo MediaURI;?>admin/css/adminlte.min.css">
  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0);"><b>PSCD</b> Admin</a>
  </div>
  
  <div class="card">
    <div class="card-body login-card-body">
		<p class="login-box-msg">Sign in to start your session</p>

		<form method="post" action="<?php echo vendor_app_util::url(
			array('area'=>'admin', 
				  'ctl'=>'login',
				  'act'=>$this->action
		)); ?>">
		  <div class="input-group mb-3">
		    <input type="email" class="form-control" name="user[email]" placeholder="Email">
		    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		  </div>
		  <div class="input-group mb-3">
		    <input type="password" class="form-control" name="user[password]" placeholder="Password">
		    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		  <div class="row">
		      <div class="col-8">
		        <div class="icheck-primary">
		          <input type="checkbox" id="remember">
		          <label for="remember">
		            Remember Me
		          </label>
		        </div>
		      </div>
		      <!-- /.col -->
		      <div class="col-4">
		        <button type="submit" name="btn_submit" class="btn btn-primary btn-block pull-right">Sign In</button>
		      </div>
		      <!-- /.col -->
		  </div>
		</form>
  	</div>
  </div>
</div>

<script src="<?php echo LibsURI; ?>js/jquery.min.js"></script>
<script src="<?php echo LibsURI; ?>bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
