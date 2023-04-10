$(document).ready(function () {
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