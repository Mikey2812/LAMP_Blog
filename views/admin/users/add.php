<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>
<?php vendor_html_helper::contentheader('Users <small>management</small>', [
    [
      'title' =>  'Index Users',
      'urlp'=>['ctl'=>$app['ctl']]
    ],
    ['urlp'  =>  ['ctl'=>$app['ctl'], 'act'=>$app['act']]]
]); ?>

<section class="content">
    <div class="container-fluid">
        <?php include_once 'views/admin/'.$app['ctl'].'/_form.php';?>
    </div>
</section>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>