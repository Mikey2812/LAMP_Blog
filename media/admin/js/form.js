$(document).ready(function () {
    $('.image-upload input[name="image"]').change(function () {
        readURL(this);
    });
    $('.btn-status-cmt').click(function (e) {
        e.preventDefault();
        tc = $(this);
        comment_id = tc.attr("data-id");
        url = tc.attr("data-src");
        value = 1;
        text = 'Active';
        if (tc.hasClass('badge-success')) {
            value = 0;
            text = 'Block'
        }
        $.ajax({
            url: url,
            data: {
                comment_id: comment_id,
                value: value,
            },
            type: "POST",
        })
            .done(function (json) {
                tc.toggleClass('badge-success');
                tc.toggleClass('badge-danger');
                tc.text(text);
                toastr["success"]("Change status comment success!!", "Comment");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });
    // $('.cmt_of_post').change(function () {
    //     link = $(this).attr('value')
    //     console.log(link);
    //     // if (link != '') {
    //     //     window.location.href = link;
    //     // }
    // });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            let ulimg = $('.image-upload img');
            if (ulimg.length == 0) {
                ulimg = $('<img class="img-thumbnail">');
                $('.image-upload').append(ulimg);
            }
            ulimg
                .attr('src', e.target.result)
                .width(300)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}