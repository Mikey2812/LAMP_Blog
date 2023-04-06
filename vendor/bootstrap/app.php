<?php
    session_start();
    $app['ctl'] = "home";
    $prs = [];
    $noPrs=0;

    // Process $app['prs'] when we use htaccess to convert all GET parrams to pr. 
    // EX: {domain}/{param1}/{param2}/...		will converted by .htaccess to: index.php?pr={param1}/{param2}/...
    if(isset($_GET["pr"])) {
        $prs = explode("/",$_GET["pr"]);
        $noPrs = count($prs);
        if($prs[$noPrs-1] == '') {
            array_pop($prs);
            $noPrs--;
        }
    }
    $app['prs'] = [];
    if($noPrs) {
        // Check if admin area
        if($prs[0]=="admin") {
            $app['area'] = 'admin';
            $app['areaPath'] = 'admin/';
            array_shift($prs);
            $noPrs--;
        } else if($prs[0]=="api") {
            $app['area'] = $prs[0];
            $app['areaPath'] = $prs[0].'/';
            array_shift($prs);
            
            $app['act'] = 'index';
            switch($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $app['act'] = ($noPrs > 2)?  'view':	'index';
                    break;
                case 'POST':
                    $app['act'] = 'add';
                    break;
                case 'PUT':
                    $app['act'] = 'edit';
                    break;
                case 'DELETE':
                    $app['act'] = 'del';
                    break;
                default:
                    $app['act'] = 'index';
            }
            
            array_splice($prs, 1, 0, $app['act']);
        }
        $app['ctl'] = isset($prs[0])?$prs[0]:null;	
        
        if(isset($prs[1])) {
            if(strpos($prs[1],"=") === false) {
                $app['act'] = $prs[1];
            } else {
                $kv = explode("=",$prs[1]);
                $app['prs'][$kv[0]] = $kv[1];
            }
        }
        if($noPrs>2) {
            for($i=2; $i<$noPrs; $i++) {
                if(strpos($prs[$i],"=") !== false) {
                    $kv = explode("=",$prs[$i]);
                    $app['prs'][$kv[0]] = $kv[1];
                } else {
                    $app['prs'][$i-1] = $prs[$i];
                }
            }
        }
    }

    // Process $app['prs'] without htaccess. 
    // EX: {domain}/index.php?k1=pr1&k2=pr2&...
    foreach($_GET as $k=>$v) {
        if($k!='pr')
            $app['prs'][$k] = $v;
    }

    $c = $app['ctl']."_controller";

    if(!is_file(ControllerREL.$app['areaPath'].$c.".php")) {
        $c = "staticpages_controller";
        $app['ctl'] = "staticpages";	
        $app['act'] = "error";
    }

    $controller = new $c();
?>