<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>

<?php vendor_html_helper::contentheader('Topics <small>management</small>', [
    [
      'title' =>  'Topics',
      'urlp'=>['ctl'=>$app['ctl']]],
    [
      'title' =>  'Detail of Topic '.$this->record['id'],
      'urlp'  =>  ['ctl'=>$app['ctl'], 'act'=>$app['act']]
    ]
]); ?>

<section class="content">
    <div class="container-fluid">
        <?php include_once 'views/admin/topics/_form.php'; ?>
    </div>
</section>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>
<?php exit(); ?>