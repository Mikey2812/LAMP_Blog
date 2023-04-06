<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PSCD Admin Template | Log in</title>
  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="softdevelopinc">
    <meta name="author" content="softdevelopinc@gmail.com">

    <link rel="stylesheet" href="<?php echo RootREL; ?>media/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RootREL; ?>media/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo RootREL; ?>media/libs/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo RootREL; ?>media/libs/css/AdminLTE.min.css">
  	<link rel="stylesheet" href="<?php echo RootREL; ?>media/css/style.css">
  	<!-- Google Font -->
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <p><b>PSCD</b> User Side</p>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body login-page">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php if($this->errors) { ?>
    <div class="alert alert-danger alert-dismissible error-change" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->errors['message']; ?>
    </div>
    <?php } ?>

  </div>
  <!-- /.login-box-body -->
</div>

<script src="<?php echo RootREL; ?>media/js/jquery.min.js"></script>
<script src="<?php echo RootREL; ?>media/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

