<?php
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL.'media/css/posts.css'); 
?>
<?php include_once 'views/layout/'.$this->layout.'header.php'; ?>
<div class="content">
    <h1>Most Viewer</h1><br />
    <div class="row">
        <?php if(count($this->records['data'])) { ?>
        <?php foreach ($this->records['data'] as $record) { ?>
        <div class="col-4 p-3 d-flex align-items-stretch flex-column">
            <div class="post-item">
                <a class="text-decoration-none"
                    href="<?php echo (vendor_app_util::url(["ctl"=>"posts", "act"=>"view/".$record['id']])) ?>">
                    <img class="blog-img w-100 rounded-4" style="height:300px"
                        src="<?=UploadURI.'posts/'.(($record['image'])? $record['image']: 'no_picture.png'); ?>">
                    <h3 class="blog-title mt-3 text-center"><?php echo $record['title']?></h3>
                </a>
                <div class="d-flex justify-content-between">
                    <p class="ms-2"><i class="fa-solid fa-user me-2"></i>by
                        <?php echo $record['users_firstname'].' '.$record['users_lastname']?></p>
                    <p class="me-2"><i class="fa-regular fa-clock me-2"></i><?php echo $record['created_at'] ?></p>
                </div>
                <div class="d-flex justify-content-end">
                    <p class="me-3"><i class="fa-regular fa-eye me-1"></i><?php echo $record['view'] ?></p>
                    <p class="me-3 likes"><i
                            class="icon-like fa-solid fa-thumbs-up me-1"></i><?php echo $record['number_like'] ?>
                    </p>
                    <p class="me-2"><i
                            class="fa-regular fa-comment me-1"></i></i><?php echo $record['number_comment'] ?>
                    </p>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>
</div>

<!-- HEADER -->
<header class="site-header" role="banner">

    <div class="navbar-wrapper">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!-- .navbar-toggle -->
                    <a class="navbar-brand" href="#">
                        <img src="https://nandoangelo.github.io/template-bootstrap/assets/img/logo.png"
                            alt="Bootstrap to Wordpress" title="Home">
                    </a>
                </div><!-- .navbar-header -->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://codepen.io/nandoangelo/pen/gOjzdvo" title="Home">Home</a></li>
                        <li class="active"><a href="#" title="Blog">Blog</a></li>
                        <li><a href="#" title="Resources">Resources</a></li>
                        <li><a href="#" title="Contact">Contact</a></li>
                    </ul><!-- .nav -->
                </div><!-- .navbar-collapse -->
            </div><!-- .container -->
        </div><!-- .navbar -->
    </div><!-- .navbar-wrapper -->

</header><!-- HEADER -->

<!-- FEATURE IMAGE -->
<section class="feature-image feature-image-default-alt" data-type="background" data-speed="2">
    <h1 class="page-title">Blog</h1>
</section><!-- FEATURE-IMAGE -->

<!-- BLOG CONTENT -->
<div class="container">
    <div class="row" id="primary">
        <main id="content" class="col-sm-8" role="main">

            <article class="post">
                <header>
                    <h3><a href="post.html" title="Full Post">Blog Title Here</a></h3>
                    <div class="post-details">
                        <i class="fa fa-user"></i> Nando Angelo
                        <i class="fa fa-clock-o"></i> <time>Agust 7, 2014</time>
                        <i class="fa fa-folder-open"></i> <a href="#">Tutorials</a>, <a href="#">Coding</a>
                        <i class="fa fa-tags"></i> Tagged <a href="#">wordpres</a>, <a href="#">premium</a>, <a
                            href="#">another tag</a>, <a href="#">yada yada</a>

                        <div class="post-comments-badge">
                            <a href="#"><i class="fa fa-comments"></i>168</a>
                        </div><!-- .post-comments-badge -->
                    </div><!-- .post-details -->
                </header><!-- header -->
                <div class="post-image">
                    <img src="https://nandoangelo.github.io/template-bootstrap/assets/img/hero-bg.jpg" alt="Hero Image">
                </div><!-- .post-image -->
                <div class="post-excerpt">
                    <p>
                        Proin suscipit luctus orci placerat fringilla. Donec hendrerit laoreet risus eget adipiscing.
                        Suspendisse in urna ligula, a volutpat mauris. Sed enim mi, bibendum eu pulvinar vel, sodales
                        vitae dui. Pellentesque sed sapien lorem, at lacinia urna. In hac habitasse platea dictumst.
                        Vivamus vel justo in leo laoreet ullamcorper non vitae lorem. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Proin bibendum ullamcorper rutrum <a href="post.html">Continue
                            Heading &raquo;</a>
                    </p>
                </div><!-- .post-excerpt -->
            </article><!-- .post -->

            <article class="post">
                <header>
                    <h3><a href="post.html" title="Full Post">Blog Title Here</a></h3>
                    <div class="post-details">
                        <i class="fa fa-user"></i> Nando Angelo
                        <i class="fa fa-clock-o"></i> <time>Agust 7, 2014</time>
                        <i class="fa fa-folder-open"></i> <a href="#">Tutorials</a>, <a href="#">Coding</a>
                        <i class="fa fa-tags"></i> Tagged <a href="#">wordpres</a>, <a href="#">premium</a>, <a
                            href="#">another tag</a>, <a href="#">yada yada</a>

                        <div class="post-comments-badge">
                            <a href="#"><i class="fa fa-comments"></i>168</a>
                        </div><!-- .post-comments-badge -->
                    </div><!-- .post-details -->
                </header><!-- header -->
                <div class="post-image">
                    <img src="https://nandoangelo.github.io/template-bootstrap/assets/img/hero-bg.jpg" alt="Hero Image">
                </div><!-- .post-image -->
                <div class="post-excerpt">
                    <p>
                        Proin suscipit luctus orci placerat fringilla. Donec hendrerit laoreet risus eget adipiscing.
                        Suspendisse in urna ligula, a volutpat mauris. Sed enim mi, bibendum eu pulvinar vel, sodales
                        vitae dui. Pellentesque sed sapien lorem, at lacinia urna. In hac habitasse platea dictumst.
                        Vivamus vel justo in leo laoreet ullamcorper non vitae lorem. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Proin bibendum ullamcorper rutrum <a href="post.html">Continue
                            Heading &raquo;</a>
                    </p>
                </div><!-- .post-excerpt -->
            </article><!-- .post -->

            <article class="post">
                <header>
                    <h3><a href="post.html" title="Full Post">Blog Title Here</a></h3>
                    <div class="post-details">
                        <i class="fa fa-user"></i> Nando Angelo
                        <i class="fa fa-clock-o"></i> <time>Agust 7, 2014</time>
                        <i class="fa fa-folder-open"></i> <a href="#">Tutorials</a>, <a href="#">Coding</a>
                        <i class="fa fa-tags"></i> Tagged <a href="#">wordpres</a>, <a href="#">premium</a>, <a
                            href="#">another tag</a>, <a href="#">yada yada</a>

                        <div class="post-comments-badge">
                            <a href="#"><i class="fa fa-comments"></i>168</a>
                        </div><!-- .post-comments-badge -->
                    </div><!-- .post-details -->
                </header><!-- header -->
                <div class="post-image">
                    <img src="https://nandoangelo.github.io/template-bootstrap/assets/img/hero-bg.jpg" alt="Hero Image">
                </div><!-- .post-image -->
                <div class="post-excerpt">
                    <p>
                        Proin suscipit luctus orci placerat fringilla. Donec hendrerit laoreet risus eget adipiscing.
                        Suspendisse in urna ligula, a volutpat mauris. Sed enim mi, bibendum eu pulvinar vel, sodales
                        vitae dui. Pellentesque sed sapien lorem, at lacinia urna. In hac habitasse platea dictumst.
                        Vivamus vel justo in leo laoreet ullamcorper non vitae lorem. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Proin bibendum ullamcorper rutrum <a href="post.html">Continue
                            Heading &raquo;</a>
                    </p>
                </div><!-- .post-excerpt -->
            </article><!-- .post -->

        </main><!-- #content -->

        <!-- SIDEBAR -->
        <aside class="col-sm-4">
            <!-- .widget subscribe-->
            <div class="widget">
                <h4>Join our mailing list</h4>
                <p>
                    Keep up-to-date with the latest news, and we'll <strong>send you something special as a thank
                        you</strong>
                </p>
                <button class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#myModal">
                    Click here to subscribe
                </button>
            </div> <!-- /.widget subscribe-->

            <!-- .widget search -->
            <div class="widget">
                <form role="form" class="search-form">
                    <label for="sidebar-search" class="sr-only">Search the blog</label>
                    <input type="text" id="sidebar-search" placeholder="Search the blog...">
                </form>
            </div> <!-- /.widget search -->

            <!-- .widget about -->
            <div class="widget">
                <h4>About the Bootstrap to Wordpress</h4>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div> <!-- /.widget about -->

            <!-- .widget recent posts -->
            <div class="widget">
                <h4>Recent Posts</h4>
                <ul>
                    <li><a href="post.html">Blog Post #1</a></li>
                    <li><a href="post.html">Blog Post #2</a></li>
                    <li><a href="post.html">Blog Post #3</a></li>
                    <li><a href="post.html">Blog Post #4</a></li>
                    <li><a href="post.html">Blog Post #5</a></li>
                </ul>
            </div><!-- /.widget recent posts -->


            <!-- .widget categories -->
            <div class="widget">
                <h4>Categories</h4>
                <ul>
                    <li><a href="#">Categorie #1</a></li>
                    <li><a href="#">Categorie #2</a></li>
                    <li><a href="#">Categorie #3</a></li>
                    <li><a href="#">Categorie #4</a></li>
                    <li><a href="#">Categorie #5</a></li>
                    <li><a href="#">Categorie #6</a></li>
                </ul>
            </div><!-- /.widget categories -->
        </aside>

    </div><!-- .row #primary -->
</div><!-- BLOG CONTENT -->

<!-- SIGN UP -->
<section id="signup" data-type="background" data-speed="4">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h2>Are you ready to take your coding skills to the <strong>next level</strong>?</h2>
                <p>
                    <a href="#" class="btn btn-lg btn-block btn-success" data-toggle="modal" data-target="#myModal">Yes,
                        sign up</a>
                </p>
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</section><!-- #signup -->

<!-- FOOTER -->
<footer>
    <div class="container">
        <div class="col-sm-3">
            <p>
                <a href="#" title="Home">
                    <img src="https://nandoangelo.github.io/template-bootstrap/assets/img/logo.png"
                        alt="Bootstrap to WordPress">
                </a>
            </p>
        </div><!-- .col -->
        <div class="col-sm-6">
            <nav>
                <ul class="list-unstyled list-inline">
                    <li><a href="">Home</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Resources</a></li>
                    <li><a href="">Contact</a></li>
                    <li class="signup-link"><a href="">Sign Up</a></li>
                </ul>
            </nav>
        </div><!-- .col -->
        <div class="col-sm-3">
            <p class="pull-right">
                &copy; 2014 Nando Angelo
            </p>
        </div><!-- .col -->
    </div><!-- .container -->
</footer><!-- footer -->

<!-- MODAL -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope"></i> Subscribe to Our Mailing List
                </h4>
            </div><!-- .modal-header -->
            <div class="modal-body">
                <p>
                    Simply enter your name and your e-mail! As a thank you for joining us, we're going to give you one
                    of our best-selling courses, <em>for free!</em>
                </p>
                <form class="form-inline" role="form">

                    <div class="form-group">
                        <label class="sr-only" for="subscribe-name">Your First Name</label>
                        <input class="form-control" type="text" id="subscribe-name"
                            placeholder="Enter your first name"></input>
                    </div><!-- .form-group -->

                    <div class="form-group">
                        <label class="sr-only" for="subscribe-email">Your E-mail</label>
                        <input class="form-control" type="email" id="subscribe-email"
                            placeholder="Enter your E-mail"></input>
                    </div><!-- .form-group -->

                    <input class="btn btn-danger" type="submit" value="Subscribe!"></input>

                </form>
                <hr>
                <p><small>
                        By provinding your e-mail you consent to receiving ocasional promotional e-mails &amp;
                        newsletters. <br>No Spam. Just good stuff. We respect you privacy &amp; you may unsubscribe at
                        any time.
                    </small></p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

<?php
    global $mediaFiles;
    array_push($mediaFiles['js'], RootREL.'media/js/posts.js');
?>
<?php include_once 'views/layout/'.$this->layout.'footer.php'; ?>