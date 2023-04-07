<?php
class posts_controller extends vendor_backend_controller
    {
        public function index()
        {
            global $app;
            $conditions = "";
            // if (isset($app['prs']['status'])) {
            //     $conditions .= "status=".$app['prs']['status'];
            // }
            // if (isset($app['prs']['role'])) {
            //     $conditions .= (($conditions) ? " AND " : "")."role=".$app['prs']['role'];
            // }
            // if (isset($app['prs']['kw'])) {
            //     $conditions .= (($conditions) ? " AND (" : "")."firstname LIKE '%".$app['prs']['kw']."%' OR lastname LIKE '%".$app['prs']['kw']."%' OR email LIKE '%".$app['prs']['kw']."%'".(($conditions) ? ")" : "");
            // }

            $pm = post_model::getInstance();
            //old
            // $this->records = $pm->allp('*', ['conditions'=>$conditions, 'joins'=>false]);
            //new 
            $this->records = $pm->allp('*', ['conditions'=>$conditions, 'joins'=>['topic','user']]);
            $this->display();
        }

        public function view($id) {
            $pm = post_model::getInstance();
                $this->record = $pm->getRecord($id);
                $this->display();
            }
    }
?>