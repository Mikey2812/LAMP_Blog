let listComment = $('.list-comments');
let commentInfo = $('.comment-avatar');
let numberComment = $('.number-comment')
let avatarSRC = "";
let userName = "";

function renderComment(json, content, path) {
    let html = `<div class="comment-items d-flex flex-row">
                    <img src="${avatarSRC} " width="60" height="60" class="rounded-circle me-3" style="min-width:60px">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                <h6 class="mr-2">${userName}</h6>
                            </div>
                            <small>A few seconds</small>
                        </div>
                        <p class="text-justify comment-text mb-0">${content}</p>
                        <div class="d-flex flex-row user-feed mt-2">
                            <span class="btn-like me-3" alt="${json}" data-type="1">
                                <i class="icon-like fa-solid fa-thumbs-up me-1">
                                </i>
                                <span class="number-like">0</span>
                            </span>
                            <button class="btn-reply border-0"
                                data-comment-path="${path}">
                                <i class="fa fa-comments-o me-1"></i>
                                <span class="reply">Reply</span>
                            </button>
                            <button class="btn-comment-edit border-0 bg-light ms-1" data-comment-path="${path}"
                                href="/PHP/LAMP_Blog/comments/edit/${json}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span class="trash">Edit</span>
                            </button>
                            <button class="btn-trash border-0 bg-light ms-1" data-comment-path="${path}"
                                href="/PHP/LAMP_Blog/comments/del/${json}">
                                <i class="fa-solid fa-trash"></i>
                                <span class="trash">Delele</span>
                            </button>
                        </div>
                    </div >
                </div > `
    listComment.prepend(html);
}

function renderReply(positon, replyCSS, json, content, path) {
    let html = `<div class="comment-items d-flex flex-row" style="padding-left:${replyCSS}">
                    <img src="${avatarSRC} " width="60" height="60" class="rounded-circle me-3" style="min-width:60px">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                <h6 class="mr-2">${userName}</h6>
                            </div>
                            <small>A few seconds</small>
                        </div>
                        <p class="text-justify comment-text mb-0">${content}</p>
                        <div class="d-flex flex-row user-feed mt-2">
                            <span class="btn-like me-3" alt="${json}" data-type="1">
                                <i class="icon-like fa-solid fa-thumbs-up me-1">
                                </i>
                                <span class="number-like">0</span>
                            </span>
                            <button class="btn-reply border-0"
                                data-comment-path="${path}>">
                                <i class="fa fa-comments-o me-1"></i>
                                <span class="reply">Reply</span>
                            </button>
                            <button class="btn-comment-edit border-0 bg-light ms-1" data-comment-path="${path}"
                                href="/PHP/LAMP_Blog/comments/edit/${json}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span class="trash">Edit</span>
                            </button>
                            <button class="btn-trash border-0 bg-light ms-1" data-comment-path="${path}"
                                href="/PHP/LAMP_Blog/comments/del/${json}">
                                <i class="fa-solid fa-trash"></i>
                                <span class="trash">Delele</span>
                            </button>
                        </div>
                    </div >
                </div > `
    positon.after(html);
}

function renderFormReply(positon, replyCSS, pathParent, value, type) {
    let html = `<div class="form-comment-items d-flex flex-row" style="padding-left:${replyCSS}px">
                    <img src="${avatarSRC} " width="60" height="60" class="rounded-circle me-3 reply-avatar"
                        style="min-width:60px">
                    <div class="w-100 d-flex align-items-center">
                        <input type="text" id="content" class="input-content_reply form-control w-100 p-3"
                            placeholder="Enter your reply..." name="reply[content]" value = "${value}">
                        <a class="btn-comments_reply_${type} btn btn-outline-primary ms-3"
                            name="${type}_comments"
                            href="/PHP/LAMP_Blog/comments/${type}" data-comment-path="${pathParent}">Add</a>
                    </div >
                </div > `
    positon.after(html);
}

function like(element) {
    if (isLogin == false) {
        toastr["warning"]("You must login to like<br /><br /><a type='button' href='login' class='btn btn-dark login'>Login Now</a>");
        return;
    }
    else {
        numberLike = element.children('span');
        quantity = parseInt(numberLike.text());
        if (element.hasClass("active")) {
            quantity = quantity - 1;
            action = -1;
        }
        else {
            quantity = quantity + 1;
            action = 1;
        }
        location_id = element.attr('alt');
        type = element.attr('data-type');
        $.ajax({
            url: '/PHP/LAMP_Blog/likes/add',
            data: {
                location_id: location_id,
                action: action,
                type: type,
            },
            type: "POST",
        })
            .done(function (json) {
                numberLike.text(quantity);
                element.toggleClass('active');
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    }

}

function convertPath(id, parent) {
    var str = id.toString();
    var zerosToAdd = 4 - str.length;
    var paddedString = '0'.repeat(zerosToAdd) + str;
    if (parent !== undefined) {
        paddedString = parent + '.' + paddedString;
    }
    return paddedString;
}

$(document).ready(function () {
    avatarSRC = commentInfo.attr("src");
    userName = commentInfo.attr("alt");

    //Like
    $('.list-comments').on('click', '.btn-like', function (event) {
        event.preventDefault();
        like($(this));

    });

    $('.posts-information').on('click', '.btn-like', function (event) {
        event.preventDefault();
        like($(this));
    });

    let inputUser = $('.input-user');
    let inputPost = $('.input-post');
    let inputContent = $('.input-content');

    //Direct Comment
    $('.btn-direct_comment').click(function (e) {
        const myPromise = new Promise((resolve, reject) => {
            window.location.href = "/PHP/LAMP_Blog/posts/view/" + $(this).attr('alt');
        });
        myPromise
            .then($("#content").focus());
    });

    //Add Comments
    $('a.btn-comments').click(function (e) {
        e.preventDefault();
        content = inputContent.val();
        if (content === '') {
            return;
        }
        tc = $(this);
        url = tc.attr('href');
        user_id = inputUser.val();
        post_id = inputPost.val();
        $.ajax({
            url: url,
            data: {
                user_id: user_id,
                post_id: post_id,
                content: content,
            },
            type: "POST",
        })
            .done(function (json) {
                let path = convertPath(post_id) + '.' + convertPath(json);
                numberComment.text(parseInt(numberComment.text()) + 1);
                renderComment(json, content, path);
                inputContent.val('');
                toastr["success"]("Comment", "Add comment Success!!");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });

    //Add Reply
    $('.list-comments').on('click', '.btn-comments_reply_addreply', function (event) {
        event.preventDefault();
        content = $('.input-content_reply').val();
        if (content === '') {
            return;
        }
        tc = $(this);
        url = tc.attr('href');
        post_id = inputPost.val();
        path_Parent = tc.attr('data-comment-path');
        let positon = $(this).parent().parent();
        let replyCSS = positon.css('padding-left');
        $.ajax({
            url: url,
            data: {
                post_id: post_id,
                content: content,
                path_Parent: path_Parent,
            },
            type: "POST",
        })
            .done(function (json) {
                console.log(json);
                let path = path_Parent + '.' + convertPath(json);
                numberComment.text(parseInt(numberComment.text()) + 1);
                renderReply(positon, replyCSS, json, content, path);
                positon.remove();
                toastr["success"]("Comment", "Add comment Success!!");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });

    //Show form reply
    $('.list-comments').on('click', 'button.btn-reply', function (event) {
        event.preventDefault();
        let pathParent = $(this).attr("data-comment-path");
        let positon = $(this).parent().parent().parent();
        let replyCSS = parseInt(positon.css('padding-left').slice(0, -2)) + 48;
        renderFormReply(positon, replyCSS, pathParent, '', 'addreply');
    });

    //Del post 
    $('.list-blog').on('click', 'a.del-record', function (event) {
        event.preventDefault();
        tc = $(this);
        url = tc.attr('href');
        $.ajax({
            url: url,
            data: {
                // id: id,
            },
            type: "POST",
        })
            .done(function (json) {
                tc.parent().parent().parent().parent().remove();
                toastr["success"]("Del Post Success!!", "Post!!");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });

    //Show form edit
    $('.list-comments').on('click', '.btn-comment-edit', function (event) {
        event.preventDefault();
        tc = $(this);
        url = tc.attr('href');
        let positon = tc.parent().parent().parent();
        positon.addClass('d-none');
        let replyCSS = parseInt(positon.css('padding-left'));
        let value = tc.parent().prev().text().replace(/^\s+/, '');
        let pathParent = tc.attr("data-comment-path");
        renderFormReply(positon, replyCSS, pathParent, value, 'edit');
    });

    //Edit Comments
    $('.list-comments').on('click', '.btn-comments_reply_edit', function (event) {
        event.preventDefault();
        content = $('.input-content_reply').val();
        if (content === '') {
            return;
        }
        tc = $(this);
        url = tc.attr('href');
        path = tc.attr('data-comment-path');
        let positon = $(this).parent().parent();
        let replyCSS = positon.css('padding-left');
        $.ajax({
            url: url,
            data: {
                content: content,
                path: path,
            },
            type: "POST",
        })
            .done(function (json) {
                positon.prev().children().children().eq(1).text(content);
                positon.prev().removeClass('d-none');
                positon.remove();
                toastr["success"]("Comment", "Edit comment Success!!");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });

    //Del comment
    $('.list-comments').on('click', '.btn-trash', function (event) {
        event.preventDefault();
        path_Comment = $(this).attr('data-comment-path');
        tc = $(this);
        url = tc.attr('href');
        $.ajax({
            url: url,
            data: {
                path_Comment: path_Comment,
            },
            type: "POST",
        })
            .done(function (json) {
                var element = $('[data-comment-path^="' + path_Comment + '"]');
                element.parent().parent().parent().remove();
                toastr["success"]("Del Post Success!!", "Post!!");
            })
            .fail(function (xhr, status, errorThrown) {
                alert("Sorry, there was a problem!");
                console.log("Error: " + errorThrown);
                console.log("Status: " + status);
                console.dir(xhr);
            });
    });

});
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}