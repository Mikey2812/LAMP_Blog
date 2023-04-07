<?php
    include_once(__DIR__.'/config/main.php');
    include_once(__DIR__.'/vendor/bootstrap/autoload.php');
    include_once(__DIR__.'/vendor/bootstrap/app.php');
    $cn = isset($_GET["ctl"])? $_GET["ctl"]: "home"; 
    if(!is_file('controllers/'.$cn.'_controller.php')) 	$cn = 'staticpages';
    $c = $cn."_controller";
    
    //$controller = new about_controller();
?>