$('#new_password, #confirm_password').on('keyup', function () {
  if ($('#new_password').val() == $('#confirm_password').val()) {
    $('#changePassword .form-group-pass').removeClass('has-warning').addClass('has-success');
    $('#error-confirm-password').html('Matching').removeClass('text-danger').add('text-success');
  } else {
    $('#changePassword .form-group-pass').removeClass('has-success').addClass('has-warning');
    $('#error-confirm-password').html('Not Matching').removeClass('text-success').add('text-danger');
  }
});

$("#savePassword").click(function () {
  var curpassword = $('#current_password').val();
  var newpassword = $('#new_password').val();
  if (newpassword != $('#confirm_password').val()) {
    return false;
  } else {
    var urlUpdate = rootUrl + "admin/users/changepassword";
    $.ajax({
      url: urlUpdate,
      dataType: "json",
      type: 'POST',
      data: { curpassword: curpassword, newpassword: newpassword },
      success: function (data) {
        $('#change-password-status button').removeClass('hide');
        if (data.status) {
          $('#change-password-status').removeClass('alert-danger').addClass('alert-success').children('p.message').html(data.message);
          setTimeout(function () {
            $('#changePassword').modal('hide');
            $('#change-password-status button').addClass('hide');
            $('#change-password-status p.message').empty();
          }, 2000);
        } else {
          $('#change-password-status').removeClass('alert-success').addClass('alert-danger').children('p.message').html(data.message);
        }
      }
    })
  }
});

var util = {};
util.post = function (url, fields) {
  var $form = $('<form>', {
    action: url,
    method: 'post'
  });
  $.each(fields, function (key, val) {
    $('<input>').attr({
      type: "hidden",
      name: key,
      value: val
    }).appendTo($form);
  });
  $form.appendTo('body').submit();
}

function converDate(d) {
  var dar = d.toLocaleDateString().split('/');
  return dar[2] + "-" + ((dar[0] < 10) ? "0" : "") + dar[0] + "-" + ((dar[1] < 10) ? "0" : "") + dar[1];
}
