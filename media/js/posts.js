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
                        </div>
                    </div >
                </div > `
    positon.after(html);
}

function renderFormReply(positon, replyCSS, pathParent) {
    let html = `<div class="form-comment-items d-flex flex-row" style="padding-left:${replyCSS}px">
                    <img src="${avatarSRC} " width="60" height="60" class="rounded-circle me-3 reply-avatar"
                        style="min-width:60px">
                    <div class="w-100 d-flex align-items-center">
                        <input type="text" id="content" class="input-content_reply form-control w-100 p-3"
                            placeholder="Enter your reply..." name="reply[content]">
                        <a class="btn-comments_reply btn btn-outline-primary ms-3"
                            name="add_comments_reply"
                            href="/PHP/LAMP_Blog/comments/addreply" data-comment-path="${pathParent}">Add</a>
                    </div>
                </div > `
    positon.after(html);
}

function like(element) {
    if (isLogin == false) {
        $('.required_login').toggleClass('d-none');
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
        numberLike.text(quantity);
        element.toggleClass('active');
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
                // let path = convertPath(post_id) + '.' + convertPath(json);
                // numberComment.text(parseInt(numberComment.text()) + 1);
                // renderComment(content, path);
                // inputContent.val('');
                toastr["success"]("Comment", "Add comment Success!!");
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
        like($(this));
    });

    $('.posts-information').on('click', '.btn-like', function (event) {
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
    $('.list-comments').on('click', '.btn-comments_reply', function (event) {
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
        // $('button.btn-reply').click(function (e) {
        // e.preventDefault();
        let pathParent = $(this).attr("data-comment-path");
        let positon = $(this).parent().parent().parent();
        let replyCSS = parseInt(positon.css('padding-left').slice(0, -2)) + 48;
        renderFormReply(positon, replyCSS, pathParent);
    });
});