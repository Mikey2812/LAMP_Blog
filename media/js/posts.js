$(document).ready(function () {
    // $.ajax({
    //     type: "POST",
    //     url: "session.php",
    //     data: { action: "get_session" },
    //     success: function (response) {
    //         alert(response);
    //     }
    // });
    $('.icon-like').click(function (e) {
        let number_like = Number($(this).parent().text());
        if ($(this).hasClass("active")) {
            number_like = number_like - 1;
        }
        else {
            number_like = number_like + 1;
        }
        $(this).parent().text(number_like);
        $(this).toggleClass("active");
    });
});