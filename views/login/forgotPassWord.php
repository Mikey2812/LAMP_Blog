<?php include_once 'views/layout/headerLogin.php'; ?>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <p><b>PSCD</b> User Side</p>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body login-page">
    <p class="login-box-msg">Bạn quên mật khẩu?</p>
    <p>Nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn.</p>
    <?php if($this->errors) { ?>
    <div class="alert alert-danger alert-dismissible error-change" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $this->errors['message']; ?>
    </div>
    <?php } ?>
    <form method="post" action="<?php echo vendor_app_util::url(array('ctl'=>'login','act'=> 'forgotPassWord')); ?>">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-5 col-xs-offset-7">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_submit">Send</button>
        </div>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<script src="<?php echo RootREL; ?>media/js/jquery.min.js"></script>
<script src="<?php echo RootREL; ?>media/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>

