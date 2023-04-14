$(document).ready(function () {
    $('a.nav-link').on('click', function () {
        console.log(this.href.substring(this.href.lastIndexOf('/') + 1));
    });
});
