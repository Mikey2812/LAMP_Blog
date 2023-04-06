<?php include_once 'views/admin/layout/'.$this->layout.'top.php'; ?>

<?php vendor_html_helper::contentheader('Users <small>management</small>', [
    [
      'title' =>  'Users',
      'urlp'=>['ctl'=>$app['ctl']]],
    [
      'title' =>  'Detail of '.$this->record['firstname']." ".$this->record['lastname'],
      'urlp'  =>  ['ctl'=>$app['ctl'], 'act'=>$app['act']]
    ]
]); ?>

<section class="content">
    <div class="container-fluid">
        <?php include_once 'views/admin/users/_form.php'; ?>
    </div>
</section>

<?php include_once 'views/admin/layout/'.$this->layout.'footer.php'; ?>
<?php exit(); ?>